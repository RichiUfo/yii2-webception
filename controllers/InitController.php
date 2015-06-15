<?php

namespace frontend\modules\accounting\controllers;

use yii\filters\AccessControl;

use frontend\modules\accounting\models\Account;
use frontend\modules\accounting\models\Transaction;

class InitController extends \frontend\components\Controller
{
        
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
    
    /** 
     * Function actionInitUser
     * This function is called the first time the user access the module
     * It create the necessary database entries for the basic features
     * */
    public function actionIndex(){      // To be removed, just for external call for debug
        $this->initializeModule();
    } 
     
    public function initializeModule() {
        
        // Chart Of Acccounts - Personal Finance
        $assets = AccountController::createAccount('Assets', 0, 1);
            $fixed_assets = AccountController::createAccount('Fixed Assets', $assets->id, 1); 
            $current_assets = AccountController::createAccount('Current Assets', $assets->id, 2);
                $trading_accounts = AccountController::createAccount('Trading Accounts', $current_assets->id, 1);  
                $savings_accounts = AccountController::createAccount('Savings Accounts', $current_assets->id, 2); 
                $checking_accounts = AccountController::createAccount('Checking Accounts', $current_assets->id, 3); 
                $cash = AccountController::createAccount('Cash', $current_assets->id, 4); 
        
        $equity = AccountController::createAccount('Equity', 0, 1);
            $capital = AccountController::createAccount('Capital', $equity->id, 1);
            $capital = AccountController::createAccount('Retained Earnings', $equity->id, 2);
            $capital = AccountController::createAccount('Forex Unrealized Profits and Losses', $equity->id, 3);
            
        
        $liabilities = AccountController::createAccount('Liabilities', 0, 1);
            $lt_liabilities = AccountController::createAccount('Long-Term Liabilities', $liabilities->id, 1);
                $mortgages = AccountController::createAccount('Mortgages', $lt_liabilities->id, 1);
                $loans = AccountController::createAccount('Other Loans', $lt_liabilities->id, 2);
            $current_liabilities = AccountController::createAccount('Current Liabilities', $liabilities->id, 2);
                $accounts_payable = AccountController::createAccount('Accounts Payable', $current_liabilities->id, 1);
                $credit_cards = AccountController::createAccount('Credit Cards', $current_liabilities->id, 2);
        
        $revenues = AccountController::createAccount('Revenues', 0, 1);
            $operating_revenues = AccountController::createAccount('Operating Revenues', $revenues->id, 1);
            $non_operating_revenues = AccountController::createAccount('Non-Operating Revenues And Gains', $revenues->id, 2);
            
        $expenses = AccountController::createAccount('Expenses', 0, 1);
            $operating_expenses = AccountController::createAccount('Operating Expenses', $expenses->id, 1);
            $non_operating_expenses = AccountController::createAccount('Non-Operating Expenses And Losses', $expenses->id, 2);
        
        return $this->render('index');
    }
    
    public function actionReset () {
        
        // transactions cleaning
        $transactions = Transaction::find()
            ->innerJoin('accounts', '`accounts`.`id` = `transactions`.`account_debit_id` OR `accounts`.`id` = `transactions`.`account_credit_id`')
			->where(['accounts.owner_id' => \Yii::$app->user->id])
            ->all();
        
        // transactions_forex cleaning
        $transactions_forex = TransactionForex::find()
            ->innerJoin('transactions', '`transactions`.`id` = `transactions_forex`.`transaction_id`')
            ->innerJoin('accounts', '`accounts`.`id` = `transactions`.`account_debit_id` OR `accounts`.`id` = `transactions`.`account_credit_id`')
            ->where(['accounts.owner_id' => \Yii::$app->user->id])
            ->all(); 
            
        return $this->render('reset', [
            'transactions' => $transactions,
            'transactions_forex' => $transactions_forex
        ]);
        
        // Delete all accounts for the logged user
        Account::deleteAll(['owner_id' => \Yii::$app->user->id]);
        
    }
}
