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

        if (! isset($this->config['tests']))
            return;

        foreach ($this->config['tests'] as $type => $active) {

            // If the test type has been disabled in the Webception config,
            //      skip processing the directory read for those tests.
            if (! $active)
                break;

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator("{$this->config['paths']['tests']}/{$type}/", \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            // Iterate through all the files, and filter out
            //      any files that are in the ignore list.
            foreach ($files as $file) {

                if (! in_array($file->getFilename(), $this->config['ignore'])
                   && $file->isFile())
                {
                    // Declare a new test and add it to the list.
                    $test = new Test();
                    $test->init($type, $file);
                    $this->addTest($test);
                    unset($test);
                }
            }
        }
    }
    
    
    /*
    * Test Runner
    * Given a test type (acceptance, functional etc) and a hash,
    * load all the tests, find the test and then run it.
    *
    * The route is called via AJAX and the return repsonse is JSON.
    */
    public function actionRunTest() {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // TO BE COMPLETE
        $response = 'Not Implemented yet';
        
        return $response;

    }
	
}
