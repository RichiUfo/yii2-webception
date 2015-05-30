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

class BalancesheetController extends Controller
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
    
    public function getFinancialData(){
        
        $assets = AccountPlus::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Assets']);
        $equity = AccountPlus::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Equity']);
        $liabilities = AccountPlus::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Liabilities']);
        
        $ret['total_assets'] = $assets->display_value;
        $ret['total_equity'] = $equity->display_value;
        $ret['total_liabilities'] = $liabilities->display_value;
        
        $ret['debt_ratio'] = round(($assets->display_value!=0)?(100 * $liabilities->display_value / $assets->display_value):0, 1);    
        
        return $ret;
    }
    
    public function actionIndex()
    {
        $assets = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Assets']);
        $equity = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Equity']);
        $liabilities = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Liabilities']);
        
        $this->layout = '@app/views/layouts/three-columns';
        return $this->render('balance-sheet', [
            'assets' => $assets, 
            'equity' => $equity, 
            'liabilities' => $liabilities,
            'back_button' => ['text' => 'Accounting', 'route' => '/accounting'],
            'left_menus' => [
                [
                    'title' => 'Reporting', 'items' => [
                        ['icon' => 'pie-chart', 'text' => 'Balance Sheet', 'type' => 'regular', 'route' => '/accounting/balancesheet'],
                        ['icon' => 'bar-chart', 'text' => 'Income', 'type' => 'regular', 'route' => '/accounting/profitloss'],
                        ['icon' => 'random', 'text' => 'Cash Flow', 'type' => 'regular', 'route' => '/accounting'],
                    ]
                ],
                [
                    'title' => 'Operations', 'items' => [
                        ['icon' => 'plus', 'text' => 'Transaction', 'type' => 'modal', 'route' => 'transaction/create'],
                        ['icon' => 'plus', 'text' => 'Account', 'type' => 'modal', 'route' => 'account/create'],
                    ]
                ]
            ]
        ]);
    }
    
    public function actionOverview()
    {
        $data = $this->getFinancialData();
        
        return $this->renderAjax('overview', [
            'data' => $data
        ]);
    }
    
}