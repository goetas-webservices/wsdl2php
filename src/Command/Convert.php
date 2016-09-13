<?php
namespace GoetasWebservices\WsdlToPhp\Command;

use GoetasWebservices\Xsd\XsdToPhp\Command\Convert as XsdToPhpConvert;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
//        $this->setDefinition([
//            new InputOption('metadata', null, InputOption::VALUE_REQUIRED, 'Generate additional WSDL metadata')
//        ]);
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
        }

        if ($this->container->getParameter('generate_metadata')) {
            $generator = $this->container->get('goetas.wsdl2php.metadata.generator');
            $metadata = $generator->generate($soapReader->getServices());

            $writer = $this->container->get('goetas.wsdl2php.metadata.writer');
            $writer->write($metadata);
        }
        return count($items) ? 0 : 255;

    }
}
