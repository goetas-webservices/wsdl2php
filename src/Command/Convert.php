<?php
namespace GoetasWebservices\WsdlToPhp\Command;

use GoetasWebservices\Xsd\XsdToPhp\Command\Convert as XsdToPhpConvert;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Convert extends XsdToPhpConvert
{
    /**
     *
     * @see Console\Command\Command
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('convert');
        $this->setDescription("Convert a WSDL file into PHP classes and JMS serializer metadata files");
    }

    /**
     *
     * @see Console\Command\Command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->loadConfigurations($input->getArgument('config'));

        $schemas = [];
        $src = $input->getArgument('src');
        $wsdlReader = $this->container->get('goetas.wsdl2php.wsdl_reader');
        foreach ($src as $file) {
            $definitions = $wsdlReader->readFile($file);
            $schemas[] = $definitions->getSchema();
        }

        $soapReader = $this->container->get('goetas.wsdl2php.soap_reader');
        foreach (['php', 'jms'] as $type) {
            $converter = $this->container->get('goetas.xsd2php.converter.' . $type);
            $wsdlConverter = $this->container->get('goetas.wsdl2php.converter.' . $type);

            $items = $wsdlConverter->visitServices($soapReader->getServices());
            $items = array_merge($items, $converter->convert($schemas));

            $writer = $this->container->get('goetas.xsd2php.writer.' . $type);
            $writer->write($items);
            var_dump(count($items));
        }
        return count($items) ? 0 : 255;

    }
}
