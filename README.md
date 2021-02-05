# Chronos

Chronos provides classes that return timestamps in order to abstract dependencies on system time.
Mostly this is useful when unit testing code, as you are able to mock the `TimeProviderInterface` and not rely on
calls to get system time

It also has a stopwatch, which uses the time providers to generate durations in seconds

## Installation
```
composer require lexide/chronos
```

To use the `lexide/syringe` DI config supplied with this library, add the following to your composer.json

```yaml
"extra": {
    "lexide/puzzle-di": {
        "whitelist": {
            "lexide/syringe": [
                "lexide/chronos"
            ]
        }
    }
}
```

_NOTE: you will need to install lexide/puzzle-di in your project to take advantage of this feature_

## TimeProviders

The TimeProviders included in this library all return the number of seconds from a given point-in-time. Each class has a `get` method which is used to 
get the current time. When mocking these classes, you can set an expectation on this method to return values that 
simulate a period of time having elapsed.

There are a number of Provider classes supplied in this library: 

* `TimeProvider` - returns a unix timestamp in seconds 
* `MilliTimeProvider`- returns a unix timestamp with millisecond precision
* `MicroTimeProvider`- returns a unix timestamp with microsecond precision
* `NanoTimeProvider` returns an arbitrary timestamp with nanosecond precision

_NOTE: The `NanoTimeProvider` **does not** return a unix timestamp. It is based on the `hrtime` function which returns 
nanoseconds elapsed from an arbitrary point-in-time, such as system start time. As this point-in-time cannot be known 
beforehand, `NanoTimeProvider` cannot be used for date calculations_

### Custom TimeProviders

If you need to use a different unit of time, such as an integer of milliseconds, you can create a new class that 
implements `Lexide\Chronos\TimeProvider\TimeProviderInterface`. In its `get` method, you can return any integer or 
float value that meets your requirements. 

## Stopwatch

The `StopWatch` class performs the common function of timing the duration of a task. It uses a TimeProvider to capture a
starting point-in-time and work out the difference between the start and a second point-in-time

To use a `StopWatch`, you must call `start()` on it to capture the starting time. Then you can call `stop()` to stop 
timing and return the time difference. Alternatively, if you want to continue timing, a call to `duration()` will return
the time elapsed but keep the watch running, allowing `duration()` to be called multiple times.
