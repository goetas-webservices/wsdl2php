<?php
namespace GoetasWebservices\WsdlToPhp\Tests;

use GoetasWebservices\WsdlToPhp\Generation\JmsSoapConverter;
use GoetasWebservices\WsdlToPhp\Generation\PhpSoapConverter;
use GoetasWebservices\XML\SOAPReader\Soap\Service;
use GoetasWebservices\XML\SOAPReader\SoapReader;
use GoetasWebservices\XML\WSDLReader\DefinitionsReader;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use GoetasWebservices\Xsd\XsdToPhp\Jms\YamlConverter;
use GoetasWebservices\Xsd\XsdToPhp\Php\PhpConverter;
use GoetasWebservices\Xsd\XsdToPhp\Tests\AbstractGenerator;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Generator extends AbstractGenerator
{
    public function getData(array $files, $servicePortNames = array(), $knownLocations = array())
    {
        $reader = new SchemaReader();
        foreach ($knownLocations as $url => $alias) {
            $reader->addKnownSchemaLocation($url, $alias);
        }
        $dispatcher = new EventDispatcher();
        $wsdlReader = new DefinitionsReader($reader, $dispatcher);
        $soapReader = new SoapReader();
        $dispatcher->addSubscriber($soapReader);
        $schemas = [];
        foreach ($files as $file) {
            $definitions = $wsdlReader->readFile($file);
            $schemas[] = $definitions->getSchema();
        }

        $services = $soapReader->getServices();
        $services = array_filter($services, function (Service $service) use ($servicePortNames) {
            return empty($servicePortNames) || in_array($service->getPort()->getName(), $servicePortNames);
        });

        $php = $this->generatePHPFiles($schemas, $services);
        $jms = $this->generateJMSFiles($schemas, $services);

        return [$php, $jms];
    }

    public function generate(array $files, $servicePortNames = array(), $knownLocations = array())
    {
        $this->cleanDirectories();

        list($php, $jms) = $this->getData($files, $servicePortNames, $knownLocations);

        $this->writeJMS($jms);
        $this->writePHP($php);

        return [$php, $jms];
    }

    protected function generatePHPFiles(array $schemas, array $services)
    {
        $converter = new PhpConverter($this->namingStrategy);

        $soapConverter = new PhpSoapConverter($converter);

        //$soapConverter->setOutputAnyAttribute(true);
        $soapConverter->setOutputAnyElement(true);

        $this->setNamespaces($converter);
        $items = $converter->convert($schemas);
        $items = array_merge($items, $soapConverter->visitServices($services));
        return $items;
    }

    protected function generateJMSFiles(array $schemas, array $services)
    {
        $converter = new YamlConverter($this->namingStrategy);
        $soapConverter = new JmsSoapConverter($converter);

        $soapConverter->setOutputAnyElement(true);

        $this->setNamespaces($converter);
        $items = $converter->convert($schemas);
        $items = array_merge($items, $soapConverter->visitServices($services));
        return $items;
    }
}
