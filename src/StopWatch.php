<?php

namespace Lexide\Chronos;

use Lexide\Chronos\Exception\StopWatchException;
use Lexide\Chronos\TimeProvider\TimeProviderInterface;

class StopWatch
{

    /**
     * @var TimeProviderInterface
     */
    protected $timeProvider;

    /**
     * @var int|float
     */
    protected $startTime;

    /**
     * @param TimeProviderInterface $timeProvider
     */
    public function __construct(TimeProviderInterface $timeProvider)
    {
        $this->timeProvider = $timeProvider;
    }

    public function start(): void
    {
        $this->startTime = $this->timeProvider->get();
    }

    /**
     * @return bool
     */
    public function isRunning(): bool
    {
        return isset($this->$this->startTime);
    }

    /**
     * @return float|int
     * @throws StopWatchException
     */
    public function duration(): int|float
    {
        if (empty($this->startTime)) {
            throw new StopWatchException("StopWatch must be started before calling duration");
        }

        return $this->timeProvider->get() - $this->startTime;
    }

    /**
     * @return int|float
     * @throws StopWatchException
     */
    public function stop(): int|float
    {
        $duration = $this->duration();
        $this->startTime = null;
        return $duration;
    }

}