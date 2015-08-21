<?php
return [
    'components' => [
        // list of component configurations
    ],
    'params' => [
        
        /*
        |--------------------------------------------------------------------------
        | Webception Settings
        |--------------------------------------------------------------------------
        */
    
        'webception' =>[
            'version'    => '0.1.0',
            'name'       => '<strong>Web</strong>ception',
            'repo'       => 'https://github.com/jayhealey/webception',
            'twitter'    => '@WebceptionApp',
            'config'     => 'App/Config/codeception.php',
            'test'       => 'App/Tests/_config/codeception_%s.php',
        ],
        
    
        /*
        |--------------------------------------------------------------------------
        | Codeception Executable
        |--------------------------------------------------------------------------
        |
        | Codeception is installed as a dependancy of Webception via Composer.
        |
        | You might need to set 'sudo chmod a+x vendor/bin/codecept' to allow Apache
        | to execute the Codeception executable.
        |
        */
    
        'executable' => Yii::getAlias('@vendor') . '/bin/codecept',
    
        /*
        |--------------------------------------------------------------------------
        | You get to decide which type of tests get included.
        |--------------------------------------------------------------------------
        */
    
        'tests' => [
            'acceptance' => true,
            'functional' => true,
            'unit'       => true,
        ],
    
        /*
        |--------------------------------------------------------------------------
        | When we scan for the tests, we need to ignore the following files.
        |--------------------------------------------------------------------------
        */
    
        'ignore' => [
            'WebGuy.php',
            'TestGuy.php',
            'CodeGuy.php',
            '_bootstrap.php',
            '.DS_Store',
            // Ignoring the default tests created by codeception
            'AcceptanceTester.php',
            'FunctionalTester.php',
            'UnitTester.php',
        ],
    
        /*
        |--------------------------------------------------------------------------
        | Setting the location as the current file helps with offering information
        | about where this configuration file sits on the server.
        |--------------------------------------------------------------------------
        */
    
        'location' => __FILE__,
    ],
];