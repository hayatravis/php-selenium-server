<?php
namespace Hayatravis\Pss;
use Hayatravis\Pss\Exception\PhpSeleniumServerException;

/**
 * Class PhpSeleniumServer
 *
 * @property string|null $pid
 * @property string $seleniumServerPath
 */
class PhpSeleniumServer
{
    private $pid;
    private $seleniumServerPath;

    public function __construct(string $seleniumServerPath = null)
    {
        $this->pid = null;
        if (!empty($seleniumServerPath)) {
            if (!file_exists($seleniumServerPath)) {
                throw new PhpSeleniumServerException('Not found selenium-server-standalone.');
            }
            $this->seleniumServerPath = $seleniumServerPath;
        } else {
            $seleniumServerPath = dirname(dirname(__FILE__)).'/vendor/bin/selenium-server-standalone';
            if (!file_exists($seleniumServerPath)) {
                throw new PhpSeleniumServerException('Not found selenium-server-standalone. Please specify the file path.');
            }
            $this->seleniumServerPath = $seleniumServerPath;
        }
    }

    /**
     * @return null|string
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Start Selenium server standalone.
     */
    public function startSeleniumServer()
    {
        if (!$this->isStopSeleniumServer()) throw new PhpSeleniumServerException('It already started.');
        exec('nohup ' . $this->seleniumServerPath . ' > /dev/null 2>&1 & echo $! 2>&1', $output);
        $this->pid = $output[0];
    }

    /**
     * Stop Selenium server standalone.
     */
    public function stopSeleniumServer()
    {
        exec('kill ' . $this->pid);
        $this->pid = null;
    }

    /**
     * Check SeleniumServer is stop.
     * @return bool
     */
    public function isStopSeleniumServer()
    {
        exec('ps aux | grep selenium-server-standalone 2>&1', $output);
        foreach ($output as $line) {
            if (preg_match('/bin\/selenium-server-standalone/', $line)) return false;
        }
        return true;
    }

}