# Gearmand Manager

Query Gearmand job servers to list workers, capabilities, and capacity.

This implements the Gearmand Administrative Protocol.
The protocol is documented at <https://gearman.org/protocol/>.

## Installation

Install with PHP Composer.

```shell
composer require flossiraptor/gearmand-manager
```

## Usage

```php
use Flossiraptor\GearmandManager\Manager;

// The default job server is '127.0.0.1' on port 4730.
$manager = new Manager();

// Print the metadata for each Gearmand function.
print("Function\tQueued\tRunning\tWorkers available\n");
foreach ($manager->status() as $function => $status) {
    printf("%s\t%d\t%d\t%d\n",
        $function,
        $status->queued,
        $status->running,
        $status->workers,
    );
}
```

## License

This software can be licensed under the 3-clause BSD license.
See `LICENSE.txt`.
