<?php

namespace Lexide\Chronos\TimeProvider;

class TimeProvider implements TimeProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return time();
    }
}