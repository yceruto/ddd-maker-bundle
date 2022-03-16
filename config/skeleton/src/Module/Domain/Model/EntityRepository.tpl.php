<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

interface <?= $class_name."\n"; ?>
{
    public function add(<?= $entity_type; ?> $<?= $entity_name; ?>): void;

    public function remove(<?= $entity_type; ?> $<?= $entity_name; ?>): void;

    public function ofId(<?= $entity_type; ?>Id $id): ?<?= $entity_type; ?>;
}
