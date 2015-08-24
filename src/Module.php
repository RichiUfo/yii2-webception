<?php

namespace godardth\yii2webception;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'godardth\yii2webception\controllers';
	
	// Database related 
	public $db;
	public $db_name;
	public $db_username;
	public $db_password;
	
	/**
     * Constructor.
     * @param string $id the ID of this module
     * @param Module $parent the parent module (if any)
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($id, $parent = null, $config = [])
    {
        parent::__construct($id, $parent, $config);
        
        $this->db_name = 'yii2_webception';
        $this->db_username = 'fullplanner2';
        $this->db_password = 'fxUYjM7U7Ua5bDRb';
		
		// Open the database connection for the module
		$this->db = new \yii\db\Connection([
			'dsn' => 'mysql:dbname='.$this->db_name.';host=localhost',
			'username' => $this->db_username,
			'password' => $this->db_password,
		]);
		$this->db->open();
		
		$this->layout = 'layout/main.php';
    }
    
    public function init()
	{
	    parent::init();
	    // initialize the module with the configuration loaded from config.php
	    \Yii::configure($this, require(__DIR__ . '/config/config.php'));
	}
		
}
