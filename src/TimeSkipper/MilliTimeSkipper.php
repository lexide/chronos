<?php

namespace Lexide\Chronos\TimeSkipper;

class MilliTimeSkipper implements TimeSkipperInterface
{

    public function skip(float|int $seconds): void
    {
        usleep(floor($seconds * 1000) * 1000);
    }

}