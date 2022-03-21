<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

class <?= $class_name; ?> implements InMemory<?= $entity_type; ?>Specification
{
    private int $offset;
    private int $limit;

    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function query(array $collection): array
    {
        return array_slice($collection, $this->offset, $this->limit);
    }
}
