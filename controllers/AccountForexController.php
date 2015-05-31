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
    * initAccount($name, $parent, $display)
    * Create a new account
    */
	public function actionDisplayForexAccount() {
		$forex = AccountForex::find()
			->where(1)
			->one();
		$account = $forex->account;
		return $this->render('display', [
			'forex' => $forex,
			//'account' => $account
		]);
	}
}
