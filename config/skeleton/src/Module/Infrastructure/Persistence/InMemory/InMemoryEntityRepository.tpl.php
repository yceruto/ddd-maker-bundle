<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $entity_class; ?>;
use <?= $entity_class; ?>Id;
use <?= $entity_class; ?>NotFound;
use <?= $entity_class; ?>Repository;
use <?= $root_namespace; ?>\Shared\Domain\Exception\EntityNotFound;
use <?= $root_namespace; ?>\Shared\Infrastructure\Persistence\InMemory\InMemoryRepository;

class <?= $class_name; ?> extends InMemoryRepository implements <?= $entity_type; ?>Repository
{
    public function add(<?= $entity_type; ?> $<?= $entity_name; ?>): void
    {
        $this->addElementOrFail($<?= $entity_name; ?>->id(), $<?= $entity_name; ?>);
    }

    public function remove(<?= $entity_type; ?> $<?= $entity_name; ?>): void
    {
        try {
            $this->removeElementOrFail($<?= $entity_name; ?>->id(), $<?= $entity_name; ?>);
        } catch (EntityNotFound $e) {
            throw <?= $entity_type; ?>NotFound::create($<?= $entity_name; ?>->id());
        }
    }

    public function ofId(<?= $entity_type; ?>Id $id): ?<?= $entity_type."\n"; ?>
    {
        return $this->collection[$id->value()] ?? null;
    }
}
