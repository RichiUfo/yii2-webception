<?php

namespace godardth\yii2webception;

class Module extends \frontend\components\Module
{
    public $controllerNamespace = 'frontend\modules\accounting\controllers';
	
	/**
     * Constructor.
     * @param string $id the ID of this module
     * @param Module $parent the parent module (if any)
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $this->db_name = 'fullplanner2_accounting';
        $this->db_username = 'accounting';
        $this->db_password = 'lECwn3sqj3_dv-X37fpHxdntrR0m0fWx';
			
		parent::__construct($id, $parent, $config);
		
    }
		
}
