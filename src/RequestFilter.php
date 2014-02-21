<?php

namespace Camspiers\SlowLog;

use DataModel;
use Psr\Log\LoggerInterface;
use RequestFilter as SilverStripeRequestFilter;
use Session;
use SS_HTTPRequest;
use SS_HTTPResponse;

class RequestFilter implements SilverStripeRequestFilter
{
    /**
     * @var array
     */
    protected $times = array();

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var int|float
     */
    protected $timeLimit;

    /**
     * @param LoggerInterface $logger
     * @param int|float $timeLimit
     */
    public function __construct(LoggerInterface $logger, $timeLimit = 1)
    {
        $this->logger = $logger;
        $this->timeLimit = $timeLimit;
    }

    /**
     * @param SS_HTTPRequest $request
     * @param Session $session
     * @param DataModel $model
     * @return bool|void
     */
    public function preRequest(SS_HTTPRequest $request, Session $session, DataModel $model)
    {
        $this->times[] = array($request, microtime(true));
    }

    /**
     * @param SS_HTTPRequest $request
     * @param SS_HTTPResponse $response
     * @param DataModel $model
     */
    public function postRequest(SS_HTTPRequest $request, SS_HTTPResponse $response, DataModel $model)
    {
        foreach ($this->times as $key => $info) {
            if ($request === $info[0]) {
                $time = microtime(true) - $info[1];
                if ($time > $this->timeLimit) {
                    $this->logger->info(
                        sprintf("Slow request time %01.2f secs at '%s'", $time, $request->getURL()),
                        array('request' => (array) $request)
                    );
                }
                unset($this->times[$key]);
            }
        }
    }
} 
