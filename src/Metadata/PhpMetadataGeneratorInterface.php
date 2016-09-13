<?php
namespace GoetasWebservices\WsdlToPhp\Metadata;

use GoetasWebservices\XML\SOAPReader\Soap\Service;

interface PhpMetadataGeneratorInterface
{
    /**
     * @param Service[] $services
     * @return array
     */
    public function generate(array $services);

    /**
     * @param string $ns
     * @param string $phpNamespace
     * @return void
     */
    public function addNamespace($ns, $phpNamespace);
}

