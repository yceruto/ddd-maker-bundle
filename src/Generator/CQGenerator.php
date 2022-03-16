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

    public function generateCommand(string $relativePath, bool $withFactory): void
    {
        $path = new Path($relativePath, $this->rootNamespace, 1);

        $this->generateApplicationCommand($path);

        if ($withFactory) {
            $this->generateApplicationCommandHandlerWithFactory($path);
            $this->generateApplicationFactory($path);
        } else {
            $this->generateApplicationCommandHandler($path);
        }

        $this->generator->writeChanges();
    }

    public function generateQuery(string $relativePath): void
    {
        $path = new Path($relativePath, $this->rootNamespace, 1);

        $this->generateApplicationQuery($path);
        $this->generateApplicationQueryHandler($path);
        $this->generateApplicationQueryResponse($path);

        $this->generator->writeChanges();
    }

    private function generateApplicationCommand(Path $path): void
    {
        $commandShortName = $path->toShortClassNameOffset();
        $className = $commandShortName.'Command';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$className.'.php',
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
        $commandShortName = $path->toShortClassNameOffset();
        $className = $commandShortName.'CommandHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$className.'.php',
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

    private function generateApplicationCommandHandlerWithFactory(Path $path): void
    {
        $aggregateShortName = $path->toShortClassName();
        $commandShortName = $path->toShortClassNameOffset();
        $className = $commandShortName.'CommandHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$className.'.php',
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

    private function generateApplicationFactory(Path $path): void
    {
        $aggregateShortName = $path->toShortClassName();
        $className = $aggregateShortName.'Factory';
        $commandShortName = $path->toShortClassNameOffset();

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Command/Factory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$commandShortName),
                'class_name' => $className,
                'command_type' => $commandShortName,
                'command_name' => strtolower($commandShortName),
                'aggregate_namespace' => $path->toNamespace('\\Domain\\Model'),
                'aggregate_type' => $aggregateShortName,
                'aggregate_name' => strtolower($aggregateShortName),
            ]
        );
    }

    private function generateApplicationQuery(Path $path): void
    {
        $queryShortName = $path->toShortClassNameOffset();
        $className = $queryShortName.'Query';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Query/Query.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$queryShortName),
                'class_name' => $className,
                'query_type' => $className,
                'query_name' => strtolower($className),
            ]
        );
    }

    private function generateApplicationQueryHandler(Path $path): void
    {
        $queryShortName = $path->toShortClassNameOffset();
        $className = $queryShortName.'QueryHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Query/QueryHandler.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$queryShortName),
                'class_name' => $className,
                'query_type' => $queryShortName,
                'query_name' => strtolower($queryShortName),
            ]
        );
    }

    private function generateApplicationQueryResponse(Path $path): void
    {
        $aggregateShortName = $path->toShortClassName();
        $queryShortName = $path->toShortClassNameOffset();
        $className = $queryShortName.'Response';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$path->normalizedOffsetValue().'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Query/Response.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$queryShortName),
                'class_name' => $className,
                'aggregate_namespace' => $path->toNamespace('\\Domain\\Model'),
                'aggregate_type' => $aggregateShortName,
                'aggregate_name' => strtolower($aggregateShortName),
            ]
        );
    }
}
