<?php
namespace GoetasWebservices\WsdlToPhp\Generation;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use GoetasWebservices\XML\SOAPReader\Soap\OperationMessage;
use GoetasWebservices\XML\SOAPReader\Soap\Service;

abstract class SoapConverter
{
    const SOAP = 'http://schemas.xmlsoap.org/soap/envelope/';
    const SOAP_12 = 'http://www.w3.org/2003/05/soap-envelope';

    protected $baseNs = [
        '1.1' => [
            'headers' => '\\SoapEnvelope\\Headers',
            'parts' => '\\SoapParts',
            'messages' => '\\SoapEnvelope\\Messages',
        ],
        '1.2' => [
            'headers' => '\\SoapEnvelope12\\Headers',
            'parts' => '\\SoapParts',
            'messages' => '\\SoapEnvelope12\\Messages',
        ]
    ];

    protected $inflector;

    public function __construct(array $baseNs = array())
    {
        $this->inflector = InflectorFactory::create()->build();
        if ($baseNs){
            $this->baseNs = $baseNs;
        }
    }

    public function visitServices(array $services)
    {
        $visited = array();
        $this->classes = array();
        foreach ($services as $service) {
            $this->visitService($service, $visited);
        }
        return $this->getTypes();
    }

    /**
     *
     * @return PHPClass[]
     */
    public function getTypes()
    {
        uasort($this->classes, function ($a, $b) {
            return strcmp(key($a), key($b));
        });

        $ret = array();

        foreach ($this->classes as $definition) {
            $classname = key($definition);
            if (strpos($classname, '\\') !== false) {
                $ret[$classname] = $definition;
            }
        }

        return $ret;
    }

    private function visitService(\GoetasWebservices\XML\SOAPReader\Soap\Service $service, array &$visited)
    {
        if ($service->getVersion() === '1.1') {
            $this->soapEnvelopeNs = self::SOAP;
        } elseif ($service->getVersion() === '1.2') {
            $this->soapEnvelopeNs = self::SOAP_12;
        } else {
            throw new \RuntimeException("SOAP version '".$service->getVersion(). "'' is not supported");
        }

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
        if (!isset($this->classes[spl_object_hash($message)])) {
            $className = $this->findPHPName($message, $this->inflector->classify($hint), $this->baseNs[$service->getVersion()]['parts']);
            $class = array();
            $data = array();
            $envelopeData["xml_namespaces"] = ['SOAP' => $this->soapEnvelopeNs];
            $class[$className] = &$data;

            if ($message->getMessage()->getDefinition()->getTargetNamespace()) {
                $data["xml_root_namespace"] = $message->getMessage()->getDefinition()->getTargetNamespace();
            }
            $this->visitMessageParts($data, $message->getBody()->getParts());

            $this->classes[spl_object_hash($message)] = &$class;

            $messageClassName = $this->findPHPName($message, $this->inflector->classify($hint), $this->baseNs[$service->getVersion()]['messages']);
            $envelopeClass = array();
            $envelopeData = array();
            $envelopeClass[$messageClassName] = &$envelopeData;
            $envelopeData["xml_root_name"] = 'SOAP:Envelope';
            $envelopeData["xml_root_namespace"] = $this->soapEnvelopeNs;
            $envelopeData["xml_namespaces"] = ['SOAP' => $this->soapEnvelopeNs];

            $property = [];
            $property["expose"] = true;
            $property["access_type"] = "public_method";
            $property["type"] = $className;
            $property["serialized_name"] = 'Body';
            $property["xml_element"]["namespace"] = $this->soapEnvelopeNs;

            $property["accessor"]["getter"] = "getBody";
            $property["accessor"]["setter"] = "setBody";

            $envelopeData["properties"]['body'] = $property;
            $this->classes[] = &$envelopeClass;


            if (1) {
                $headersClass = array();
                $headersData = array();

                $headersData["xml_namespaces"] = ['SOAP' => $this->soapEnvelopeNs];

                $className = $this->findPHPName($message, $this->inflector->classify($hint), $this->baseNs[$service->getVersion()]['headers']);

                $headersClass[$className] = &$headersData;
                $this->classes[] = &$headersClass;

                $property = [];
                $property["expose"] = true;
                $property["access_type"] = "public_method";
                $property["type"] = count($message->getHeaders()) ? $className : 'GoetasWebservices\SoapServices\Metadata\Headers\Handler\HeaderPlaceholder';
                $property["serialized_name"] = 'Header';
                $property["xml_element"]["namespace"] = $this->soapEnvelopeNs;

                $property["accessor"]["getter"] = "getHeader";
                $property["accessor"]["setter"] = "setHeader";

                $envelopeData["properties"]['header'] = $property;

                foreach ($message->getHeaders() as $k => $header) {
                    $this->visitMessageParts($headersData, [$header->getPart()], 'GoetasWebservices\SoapServices\SoapEnvelope\Headers');
                }
            }

        }
        return $this->classes[spl_object_hash($message)];
    }

    private function visitMessageParts(&$data, array $parts, $wrapper = null)
    {
        /**
         * @var $part \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
         */
        foreach ($parts as $part) {
            $property = [];
            $property["expose"] = true;
            $property["access_type"] = "public_method";


            $property["accessor"]["getter"] = "get" . $this->inflector->classify($part->getName());
            $property["accessor"]["setter"] = "set" . $this->inflector->classify($part->getName());


            if ($part->getElement()) {
                $property["xml_element"]["namespace"] = $part->getElement()->getSchema()->getTargetNamespace();
                $property["serialized_name"] = $part->getElement()->getName();
                $c = $this->converter->visitElementDef($part->getElement()->getSchema(), $part->getElement());
            } else {
                $property["xml_element"]["namespace"] = null;
                $property["serialized_name"] = $part->getName();
                $c = $this->converter->visitType($part->getType());
            }
            if ($wrapper) {
                $property["type"] = $wrapper . "<'" . key($c) . "'>";
            } else {
                $property["type"] = key($c);
            }

            $data['properties'][$this->inflector->camelize($part->getName())] = $property;
        }
    }

    private function findPHPName(OperationMessage $message, $hint = '', $nsadd = '')
    {
        $name = $this->inflector->classify($message->getMessage()->getOperation()->getName()) . $hint;
        $targetNs = $message->getMessage()->getDefinition()->getTargetNamespace();

        $namespaces = $this->converter->getNamespaces();

        if (!isset($namespaces[$targetNs])) {
            throw new Exception(sprintf("Can't find a PHP namespace to '%s' namespace", $targetNs));
        }
        $ns = $namespaces[$targetNs];
        return $ns . $nsadd . "\\" . $name;
    }
}
