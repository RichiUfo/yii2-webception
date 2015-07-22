<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\filters\AccessControl;

//use frontend\controllers\NotificationController;
//use frontend\controllers\LocalizationController;

//use frontend\modules\accounting\models\Transaction;
//use frontend\modules\accounting\models\TransactionPlus;
//use frontend\modules\accounting\models\TransactionForex;
//use frontend\modules\accounting\models\Account;
//use frontend\modules\accounting\models\AccountPlus;
//use frontend\modules\accounting\models\AccountHierarchy;

class SummmaryController extends \frontend\components\Controller
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
    
    public function renderEntitySummary() {
        return $this->render('entity');
    }
    
    
}