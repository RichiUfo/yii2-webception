<?php

namespace godardth\yii2webception\models;

use Yii;

/**
 * This is the model class for Test.
 */
class Test extends \yii\base\Model
{
    
    /**
     * Possible test states
     */
    const STATE_PASSED = 'Passed';
    const STATE_FAILED = 'Failed';
    const STATE_ERROR  = 'Error';
    const STATE_READY  = 'Ready';
    
    /**
     * MD5 of the file name
     *
     * @var string
     */
    private $hash;

    /**
     * Filename of the test.
     *
     * @var string
     */
    public $filename;

    /**
     * Readable version of the filename
     *
     * @var string
     */
    public $title;

    /**
     * The file object.
     *
     * @var SplFileInfo
     */
    private $file;

    /**
     * Test Type: Functional, Acceptance or Unit.
     *
     * @var string
     */
    public $type;

    /**
     * Log of the test result
     *
     * @var array  Each array entry is a console log line.
     */
    private $log = array();

    /**
     * Result of running the test.
     *
     * @var bool
     */
    private $passed = false;

    private $state;

    /**
     * List of responses that can occur from Codeception.
     *
     * Using these, we scan the result when log is added to the test.
     *
     * @var array
     */
    private $responses = array(
        'timeout'   => 'Operation timed out after',
        'writeable' => 'Path for logs is not writable',
        'passed'    => array(
            'PASSED',   // Functional & Acceptance Test
            'OK \('     // Unit Test
        ),
        'failed'    => 'FAILURES',
    );

    /**
     * On Test __construct, the passed matches are turned into a regex.
     *
     * @var string
     */
    private $passed_regex;
    private $failure_regex;

    /**
     * Colour tags from Codeception's coloured output.
     *
     * @var array
     */
    private $colour_codes = array(
        "[37;45m",
        "[2K",
        "[1m",
        "[0m",
        "[30;42m",
        "[37;41m",
        "[33m",
        "[36m",
        "[35;1m",
        "-",
    );

    /**
     * File extensions to remove from the output.
     *
     * @var array
     */
    private $filtered_files = array(
        'Cept.php',
        'Cest.php',
        'Test.php',
    );


    public function __construct()
    {
        // Declare the regex string containing all the responses that
        // can indicate that as a passed test.
        $this->passed_regex = implode('|', $this->responses['passed']);

        // maybe there will be any more failures? Then we are going to need this
        $this->failure_regex = $this->responses['failed'];
        
        $this->state = self::STATE_READY; 
    }

    /**
     * Initialization of the Test
     *
     * @param string $type Type of Test
     * @param object $file File for the Test
     */
    public function initialize($type, $file)
    {
        $filename       = $this->filterFileName($file->getFileName());
        $posTypePath    = strpos($file->getPathname(), "/{$type}/") + strlen("/{$type}/");

        $this->hash     = $this->makeHash($file->getPathname());
        $this->title    = $this->filterTitle($filename);
        $this->filename = substr($file->getPathname(), $posTypePath);
        $this->file     = $file;
        $this->type     = $type;
        $this->state    = self::STATE_READY; 
    }

    /**
     * Filter out content from a title any to improve readability of the test name
     *
     * @param  string $filename
     * @return string
     */
    public function filterFileName($filename)
    {
        return str_ireplace($this->filtered_files, '', $filename);
    }

    /**
     * Generate a unique hash for the test.
     *
     * @param  string $string
     * @return string MD5 of $string
     */
    public function makeHash($string)
    {
        return md5($string);
    }

    /**
     * Turn a "CamelCasedString" into "Camel Cased String".
     * This is to improve readability of the test list.
     *
     * @param  string $title
     * @return string
     */
    public function filterTitle($title)
    {
        return trim(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $title));
    }


    /**
     * Get the Test Hash
     *
     * The hash is the Test title that's been md5'd.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get the Test type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the file Filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set if the test has been passed.
     *
     * @return boolean
     */
    public function setPassed()
    {
        $this->passed = true;
    }

    /**
     * Sets passed to false if test fails
     */
    public function setFailed()
    {
        $this->passed = false;
    }

    /**
     * Return if the test was run and passed
     *
     * @return boolean
     */
    public function passed()
    {
        return $this->passed;
    }

    /**
     * Return if the test was successfully run.
     *
     * This is deteremined by simply checking the length of the log.
     *
     * @return boolean
     */
    public function ran()
    {
        return sizeof($this->log) > 0;
    }

    /**
     * Get the Test state based on if the test has run or passed.
     *
     * @return boolean
     */
    public function getState()
    {
        return ($this->passed() ? self::STATE_PASSED :
               ($this->ran()    ? self::STATE_FAILED : self::STATE_ERROR));
    }

    /**
     * Add a new line entry to the Test log.
     *
     * Also check the log line may indicate if the Test has passed.
     *
     * @param String $line
     */
    public function setLog($lines = array())
    {
        $failed = false;
        foreach ($lines as $line) {

            if (self::checkLogForTestPass($line) && $failed==false)
                $this->setPassed();

            if (self::checkLogForTestFailure($line)) {
                $this->setFailed();
                $failed = true;
            }

            // Filter the line of any junk and add to the log.
            $this->log[] = $this->filterLog($line);
        }
    }

    /**
     * Return the log as a HTML string.
     *
     * @param  $format Split the array into HTML with linebreaks or return as-is if false.
     * @return HTML/Array
     */
    public function getLog($format = TRUE)
    {
        return $format ? implode($this->log, PHP_EOL) : $this->log;
    }

    /**
     * Filter out junk content from a log line.
     *
     * @param String $line
     */
    private function filterLog($line)
    {
        return str_replace($this->colour_codes, '', $line);
    }

    /**
     * Check if it contains any text that indiciates that the test has passed.
     *
     * @param  string  $line
     * @return boolean
     */
    public function checkLogForTestPass($line)
    {
        return count(preg_grep("/({$this->passed_regex})/", array($line))) > 0;
    }

    /**
     * Checks if line contains failure regex
     *
     * @param string $line
     * @return bool
     */
    public function checkLogForTestFailure($line)
    {
        return count(preg_grep("/({$this->failure_regex})/", array($line))) > 0;
    }

    /**
     * Reset a Test back to default.
     */
    public function reset()
    {
        $this->log    = array();
        $this->passed = FALSE;
    }
  
}
