<?php

namespace frontend\modules\_template\controllers;

class DefaultController extends \app\components\Controller
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
