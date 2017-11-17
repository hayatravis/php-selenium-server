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
        exec('ps | grep selenium-server-standalone', $output);
        $result = false;
        foreach ($output as $line) {
            if (preg_match('/selenium-server-standalone.jar/', $line)) $result = true;
        }
        $this->assertTrue($result);
        $mock->stopSeleniumServer();
    }

    public function testStopSeleniumServer()
    {
        /**
         * @var \Hayatravis\Pss\PhpSeleniumServer $mock
         */
        $mock = Phake::partialMock('Hayatravis\Pss\PhpSeleniumServer');
        $mock->startSeleniumServer();
        $mock->stopSeleniumServer();
        exec('ps | grep selenium-server-standalone', $output);
        $result = false;
        foreach ($output as $line) {
            if (preg_match('/selenium-server-standalone.jar/', $line)) $result = true;
        }
        $this->assertFalse($result);
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