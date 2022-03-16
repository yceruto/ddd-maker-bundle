<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $aggregate_namespace; ?>\<?= $aggregate_type; ?>;

class <?= $class_name."\n"; ?>
{
    public function create(<?= $command_type; ?>Command $command): <?= $aggregate_type."\n"; ?>
    {
        // ...
    }
}
