<?php

namespace frontend\modules\accounting\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use frontend\modules\accounting\models\Transaction;
use frontend\modules\accounting\models\Account;
use frontend\modules\accounting\models\AccountPlus;
use frontend\modules\accounting\models\AccountHierarchy;

class ProfitlossController extends \frontend\components\Controller
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
    
    public function actionIndex($start = '', $end ='')
    {
        
        /** 
         * AJAX -> Render the partial view
         */
        if(\Yii::$app->request->isAjax) {
            
            $operating_revenues = AccountHierarchy::findOne([
                'owner_id' => Yii::$app->user->id, 
                'name' => 'Operating Revenues'
            ]);
            $non_operating_revenues = AccountHierarchy::findOne([
                'owner_id' => Yii::$app->user->id, 
                'name' => 'Non-Operating Revenues And Gains'
            ]);
            $operating_expenses = AccountHierarchy::findOne([
                'owner_id' => Yii::$app->user->id, 
                'name' => 'Operating Expenses'
            ]);
            $non_operating_expenses = AccountHierarchy::findOne([
                'owner_id' => Yii::$app->user->id, 
                'name' => 'Non-Operating Expenses And Losses'
            ]);
            
            return $this->renderAjax('partial_profitloss', [
                'operating_revenues' => $operating_revenues, 
                'non_operating_revenues' => $non_operating_revenues,
                'operating_expenses' => $operating_expenses,
                'non_operating_expenses' => $non_operating_expenses,
            ]);
        }
        
        /** 
         * REGULAR -> Render the full view
         */
        else{
            $this->layout = '@app/views/layouts/two-columns-left';
            return $this->render('profitloss', [
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
                        'title' => 'Accounting', 'items' => [
                            ['icon' => 'plus', 'text' => 'Transaction', 'type' => 'modal_preload', 'route' => 'transaction/create'],
                            ['icon' => 'plus', 'text' => 'Account', 'type' => 'modal_preload', 'route' => 'transaction/create'],
                        ]
                    ]
                ]
            ]);
        }
    }
    
    public function actionOverview()
    {
        return $this->renderAjax('overview', [
            'data' => null
        ]);
    }
    
    
}