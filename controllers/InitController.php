<?php

namespace frontend\modules\accounting\controllers;

use yii\filters\AccessControl;

use app\modules\accounting\models\Account;

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
     
    public function initializeModule()
    {
        
        // Chart Of Acccounts - Personal Finance
        $assets = AccountController::initAccount('Assets', 0, 1);
            $fixed_assets = AccountController::initAccount('Fixed Assets', $assets->id, 1); 
            $current_assets = AccountController::initAccount('Current Assets', $assets->id, 2);
                $trading_accounts = AccountController::initAccount('Trading Accounts', $current_assets->id, 1);  
                $savings_accounts = AccountController::initAccount('Savings Accounts', $current_assets->id, 2); 
                $checking_accounts = AccountController::initAccount('Checking Accounts', $current_assets->id, 3); 
                $cash = AccountController::initAccount('Cash', $current_assets->id, 4); 
        
        $equity = AccountController::initAccount('Equity', 0, 1);
            $capital = AccountController::initAccount('Capital', $equity->id, 1);
            $capital = AccountController::initAccount('Retained Earnings', $equity->id, 2);
            
        
        $liabilities = AccountController::initAccount('Liabilities', 0, 1);
            $lt_liabilities = AccountController::initAccount('Long-Term Liabilities', $liabilities->id, 1);
                $mortgages = AccountController::initAccount('Mortgages', $lt_liabilities->id, 1);
                $loans = AccountController::initAccount('Other Loans', $lt_liabilities->id, 2);
            $current_liabilities = AccountController::initAccount('Current Liabilities', $liabilities->id, 2);
                $accounts_payable = AccountController::initAccount('Accounts Payable', $current_liabilities->id, 1);
                $credit_cards = AccountController::initAccount('Credit Cards', $current_liabilities->id, 2);
        
        $revenues = AccountController::initAccount('Revenues', 0, 1);
            $operating_revenues = AccountController::initAccount('Operating Revenues', $revenues->id, 1);
            $non_operating_revenues = AccountController::initAccount('Non-Operating Revenues And Gains', $revenues->id, 2);
            
        $expenses = AccountController::initAccount('Expenses', 0, 1);
            $operating_expenses = AccountController::initAccount('Operating Expenses', $expenses->id, 1);
            $non_operating_expenses = AccountController::initAccount('Non-Operating Expenses And Losses', $expenses->id, 2);
        
        return $this->render('index');
    }
}
