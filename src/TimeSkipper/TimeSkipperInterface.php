<?php

namespace Lexide\Chronos\TimeSkipper;

interface TimeSkipperInterface
{

    /**
     * @param float|int $seconds
     */
    public function skip(float|int $seconds): void;

}