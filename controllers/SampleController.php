<?php

namespace frontend\modules\_template\controllers;

use frontend\modules\_template\models\Sample;

class SampleController extends \frontend\components\Controller
{
    public function actionIndex()
    {
		$samples = Sample::find()
			->where(1)
			->all();
		
        return $this->render('index', ['samples' => $samples]);
    }
}