<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use frontend\components\ExchangeController;

use frontend\modules\accounting\models\Account;
use frontend\modules\accounting\models\AccountHierarchy;

class DefaultController extends \frontend\components\Controller
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()  {
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
	 * Routed Actions - Views Rendering
	 */
    public function actionIndex($start='', $end='') {
        $data = BalancesheetController::getFinancialData();
    
        if(\Yii::$app->request->isAjax) {
            
            // Get the balance sheet accounts evolution
            $balancesheet = BalancesheetController::getBalanceSheetHistoricalBalance($start, $end);
            
            return $this->renderAjax('partial_summary', [
                'start' => $start,
                'end' => $end,
                'data' => $data,
                'balancesheet' => $balancesheet
            ]);
        }
        else{
            $this->layout = '@app/views/layouts/one-column-header';
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
                            ['icon' => 'plus', 'text' => 'Transaction', 'type' => 'modal_preload', 'route' => 'transaction/create'], 
                            ['icon' => 'plus', 'text' => 'Account', 'type' => 'modal_preload', 'route' => 'account/create'],
                        ]
                    ]
                ],
                'start' => $start,
                'end' => $end
            ]);
        }
    }
    public function actionIndexHeader($start='', $end='') {
        $data = BalancesheetController::getFinancialData();
    
        if(\Yii::$app->request->isAjax) {
            
            // Get the balance sheet accounts evolution
            $balancesheet = BalancesheetController::getBalanceSheetHistoricalBalance($start, $end);
            
            return $this->renderAjax('partial_summary_header', [
                'start' => $start,
                'end' => $end,
                'data' => $data,
                'balancesheet' => $balancesheet
            ]);
        }
    }
    
	
}
