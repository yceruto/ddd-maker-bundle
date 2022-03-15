<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Aggregate\AggregateRoot;

class <?= $class_name; ?> extends AggregateRoot
{
    protected <?= $class_name; ?>Id $id;
}
