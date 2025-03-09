<?php declare(strict_types=1);

namespace Vite\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class WebforgeViteExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('vite.app_cdn', $config['app_cdn']);
        $container->setParameter('vite.dev_server', $config['dev_server']);
        $container->setParameter('vite.public_base_path', $config['public_base_path']);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('framework', [
            'http_client' => [
                'scoped_clients' => [
                    'internalNginx' => [
                        'base_uri' => '%env(INTERNAL_WEB_ADDR)%'
                    ]
                ]
            ]
        ]);
    }
}
