<?php

namespace frontend\modules\accounting\controllers;

class DefaultController extends \frontend\components\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	/** You can access this action at the following URL 
	* [MODULE_NAME]/default/another-action **/
    public function actionAnotherAction()
    {
        return $this->render('another-view');
    }
}
