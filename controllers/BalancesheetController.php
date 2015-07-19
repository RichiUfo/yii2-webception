<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use frontend\components\ExchangeController;

use frontend\modules\accounting\models\Transaction;
use frontend\modules\accounting\models\Account;
use frontend\modules\accounting\models\AccountPlus;
use frontend\modules\accounting\models\AccountHierarchy;

class BalancesheetController extends Controller
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
    
    public function getFinancialData(){
        
        $assets = AccountPlus::findOne(['owner_id' => ExchangeController::get('entities', 'active_entity_id'), 'name' => 'Assets']);
        $equity = AccountPlus::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Equity']);
        $liabilities = AccountPlus::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Liabilities']);
        
        $ret['total_assets'] = $assets->sign * $assets->value;
        $ret['total_equity'] = $equity->sign * $equity->value;
        $ret['total_liabilities'] = $liabilities->sign * $liabilities->value;
        
        $ret['debt_ratio'] = round(($ret['total_assets']!=0)?(100 * $ret['total_liabilities'] / $ret['total_assets']):0, 1);    
        
        return $ret;
    }
    
    public function getBalanceSheetHistoricalBalance($start, $end, $currency = null) {
        
        $eq = AccountPlus::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Equity']);
        $li = AccountPlus::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Liabilities']);
        
        $equity = AccountController::getHistoricalBalance($eq->id, $start, $end, $currency, 1);
        $liabilities = AccountController::getHistoricalBalance($li->id, $start, $end, $currency, 1);
        
        $ret = [];
        foreach($equity as $d => $v)
            $ret[$d] = [$equity[$d], $liabilities[$d]];
            
        return $ret;
    }
    
    public function actionIndex($start = '', $end ='') {
        
        $assets = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Assets']);
        $equity = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Equity']);
        $liabilities = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Liabilities']);
        
        /** 
         * AJAX -> Render the partial view
         */
        if(\Yii::$app->request->isAjax) {
            return $this->renderAjax('partial_balancesheet', [
                'assets' => $assets, 
                'equity' => $equity, 
                'liabilities' => $liabilities
            ]);
        }
        
        /** 
         * REGULAR -> Render the full view
         */
        else{
            $this->layout = '@app/views/layouts/one-column-header';
            return $this->render('balancesheet', [
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
                            ['icon' => 'plus', 'text' => 'Transaction', 'type' => 'modal_preload', 'route' => 'transaction/create'], 
                            ['icon' => 'plus', 'text' => 'Account', 'type' => 'modal_preload', 'route' => 'account/create'],
                        ]
                    ]
                ]
            ]);
        }
    }
    public function actionIndexHeader($start = '', $end ='') {
        
        // Get accounts data
        $assets = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Assets']);
        $equity = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Equity']);
        $liabilities = AccountHierarchy::findOne(['owner_id' => Yii::$app->user->id, 'name' => 'Liabilities']);
        
        // AJAX -> Render the partial view
        if(\Yii::$app->request->isAjax) {
            return $this->renderAjax('partial_balancesheet_header', [
                'assets' => $assets, 
                'equity' => $equity, 
                'liabilities' => $liabilities
            ]);
        }
    }
    /**
     * AJAX Actions Section (Returns Partials OR JSON)
     */
    public function actionOverview() {
        $data = $this->getFinancialData();
        
        return $this->renderAjax('overview', [
            'data' => $data
        ]);
    }
    
}