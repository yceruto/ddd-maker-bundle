<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

interface <?= $class_name."\n"; ?>
{
    public function createSearch(int $offset, int $limit): <?= $entity_type; ?>Specification;
}
