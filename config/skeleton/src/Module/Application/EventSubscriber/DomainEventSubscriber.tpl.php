<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $event_namespace; ?>\<?= $event_type; ?>;
use <?= $root_namespace; ?>\Shared\Domain\Bus\Event\DomainEventSubscriber;

class <?= $class_name; ?> implements DomainEventSubscriber
{
    public function __invoke(<?= $event_type; ?> $event): void
    {
        // ...
    }
}
