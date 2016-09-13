<?php
namespace GoetasWebservices\WsdlToPhp\Metadata;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class PhpMetadataWriter implements PhpMetadataWriterInterface
{
    use LoggerAwareTrait;
    /**
     * @var string
     */
    private $destination;

    public function __construct($destination, LoggerInterface $logger = null)
    {
        $this->destination = $destination;
        $this->logger = $logger ?: new NullLogger();;
    }

    /**
     * @param array $metadata
     * @return void
     */
    public function write(array $metadata)
    {
        $this->logger->info(sprintf("Writing WSDL metadata to %s", $this->destination));
        file_put_contents($this->destination, var_export($metadata, 1));
    }
}

