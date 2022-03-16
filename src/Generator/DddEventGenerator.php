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

    public function generateEvent(string $relativePath): void
    {
        $path = new Path($relativePath, $this->rootNamespace, 1);

        $this->generateDomainEvent($path);

        $this->generator->writeChanges();
    }

    private function generateDomainEvent(Path $path): void
    {
        $aggregateShortName = $path->toShortClassName();
        $className = $aggregateShortName.'Was'.$path->toShortClassNameOffset();

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
}
