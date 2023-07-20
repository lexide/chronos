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
     * @param bool $intervalMode
     * @return StopWatch
     */
    public function create(bool $intervalMode = false): StopWatch
    {
        return new StopWatch($this->timeProvider, $intervalMode);
    }

    /**
     * @param bool $intervalMode
     * @return MultiStopWatch
     */
    public function createMulti(bool $intervalMode = false): MultiStopWatch
    {
        return new MultiStopWatch($this->timeProvider, $intervalMode);
    }

}