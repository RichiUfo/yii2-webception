<?php

namespace frontend\modules\accounting;

class Module extends \frontend\components\Module
{
    public $controllerNamespace = 'frontend\modules\accounting\controllers';

	public $db_name;
	public $db_username;
	public $db_password;
	
	/**
     * Constructor.
     * @param string $id the ID of this module
     * @param Module $parent the parent module (if any)
     * @param array $config name-value pairs that will be used to initialize the object properties
     *
    public function __construct($id, $parent = null, $config = [])
    {
        parent::__construct($id, $parent, $config);
		
		// Open the database connection for the module
		$this->db = new \yii\db\Connection([
			'dsn' => 'mysql:dbname='.$this->db_name.';host=localhost',
			'username' => $this->db_username,
			'password' => $this->db_password,
		]);
		$this->db->open();
		
    }
	
	/**
     * Constructor.
     * @param string $id the ID of this module
     * @param Module $parent the parent module (if any)
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $this->db_name = 'fullplanner2_accounting'
        $this->db_username = 'accounting'
        $this->db_password = 'lECwn3sqj3_dv-X37fpHxdntrR0m0fWx'
			
		parent::__construct($id, $parent, $config);
		
    }
		
}
