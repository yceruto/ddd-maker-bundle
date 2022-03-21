<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $entity_class; ?>;
use <?= $entity_class; ?>Specification;

interface <?= $class_name; ?> extends <?= $entity_type; ?>Specification
{
    /**
     * @param array<<?= $entity_type; ?>> $collection
     *
     * @return array<<?= $entity_type; ?>>
     */
    public function query(array $collection): array;
}
