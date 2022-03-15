<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Yceruto\DddMakerBundle\Generator\DddModuleGenerator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
            ->bind('string $projectDir', param('kernel.project_dir'))
            ->bind('string $skeletonDir', param('ddd_maker.skeleton_dir'))
            ->bind('string $rootNamespace', param('ddd_maker.root_namespace'))

        ->load('Yceruto\\DddMakerBundle\\', '../src/*')

        ->set(DddModuleGenerator::class)
            ->bind('Symfony\Bundle\MakerBundle\Generator $generator', service('maker.generator'))
    ;
};
