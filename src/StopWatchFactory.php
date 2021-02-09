<?php

namespace Lexide\Chronos;

use Lexide\Chronos\TimeProvider\TimeProviderInterface;

class StopWatchFactory
{

    /**
     * @var TimeProviderInterface
     */
    protected $timeProvider;

    /**
     * @param TimeProviderInterface $timeProvider
     */
    public function __construct(TimeProviderInterface $timeProvider)
    {
        $this->timeProvider = $timeProvider;
    }

    /**
     * @return StopWatch
     */
    public function create(): StopWatch
    {
        return new StopWatch($this->timeProvider);
    }

}