<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

class <?= $class_name."\n"; ?>
{
    public string $id;

    /**
     * @param array<<?= $entity_type; ?>> $collection
     *
     * @return array<int, static>
     */
    public static function createCollection(array $collection): array
    {
        return array_map([static::class, 'create'], $collection);
    }

    public static function create(<?= $entity_type; ?> $<?= $entity_name; ?>): self
    {
        $self = new static();
        $self->id = $<?= $entity_name; ?>->id()->value();

        return $self;
    }
}
