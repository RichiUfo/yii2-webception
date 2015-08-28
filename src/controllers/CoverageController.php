<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use godardth\yii2webception\models\Coverage;

/*
* TestController
* Groups all methods related to TestManagement
*/
class CoverageController extends Controller
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
    
    /*
    * Coverage Runner
    * Given a test type (acceptance, functional etc) and a sitename
    *
    * The route is called via AJAX and the return repsonse is JSON.
    */
    public function actionRunCoverage($site) {
        // Call the data generation command
        $siteObj = Site::findOne(['name' => $site]);
        $command = TerminalController::getCommandPath($siteObj, 'functional', null, true);
        TerminalController::run_terminal_command($command);
        
        // Return the coverage data
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return self::actionGetCoverage($site);
    }
    
    public static function actionGetCoverage($site) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $coverage = new Coverage($site);
        if(!$coverage->coverageDataExists())
            return false;    
        return $coverage;
        
    }
	 
}
