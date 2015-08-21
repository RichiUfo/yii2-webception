<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
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
        
        $sites = SiteController::getAvailableSites();
        
        $checks = [
            'configuration' => null,  
            'executable' => CodeceptionController::checkExecutable(),
            'writeable' => null
        ];
        
        return $this->render('index', [
            'sites' => $sites, 
            'checks' => $checks
        ]); 

    }
    
	
}
