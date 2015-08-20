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
    
    public function getAvailableSites() {
        return Site::findAll();
    }
    
    
	
}
