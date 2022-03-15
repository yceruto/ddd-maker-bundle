<?php

/*
 * This file is part of the DddBundle package.
 *
 * (c) Yonel Ceruto <yonelceruto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yceruto\DddMakerBundle;

use MicroSymfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use MicroSymfony\Component\HttpKernel\Bundle\MicroBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

class DddMakerBundle extends MicroBundle
{
    public function configuration(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->scalarNode('skeleton_dir')->defaultValue(dirname(__DIR__).'/config/skeleton')->end()
                ->scalarNode('root_namespace')->defaultValue('App')->end()
            ->end()
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->parameters()
            ->set('ddd_maker.skeleton_dir', $config['skeleton_dir'])
            ->set('ddd_maker.root_namespace', $config['root_namespace'])
        ;

        $container->import('../config/services.php');
    }

    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
