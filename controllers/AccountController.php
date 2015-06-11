<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use frontend\controllers\NotificationController;
use frontend\controllers\LocalizationController;

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
    public function createAccount($name, $parentid, $display){
        
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
            $account->name = $name;
            $account->display_position = $display;
            $account->system = 1;
            $account->value = 0;
            $account->currency = 'EUR';
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
        $account = AccountPlus::findOne($accountid);
        while($account != null){
            $account->value += $amount;
            $account->save();
            $account = AccountPlus::findOne($account->parent_id);
        }
        return true;    // Need to add exception management
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
        if ($account === null) {
            throw new NotFoundHttpException;
        }
        
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
     * AJAX Actions Section (Returns JSON)
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
