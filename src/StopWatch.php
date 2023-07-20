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
     * @var bool
     */
    protected $intervalMode;

    /**
     * @param TimeProviderInterface $timeProvider
     * @param bool $intervalMode
     */
    public function __construct(TimeProviderInterface $timeProvider, bool $intervalMode = false)
    {
        $this->timeProvider = $timeProvider;
        $this->intervalMode = $intervalMode;
    }

    /**
     * @param bool $intervalMode
     */
    public function setIntervalMode(bool $intervalMode): void
    {
        $this->intervalMode = $intervalMode;
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
        return isset($this->startTime);
    }

    /**
     * @return float|int
     */
    public function duration(): int|float
    {
        if (empty($this->startTime)) {
            return 0;
        }
        $time = $this->timeProvider->get();
        $difference = $time - $this->startTime;
        if ($this->intervalMode) {
            $this->startTime = $time;
        }
        return $difference;
    }

    /**
     * @return int|float
     */
    public function stop(): int|float
    {
        $duration = $this->duration();
        $this->startTime = null;
        return $duration;
    }

}