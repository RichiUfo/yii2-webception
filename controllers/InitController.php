<?php

namespace frontend\modules\accounting\controllers;

use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use frontend\modules\accounting\models\Account;
use frontend\modules\accounting\models\AccountForex;
use frontend\modules\accounting\models\Transaction;
use frontend\modules\accounting\models\TransactionForex;

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
        $this->initializeModule('personal');
    } 
    
    public function initializeModule($chart) {
        
        function create_rec($accounts, $parent_id = 0) {
            foreach($accounts as $account){
                $parent = AccountController::createAccount($account['number'], $account['name'], $parent_id);
                if (isset($account['children'])) 
                    create_rec($account['children'], $parent->id);
            }
        }
        
        // Check the availability of the charts of accounts template
        $file = "http://www.fullplanner.com/assets/dcd1142a/chartsofaccounts/".$chart.".json";
        $headers = @get_headers($file);
        if($headers[0] == 'HTTP/1.0 404 Not Found')
            throw new NotFoundHttpException;

        // Get the charts of accounts
        $data = file_get_contents ($file);
        $accounts = json_decode($data, true);
        
        // Check that the module has not been initialized with another charts of accounts
        /* TO BE IMPLEMENTED */
        
        // Create or update the accounts
        create_rec($accounts);
        
        return $this->render('index', [
            'chart' => $chart,
            'accounts' => $accounts
        ]);
    }
    
    public function actionReset () {
        
        $transactions = Transaction::find()
            ->innerJoin('accounts', '`accounts`.`id` = `transactions`.`account_debit_id` OR `accounts`.`id` = `transactions`.`account_credit_id`')
			->where(['accounts.owner_id' => ExchangeController::get('entities', 'active_entity_id')])
            ->all();
        
        $transactions_forex = TransactionForex::find()
            ->innerJoin('transactions', '`transactions`.`id` = `transactions_forex`.`transaction_id`')
            ->innerJoin('accounts', '`accounts`.`id` = `transactions`.`account_debit_id` OR `accounts`.`id` = `transactions`.`account_credit_id`')
            ->where(['accounts.owner_id' => ExchangeController::get('entities', 'active_entity_id')])
            ->all(); 
        
        $accounts = Account::findAll(['owner_id' => ExchangeController::get('entities', 'active_entity_id')]);
        
        $accounts_forex = AccountForex::find()
            ->innerJoin('accounts', '`accounts`.`id` = `accounts_forex`.`account_id`')
            ->where(['accounts.owner_id' => ExchangeController::get('entities', 'active_entity_id')])
            ->all();
        
        // Remove All
        foreach ($transactions as $e) $e->delete();
        foreach ($transactions_forex as $e) $e->delete();
        foreach ($accounts as $e) $e->delete();
        foreach ($accounts_forex as $e) $e->delete();
        
        return $this->render('reset', [
            'transactions' => $transactions,
            'transactions_forex' => $transactions_forex,
            'accounts' => $accounts,
            'accounts_forex' => $accounts_forex
        ]);
        
    }
}
