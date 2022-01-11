<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
            ->bind('string $projectDir', param('kernel.project_dir'))
    ;

    $services->load('Yceruto\\DddMakerBundle\\', '../src/*')
        ->exclude('../src/{DependencyInjection}');
};
