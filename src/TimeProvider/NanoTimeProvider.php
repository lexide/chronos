<?php

namespace Lexide\Chronos\TimeProvider;

class NanoTimeProvider implements TimeProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(): float|int
    {
        return hrtime(true) / 1000000000;
    }

}