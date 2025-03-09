<?php declare(strict_types=1);

namespace Vite\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('webforge_vite');

        $treeBuilder->getRootNode()
            ->children()
                ->stringNode('app_cdn')
                    ->defaultValue('')
                ->end()
                ->stringNode('dev_server')
                    ->defaultValue('http://127.0.0.1:3030')
                ->end()
                ->stringNode('public_base_path')
                    ->defaultValue('/build/')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
