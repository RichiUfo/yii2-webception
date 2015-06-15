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
		
		// SALES -- Amount of foreign currency sold AND Revenue from currency sales RFCS)
		$sold_forex_amount = 0;
		$rfcs = 0;
		foreach($operations as $op) {
			if($op->transaction->accountCredit->id === $account->account->id) {
				$sold_forex_amount += $op->forex_value;		// In foreign currency
				$rfcs += $op->transaction->value;			// In base currency
			}
		}
	
		// PURCHASES -- Cost of currency sold (COCS)
		$purchased_forex_amount = 0;
		$cocs = 0;
		foreach($operations as $op) {
			if($op->transaction->accountDebit->id === $account->account->id) {
				if ($purchased_forex_amount + $op->forex_value < $sold_forex_amount) {
					$cocs += $op->transaction->value;
					$purchased_forex_amount += $op->forex_value;
				}
				else if ($purchased_forex_amount < $sold_forex_amount) {
					$cocs += ($sold_forex_amount - $purchased_forex_amount) * $op->transaction->value / $op->forex_value;
				}
			}
		}
		
		// Update the realized value AND save in database
		$account->realized = $rfcs - $cocs; 		// Revenue - Cost
		$account->save();
		return [$account, $rfcs, $cocs, $sold_forex_amount, $operations];
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
