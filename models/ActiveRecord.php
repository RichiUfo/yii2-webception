<?php

namespace app\modules\_template\models;

class ActiveRecord extends \app\components\ActiveRecord
{

    public static function getDb()
	{
        $db = new \yii\db\Connection([
			'dsn' => 'mysql:dbname=fullplanner2_template;host=127.0.0.1',
			'username' => 'root',
			'password' => 'BvL3iSG2wg',
		]);
		$db->open();
		return $db;
   	}

}