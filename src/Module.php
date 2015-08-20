<?php

namespace godardth\yii2webception;

class Module extends \frontend\components\Module
{
    public $controllerNamespace = 'godardth\yii2webception\controllers';
	
	/**
     * Constructor.
     * @param string $id the ID of this module
     * @param Module $parent the parent module (if any)
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $this->db_name = 'yii2_webception';
        $this->db_username = 'fullplanner2';
        $this->db_password = 'fxUYjM7U7Ua5bDRb';
			
		parent::__construct($id, $parent, $config);
		
    }
		
}
