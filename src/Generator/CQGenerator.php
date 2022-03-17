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

    public function generateCommand(string $namespacePath, string $name, bool $withFactory): void
    {
        $path = new Path($namespacePath, $this->rootNamespace);
        $name = Path::normalize($name);

        $this->generateApplicationCommand($path, $name);

        if ($withFactory) {
            $this->generateApplicationCommandHandlerWithFactory($path, $name);
            $this->generateApplicationFactory($path, $name);
        } else {
            $this->generateApplicationCommandHandler($path, $name);
        }

        $this->generator->writeChanges();
    }

    public function generateQuery(string $namespacePath, string $name): void
    {
        $path = new Path($namespacePath, $this->rootNamespace);
        $name = Path::normalize($name);

        $this->generateApplicationQuery($path, $name);
        $this->generateApplicationQueryHandler($path, $name);
        $this->generateApplicationQueryResponse($path, $name);

        $this->generator->writeChanges();
    }

    private function generateApplicationCommand(Path $path, string $name): void
    {
        $className = $name.'Command';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$name.'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Command/Command.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$name),
                'class_name' => $className,
                'command_type' => $className,
                'command_name' => strtolower($className),
            ]
        );
    }

    private function generateApplicationCommandHandler(Path $path, string $name): void
    {
        $className = $name.'CommandHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$name.'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Command/CommandHandler.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$name),
                'class_name' => $className,
                'command_type' => $name,
                'command_name' => strtolower($name),
            ]
        );
    }

    private function generateApplicationCommandHandlerWithFactory(Path $path, string $name): void
    {
        $aggregateShortName = $path->toShortClassName();
        $className = $name.'CommandHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$name.'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Command/CommandHandlerWithFactory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$name),
                'class_name' => $className,
                'command_type' => $name,
                'command_name' => strtolower($name),
                'aggregate_type' => $aggregateShortName,
                'aggregate_name' => strtolower($aggregateShortName),
            ]
        );
    }

    private function generateApplicationFactory(Path $path, string $name): void
    {
        $aggregateShortName = $path->toShortClassName();
        $className = $aggregateShortName.'Factory';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$name.'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Command/Factory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$name),
                'class_name' => $className,
                'command_type' => $name,
                'command_name' => strtolower($name),
                'aggregate_namespace' => $path->toNamespace('\\Domain\\Model'),
                'aggregate_type' => $aggregateShortName,
                'aggregate_name' => strtolower($aggregateShortName),
            ]
        );
    }

    private function generateApplicationQuery(Path $path, string $name): void
    {
        $className = $name.'Query';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$name.'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Query/Query.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$name),
                'class_name' => $className,
                'query_type' => $className,
                'query_name' => strtolower($className),
            ]
        );
    }

    private function generateApplicationQueryHandler(Path $path, string $name): void
    {
        $className = $name.'QueryHandler';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$name.'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Query/QueryHandler.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$name),
                'class_name' => $className,
                'query_type' => $name,
                'query_name' => strtolower($name),
            ]
        );
    }

    private function generateApplicationQueryResponse(Path $path, string $name): void
    {
        $aggregateShortName = $path->toShortClassName();
        $className = $name.'Response';

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/'.$name.'/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Application/Query/Response.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\'.$name),
                'class_name' => $className,
                'aggregate_namespace' => $path->toNamespace('\\Domain\\Model'),
                'aggregate_type' => $aggregateShortName,
                'aggregate_name' => strtolower($aggregateShortName),
            ]
        );
    }
}
