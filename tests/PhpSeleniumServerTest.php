<?php
use PHPUnit\Framework\TestCase;

class PhpSeleniumServerTest extends TestCase
{
    public function testGetPidIsNull()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', dirname(dirname(__FILE__)).'/vendor/bin/selenium-server-standalone');
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
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', dirname(dirname(__FILE__)).'/vendor/bin/selenium-server-standalone');
        $mock->startSeleniumServer();
        $this->assertNotNull($mock->getPid());
        $mock->stopSeleniumServer();
    }

    public function testStartSeleniumServer()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', dirname(dirname(__FILE__)).'/vendor/bin/selenium-server-standalone');
        $mock->startSeleniumServer();
        $command = 'ps aux | grep selenium-server-standalone';
        passthru($command);
        $this->expectOutputRegex('/bin\/selenium-server-standalone/');
        $mock->stopSeleniumServer();
    }

    public function testIsStopSeleniumServerIsTrue()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', dirname(dirname(__FILE__)).'/vendor/bin/selenium-server-standalone');
        $mock->startSeleniumServer();
        $this->assertFalse($mock->isStopSeleniumServer());
        $mock->stopSeleniumServer();
    }

    public function testIsStopSeleniumServerIsFalse()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer', dirname(dirname(__FILE__)).'/vendor/bin/selenium-server-standalone');
        $this->assertTrue($mock->isStopSeleniumServer());
    }
}