<?php

namespace godardth\yii2webception\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for Codeception.
 */
class Coverage extends \yii\base\Model
{
    
    public $site;
    
    public $classes;
    public $coveredconditionals;
    public $conditionals;
    public $coveredstatements;
    public $statements;
    public $coveredmethods;
    public $methods;
    
    public $coverage_lines;
    public $coverage_methods;
    public $coverage_class;

    
    public function __construct($site) {
        
        // Class Properties
        $this->site = $site;
        
        // Parse the previous XML (if any)
        $url = Url::to('tests/'.$this->site.'/coverage.xml');
        $data = simplexml_load_file($url);
        $metrics = (array)$data->xpath("/coverage/project/metrics")[0]->attributes();
        
        // Raw values
        $this->classes = $metrics['@attributes']['classes'];
        $this->coveredconditionals = $metrics['@attributes']['coveredconditionals']; 
        $this->conditionals = $metrics['@attributes']['conditionals'];
        $this->coveredstatements = $metrics['@attributes']['coveredstatements'];
        $this->statements = $metrics['@attributes']['statements']; 
        $this->coveredmethods = $metrics['@attributes']['coveredmethods']; 
        $this->methods = $metrics['@attributes']['methods'];
        
        // Calculations
        $coverage_lines = 0;
        $coverage_methods = 100 * ((int)$this->coveredmethods / (int)$this->methods);
        $coverage_class = 0 * ($this->classes);
    }
    
}
