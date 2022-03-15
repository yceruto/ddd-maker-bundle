<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

interface <?= $class_name."\n"; ?>
{
    public function add(<?= $entity_type; ?> $<?= $entity_name; ?>): void;

    public function remove(<?= $entity_type; ?> $<?= $entity_name; ?>): void;

    public function ofId(<?= $entity_id_type; ?> $id): ?<?= $entity_type; ?>;
}
