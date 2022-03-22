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

class DddQuerySpecificationGenerator
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

    public function generateQuerySpecification(string $namespacePath, string $name = 'Search'): void
    {
        $path = new NamespacePath($namespacePath, $this->rootNamespace);
        $name = NamespacePath::normalize($name);

        // Domain
        $this->generateDomainEntitySpecification($path);
        $this->generateDomainEntitySpecificationFactory($path);

        // Infrastructure
        $this->generateInfraEntitySpecification($path, $name);
        $this->generateInfraEntitySpecificationFactory($path, $name);

        $this->generator->writeChanges();
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

    private function generateInfraEntitySpecification(NamespacePath $path, string $name): void
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

        $className = 'Doctrine'.$name.$entityShortName.'Specification';
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
                'spec_name' => $name,
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

        $className = 'InMemory'.$name.$entityShortName.'Specification';
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

    private function generateInfraEntitySpecificationFactory(NamespacePath $path, string $name): void
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
                'spec_name' => $name,
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
                'spec_name' => $name,
            ]
        );
    }
}
