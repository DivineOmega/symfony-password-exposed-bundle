<?php

namespace DivineOmega\PasswordExposed\Symfony\DependencyInjection\Compiler;

use DivineOmega\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class HttpClientCompiler
 *
 * @package DivineOmega\PasswordExposed\Symfony\DependencyInjection\Compiler
 * @author  Nikita Loges
 */
class HttpClientCompiler implements CompilerPassInterface
{

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition(PasswordExposedCheckerInterface::class);

        $httpClient = $container->getParameter('password_exposed.http_client');
        $cache = $container->getParameter('password_exposed.cache');
        $cacheLifetime = $container->getParameter('password_exposed.cache_lifetime');
        $requestFactory = $container->getParameter('password_exposed.request_factory');
        $uriFactory = $container->getParameter('password_exposed.uri_factory');

        if ($httpClient !== null) {
            $definition->setArgument(0, new Reference($httpClient));
        }

        $definition->setArgument(1, new Reference($cache));
        if ($cacheLifetime !== null) {
            $definition->setArgument(2, $cacheLifetime);
        }
        if ($requestFactory !== null) {
            $definition->setArgument(3, new Reference($requestFactory));
        }
        if ($uriFactory !== null) {
            $definition->setArgument(4, new Reference($uriFactory));
        }
    }
}
