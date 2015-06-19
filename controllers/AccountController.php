<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use frontend\controllers\NotificationController;
use frontend\controllers\LocalizationController;
use frontend\components\ExchangeController;

use frontend\modules\accounting\models\Transaction;
use frontend\modules\accounting\models\Account;
use frontend\modules\accounting\models\AccountPlus;
use frontend\modules\accounting\models\AccountHierarchy;

class AccountController extends \frontend\components\Controller
{    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
    * createAccount($name, $parent, $display)
    * Create a new account
    */
    public function getNextAvailableNumber($parent_id) {
        $parent = Account::findOne($parent_id);
        
        // Get the base number (without the zeros)
        $base = $parent->number;
        while(!is_float($base/10))
            $base /= 10;
        
        // Minimum
        $base_min = $base;
        while($base_min * 10 < 99999) 
            $base_min *= 10;
        $base_max = $base*10+9;
        while($base_max * 10 < 99999) 
            $base_max *= 10;
        
        // Find the child account with the highest number
        $last_account = Account::find()
            ->where(['parent_id' => $parent->id])
            ->andWhere('`number` > '.$base_min.' AND `number` < '.$base_max)
            ->orderBy('`number` DESC')
            ->one();
        
        // Get the base number (without the zeros)
        if(isset($last_account->number)){
            $base = $last_account->number;
            while(!is_float($base/10))
                $base /= 10;
            $base += 1;
        }
        else {
            $base = $base*10+1;
        }
        while($base * 10 < 99999) 
            $base *= 10;
            
        return $base;
    }
    public function createAccount($number, $name, $parentid, $display=0, $specialClass='') {
        
        // Check (by name) if the account is already existing    
        $check = Account::findOne([
            'name' => $name,
            'owner_id' => Yii::$app->user->id
        ]);
        
        // If not, create it
        if($check == null){
            $account = new Account();
            $account->owner_id = Yii::$app->user->id;
            $account->parent_id = $parentid;
            $account->number = $number;
            $account->name = $name;
            $account->display_position = $display;
            $account->system = 1;
            $account->value = 0;
            $account->currency = 'EUR';
            $account->special_class = $specialClass;
            $account->save();
            $ret = $account;
        }
        else {
            $ret = $check;
        }
        
        // Create the "Others" account if necessary 
        AccountController::createOtherAccount($parentid);
        
        // Return the created account
        return $ret;
    }
    private function createOtherAccount($parentid){
        
        $parent = AccountHierarchy::findOne($parentid);
        $others = false;
        
        if($parent){
            foreach($parent->children as $child)
                if($child->special_class == 'others')
                    $others = true;
                
            if(in_array($parent->name, ['Assets', 'Liabilities', 'Equity', 'Cash', 'Forex Unrealized Profits and Losses'])){
                $exclude = true;
            } else {
                $exclude = false;
            }
                
            if(!$others and !$exclude){
                $new_others = new Account();
                $new_others->owner_id = Yii::$app->user->id;
                $new_others->parent_id = $parent->id;
                $new_others->name = "Other ".$parent->name;
                $new_others->display_position = 0;
                $new_others->system = 1;
                $new_others->value = 0;
                $new_others->currency = $parent->currency;
                $new_others->special_class = 'others';
                $new_others->save();
            }
        }
        
    }
    
