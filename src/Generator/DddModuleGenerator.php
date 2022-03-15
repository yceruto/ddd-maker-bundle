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

class DddModuleGenerator
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

    public function generateBasic(string $relativePath): void
    {
        $path = new Path($relativePath, $this->rootNamespace);
        $normalizedPath = $path->normalizedValue();

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$normalizedPath.'/Application/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$normalizedPath.'/Domain/Model/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$normalizedPath.'/Infrastructure/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );

        $this->generator->writeChanges();
    }

    public function generateFull(string $relativePath): void
    {
        $path = new Path($relativePath, $this->rootNamespace);
        $normalizedPath = $path->normalizedValue();

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$normalizedPath.'/Application/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );

        $this->generateEntity($path);
        $this->generateEntityId($path);
        $this->generateEntityRepository($path);

        $this->generator->generateFile(
            $this->projectDir.'/src/'.$normalizedPath.'/Infrastructure/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );

        $this->generator->writeChanges();
    }

    private function generateEntity(Path $path): void
    {
        $className = $path->toShortClassName();
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/Entity.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
            ]
        );
    }

    private function generateEntityId(Path $path): void
    {
        $className = $path->toShortClassName().'Id';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntityId.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
            ]
        );
    }

    private function generateEntityRepository(Path $path): void
    {
        $entityClassName = $path->toShortClassName();
        $className = $entityClassName.'Repository';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntityRepository.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityClassName,
                'entity_id_type' => $entityClassName.'Id',
                'entity_name' => strtolower($entityClassName),
            ]
        );
    }
}
