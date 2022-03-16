<?php

/*
 * This file is part of the DddBundle package.
 *
 * (c) Yonel Ceruto <yonelceruto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yceruto\DddMakerBundle\Generator;

use Symfony\Bundle\MakerBundle\Generator;
use Yceruto\DddMakerBundle\Path;

class CQGenerator
{
    private Generator $generator;
    private string $projectDir;
    private string $skeletonDir;
    private string $rootNamespace;

    public function __construct(Generator $generator, string $projectDir, string $skeletonDir, string $rootNamespace)
    {
        $this->generator = $generator;
        $this->projectDir = $projectDir;
        $this->skeletonDir = $skeletonDir;
        $this->rootNamespace = $rootNamespace;
    }

    public function generate(string $relativePath, string $factory = null): void
    {
        $path = new Path($relativePath, $this->rootNamespace, 1);

        $this->generateApplicationCommand($path);

        if (null === $factory) {
            $this->generateApplicationCommandHandler($path);
        } else {
            $this->generateApplicationCommandHandlerWithFactory($path, $factory);
            $this->generateApplicationFactory($path, $factory);
        }

        $this->generator->writeChanges();
    }

    private function generateApplicationCommand(Path $path): void
    {
        $commandShortName = $path->toShortClassName();
        $className = $commandShortName.'Command';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$commandShortName.'Command.php',
            $this->skeletonDir.'/src/Module/Application/Command/Command.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$commandShortName),
                'class_name' => $className,
                'command_type' => $className,
                'command_name' => strtolower($className),
            ]
        );
    }

    private function generateApplicationCommandHandler(Path $path): void
    {
        $commandShortName = $path->toShortClassName();
        $className = $commandShortName.'CommandHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$commandShortName.'CommandHandler.php',
            $this->skeletonDir.'/src/Module/Application/Command/CommandHandler.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$commandShortName),
                'class_name' => $className,
                'command_type' => $commandShortName,
                'command_name' => strtolower($commandShortName),
            ]
        );
    }

    private function generateApplicationCommandHandlerWithFactory(Path $path, string $factory): void
    {
        $aggregatePath = new Path($factory, $this->rootNamespace);
        $aggregateShortName = $aggregatePath->toShortClassName();
        $commandShortName = $path->toShortClassName();
        $className = $commandShortName.'CommandHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$commandShortName.'CommandHandler.php',
            $this->skeletonDir.'/src/Module/Application/Command/CommandHandlerWithFactory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$commandShortName),
                'class_name' => $className,
                'command_type' => $commandShortName,
                'command_name' => strtolower($commandShortName),
                'aggregate_type' => $aggregateShortName,
                'aggregate_name' => strtolower($aggregateShortName),
            ]
        );
    }

    private function generateApplicationFactory(Path $path, string $factory): void
    {
        $aggregatePath = new Path($factory, $this->rootNamespace);
        $aggregateShortName = $aggregatePath->toShortClassName();
        $className = $aggregateShortName.'Factory';
        $commandShortName = $path->toShortClassName();

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$aggregateShortName.'Factory.php',
            $this->skeletonDir.'/src/Module/Application/Command/Factory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$commandShortName),
                'class_name' => $className,
                'command_type' => $commandShortName,
                'command_name' => strtolower($commandShortName),
                'aggregate_namespace' => $aggregatePath->toNamespace('\\Domain\\Model'),
                'aggregate_type' => $aggregateShortName,
                'aggregate_name' => strtolower($aggregateShortName),
            ]
        );
    }
}
