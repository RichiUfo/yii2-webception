<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use app\modules\accounting\models\Transaction;
use app\modules\accounting\models\Account;
use app\modules\accounting\models\AccountPlus;
use app\modules\accounting\models\AccountHierarchy;

class CashflowController extends \frontend\components\Controller
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
    
    public function actionIndex()
    {
        
       
    }
    
    public function actionOverview()
    {
        //$data = $this->getFinancialData();
        
        return $this->renderAjax('overview', [
            'data' => null
        ]);
    }
    
    
}