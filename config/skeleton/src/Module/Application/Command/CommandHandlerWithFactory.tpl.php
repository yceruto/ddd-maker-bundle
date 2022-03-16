<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Bus\Command\CommandHandler;

class <?= $class_name; ?> implements CommandHandler
{
    private <?= $aggregate_type; ?>Factory $factory;

    public function __construct(<?= $aggregate_type; ?>Factory $factory)
    {
        $this->factory = $factory;
    }

    public function __invoke(<?= $command_type; ?>Command $command): void
    {
        $<?= $aggregate_name; ?> = $this->factory->create($command);

        // ...
    }
}
