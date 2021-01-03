<?php
namespace GoetasWebservices\WsdlToPhp\Generation;

use Doctrine\Common\Inflector\Inflector;
use Exception;
use GoetasWebservices\XML\SOAPReader\Soap\OperationMessage;
use GoetasWebservices\XML\SOAPReader\Soap\Service;
use GoetasWebservices\Xsd\XsdToPhp\Php\PhpConverter;
use GoetasWebservices\Xsd\XsdToPhp\Php\Structure\PHPClass;
use GoetasWebservices\Xsd\XsdToPhp\Php\Structure\PHPProperty;

class PhpSoapConverter extends SoapConverter
{
    private $classes = [];

    private $converter;

    public function __construct(PhpConverter $converter, array $baseNs = array())
    {
        $this->converter = $converter;
        parent::__construct($baseNs);
    }

    public function visitServices(array $services)
    {
        $visited = array();
        $this->classes = array();
        foreach ($services as $service) {
            $this->visitService($service, $visited);
        }
        $classes = array();
        foreach ($this->classes as $k => $v) {
            if (strpos($k, '__') !== 0) {
                $classes[$k] = $v;
            }
        }
        return $classes;
    }

    private function visitService(Service $service, array &$visited)
    {
        if (isset($visited[spl_object_hash($service)])) {
            return;
        }
        $visited[spl_object_hash($service)] = true;

        foreach ($service->getOperations() as $operation) {
            $this->visitOperation($operation, $service);
        }
    }

    private function visitOperation(\GoetasWebservices\XML\SOAPReader\Soap\Operation $operation, Service $service)
    {
        $this->visitMessage($operation->getInput(), 'input', $operation, $service);
        if (null !== ($output = $operation->getOutput())) {
            $this->visitMessage($output, 'output', $operation, $service);
        }
    }

    private function visitMessage(OperationMessage $message, $hint, \GoetasWebservices\XML\SOAPReader\Soap\Operation $operation, Service $service)
    {
        if (!isset($this->classes['__' . spl_object_hash($message)])) {

            $this->classes['__' . spl_object_hash($message)] = $bodyClass = new PHPClass();

            list ($name, $ns) = $this->findPHPName($message, Inflector::classify($hint));
            $bodyClass->setName(Inflector::classify($name));
            $bodyClass->setNamespace($ns . $this->baseNs[$service->getVersion()]['parts']);
            if ($message->getBody()->getParts()) {
                $this->classes[$bodyClass->getFullName()] = $bodyClass;
            }

            $this->visitMessageParts($bodyClass, $message->getBody()->getParts());

            $envelopeClass = new PHPClass();
            $envelopeClass->setName(Inflector::classify($name));
            $envelopeClass->setNamespace($ns . $this->baseNs[$service->getVersion()]['messages']);
            $envelopeClass->setImplements(['GoetasWebservices\SoapServices\Metadata\Envelope\Envelope']);
            $this->classes[$envelopeClass->getFullName()] = $envelopeClass;

            if ($message->getBody()->getParts()) {
                $property = new PHPProperty('body', $bodyClass);
                $envelopeClass->addProperty($property);
            }


            $property = new PHPProperty('header');
            $headerClass = new PHPClass();
            $headerClass->setName(Inflector::classify($name));
            $headerClass->setNamespace($ns . $this->baseNs[$service->getVersion()]['headers']);

            $this->classes[$headerClass->getFullName()] = $headerClass;

            $envelopeClass->addProperty($property);

            $property->setType(new PHPClass($headerClass->getName(), $headerClass->getNamespace()));

            foreach ($message->getHeaders() as $header) {
                $this->visitMessageParts($headerClass, [$header->getPart()]);
            }

        }
        return $this->classes['__' . spl_object_hash($message)];
    }

    private function visitMessageParts(PHPClass $class, array $parts)
    {
        /**
         * @var $part \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
         */
        foreach ($parts as $part) {
            $property = new PHPProperty();

            if ($part->getElement()) {
                $property->setName(Inflector::camelize($part->getElement()->getName()));
                $property->setType($this->converter->visitElementDef($part->getElement()));
            } else {
                $property->setName(Inflector::camelize($part->getName()));
                $property->setType($this->converter->visitType($part->getType()));
            }

            $class->addProperty($property);
        }
    }

    private function findPHPName(OperationMessage $message, $hint = '')
    {
        $name = $message->getMessage()->getOperation()->getName() . ucfirst($hint);
        $targetNs = $message->getMessage()->getDefinition()->getTargetNamespace();
        $namespaces = $this->converter->getNamespaces();
        if (!isset($namespaces[$targetNs])) {
            throw new Exception(sprintf("Can't find a PHP namespace to '%s' namespace", $targetNs));
        }
        $ns = $namespaces[$targetNs];
        return [
            $name,
            $ns
        ];
    }
}
