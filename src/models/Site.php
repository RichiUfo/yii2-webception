<?php

namespace godardth\yii2webception\models;

use Yii;

/**
 * This is the model class for Site.
 */
class Site extends \yii\db\ActiveRecord
{
    
    public $tests = array();
    
    public static function getDb()
	{
		return \Yii::$app->controller->module->db;
   	}
   	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'config'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'config' => 'Configuration File',
        ];
    }
    
    private function getTests() {
        return new Test;
    }
    
    public function __construct() {
        $this->tests = self::getTests();
    }
    
    // FROM ORIGINAL WEBCEPTION
    

    /**
     * Hash value of the current site.
     *
     * @var false if not set; string if set.
     */
    private $hash = false;

    /**
     * Set the current site.
     *
     * @param string if set, false if not.
     */
    public function set($hash=false)
    {
        // If hash matched in sites, set hash.
        if (isset($this->sites[$hash])) {
            $this->hash = $hash;
        } elseif ($hash == false && sizeof($this->sites) > 0) {
            // If no site set, but sites available,
            // pick the first in the list.
            reset($this->sites);
            $this->hash = key($this->sites);
        } else {
            // If no site found or none available,
            // set as false.
            $this->hash = false;
        }
    }

    /**
     * Return the name of the current site.
     *
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * Return the full path to the Codeception.yml for the current site.
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->get('path');
    }

    /**
     * Return just the path of the Codeception.yml file for the current site.
     *
     * @return string
     */
    public function getConfigPath()
    {
        $path = $this->get('path');

        return ($path !== false) ?
             dirname($path) . '/' : false;
    }

    /**
     * Return just the filename of the configuration file for the current site.
     *
     * Usually returns 'Codeception.yml'.
     *
     * @return string
     */
    public function getConfigFile()
    {
        $path = $this->get('path');

        return ($path !== false) ?
             basename($path) : false;
    }

    /**
     * Getter for site details.
     *
     * @param  string $value Name of the required field.
     * @return string (or FALSE if $value not set)
     */
    public function get($value)
    {
        return ($this->hash !== false) && isset($this->sites[$this->hash][$value])
                ? $this->sites[$this->hash][$value] : false;
    }

    /**
     * Return the hash of the current site.
     *
     * @return string (or FALSE if not set)
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Given a list of sites, prepare a unique hash
     * and tidy up the path to the Codeception configuration.
     *
     * @param  array $sites List of sites set in Codeception.php configuration.
     * @return array $filtered
     */
    public function prepare($sites = array())
    {
        $filtered = array();

        foreach ($sites as $name => $path) {
            $filtered[md5($name)] = array(
                'name' => $name,
                'path' => realpath(dirname($path)) .'/' . basename($path)
            );
        }

        return $filtered;
    }

    /**
     * Confirm if the Site details are valid.
     *
     * It counts that Sites are set and a hash was decided on __construct().
     *
     * @return boolean
     */
    public function ready()
    {
        return sizeof($this->sites) > 0 && $this->hash !== false;
    }
    
}
