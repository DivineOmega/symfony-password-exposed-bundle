<?php

namespace DivineOmega\PasswordExposed\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * Class PasswordExposedExtension
 *
 * @package DivineOmega\PasswordExposed\Symfony\DependencyInjection
 * @author  Nikita Loges
 */
class PasswordExposedExtension extends ConfigurableExtension
{

    /**
     * @inheritdoc
     */
    public function loadInternal(array $config, ContainerBuilder $container)
    {
        $locator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new Loader\YamlFileLoader($container, $locator);
        $loader->load('services.yml');

        $container->setParameter('password_exposed.http_client', $config['http_client']);
        $container->setParameter('password_exposed.cache', $config['cache']);
        $container->setParameter('password_exposed.cache_lifetime', $config['cache_lifetime']);
        $container->setParameter('password_exposed.request_factory', $config['request_factory']);
        $container->setParameter('password_exposed.uri_factory', $config['uri_factory']);
    }
}
