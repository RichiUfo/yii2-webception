<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/*
* CodeceptionController
* Groups all methodes interaction with the codeception executable
*/
class CodeceptionController extends Controller
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
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
        
    /**
     * Check that the Codeception executable exists and is runnable.
     *
     * @param  string $file   File name of the Codeception executable.
     * @param  string $config Full path of the config of where the $file was defined.
     * @return array  Array of flags used in the JSON respone.
     */
    public function checkExecutable() {
        
        $config = \Yii::$app->controller->module->params;
        $file = $config['executable'];
        $config = $config['location'];
        
        $response= array();
        $response['resource'] = $file;

        if (! file_exists($file)) {
            $response['error'] = 'The Codeception executable could not be found. ('.$file.')';
        } elseif ( ! is_executable($file) && strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            $response['error'] = 'Codeception isn\'t executable. Have you set executable rights to the following (try chmod o+x).';
        }

        // If there wasn't an error, then it's good!
        $response['passed'] = ! isset($response['error']);

        return $response;
    }
        
    /**
     * Check that the Codeception configuratio has been loaded.
     */
    public function checkConfiguration() {
        
        $config = \Yii::$app->controller->module->params;
        
        return !empty($config);
    }
    
}
