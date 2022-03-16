<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Aggregate\AggregateRoot;

class <?= $class_name; ?> extends AggregateRoot
{
    protected <?= $class_name; ?>Id $id;

    private function __construct(<?= $entity_type; ?>Id $id)
    {
        $this->id = $id;
    }

    public static function create(<?= $entity_type; ?>Id $id): self
    {
        $<?= $entity_type; ?> = new self($id);
        $<?= $entity_type; ?>->record(new <?= $entity_type; ?>WasCreated($id->value()));

        return $<?= $entity_type; ?>;
    }

    public function id(): <?= $class_name; ?>Id
    {
        return $this->id;
    }
}
