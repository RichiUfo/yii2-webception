<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use app\modules\accounting\models\Transaction;
use app\modules\accounting\models\Account;
use app\modules\accounting\models\AccountPlus;
use app\modules\accounting\models\AccountHierarchy;

class AssetController extends \frontend\components\Controller
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
    
    
    public function actionOverview()
    {
        return $this->renderAjax('overview');
    }
    
}
