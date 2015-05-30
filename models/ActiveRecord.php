<?php

namespace frontend\modules\accounting\models;

class ActiveRecord extends \frontend\components\ActiveRecord
{
	
	public $db_name = 'fullplanner2_accounting';
	public $db_username = 'accounting';
	public $db_password = 'lECwn3sqj3_dv-X37fpHxdntrR0m0fWx';
	
    public static function getDb()
	{
        /*$db = new \yii\db\Connection([
			'dsn' => 'mysql:dbname=fullplanner2_accounting;host=localhost',
			'username' => 'accounting',
			'password' => 'lECwn3sqj3_dv-X37fpHxdntrR0m0fWx',
		]);
		$db->open();*/
		return $this->db;
   	}

}