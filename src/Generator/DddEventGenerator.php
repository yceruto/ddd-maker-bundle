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

class DddEventGenerator
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

    public function generateEvent(string $namespacePath, string $name): void
    {
        $path = new Path($namespacePath, $this->rootNamespace);
        $name = Path::normalize($name);

        $this->generateDomainEvent($path, $name);

        $this->generator->writeChanges();
    }

    public function generateEventSubscriber(string $namespacePath, string $name, string $event, string $eventRelativePath = null): void
    {
        $path = new Path($namespacePath, $this->rootNamespace);
        $event = Path::normalize($event);
        $name = Path::normalize($name);
        $eventPath = null;

        if (null !== $eventRelativePath) {
            $eventPath = new Path($eventRelativePath, $this->rootNamespace);
        }

        $this->generateDomainEventSubscriber($path, $name, $event, $eventPath);

        $this->generator->writeChanges();
    }

    private function generateDomainEvent(Path $path, string $name): void
    {
        $classShortName = $path->toShortClassName();
        $className = $classShortName.'Was'.$name;

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/Event.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
            ]
        );
    }

    private function generateDomainEventSubscriber(Path $path, string $name, string $event, Path $eventPath = null): void
    {
        if (null !== $eventPath) {
            $entityShortName = $eventPath->toShortClassName();
            $eventNamespace = $eventPath->toNamespace('\\Domain\\Model');
        } else {
            $entityShortName = $path->toShortClassName();
            $eventNamespace = $path->toNamespace('\\Domain\\Model');
        }
        $eventType = $entityShortName.'Was'.$event;

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Application/EventSubscriber/'.$name.'.php',
            $this->skeletonDir.'/src/Module/Application/EventSubscriber/DomainEventSubscriber.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Application\\EventSubscriber'),
                'class_name' => $name,
                'event_namespace' => $eventNamespace,
                'event_type' => $eventType,
            ]
        );
    }
}
