<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use frontend\modules\accounting\models\AccountHierarchy;

class DefaultController extends \frontend\components\Controller
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
        $data = BalancesheetController::getFinancialData();
    
        $this->layout = '@app/views/layouts/three-columns';
        return $this->render('index' , [
            'data' => $data,
            'back_button' => ['text' => 'Home', 'route' => '/'],
            'left_menus' => [
                [
                    'title' => 'Reporting', 'items' => [
                        ['icon' => 'pie-chart', 'text' => 'Balance Sheet', 'type' => 'regular', 'route' => '/accounting/balancesheet'],
                        ['icon' => 'bar-chart', 'text' => 'Income', 'type' => 'regular', 'route' => '/accounting/profitloss'],
                        ['icon' => 'random', 'text' => 'Cash Flow', 'type' => 'regular', 'route' => '/accounting'],
                    ]
                ],
                [
                    'title' => 'Accounting', 'items' => [
                        ['icon' => 'plus', 'text' => 'Transaction', 'type' => 'modal', 'route' => 'transaction/create'],
                        ['icon' => 'plus', 'text' => 'Account', 'type' => 'modal', 'route' => 'account/create'],
                    ]
                ]
            ]
        ]);
    }
}
