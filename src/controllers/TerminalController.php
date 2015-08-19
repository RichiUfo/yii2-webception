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
                        'roles' => ['@'],
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
	
}