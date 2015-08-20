<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/*
* TestController
* Groups all methods related to TestManagement
*/
class SiteController extends Controller
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
    
    public function getAvailableTests($site) {
        // To Be Implemented
    }
    
    
    /*
    * Test Runner
    * Given a test type (acceptance, functional etc) and a hash,
    * load all the tests, find the test and then run it.
    *
    * The route is called via AJAX and the return repsonse is JSON.
    */
    public function actionRunTest($start='', $end='') {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // TO BE COMPLETE
        $response = null;
        
        return $response;

    }
	
}
