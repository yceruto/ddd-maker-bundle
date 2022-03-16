<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $entity_class; ?>Specification;
use <?= $entity_class; ?>SpecificationFactory;

class <?= $class_name; ?> implements <?= $entity_type; ?>SpecificationFactory
{
    public function createSearch(int $offset, int $limit): <?= $entity_type; ?>Specification
    {
        return new DoctrineSearch<?= $entity_type; ?>Specification($offset, $limit);
    }
}
