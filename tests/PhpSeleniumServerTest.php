<?php
use PHPUnit\Framework\TestCase;

class PhpSeleniumServerTest extends TestCase
{
    public function testGetPidIsNull()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer');
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
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer');
        $mock->startSeleniumServer();
        $this->assertNotNull($mock->getPid());
        $mock->stopSeleniumServer();
    }

    public function testStartSeleniumServer()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer');
        $mock->startSeleniumServer();
        $command = 'ps | grep selenium-server-standalone';
        passthru($command);
        $this->expectOutputRegex('/selenium-server-standalone.jar/');
        $mock->stopSeleniumServer();
    }

    public function testIsStopSeleniumServerIsTrue()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer');
        $mock->startSeleniumServer();
        $this->assertFalse($mock->isStopSeleniumServer());
        $mock->stopSeleniumServer();
    }

    public function testIsStopSeleniumServerIsFalse()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer');
        $this->assertTrue($mock->isStopSeleniumServer());
    }
}