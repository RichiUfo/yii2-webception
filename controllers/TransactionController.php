<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\filters\AccessControl;

use frontend\controllers\NotificationController;
use frontend\controllers\LocalizationController;

use frontend\modules\accounting\models\Transaction;
use frontend\modules\accounting\models\TransactionForex;
use frontend\modules\accounting\models\Account;
use frontend\modules\accounting\models\AccountPlus;
use frontend\modules\accounting\models\AccountHierarchy;

class TransactionController extends \frontend\components\Controller
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionCreate() {
        $model = new Transaction();
        
        if ($model->load(Yii::$app->request->post())) {
            
            // Prepare the transaction creation
            $cur = \Yii::$app->user->identity->acc_currency;
            $deb = AccountPlus::findOne($model->account_debit_id);
            $cre = AccountPlus::findOne($model->account_credit_id);
            
            // Regular Transaction
            if($deb->currency === $cur and $cre->currency === $cur){
                if ($model->validate()) {
                    self::createTransactionRegular($deb, $cre, $model->value, $model->date_value, $model->name, $model->description);
                    NotificationController::setNotification('success', 'Transaction Saved', 'The transaction has been saved !');
                }
            }
            
            // Forex Transaction
            else {
                
                if ($cur !== $deb->currency) {
                    $value_forex = Yii::$app->request->post('value_debit');
                    $value = Yii::$app->request->post('value_credit');
                }
                else if ($cur !== $cre->currency) {
                    $value = Yii::$app->request->post('value_debit');
                    $value_forex = Yii::$app->request->post('value_credit');
                }
                self::createTransactionForex($deb, $cre, $value, $value_forex, $model->date_value, $model->name, $model->description);
                NotificationController::setNotification('success', 'Forex Transaction Saved', 'The transaction has been saved !');
            }

            return 'Saved';
        }
        
        // Step 1 : Request users inputs
        $model->date_value = date('Y/m/d');
		if(\Yii::$app->request->isAjax) {
			return $this->renderAjax('create', [
				'model' => $model,
				'accounts' => AccountController::getAccountList(true)
        	]);
		}
		else {
			return $this->render('create', [
				'model' => $model,
				'accounts' => AccountController::getAccountList(true)
        	]);
		}
        
    }
    
    /**
     * Private Functions
     */
    public function getTransactionsFrom($accountid, $last_update_dt = null) {
        
        // 1- Building the time query
        $now_dt = new \DateTime();
        $now = $now_dt->format('Y-m-d H:i:s');
        if($last_update_dt) {
            $last_update = $last_update_dt->format('Y-m-d H:i:s');
            $time_query = "date_value between '".$last_update."' and '".$now."'";
        }
        else {
            $time_query = "date_value < '".$now."'";
        }
        
        // 2- Searching the transactions
        $transactions = Transaction::find()
            ->where('account_credit_id = '.$accountid.' OR account_debit_id = '.$accountid)
            ->andWhere($time_query)
            ->orderBy(['date_value' => SORT_DESC])
            ->all();
            
        return $transactions;
    }
    public function getTransactions($accountid, $start, $end, $children = true){
        
        // Convert the id of the account hierarchy to a SQL compatible format
        $account = AccountHierarchy::findOne($accountid);
        if($children) {
            $ids = $account->getChildrenIdList();
            $strids = '(';
            foreach ($ids as $id) {$strids .= $id.','; }
            $strids = substr_replace($strids, ')', -1);
        }
        else {
            $strids = '('.$account->id.')';
        }
        
        // Time Query Management
        if ($end === 'now') {
            $now_dt = new \DateTime();
            $now = $now_dt->format('Y-m-d H:i:s');
            $time_query = "transactions.date_value between '".$start."' and '".$now."'";
        } else {
            $time_query = "transactions.date_value between '".$start."' and '".$end." 23:59:59.999'";
        }
        
        // Find the transactions
        $transactions = Transaction::find()
            ->joinWith(['accountForex'])
            ->where('account_credit_id IN '.$strids.' OR account_debit_id IN '.$strids.' OR transactions_forex.account_forex_id IN '.$strids)
            ->andWhere($time_query)
            ->orderBy(['transactions.date_value' => SORT_DESC])
            ->all();
        
        // Debit/Credit, Value, Currency
        foreach($transactions as $transaction){
             
            // Forex Transaction
            if(isset($transaction->transactionForex)){
                
                // I. Check if the transaction is a debit or credit for this account
                $transaction->credit['isCredit'] = (in_array($transaction->account_credit_id, $ids))?true:false;       
                $transaction->debit['isDebit'] = (in_array($transaction->account_debit_id, $ids))?true:false;  
                
                // II. Currency
                $transaction->credit['currency'] = $transaction->accountCredit->currency;
                $transaction->debit['currency'] = $transaction->accountDebit->currency;
                
                // III. Value
                if($transaction->credit['currency'] === 'EUR') {
                    $transaction->credit['value'] = $transaction->value;
                } else {
                    $transaction->credit['value'] = $transaction->transactionForex['forex_value'];;
                }
                
                // Debit Side
                if($transaction->debit['currency'] === 'EUR') {
                    $transaction->debit['value'] = $transaction->value;
                } else {
                    $transaction->debit['value'] = $transaction->transactionForex['forex_value'];
                }
            }
            
            // NON-Forex Transaction
            else{
                // I. Check if the transaction is a debit or credit for this account
                $transaction->credit['isCredit'] = (in_array($transaction->account_credit_id, $ids))?true:false;       
                $transaction->debit['isDebit'] = (in_array($transaction->account_debit_id, $ids))?true:false;  
                // II. Currency
                $transaction->credit['currency'] = $transaction->accountCredit->currency;
                $transaction->debit['currency'] = $transaction->accountDebit->currency;
                // III. Value
                $transaction->credit['value'] = $transaction->value;
                $transaction->debit['value'] = $transaction->value;
            }
            
        }
        
        // Format the values and currencies
        
        
        return $transactions;
    }
    public function getMovements($accountid, $start, $end) {
        
        $transactions = TransactionController::getTransactions($accountid, $start, $end);
        
        $passed_credits = 0;
        $future_credits = 0;
        $passed_debits = 0;
        $future_debits = 0;
        
        $now = new \DateTime("now", new \DateTimeZone(\Yii::$app->user->identity->acc_timezone));
        
        foreach($transactions as $transaction) {
            $transaction_time = new \DateTime($transaction->date_value);
            
            if($transaction->debit) {
                if($now >= $transaction_time) $passed_debits += $transaction->value;
                else $future_debits += $transaction->value;
            }
        
            if($transaction->credit){
                if($now >= $transaction_time) $passed_credits += $transaction->value;
                else $future_credits += $transaction->value;
            }
        }
        
        return array(
            'passed_credits' => $passed_credits, 
            'future_credits' => $future_credits,
            'passed_debits' => $passed_debits,
            'future_debits' => $future_debits,
            // DEBUG
            'now' => $now,
            'transactions' => $transactions 
        );
    }
    private function createTransaction($model) {
        
        $now_dt = new \DateTime();
        $datevalue_dt = new \DateTime($model->date_value);
        
        if($datevalue_dt <= $now_dt) {
            $debit = AccountController::updateAccountValue($model->account_debit_id, -1 * $model->value);
            $credit = AccountController::updateAccountValue($model->account_credit_id, $model->value);
        }
        
        return $model->save();
    }
    
    private function createTransactionRegular($debit, $credit, $value, $date, $name, $description) {
        // Register the transaction in the database
        $transaction = new Transaction;
        $transaction->account_debit_id = $debit->id;
        $transaction->account_credit_id = $credit->id;
        $transaction->date_value = $date;
        $transaction->name = $name;
        $transaction->description = $description;
        $transaction->value = $value;
        $transaction->save();
        
        // Update the accouts values 
        $debit = AccountController::updateAccountValue($debit->id, -1 * $value);
        $credit = AccountController::updateAccountValue($credit->id, $value);
        
        // Return the created transaction
        return $transaction;
    }
    private function createTransactionForex($debit, $credit, $value, $value_forex, $date, $name, $description) {
        
        $system_currency = \Yii::$app->user->identity->acc_currency;;
        $debit_currency = $debit->currency;
        $credit_currency = $credit->currency;
        
        /*
        * CASE 1 - One foreign currency
        */
        if(($system_currency === $debit_currency or $system_currency === $credit_currency) and ($debit_currency !== $credit_currency)){
            
            // STEP 1 - Get the foreign currency & associated trading account
            if($system_currency !== $debit_currency){
                $foreign_currency = $debit_currency;
            } else {
                $foreign_currency = $credit_currency;
            }
            $trading = AccountForexController::getForexAccount($foreign_currency);
            
            // STEP 2 - Create the regular transaction
            if($credit_currency === $system_currency) {
                $transaction = self::createTransactionRegular($debit, $credit, $value, $date, $name, $description);
            }
            else if($debit_currency === $system_currency) {
                $transaction = self::createTransactionRegular($debit, $credit, $value, $date, $name, $description);
            }
            
            // STEP 3 - Create the forex transaction
            $forex_transaction = new TransactionForex;
            $forex_transaction->transaction_id = $transaction->id;
            $forex_transaction->account_forex_id = $trading->id;
            $forex_transaction->forex_value = $value_forex;
            $forex_transaction->save();
            // Foreign account is credit (Selling Foreign Currency)
            if($credit_currency !== $system_currency) {
                $trading->forex_value -= $value_forex;
                $credit->value += $value_forex;
                $credit->save();
            }
            // Foreign account is debit (Buying Foreign Currency)
            else {
                $trading->forex_value += $value_forex;
                $debit->value -= $value_forex;
                $debit->save();
            }
            $trading->save();
        }
        return true;
    }
    
    /**
     * AJAX Actions Section (Returns VIEW or JSON)
     */
    public function actionValidateAccountSelection($accountdebitid, $accountcreditid){
    
        \Yii::$app->response->format = 'json';
        
        $debit = AccountPlus::findOne($accountdebitid);
        $debit = AccountPlus::findOne($accountcreditid);
        
        $valid = true;
        $message = "";
        
        // 1. Check that accounts are different
        if($accountdebitid == $accountcreditid){
            $valid = false;
            $message = "Error: The debit and credit accounts are same !";
        }
        
        // X. Return the validation data
        $ret['valid'] = $valid;
        $ret['message'] = $message;
        return $ret;
    }
    public function actionGetTransactionsView($accountid, $start, $end) {
        
        // Account Information
        $account = AccountHierarchy::findOne(['id' => $accountid, 'owner_id' => Yii::$app->user->id]);
        if ($account === null) throw new NotFoundHttpException;
        
        // Closing Balance
        //$closing_balance = AccountController::getAccountBalance($account->id, date("Y-m-d")) * $account->sign;
        $movements = AccountController::getMovementsSummary($accountid, $start, $end);
        $closing_balance = $movements['closing_balance'];
        
        // Transactions
        $transactions = $this->getTransactions($account->id, $start, $end);
        
        return $this->renderAjax('partial_transactions', [
            'start' => $start,
            'end' => $end,
            'account' => $account,
            'closing_balance' => $closing_balance,
            'transactions' => $transactions
        ]);
    }
    public function actionGetTransactionsJson($accountid, $start, $end) {
        $transactions = $this->getTransactions($accountid, $start, $end);
        return json_encode($transactions);
    }
    public function actionGetMovementsJson($accountid, $start, $end) {
        
        return json_encode($this->getMovements($accountid, $start, $end));
    
    }
    
}