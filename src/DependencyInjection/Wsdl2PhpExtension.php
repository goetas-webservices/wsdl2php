<?php
namespace GoetasWebservices\WsdlToPhp\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Wsdl2PhpExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $xml = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $xml->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }
        $container->setParameter('goetas_webservices.wsdl2php.config', $config);
    }

    public function getAlias()
    {
        return 'wsdl2php';
    }
}
