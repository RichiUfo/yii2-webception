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
        
        // Test Logging For Each Site
        $logging_passed = true;
        foreach ($sites as $site) {
            if (!$site->logging['passed'])
                $logging_passed = false;
        }
        
        $checks = [
            'configuration' => CodeceptionController::checkConfiguration(),  
            'executable' => CodeceptionController::checkExecutable(),
            'logging' => $logging_passed
        ];
        
        return $this->render('index', [
            'sites' => $sites, 
            'checks' => $checks
        ]); 

    }
    
	
}
