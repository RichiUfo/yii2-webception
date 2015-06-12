<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use frontend\modules\accounting\models\Account;

use frontend\controllers\NotificationController;
use frontend\controllers\LocalizationController;

use frontend\modules\accounting\models\AccountForex;
use frontend\modules\accounting\models\TransactionForex;

class AccountForexController extends \frontend\components\Controller
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
    
	/**
    * Methods
    */
	public function createForexAccount($name, $parentid, $display, $currency) {
		$account = AccountController::createAccount($name, $parentid, $display, 'forex_trading');
		$forex = new AccountForex;
		$forex->forex_currency = $currency;
		$forex->account_id = $account->id; 
		$forex->save();
	}
	public function getForexAccount($currency) {
		$trad_acc = AccountForex::find()
			->joinWith('account')
			->where(['accounts.owner_id' => Yii::$app->user->id])
			->andWhere(['forex_currency' => $currency])
			->one();
		
		if(!$trad_acc) {
			$parent = Account::find()
				->where(['owner_id' => Yii::$app->user->id])
				->andWhere(['name' => 'Forex Unrealized Profits and Losses'])
				->one();
			$name = $currency;
			$trad_acc = AccountForexController::createForexAccount($name, $parent->id, 1, $currency);
		}
			
		return $trad_acc;
		
	}
	public function updateRealizedProfits($account, $transaction) {
		
		// Useful Variables
		$account->forex_value;
		
		$operations = TransactionForex::find()
			->where(['account_forex_id' => $account->id])
			->all();
		
		$ope = [];
		foreach($operations as $op){
			if($op->transaction->accountDebit->id === $account->account->id){
				array_push($ope, [$op->id.' is buy']);
			}
			else {
				array_push($op->id.' is sell');
			}
		}
		return $ope;
		
		// Update the realized value AND save in database
		$account->realized = 0;
		$account->save();
	}
	
    /**
    * Actions
    */
	public function actionAccounts() {
		$forex = AccountForex::find()
			->joinWith('account')
			->where(['accounts.owner_id' => Yii::$app->user->id])
			->all();
		return $this->render('accounts', [
			'forex' => $forex,
		]);
	}
	public function actionAccount($id) {
		$account = AccountForex::find()
			->joinWith('account')
			->where(['accounts.owner_id' => Yii::$app->user->id])
			->andWhere(['accounts_forex.id' => $id])
			->one();
			
		return $this->render('account', [
			'account' => $account,
		]);
	}
	
	public function actionTest($accid, $traid) {
		$acc = AccountForex::findOne($accid);
		$tra = TransactionForex::findOne($traid);
		$res = AccountForexController::updateRealizedProfits($acc, $tra);
		return $this->render('test', ['res' => $res]);
	}
	
}
