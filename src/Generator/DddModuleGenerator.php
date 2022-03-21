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

class DddModuleGenerator
{
    private Generator $generator;
    private string $rootDir;
    private string $skeletonDir;
    private string $rootNamespace;

    public function __construct(Generator $generator, string $rootDir, string $skeletonDir, string $rootNamespace)
    {
        $this->generator = $generator;
        $this->rootDir = $rootDir;
        $this->skeletonDir = $skeletonDir;
        $this->rootNamespace = $rootNamespace;
    }

    public function generateBasic(string $namespacePath): void
    {
        $path = new NamespacePath($namespacePath, $this->rootNamespace);
        $normalizedPath = $path->normalizedValue();

        $this->generator->generateFile(
            $this->rootDir.'/'.$normalizedPath.'/Application/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );
        $this->generator->generateFile(
            $this->rootDir.'/'.$normalizedPath.'/Domain/Model/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );
        $this->generator->generateFile(
            $this->rootDir.'/'.$normalizedPath.'/Infrastructure/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );

        $this->generator->writeChanges();
    }

    public function generateFull(string $namespacePath, bool $withSpec): void
    {
        $path = new NamespacePath($namespacePath, $this->rootNamespace);
        $normalizedPath = $path->normalizedValue();

        // Application
        $this->generator->generateFile(
            $this->rootDir.'/'.$normalizedPath.'/Application/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );

        // Domain
        $this->generateDomainEntity($path);
        $this->generateDomainEntityId($path);
        $this->generateDomainEntityDto($path);
        $this->generateDomainEntityEvent($path);
        $this->generateDomainEntityNotFound($path);
        $this->generateDomainEntityRepository($path);
        if ($withSpec) {
            $this->generateDomainEntitySpecification($path);
            $this->generateDomainEntitySpecificationFactory($path);
        }

        // Infrastructure
        $this->generateInfraDoctrineDbalEntityIdType($path);
        $this->generateInfraEntityRepository($path);
        if ($withSpec) {
            $this->generateInfraEntitySpecification($path);
            $this->generateInfraEntitySpecificationFactory($path);
        }

        $this->generator->writeChanges();
    }

    private function generateDomainEntity(NamespacePath $path): void
    {
        $className = $path->toShortClassName();
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
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

    private function generateDomainEntityId(NamespacePath $path): void
    {
        $className = $path->toShortClassName().'Id';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntityId.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
            ]
        );
    }

    private function generateDomainEntityDto(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'Dto';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntityDto.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateDomainEntityEvent(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'WasCreated';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/Event.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateDomainEntityRepository(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'Repository';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
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

    private function generateDomainEntityNotFound(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'NotFound';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
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

    private function generateDomainEntitySpecification(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'Specification';

        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntitySpecification.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateDomainEntitySpecificationFactory(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'SpecificationFactory';

        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Domain/Model/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Domain/Model/EntitySpecificationFactory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Domain\\Model'),
                'class_name' => $className,
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateInfraDoctrineDbalEntityIdType(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();
        $className = $entityShortName.'IdType';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/Dbal/Type/'.$className.'.php',
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

    private function generateInfraEntityRepository(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();

        $className = 'Doctrine'.$entityShortName.'Repository';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/'.$className.'.php',
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
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/InMemory/'.$className.'.php',
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

    private function generateInfraEntitySpecification(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();

        $className = 'Doctrine'.$entityShortName.'Specification';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/Doctrine/Specification/DoctrineEntitySpecification.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\Doctrine\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );

        $className = 'DoctrineSearch'.$entityShortName.'Specification';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/Doctrine/Specification/DoctrineSearchEntitySpecification.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\Doctrine\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );

        $className = 'InMemory'.$entityShortName.'Specification';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/InMemory/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/InMemory/Specification/InMemoryEntitySpecification.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\InMemory\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );

        $className = 'InMemorySearch'.$entityShortName.'Specification';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/InMemory/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/InMemory/Specification/InMemorySearchEntitySpecification.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\InMemory\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }

    private function generateInfraEntitySpecificationFactory(NamespacePath $path): void
    {
        $entityShortName = $path->toShortClassName();

        $className = 'Doctrine'.$entityShortName.'Specification';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/Doctrine/Specification/DoctrineEntitySpecification.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\Doctrine\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );

        $className = 'Doctrine'.$entityShortName.'SpecificationFactory';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/Doctrine/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/Doctrine/Specification/DoctrineEntitySpecificationFactory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\Doctrine\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );

        $className = 'InMemory'.$entityShortName.'Specification';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/InMemory/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/InMemory/Specification/InMemoryEntitySpecification.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\InMemory\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );

        $className = 'InMemory'.$entityShortName.'SpecificationFactory';
        $this->generator->generateFile(
            $this->rootDir.'/'.$path->normalizedValue().'/Infrastructure/Persistence/InMemory/Specification/'.$className.'.php',
            $this->skeletonDir.'/src/Module/Infrastructure/Persistence/InMemory/Specification/InMemoryEntitySpecificationFactory.tpl.php',
            [
                'root_namespace' => $this->rootNamespace,
                'namespace' => $path->toNamespace('\\Infrastructure\\Persistence\\InMemory\\Specification'),
                'class_name' => $className,
                'entity_class' => $path->toNamespace('\\Domain\\Model\\'.$entityShortName),
                'entity_type' => $entityShortName,
                'entity_name' => strtolower($entityShortName),
            ]
        );
    }
}
