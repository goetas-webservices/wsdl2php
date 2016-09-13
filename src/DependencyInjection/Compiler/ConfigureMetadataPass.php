<?php
namespace GoetasWebservices\WsdlToPhp\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigureMetadataPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('xsd2php.config');

        $writer = $container->getDefinition('goetas.wsdl2php.metadata.generator');
        $writer->replaceArgument(2, $config['namespaces']);

    }
}
