<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use Doctrine\ORM\QueryBuilder;
use <?= $entity_class; ?>;
use <?= $entity_class; ?>Specification;

interface <?= $class_name; ?> extends <?= $entity_type; ?>Specification
{
    /**
    * @return iterable<<?= $entity_type; ?>>
    */
    public function query(QueryBuilder $qb): iterable;
}
