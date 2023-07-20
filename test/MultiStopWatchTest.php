<?php

namespace Lexide\Chronos\Test;

use Lexide\Chronos\MultiStopWatch;
use Lexide\Chronos\TimeProvider\TimeProviderInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class MultiStopWatchTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var TimeProviderInterface|MockInterface
     */
    protected $timeProvider;

    public function setUp(): void
    {
        $this->timeProvider = \Mockery::mock(TimeProviderInterface::class);
    }

    public function testZeroIfNotStarted()
    {
        $key = "foo";

        $this->timeProvider->shouldNotReceive("get");

        $stopWatch = new MultiStopWatch($this->timeProvider);

        $this->assertSame(0, $stopWatch->duration($key));
        $this->assertSame(0, $stopWatch->stop($key));
    }

    public function testReturnsTimeDifference()
    {
        $key = "foo";
        $difference = 5;
        $start = 10;

        $this->timeProvider->shouldReceive("get")->twice()->andReturnValues([$start, $start + $difference]);

        $stopWatch = new MultiStopWatch($this->timeProvider);
        $stopWatch->start($key);
        $this->assertSame($difference, $stopWatch->duration($key));
    }

    public function testWatchCanBeStopped()
    {
        $key = "foo";
        $difference = 5;
        $start = 10;

        $this->timeProvider->shouldReceive("get")->twice()->andReturnValues([$start, $start + $difference]);

        $stopWatch = new MultiStopWatch($this->timeProvider);
        $stopWatch->start($key);

        $this->assertTrue($stopWatch->isRunning($key));
        $this->assertSame($difference, $stopWatch->stop($key));
        $this->assertFalse($stopWatch->isRunning($key));
    }

    public function testIntervalMode()
    {
        $key = "foo";
        $start = 10;
        $intervals = [34, 9, 111, 57];
        $times = [$start];
        $running = $start;
        foreach ($intervals as $interval) {
            $running += $interval;
            $times[] = $running;
        }

        $this->timeProvider->shouldReceive("get")->andReturnValues($times);

        $stopWatch = new MultiStopWatch($this->timeProvider, true);
        $stopWatch->start($key);

        foreach ($intervals as $interval) {
            $this->assertSame($interval, $stopWatch->duration($key));
        }

    }


    public function testMultipleConcurrentRuns()
    {
        $runCount = 4;
        $initial = 100;

        $starts = [];
        $ends = [];
        $differences = [];

        for ($i = 0; $i < $runCount; ++$i) {
            $start = $initial + ($i * 15);
            $diff = ($i + 1) * 20;
            $end = $start + $diff;
            $starts[] = $start;
            $differences[] = $diff;
            $ends[] = $end;
        }

        $times = array_merge($starts, $ends);

        $this->timeProvider->shouldReceive("get")->andReturnValues($times);

        $stopWatch = new MultiStopWatch($this->timeProvider);

        for ($i = 0; $i < $runCount; ++$i) {
            $stopWatch->start("foo" . $i);
        }

        for ($i = 0; $i < $runCount; ++$i) {
            $key = "foo" . $i;
            $this->assertTrue($stopWatch->isRunning($key));
            $this->assertSame($differences[$i], $stopWatch->stop($key));
            $this->assertFalse($stopWatch->isRunning($key));
        }

    }
}
