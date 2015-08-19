<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use godardth\yii2webception\models\Codeception;

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
    public function actionIndex() {
        
        //$param = \Yii::$app->controller->module->params['tests'];
        
        $tests       = false;
        $test_count  = 0;
        $webception  = $app->config('webception');
        $codeception = new Codeception;
    
        /*if ($codeception->ready()) {
            $tests      = $codeception->getTests();
            $test_count = $codeception->getTestTally();
        }*/
        
        return $this->render('index', [
            'name'        => '$app->getName()',
            'webception'  => $webception,
            'codeception' => $codeception,
            'tests'       => $tests,
            'test_count'  => $test_count,
        ]);

    }
    
	
}
