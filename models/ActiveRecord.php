<?php

namespace frontend\modules\accounting\models;

class ActiveRecord extends \frontend\components\ActiveRecord
{
	
    public static function getDb()
	{
		return \Yii::$app->controller->module->db;
   	}

}