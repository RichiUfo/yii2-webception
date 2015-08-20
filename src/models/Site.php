<?php

namespace godardth\yii2webception\models;

use Yii;

/**
 * This is the model class for Site.
 */
class Site extends \yii\db\ActiveRecord
{
    
    public $directories = array();
    public $tests = [1];
    public $configuration = null;
    
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
    public function attributeLabels() {
        return [
            'name' => 'Name',
            'config' => 'Configuration File',
        ];
    }
    
    public function loadConfig($full_path) {
        $path = pathinfo($full_path)['dirname'] . '/';
        $file = pathinfo($full_path)['basename'];

        // If the Codeception YAML can't be found, the application can't go any further.
        if (! file_exists($full_path))
            return false;

        // Using Symfony's Yaml parser, the file gets turned into an array.
        $config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($full_path));

        // Update the config to include the full path.
        foreach ($config['paths'] as $key => &$test_path) {
            $test_path = file_exists($path . $test_path) ?
                 realpath($path . $test_path) : $path . $test_path;
        }

        return $config;
    }
    
    public function addTest($test) {
        array_push($this->tests, $test);
    }
    
    public function getTests() {
        
        $types = array(
            'acceptance' => true,
            'functional' => true,
            'unit'       => true,
        );
        
        foreach ($types as $type => $active) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator("{$this->configuration['paths']['tests']}/{$type}/", \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );
    
            // Iterate through all the files, and filter out
            //      any files that are in the ignore list.
            foreach ($files as $file) {
                //if (! in_array($file->getFilename(), $this->configuration['ignore']) && $file->isFile())
                if ($file->isFile())
                {
                    // Declare a new test and add it to the list.
                    $test = new Test();
                    //$test->init($type, $file);
                    $test->title = $file->getFilename();
                    array_push($this->tests, $test);
                    //unset($test);
                }
    
            }
        }
    }
    
    public function afterFind() {
        parent::afterFind();
        $this->configuration = self::loadConfig($this->config);
        $this->tests = $this->getTests();
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
