<?php

namespace DivineOmega\PasswordExposed\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use function method_exists;

/**
 * Class Configuration
 *
 * @package DivineOmega\PasswordExposed\Symfony\DependencyInjection
 * @author  Nikita Loges
 */
class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('password_exposed');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('password_exposed');
        }

        $rootNode->children()
            ->booleanNode('enable')->defaultTrue()->end()
            ->scalarNode('http_client')->defaultNull()->end()
            ->scalarNode('cache')->defaultValue('cache.app')->cannotBeEmpty()->end()
            ->scalarNode('cache_lifetime')->defaultValue(2592000)->end()
            ->scalarNode('request_factory')->defaultNull()->end()
            ->scalarNode('uri_factory')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
