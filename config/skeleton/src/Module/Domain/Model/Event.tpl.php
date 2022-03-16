<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Bus\Event\DomainEvent;

final class <?= $class_name; ?> extends DomainEvent
{
}
