<?php

namespace Psr\Log\Test;

use Psr\Log\NullLogger;
use Psr\Log\AbstractLogger;

class TestCase extends LoggerInterfaceTest
{
    private $logger;
    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        $this->logger = new MyLogger();
        return $this->logger;
    }
    
    /**
     * This must return the log messages in order.
     *
     * The simple formatting of the messages is: "<LOG LEVEL> <MESSAGE>".
     *
     * Example ->error('Foo') would yield "error Foo".
     *
     * @return string[]
     */
    public function getLogs()
    {
        return $this->logger->data;
    }

}

class MyLogger extends AbstractLogger
{
    public $data = array();
    public function log($level, $message, array $context = array())
    {
        if ($level === 'invalid level') {
            throw new \Psr\Log\InvalidArgumentException();
        }

        $message = str_replace('{user}', $context['user'], $message);
        $message = str_replace('{foo.bar}', $context['foo.bar'], $message);
        $message = str_replace('{foo.bar}', $context['foo']['bar'], $message);
        $this->data[] = "$level $message";
    }
}
