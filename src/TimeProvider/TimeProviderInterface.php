<?php

namespace Lexide\Chronos\TimeProvider;

interface TimeProviderInterface
{
    /**
     * @return float|int
     */
    public function get();
}