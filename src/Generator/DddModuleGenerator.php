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

        // Application
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$normalizedPath.'/Application/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );

        // Domain
        $this->generateDomainEntity($path);
        $this->generateDomainEntityId($path);
        $this->generateDomainEntityEvent($path);
        $this->generateDomainEntityNotFound($path);
        $this->generateDomainEntityRepository($path);

        // Infrastructure
        $this->generateInfraDoctrineDbalEntityIdType($path);
        $this->generateInfraEntityRepository($path);

        $this->generator->writeChanges();
    }

    private function generateDomainEntity(Path $path): void
    {
        $className = $path->toShortClassName();
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/Entity.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $className,
                'entity_name' => strtolower($className),
            ]
        );
    }

    private function generateDomainEntityId(Path $path): void
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

    private function generateDomainEntityEvent(Path $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'WasCreated';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntityWasCreated.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateDomainEntityRepository(Path $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'Repository';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntityRepository.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateDomainEntityNotFound(Path $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'NotFound';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntityNotFound.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateInfraDoctrineDbalEntityIdType(Path $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'IdType';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/Dbal/Type/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/Doctrine/Dbal/Type/EntityIdType.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\Doctrine\\Dbal\\Type'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateInfraEntityRepository(Path $path): void
    {
        $entityShortName = $path->toShortClassName();

        $className = 'Doctrine'.$entityShortName.'Repository';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/Doctrine/DoctrineEntityRepository.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\Doctrine'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );

        $className = 'InMemory'.$entityShortName.'Repository';
        $this->generator->generateFile(
            $this->projectDir.'/src/'.$path->normalizedValue().'/Infrastructure/Persistence/InMemory/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/InMemory/InMemoryEntityRepository.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\InMemory'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }
}
