<?php

namespace frontend\modules\accounting\controllers;

use yii\rest\ActiveController;

class AccountRestController extends ActiveController
{
    public $modelClass = 'frontend\modules\accounting\models\Account';
}