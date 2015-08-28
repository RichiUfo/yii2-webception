<?php

namespace godardth\yii2webception\models;

use Yii;
use yii\helpers\Url;

/**
 * Defining the types stored in coverage.xml
 */
class CovBaseElement {
    public $children = [];
}
class CovCoverage extends BaseElement {
    public $generated;
}
class CovProject extends BaseElement {
    public $timestamp;
}
class CovPackage extends BaseElement {
    public $name;
}
class CovFile extends BaseElement {
    public $name;
}
class CovClass extends BaseElement {
    public $name;
    public $namespace;
}
class CovMetrics  extends BaseElement {
    public $methods;
    public $coveredmethods;
    public $conditionals;
    public $coveredconditionals;
    public $statements;
    public $coveredstatements;
    public $elements;
    public $coveredelements;
    public $loc;
    public $ncloc;
    public $classes;
    public $files;
}
class CovLine extends BaseElement {
    public $num;
    public $type;
    public $name;
    public $crap;
    public $count;
}

/**
 * This is the model class for Codeception.
 */
class Coverage extends \yii\base\Model
{
    
    public $site;
    public $metrics;
    
    public function __construct($site) {
        
        // Class Properties
        $this->site = $site;
        
        // Parse the previous XML (if any)
        $url = Url::to('tests/'.$this->site.'/coverage.xml');
        $filename = $url;
        $data = simplexml_load_file($url);
        $this->metrics = $data->xpath("/coverage/project/metrics");
    }
    
}