    /**
    * updateAccountValue($accountid, $amount)
    * Use the function to update the account value and all the parent accounts
    */
    public function updateAccountValue($accountid, $amount) {
        $account = Account::findOne($accountid);
        $account->value += $amount;
        return $account->save();
    }
    public function getCurrentAccountValues($accountid) {
        
        // 1- Get the intrinsic account value (not considering children accounts)
        $account = Account::findOne($accountid);
        $now_dt = new \DateTime();
        if($account->date_value) {
            $last_update_dt = new \DateTime($account->date_value);
            $transactions = TransactionController::getTransactionsFrom($accountid, $last_update_dt);
        }
        else {
            $transactions = TransactionController::getTransactionsFrom($accountid);
        }
        foreach($transactions as $transaction) {
            if($transaction->account_credit_id === $account->id) {
                $account->value += $transaction->value;
            }
            if($transaction->account_debit_id === $account->id) {
                $account->value -= $transaction->value;
            }
        }
        $account->date_value = $now_dt->format('Y-m-d H:i:s');
        $account->save();
        
        $values[$account->currency] = $account->value;
        
        // 2- Get the children account values in the main parent account currency
        $children = AccountController::getChildrenAccounts($accountid);
        foreach($children as $child) {
            $values_children = AccountController::getCurrentAccountValues($child->id);
            
            foreach ($values_children as $curc => $valc)
                if(isset($values[$curc])) {
                    $values[$curc] += $valc;
                }
                else {
                    $values[$curc] = $valc;
                }
        }
        
        // 3- Return an array of values in the difference account currencies (currency => value)
        return $values;
    }
    public function getCurrentAccountValue($accountid, $currency) {
        
        // 1- Get the balances in all account currencies
        $values = AccountController::getCurrentAccountValues($accountid);
        
        // 2- Convert all to the given currency
        $total = 0;
        foreach($values as $cur => $val) {
            if($cur !== $currency) {
                $total += ExchangeController::get('finance', 'currency-conversion', [
                    'value' => $val,
                    'from' => $cur,
                    'to' => $currency
                ]);
            }
            else {
                $total += $val;
            }
        }
        
        return $total;
    }
    public function getChildrenAccounts($accountid) {
        $children = Account::find()
            ->where(['parent_id' => $accountid])
            ->all();
        return $children;
    }

    /**
    * getAccountList()
    * Returns a list of accounts as "id" => "name" pairs directly useable in a dropdown component
    */
    public function getAccountList($end_children_only) {
        
        // 0- Recursive function returning an account and its children
        function recConvertAccounts($accounts, $end_children_only){
            
            $array_ret = array();
            foreach($accounts as $account){
                
                // Returns only accounts with no child (new transaction case)
                if($end_children_only) {
                    if(!$account->has_children){
                        $array_ret[$account->id] = $account->name;
                    }
                    else{
                        $array_ret[$account->name] = recConvertAccounts($account->children, $end_children_only);
                    }
                }
                
                // Returns all accounts (new account case)
                else {
                    $array_ret[$account->id] = $account->name;
                }
            }
            
            return $array_ret;
        }
        
        // 1- Get the root accounts
        if($end_children_only){
            $roots = AccountHierarchy::find()
                ->where(['parent_id' => 0])
                ->andWhere(['owner_id' => Yii::$app->user->id])
                ->all();
        }
        else {
            $roots = AccountHierarchy::find()
                ->where(['owner_id' => Yii::$app->user->id])
                ->all();
        }
            
        return recConvertAccounts($roots, $end_children_only);
    }
    public function getMovementsSummary($accountid, $start, $end) {
        $account = AccountPlus::findOne($accountid);
        $movements = TransactionController::getMovements($accountid, $start, $end);
        $current_balance = $account->value;
        $opening_balance = $current_balance - $movements['passed_credits'] + $movements['passed_debits'];
        $closing_balance = $current_balance + $movements['future_credits'] - $movements['future_debits'];
        
        return array_merge($movements, [
            'opening_balance' => $opening_balance,
            'current_balance' => $current_balance,
            'closing_balance' => $closing_balance,
            'movements' => $movements
        ]);
    }
    public function getHistoricalValue($accountid, $start, $end) {
        $account = AccountPlus::findOne($accountid);
        $transactions = TransactionController::getTransactions($accountid, $start, $end);
        
        // Initializing calculation variables
        $datapoints = [];
        $today = new \DateTime();
        $current_date = $today->format('Y-m-d');
        $current_value = $account->value;
        $datapoints[$current_date] = $current_value;
        
        // Calculating historical values
        foreach ($transactions as $transaction) {
            
            // If transaction is modifying the account value, calculate a new datapoint
            $current_date_dt = new \DateTime($transaction->date_value);
            $current_date = $current_date_dt->format('Y-m-d');
            
            // Add current value (Today)
            $datapoints[$current_date] = round($current_value, 2);
            
            // Past Transactions
            if ($today > $current_date_dt) {
                if(!$transaction->credit and $transaction->debit) {
                    $current_value += $transaction->value;
                }
                else if ($transaction->credit and !$transaction->debit) {
                    $current_value -= $transaction->value;
                }
            }
            
            // Future Transactions
            else if ($today < $current_date_dt) {
                if(!$transaction->credit and $transaction->debit) {
                    $current_value -= $transaction->value;
                }
                else if ($transaction->credit and !$transaction->debit) {
                    $current_value += $transaction->value;
                }
            }
            
        }
        
        // In case we have no initial value, set 0 for the start date
        $current_date = new \DateTime($current_date);
        $start_dt = new \DateTime($start);
        if ($start_dt < $current_date)
            $datapoints[$start] = 0;
        
        // Sort by ascending date order
        ksort($datapoints);
        
        // Currencies aggregation to main currency
        
        
        return $datapoints;
    }
    public function getHistoricalValues($accountid, $start, $end) {
        
        // 0- Variables Init
        $now_dt = new \DateTime();
        $start_dt = new \DateTime($start);
        $end_dt = new \DateTime($end);
        
        // 1- Get Current Values (All Currencies)
        $current = AccountController::getCurrentAccountValues($accountid);
        if($now_dt > $start_dt and $now_dt < $end_dt)
            $datapoints[$now_dt->format('Y-m-d')] = $current;
        
        // 2- Get Related Transactions (DESC date_value - most recent first)
        $transactions = TransactionController::getTransactions($accountid, $start, $end);
        
        // 3- Calculate Past Values
        $c = $current;
        foreach ($transactions as $t) {
            $date_dt = new \DateTime($t->date_value);
            if ($date_dt < $now_dt) {
                $datapoints[$date_dt->format('Y-m-d')] = $c;
                if ($t->debit) $c[$t->currency] += $t->value;
                if ($t->credit) $c[$t->currency] -= $t->value;
            }

        }
        
        // Sort & Return the values
        ksort($datapoints);
        return $datapoints;
    }
    public function getAccountCurrencies($accountid) {
        
        $account = Account::findOne($accountid);
        $currencies = [$account->currency];
        
        $children = AccountController::getChildrenAccounts($accountid); 
        foreach($children as $child){
            $cur_child = AccountController::getAccountCurrencies($child->id);
            foreach($cur_child as $cur)
                if (!in_array($cur, $currencies)) 
                    array_push($currencies, $cur);
        }
        
        return $currencies;
    }
    
