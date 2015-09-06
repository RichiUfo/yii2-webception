<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use godardth\yii2webception\models\Site;

/*
* SiteController
* Groups all methods related to Site Management
*/
class SiteController extends Controller
{
    
    /**
     * @inheritdoc
     */
    /*public function behaviors()  {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }*/
    
    public function getAvailableSites() {
        return Site::find()->where(1)->all();
    }
    
    
    public function checkWriteableLog($site) {
        
        $response = array();
        $response['resource'] = $site->directories['log'];

        if (is_null($path)) {
            $response['error'] = 'The Codeception Log is not set. Is the Codeception configuration set up?';
        } elseif (! file_exists($path)) {
            $response['error'] = 'The Codeception Log directory does not exist. Please check the following path exists:';
        } elseif (! is_writeable($path)) {
            $response['error'] = 'The Codeception Log directory can not be written to yet. Please check the following path has \'chmod 777\' set:';
        }

        $response['passed'] = ! isset($response['error']);

        return $response;
    }
	
}
