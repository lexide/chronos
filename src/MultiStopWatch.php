<?php

namespace Lexide\Chronos;

use Lexide\Chronos\TimeProvider\TimeProviderInterface;

class MultiStopWatch
{
    /**
     * @var TimeProviderInterface
     */
    protected $timeProvider;

    /**
     * @var int[]|float[]
     */
    protected $startTimes;

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

    /**
     * @param string $key
     */
    public function start(string $key): void
    {
        $this->startTimes[$key] = $this->timeProvider->get();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isRunning(string $key): bool
    {
        return isset($this->startTimes[$key]);
    }

    /**
     * @param string $key
     * @return float|int
     */
    public function duration(string $key): int|float
    {
        if (empty($this->startTimes[$key])) {
            return 0;
        }

        $time = $this->timeProvider->get();
        $difference = $time - $this->startTimes[$key];
        if ($this->intervalMode) {
            $this->startTimes[$key] = $time;
        }
        return $difference;
    }

    /**
     * @param string $key
     * @return int|float
     */
    public function stop(string $key): int|float
    {
        $duration = $this->duration($key);
        unset($this->startTimes[$key]);
        return $duration;
    }
}