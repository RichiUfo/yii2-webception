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
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $coverage = new Coverage($site);
        var_dump($coverage->data);
        //return $coverage->data->coverage;

    }
	    
	/**
     * Given a site and types, run the Codeception coverage test.
     *
     * @param  Test $test Current test to Run.
     * @return Test $test Updated test with log and result.
     */
    /*public function run($site, $type=[])
    {
        // Get the full command path to run the test.
        $command = TerminalController::getCommandPath($site, $test->type, $test->filename);


        // Run the helper function (as it's not specific to Codeception)
        // which returns the result of running the terminal command into an array.
        $output  = TerminalController::run_terminal_command($command);

        // Add the log to the test which also checks to see if there was a pass/fail.
        $test->setLog($output);

        return $test;
    }*/
}
