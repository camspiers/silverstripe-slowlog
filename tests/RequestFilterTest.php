<?php

namespace Camspiers\SlowLog;

class RequestFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testLog()
    {
        $logger = $this->getMock('Psr\Log\LoggerInterface');
        $logger->expects($this->once())
            ->method('info');
        
        $filter = new RequestFilter($logger, 1);
        
        $req = new \SS_HTTPRequest('GET', '/');
        $mod = new \DataModel();
        
        $filter->preRequest($req, new \Session(array()), $mod);
        sleep(2);
        $filter->postRequest($req, new \SS_HTTPResponse(), $mod);
    }

    public function testNoLog()
    {
        $logger = $this->getMock('Psr\Log\LoggerInterface');
        $logger->expects($this->never())
            ->method('info');
        
        $filter = new RequestFilter($logger, 1);

        $req = new \SS_HTTPRequest('GET', '/');
        $mod = new \DataModel();

        $filter->preRequest($req, new \Session(array()), $mod);
        sleep(0.5);
        $filter->postRequest($req, new \SS_HTTPResponse(), $mod);
    }
} 