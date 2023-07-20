<?php

namespace Lexide\Chronos\TimeSkipper;

class MicroTimeSkipper implements TimeSkipperInterface
{

    public function skip(float|int $seconds): void
    {
        usleep($seconds * 1000000);
    }

}