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
    }

    protected static function sanitizePhp($ns)
    {
        return strtr($ns, '/', '\\');
    }

    public function getAlias()
    {
        return 'wsdl2php';
    }
}
