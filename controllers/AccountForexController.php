<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use frontend\controllers\NotificationController;
use frontend\controllers\LocalizationController;

use frontend\modules\accounting\models\AccountForex;

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
    * Displays all forex accounts of the logged user
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
	
	/**
    * Displays one forex accounts identified by its $id
    */
	public function actionAccount($id) {
		$forex = AccountForex::find()
			->joinWith('account')
			->where(['accounts.owner_id' => Yii::$app->user->id])
			->andWhere(['accounts_forex.id' => $id])
			->all();
		return $this->render('account', [
			'forex' => $forex,
		]);
	}
}