    /**
    * Return an array with the opening balance closing balance and relevant transactions
    */
    public function getAccountBalance($accountid, $date) {
        
        $account = Account::findOne($accountid);
        $balance = $account->value;
        
        // Calculate closing balance
        $transactions = TransactionController::getTransactions($accountid, $date, 'now');
        foreach ($transactions as $transaction){
            if($transaction->credit) $balance -= $transaction->value;
            if($transaction->debit) $balance += $transaction->value;
        }
        
        return $balance;
        
    }
    public function actionAccount($id) {
        
        // Account Information
        $account = AccountHierarchy::findOne(['id' => $id, 'owner_id' => Yii::$app->user->id]);
        if ($account === null)
            throw new NotFoundHttpException;
        
        // Closing Balance
        $closing_balance = $this->getAccountBalance($account->id, date("Y-m-d")) * $account->sign;
        
        // Transactions & Movements
        $transactions = TransactionController::getTransactions($account->id, '2015/01/01', 'now');
        $movements = $this->getMovementsSummary($account->id, '2015/01/01', 'now');
        
        // Back Button
        if ($account->statement == "balance_sheet") {
            $back_button = ['text' => 'Balance Sheet', 'route' => '/accounting/balancesheet'];
        }
        else {
            $back_button = ['text' => 'Profits &amp; Losses', 'route' => '/accounting/profitloss'];
        }
        
        $this->layout = '@app/views/layouts/three-columns';
        return $this->render('account', [
            'account' => $account,
            'transactions' => $transactions,
            'movements' => $movements,
            'closing_balance' => $closing_balance,
            'back_button' => $back_button,
            'left_menus' => [
                [
                    'title' => 'Reporting', 'items' => [
                        ['icon' => 'pie-chart', 'text' => 'Balance Sheet', 'type' => 'regular', 'route' => '/accounting/balancesheet'],
                        ['icon' => 'bar-chart', 'text' => 'Income', 'type' => 'regular', 'route' => '/accounting/profitloss'],
                        ['icon' => 'random', 'text' => 'Cash Flow', 'type' => 'regular', 'route' => '/accounting'],
                    ]
                ],
                [
                    'title' => 'Accounting', 'items' => [
                        ['icon' => 'plus', 'text' => 'Transaction', 'type' => 'modal', 'route' => 'transaction/create'],
                        ['icon' => 'plus', 'text' => 'Account', 'type' => 'modal', 'route' => 'account/create'],
                    ]
                ]
            ],
            'localdatetime' => LocalizationController::getCurrentLocalDateTime(\Yii::$app->user->identity->app_timezone, 'd.m.Y, H:i:s'),
            'accdatetime' => LocalizationController::getCurrentLocalDateTime(\Yii::$app->user->identity->acc_timezone, 'd.m.Y, H:i:s')
        ]);
    }
    public function actionCreate() {
        $model = new Account();
    
        if ($model->load(Yii::$app->request->post())) {
            
            $model->owner_id = Yii::$app->user->id;
            $model->display_position = 10;
            $model->system = 0;
            $model->value = 0;
            
            if ($model->validate()) {
                
                // Step 2 : Register the new account
                $model->save();
                AccountController::createOtherAccount($model->parent_id);
                NotificationController::setNotification('info', 'New Account Created', 'The action creation was successful.');
                return;
                
            }
        }
        
        // Step 1 : Request users inputs
        return $this->renderAjax('create', [
            'model' => $model,
            'accounts' => $this->getAccountList(false)
        ]);
    }
    public function actionRename() {
        $id = (int)Yii::$app->request->post('account_id', 0);
        $alias = Yii::$app->request->post('AccountHierarchy', 0)['alias'];
        
        $account = Account::findOne($id);
        $old_alias = $account->alias;
        $account->alias = $alias;
        
        if ($account->save()) {
            NotificationController::setNotification('success', 'Account Renamed', 'Account '.$old_alias.' successfully renamed to '.$alias.'.');
            return true;
        } else {
            NotificationController::setNotification('error', 'Account Not Renamed', 'The account renaiming has failed !');
            return json_encode($account);
        }
        
        
    }
    public function actionUpdate() {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // Different handling depending on ANGULAR or CLASSIC post request
        if(Yii::$app->request->post()){
            $post_data = Yii::$app->request->post();
        }
        else {
            $post_data = json_decode(utf8_encode(file_get_contents("php://input")), false);
            $post_data = ArrayHelper::toArray($post_data);
        }
    
        $id = (int)$post_data['id'];
        $property = $post_data['property'];
        $value = $post_data['value']; 
        
        if($property == 'alias'){
            $account = Account::findOne(100);
            $account->alias = $value;
            $account->save();
            return $account->save();
        }
        else {
            return false;
        }
    }
    
    /**
     * AJAX Actions Section (Returns Partials OR JSON)
     */
    public function actionGetAccountSummary($accountid) {
        
        \Yii::$app->response->format = 'json';
        
        $account = AccountPlus::findOne($accountid);
        $currency = LocalizationController::getInfoFromCurrencyCode($account->currency);
        
        $ret['name'] = $account->name;
        $ret['root'] = $account->root_account->name;
        $ret['sign'] = $account->sign;
        $ret['value'] = $account->value;
        $ret['display_value'] = $account->sign*$account->value;
        $ret['currency']['code'] = $account->currency;
        $ret['currency']['name'] = $currency['name'];
        $ret['currency']['img'] = $currency['img'].'.png';
        $ret['currency']['symbol'] = $currency['symbol'];
        
        return $ret;
        
    }
    public function actionGetMovementsSummaryView($accountid, $start, $end) {
        
        $account = AccountPlus::findOne($accountid);
        $movements = $this->getMovementsSummary($accountid, $start, $end);
        
        return $this->renderAjax('partial_movements', [
            'start' => $start,
            'end' => $end,
            'account' => $account,
            'movements' => $movements
        ]);
    }

}
