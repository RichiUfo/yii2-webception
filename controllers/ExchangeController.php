<?php

namespace frontend\modules\finance\controllers;

use Yii;
use yii\filters\AccessControl;

use frontend\modules\accounting\models\ForexRate;

class ExchangeController extends \frontend\components\Controller
{
    public static function getDb()
	{
		return \Yii::$app->getModule('accounting')->db;
   	}
    
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
   
    public function get($data, $params = []) {
        switch ($data) {
            case 'entity_summary':
                return SummaryController::renderEntitySummary($params);
                break;
            default:
                return null;
        }
    }
    
}
