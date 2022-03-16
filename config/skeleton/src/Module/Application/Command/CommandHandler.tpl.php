<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Bus\Command\CommandHandler;

class <?= $class_name; ?> implements CommandHandler
{
    public function __invoke(<?= $command_type; ?>Command $command): void
    {
        // ...
    }
}
