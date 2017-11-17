<?php
use PHPUnit\Framework\TestCase;

/**
 * Class PhpSeleniumServerTest
 *
 * @property string $path
 */
class PhpSeleniumServerTest extends TestCase
{
    public $path;

    public function setUp()
    {
        $this->path = dirname(dirname(__FILE__)).'/vendor/bin/selenium-server-standalone';
    }

    public function tearDown()
    {
        $this->path = null;
    }

    public function testGetPidIsNull()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', $this->path);
        $this->assertNull($mock->getPid());
    }

    public function testJavaIsAvailable()
    {
        $command = 'java -version 2>&1';
        passthru($command);
        $this->expectOutputRegex('/java version \"(.*)\"/');
    }

    public function testGetPid()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', $this->path);
        $mock->startSeleniumServer();
        $this->assertNotNull($mock->getPid());
        $mock->stopSeleniumServer();
    }

    public function testStartSeleniumServer()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', $this->path);
        $mock->startSeleniumServer(100000);
        $command = 'ps aux | grep selenium-server-standalone';
        passthru($command);
        $this->expectOutputRegex('/bin\/selenium-server-standalone/');
        $mock->stopSeleniumServer();
    }

    /**
     * @expectedException \Hayatravis\Pss\Exception\PhpSeleniumServerException
     * @expectedExceptionMessage Not found selenium-server-standalone.
     */
    public function testStartSeleniumSeverWithPathException()
    {
        Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', 'nothing');
    }

    /**
     * @expectedException \Hayatravis\Pss\Exception\PhpSeleniumServerException
     * @expectedExceptionMessage Not found selenium-server-standalone. Please specify the file path.
     */
    public function testStartSeleniumServerException()
    {
        Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer');
    }

    public function testIsStopSeleniumServerIsTrue()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', $this->path);
        $mock->startSeleniumServer();
        $this->assertFalse($mock->isStopSeleniumServer());
        $mock->stopSeleniumServer();
    }

    public function testIsStopSeleniumServerIsFalse()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', $this->path);
        $this->assertTrue($mock->isStopSeleniumServer());
    }
}