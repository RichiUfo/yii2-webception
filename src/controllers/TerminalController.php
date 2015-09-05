<?php

namespace godardth\yii2webception\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/*
* TerminalController
* Groups all methodes interaction with the system terminal
*/
class TerminalController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()  {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Run a terminal command.
     *
     * @param  string $command
     * @return array  Each array entry is a line of output from running the command.
     */
    public function run_terminal_command($command)
    {
        $output = array();

        $spec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );

        flush();

        $process = proc_open($command, $spec, $pipes, realpath('./'), $_ENV);

        if (is_resource($process)) {

            while ($line = fgets($pipes[1])) {

                // Trim any line breaks and white space
                $line = trim(preg_replace("/\r|\n/", "", $line));

                // If the line has content, add to the output log.
                if (! empty($line))
                    $output[] = $line;

                flush();
            }
        }

        return $output;
    }
    
    /**
     * Full command to run a Codeception test.
     *
     * @param  string $type     Test Type (Acceptance, Functional, Unit)
     * @param  string $filename Name of the Test
     * @return string Full command to execute Codeception with requred parameters.
     */
    public function getCommandPath($site, $type, $filename, $coverage=false)
    {
        $config = \Yii::$app->controller->module->params;
        
        // Build all the different parameters as part of the console command
        if($coverage) {
            $params = array(
                $config['executable'],                          // Codeception Executable
                "run",                                          // Command to Codeception
                "--no-colors",                                  // Forcing Codeception to not use colors, if enabled in codeception.yml
                "--config=\"{$site->config}\"",                 // Full path & file of Codeception
                $type,                                          // Test Type (Acceptance, Unit, Functional)
                "--coverage --coverage-xml --coverage-html",    // COVERAGE
                "2>&1"                                          // Added to force output of running executable to be streamed out
            );
        }
        else {
            $params = array(
                $config['executable'],              // Codeception Executable
                "run",                              // Command to Codeception
                "--no-colors",                      // Forcing Codeception to not use colors, if enabled in codeception.yml
                "--config=\"{$site->config}\"",     // Full path & file of Codeception
                $type,                              // Test Type (Acceptance, Unit, Functional)
                $filename,                          // Filename of the Codeception test
                "2>&1"                              // Added to force output of running executable to be streamed out
            );
        }

        // Build the command to be run.
        return implode(' ', $params);
    }
	
}
