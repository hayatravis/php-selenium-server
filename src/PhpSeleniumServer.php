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

    /**
     * PhpSeleniumServer constructor.
     *
     * @param string|null $seleniumServerPath
     */
    public function __construct(string $seleniumServerPath = null)
    {
        $this->prepare($seleniumServerPath);
    }

    /**
     * @param string|null $seleniumServerPath
     */
    public function prepare(string $seleniumServerPath = null)
    {
        $this->pid = null;
        $path = $seleniumServerPath ?? dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/vendor/bin/selenium-server-standalone';
        if (!$this->isExist($path)) {
            throw new PhpSeleniumServerException('Not found selenium-server-standalone. Please specify the file path.');
        }
        $this->seleniumServerPath = $seleniumServerPath;
    }

    /**
     * Check Selenium server path.
     * @param string|null $seleniumServerPath
     *
     * @return bool
     */
    public function isExist(string $seleniumServerPath = null)
    {
        return file_exists($seleniumServerPath);
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
     * if catch the WebDriverCurlException, set $microSeconds.
     * @param int|null $microSeconds
     */
    public function startSeleniumServer(int $microSeconds = null)
    {
        if (!$this->isStopSeleniumServer()) throw new PhpSeleniumServerException('It already started.');
        exec('nohup ' . $this->seleniumServerPath . ' > /dev/null 2>&1 & echo $! 2>&1', $output);
        $this->pid = $output[0];
        if (!empty($microSeconds)) {
            usleep($microSeconds);
        }
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