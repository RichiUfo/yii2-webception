<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/*
* TestController
* Groups all methods related to TestManagement
*/
class TestController extends Controller
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
    public function actionRunTest($hash) {
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $test = null;
        $sites = SiteController::getAvailableSites();
        foreach ($sites as $s) {
            foreach ($s->tests as $t) {
                if ($t->hash === $hash)
                    $test = $t;
            }
        }
        
        $response = [
            'message'     => null,
            'run'         => false,
            'passed'      => false,
            'state'       => 'error',
            'log'         => null
        ];
        
        if (is_null($response['message'])) {
            $this->run($test);
            
            //$response['run']    = $test->ran();
            //$response['log']    = $test->getLog();
            //$response['passed'] = $test->passed();
            //$response['state']  = $test->getState();
            //$response['title']  = $test->getTitle();
        }
        
        return $response;

    }
	    
	/**
     * Given a test, run the Codeception test.
     *
     * @param  Test $test Current test to Run.
     * @return Test $test Updated test with log and result.
     */
    public function run($test)
    {
        // Get the full command path to run the test.
        $command = TerminalController::getCommandPath($test->type, $test->filename);

        // Attempt to set the correct writes to Codeceptions Log path.
        //@chmod($this->getLogPath(), 0777);

        // Run the helper function (as it's not specific to Codeception)
        // which returns the result of running the terminal command into an array.
        $output  = TerminalController::run_terminal_command($command);

        // Add the log to the test which also checks to see if there was a pass/fail.
        $test->setLog($output);

        return $test;
    }
}
