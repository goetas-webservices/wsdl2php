<?php
namespace GoetasWebservices\WsdlToPhp\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wsdl2php');
        $rootNode
            ->children()
            ->scalarNode('headers')
            ->defaultValue('\\SoapEnvelope\\Headers')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('parts')
            ->defaultValue('\\SoapEnvelope\\Parts')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('messages')
            ->defaultValue('\\SoapEnvelope\\Messages')
            ->cannotBeEmpty()
            ->end()
            ->arrayNode('metadata')->fixXmlConfig('metadata')
                ->cannotBeEmpty()->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
