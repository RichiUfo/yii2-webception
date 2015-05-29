<?php

namespace app\modules\_template\controllers;

use app\modules\_template\models\Sample;

class SampleController extends \app\components\Controller
{
    public function actionIndex()
    {
		$samples = Sample::find()
			->where(1)
			->all();
		
        return $this->render('index', ['samples' => $samples]);
    }
}