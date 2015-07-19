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
use frontend\modules\accounting\models\TransactionPlus;
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
    * Account Creation Methods
    */
    public function createAccount($number, $name, $parentid, $display=0, $specialClass='') {
        
        // Check (by name) if the account is already existing    
        $check = Account::findOne([
            'name' => $name,
            'owner_id' => ExchangeController::get('entities', 'active_entity_id')
        ]);
        
        // If not, create it
        if($check == null){
            $account = new Account();
            $account->owner_id = ExchangeController::get('entities', 'active_entity_id');
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
                $new_others->owner_id = ExchangeController::get('entities', 'active_entity_id');
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
    * Global User Accounts Methods
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
                ->andWhere(['owner_id' => ExchangeController::get('entities', 'active_entity_id')])
                ->all();
        }
        else {
            $roots = AccountHierarchy::find()
                ->where(['owner_id' => ExchangeController::get('entities', 'active_entity_id')])
                ->all();
        }
            
        return recConvertAccounts($roots, $end_children_only);
    }
    
    /**
     * Hierarchy Related Methods
     */
    public function getChildrenAccounts($accountid) {
        $children = Account::find()
            ->where(['parent_id' => $accountid])
            ->all();
        return $children;
    }
    
    /**
     * Movements Related Methods
     */
    public function getMovementsSummary($accountid, $start, $end, $transactions=null) {
        
        $account = AccountPlus::findOne($accountid);
        $current_balance = $account->value;
        
        // STEP 1 - Get the transactions (if not already provided)
        if(!$transactions)
            $transactions = self::getTransactions($accountid, $start, $end);
        
        if (!$transactions) {
            return [
                'opening_balance' => 0 ,
                'current_balance' => 0,
                'closing_balance' => 0,
                'past_debits' => 0,
                'past_credits' => 0,
                'future_debits' => 0,
                'future_credits' => 0
            ];
        }
        
            
        // STEP 2 - Calculate movements
        $now = new \DateTime();
        $opening_balance = 0;
        $closing_balance = 0;
        $past_debits = 0;
        $past_credits = 0;
        $future_debits = 0;
        $future_credits = 0;
        foreach ($transactions as $t) {
            
            $date = new \DateTime($t->date_value);
            $debit  = $t->valueDebit;
            $credit = $t->valueCredit;
            
            // Convert to account currency
            $date_conv = ($date <= $now) ? $t->date_value : $now->format('Y-m-d');
            if($t->accountDebit['currency'] !== $account->currency)
                $debit = ExchangeController::get('finance', 'currency-conversion', [
                    'value' => $t->valueDebit,
                    'from' => $t->accountDebit['currency'],
                    'to' => $account->currency,
                    'date' => $date_conv,
                ]);
            if($t->accountCredit['currency'] !== $account->currency)
                $credit = ExchangeController::get('finance', 'currency-conversion', [
                    'value' => $t->valueCredit,
                    'from' => $t->accountCredit['currency'],
                    'to' => $account->currency,
                    'date' => $date_conv,
                ]);
            
            
            if($date <= $now) {
                $past_debits += $debit;
                $past_credits += $credit;
            }
            else {
                $future_debits += $debit;
                $future_credits += $credit;
            }
        }
        
        // STEP 3 - Foramt and Return
        return [
            'opening_balance' => $current_balance + $past_debits - $past_credits ,
            'current_balance' => $current_balance,
            'closing_balance' => $current_balance - $future_debits + $future_credits,
            'past_debits' => $past_debits,
            'past_credits' => $past_credits,
            'future_debits' => $future_debits,
            'future_credits' => $future_credits
        ];
    }
    public function getTransactions($accountid, $start, $end, $balance=null) {
        $transactions = TransactionController::getTransactions($accountid, $start, $end);
        
        // STEP 1 - Remove or confirm the debit or credit side
        $account = AccountHierarchy::findOne($accountid);
        $ids = $account->getChildrenIdList();
        foreach ($transactions as $t) {
            if (!in_array($t->account_debit_id, $ids)) $t->valueDebit = 0;
            if (!in_array($t->account_credit_id, $ids)) $t->valueCredit = 0;
        }
        
        // STEP 2 - Calculate the after transaction account balance
        if ($balance) {
            $now = new \DateTime();
            foreach($transactions as $t) {
                $t->updatedBalance = $balance;
                $date = new \DateTime($t->date_value);
                
                // Debit Case
                if ($t->valueDebit !== 0) {
                    $balance += ExchangeController::get('finance', 'currency-conversion', [
                        'value' => $t->valueDebit,
                        'from' => $t->accountDebit['currency'],
                        'to' => $account->currency,
                        'date' => $t->date_value,
                    ]);
                }
                
                // Credit Case
                if ($t->valueCredit !== 0) {
                    $balance -= ExchangeController::get('finance', 'currency-conversion', [
                        'value' => $t->valueCredit,
                        'from' => $t->accountCredit['currency'],
                        'to' => $account->currency,
                        'date' => $t->date_value,
                    ]);
                }
            }
        }
        
        return $transactions;
    }
    
    /**
     * Account Valuation Methods
     */
    public function getCurrentBalancesSingle($accountid) {
        
        // STEP 1 - Get the account
        $account = Account::findOne($accountid);
        
        // STEP 2 - In case of special account, redirect to specific functions
        if ($account->accountForex)
            return AccountForexController::getCurrentBalancesSingle($accountid);
        
        // STEP 3 - In case of regular account, calculate the value based on transactions
        $now_dt = new \DateTime();
        
        $transactions = TransactionPlus::find()
            ->where('id > '.$account->last_transaction_id)
            ->andWhere('account_debit_id = '.$account->id.' OR account_credit_id = '.$account->id)
            ->andWhere("date_value < '".$now_dt->format('Y-m-d H:i:s')."'")
            ->all();

        foreach($transactions as $t){
            $account->last_transaction_id = $t->id;
            if($t->account_debit_id === $account->id)   $account->value -= $t->valueDebit;
            if($t->account_credit_id === $account->id)  $account->value += $t->valueCredit;
        }
        
        $account->save();
        $values[$account->currency] = $account->value;
        
        return $values;
        
    }
    public function getCurrentBalancesRecursive($accountid) {
        
        // STEP 1 - Get the current account multiple currencies balances
        $values = self::getCurrentBalancesSingle($accountid);
        
        // STEP 2 - Get the children account values in the main parent account currency
        $children = self::getChildrenAccounts($accountid);
        foreach($children as $child) {
            $values_children = self::getCurrentBalancesRecursive($child->id);
            
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
    public function getCurrentBalance($accountid, $currency = null) {
        
        // STEP 1 - Get the balances in all account currencies
        $balances = self::getCurrentBalancesRecursive($accountid);
        
        // STEP 2 - Check the display currency
        if (!$currency) 
            $currency = \Yii::$app->user->identity->acc_currency;
            
        // STEP 3 - Convert the balances to the destination currency
        $balance = 0;
        foreach ($balances as $cur => $bal) {
            if($cur !== $currency) {
                $balance += ExchangeController::get('finance', 'currency-conversion', [
                    'value' => $bal,
                    'from' => $cur,
                    'to' => $currency
                ]);
            }   
            else {
                $balance += $bal;
            }
        
        }
        
        return $balance;
    }
    public function getHistoricalBalances($accountid, $start, $end) {
        
        // 0- Variables Init
        $now_dt =   new \DateTime();
        $start_dt = new \DateTime($start);
        $end_dt =   new \DateTime($end);
        
        // 1- Get Current Values
        $current = self::getCurrentBalancesRecursive($accountid);
        if($now_dt > $start_dt and $now_dt < $end_dt)
            $datapoints[$now_dt->format('Y-m-d')] = $current;
        
        // 2- Get Related Transactions (DESC date_value - most recent first)
        $transactions = TransactionController::getTransactions($accountid, $start, $end);
        
        // 3- Get the children ID list
        $account = AccountHierarchy::findOne($accountid);
        $children = $account->getChildrenIdList();
        
        // 4- Calculate Past Values
        $c = $current;
        foreach ($transactions as $t) {
            $date_dt = new \DateTime($t->date_value);
            if ($date_dt < $now_dt) {
                $datapoints[$date_dt->format('Y-m-d')] = $c;
                
                // CASE 1 - Forex Account
                if($account->accountForex) {
                    $c[$t->accountCredit['currency']] += $t->valueCredit;
                    $c[$t->accountDebit['currency']] -= $t->valueDebit;
                }
                
                // CASE 2 - Regular Account
                else {
                    if(in_array($t->accountDebit['id'], $children)) $c[$t->accountDebit['currency']] += $t->valueDebit;
                    if(in_array($t->accountCredit['id'], $children)) $c[$t->accountCredit['currency']] -= $t->valueCredit;
                }
            }
        }
        
        // Sort & Return the values
        if (isset($datapoints)) {
            ksort($datapoints);
            return $datapoints;
        } 
        else {
            return [];
        }
    }
    public function getHistoricalBalance($accountid, $start, $end, $currency = null, $extrapolate = null) {
        
        // STEP 1 - Get The Balances In Multiple Currencies
        $datapoints = self::getHistoricalBalances($accountid, $start, $end);
        
        // STEP 2 - Check the display currency
        if (!$currency) 
            $currency = \Yii::$app->user->identity->acc_currency;
        
        // STEP 3 - Extrapolate the data
        if($extrapolate) {
            
            $start = new \DateTime($start);
            $end = new \DateTime($end);
            $current = $start;
            
            $previous = isset($datapoints[0]) ? $datapoints[0] : [];
            
            while($current < $end) {
                
                if(isset($datapoints[$current->format('Y-m-d')])) {
                    $previous = $datapoints[$current->format('Y-m-d')];
                }
                else {
                    $datapoints[$current->format('Y-m-d')] = $previous;
                }
                
                $current->modify('+1 day');
            }
            
        }
            
        // STEP 4 - Convert To Destination Currency
        $balances = [];
        foreach ($datapoints as $date => $datapoint)
            $balances[$date] = self::convertAccountBalances($datapoint, $currency, $date);
        
        ksort($balances);
        return $balances;
    }
    
    /**
     * Currency Related Methods
     */
    public function getAccountCurrencies($accountid) {
        
        // STEP 1 - Get the account
        $account = Account::findOne($accountid);
        
        // STEP 2 - Special Accounts, Current Level Currency
        if ($account->accountForex) 
            return AccountForexController::getAccountCurrencies($accountid);
        
        // STEP 3 - Regular Accounts, Recursivity
        $currencies = [$account->currency];
        $children = AccountController::getChildrenAccounts($accountid); 
        foreach($children as $child){
            $cur_child = AccountController::getAccountCurrencies($child->id);
            foreach($cur_child as $cur)
                if (!in_array($cur, $currencies)) array_push($currencies, $cur);
        }
        
        return $currencies;
    }
    private function convertAccountBalances($balances, $currency = null, $date = null) {
        
        if(!$date) $date = new \DateTime();
        if (!$currency) $currency = \Yii::$app->user->identity->acc_currency;
        
        $balance = 0;
        foreach ($balances as $cur => $val) {
            if($cur !== $currency) {
                $balance += ExchangeController::get('finance', 'currency-conversion', [
                    'value' => $val,
                    'from' => $cur,
                    'to' => $currency,
                    'date' => $date,
                ]);
            }
            else {
                $balance += $val;
            }
        }
        
        return $balance;
    }
    
    /**
     * Account Numbering Methods
     */
    public function getNextAvailableNumber($parentid) {
        $parent = Account::findOne($parentid);
        
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

    /**
    * Routed Actions
    */
    public function actionDisplay($id, $start='', $end='') {
        
        // Configuring The Back Buttons
        $account = AccountPlus::findOne(['id' => $id, 'owner_id' => ExchangeController::get('entities', 'active_entity_id')]);
        if ($account->statement == "balance_sheet") {
            $back_button = ['text' => 'Balance Sheet', 'route' => '/accounting/balancesheet'];
        }
        else {
            $back_button = ['text' => 'Profits &amp; Losses', 'route' => '/accounting/profitloss'];
        }
        
        /** 
         * AJAX -> Render the partial view
         */
        if(\Yii::$app->request->isAjax) {
            
            // STEP 1 - Account Information
            $account = AccountHierarchy::findOne(['id' => $id, 'owner_id' => ExchangeController::get('entities', 'active_entity_id')]);
            if ($account === null) throw new NotFoundHttpException;
            
            // STEP 2 - Transactions Information
            $movements = self::getMovementsSummary($id, $start, $end);
            $transactions = self::getTransactions($id, $start, $end, $movements['closing_balance']);
            
            // STEP 3 - Rendering The Partial View
            return $this->renderPartial('partial_account', [
                'start' => $start,
                'end' => $end,
                'account' => $account,
                'movements' => $movements,
                'transactions' => $transactions
            ]);
        }
        
        /** 
         * REGULAR -> Render the full view
         */
        else{
            $this->layout = '@app/views/layouts/one-column-header';
            return $this->render('account', [
                'account' => $account,
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
                            ['icon' => 'plus', 'text' => 'Transaction', 'type' => 'modal_preload', 'route' => 'transaction/create'],
                            ['icon' => 'plus', 'text' => 'Account', 'type' => 'modal_preload', 'route' => 'account/create'],
                        ]
                    ]
                ],
                'localdatetime' => LocalizationController::getCurrentLocalDateTime(\Yii::$app->user->identity->app_timezone, 'd.m.Y, H:i:s'),
                'accdatetime' => LocalizationController::getCurrentLocalDateTime(\Yii::$app->user->identity->acc_timezone, 'd.m.Y, H:i:s')
            ]);
        }
    } 
    public function actionDisplayHeader() {
        
        $owner = ExchangeController::get('entities', 'active_entity_id'); 
        
        return $this->renderPartial('partial_account_header', [
            'owner' => $owner 
        ]);
    }
    public function actionCreate() {
        $model = new Account();
    
        if ($model->load(Yii::$app->request->post())) {
            
            $model->owner_id = ExchangeController::get('entities', 'active_entity_id');
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
            NotificationController::setNotification('error', 'Account Not Renamed', 'The account renaming has failed !');
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
    public function actionGetNextAvailableNumber($parentid) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $ret = [
            'base' => AccountController::getNextAvailableNumber($parentid),
            'options' => [1,2,3,4,5,6,7,8,9]
        ];
        
        return $ret
    }

}
