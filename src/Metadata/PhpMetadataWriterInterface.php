<?php
namespace GoetasWebservices\WsdlToPhp\Metadata;

interface PhpMetadataWriterInterface
{
    /**
     * @param array $metadata
     * @return void
     */
    public function write(array $metadata);
}

