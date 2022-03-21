<?php

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
            ->bind('string $projectDir', param('kernel.project_dir'))
            ->bind('string $skeletonDir', param('ddd_maker.skeleton_dir'))
            ->bind('string $rootNamespace', param('ddd_maker.root_namespace'))
            ->bind('string $rootDir', param('kernel.project_dir').'/'.param('ddd_maker.root_dir'))

        ->load('Yceruto\\DddMakerBundle\\', '../src/*')

        ->alias(Generator::class, 'maker.generator')
    ;
};
