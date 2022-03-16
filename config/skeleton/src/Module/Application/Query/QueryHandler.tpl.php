<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Bus\Query\QueryHandler;

class <?= $class_name; ?> implements QueryHandler
{
    public function __invoke(<?= $query_type; ?>Query $query): void
    {
        // ...
    }
}
