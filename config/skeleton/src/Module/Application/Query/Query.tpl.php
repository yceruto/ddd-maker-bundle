<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Bus\Query\Query;

/**
 * @psalm-immutable
 */
class <?= $class_name; ?> implements Query
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
