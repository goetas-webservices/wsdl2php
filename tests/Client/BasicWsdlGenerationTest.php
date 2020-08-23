<?php
namespace GoetasWebservices\WsdlToPhp\Tests;

use PHPUnit\Framework\TestCase;

class BasicWsdlGenerationTest extends TestCase
{
    /**
     * @var Generator
     */
    protected static $generator;
    protected static $php = [];
    protected static $jms = [];
    protected static $jms12 = [];
    private static $namespace = 'Ex';

    public static function setUpBeforeClass(): void
    {
        self::$generator = new Generator([
            'http://www.example.org/test/' => self::$namespace
        ]);

        list(, self::$jms12) = self::$generator->getData([__DIR__ . '/../Fixtures/test12.wsdl']);

        list(self::$php, self::$jms) = self::$generator->getData([__DIR__ . '/../Fixtures/test.wsdl']);
        self::$generator->registerAutoloader();
    }

    public static function tearDownAfterClass(): void
    {
        self::$generator->unRegisterAutoloader();
        //self::$generator->cleanDirectories();
    }

    public function testGenerator()
    {
        self::setUpBeforeClass();
        self::assertTrue(true);
    }

    public function getTypes()
    {
        return array(
            ['Ex\\AFault'],
            ['Ex\\AuthHeader'],
            ['Ex\\AuthHeaderLocal'],
            ['Ex\\BFault'],
            ['Ex\\CustomComplexType'],
            ['Ex\\DoSomething'],
            ['Ex\\DoSomethingResponse'],
            ['Ex\\GetMultiParam'],
            ['Ex\\GetMultiParamResponse'],
            ['Ex\\GetReturnMultiParam'],
            ['Ex\\GetReturnMultiParamResponse'],
            ['Ex\\GetSimple'],
            ['Ex\\GetSimpleResponse'],
            ['Ex\\GetType'],
            ['Ex\\GetTypeResponse'],
            ['Ex\\NoInputResponse'],
            ['Ex\\RequestHeader'],
            ['Ex\\RequestHeaderResponse'],
            ['Ex\\RequestHeaders'],
            ['Ex\\RequestHeadersResponse'],
            ['Ex\\ResponseFault'],
            ['Ex\\ResponseFaultResponse'],
            ['Ex\\ResponseFaults'],
            ['Ex\\ResponseFaultsResponse'],
            ['Ex\\ResponseHader'],
            ['Ex\\ResponseHaderResponse'],
            ['Ex\\OneWayNotify'],
        );
    }

    /**
     * @dataProvider getTypes
     */
    public function testPhpTypes($part)
    {
        $this->assertArrayHasKey($part, self::$php);
    }

    public function getMessages()
    {
        return array(
            ['Ex\\SoapEnvelope\\Messages\\DoSomethingInput'],
            ['Ex\\SoapEnvelope\\Messages\\DoSomethingOutput'],
            ['Ex\\SoapEnvelope\\Messages\\GetMultiParamInput'],
            ['Ex\\SoapEnvelope\\Messages\\GetMultiParamOutput'],
            ['Ex\\SoapEnvelope\\Messages\\GetReturnMultiParamInput'],
            ['Ex\\SoapEnvelope\\Messages\\GetReturnMultiParamOutput'],
            ['Ex\\SoapEnvelope\\Messages\\GetSimpleInput'],
            ['Ex\\SoapEnvelope\\Messages\\GetSimpleOutput'],
            ['Ex\\SoapEnvelope\\Messages\\NoInputOutput'],
            ['Ex\\SoapEnvelope\\Messages\\NoOutputInput'],
            ['Ex\\SoapEnvelope\\Messages\\RequestHeaderInput'],
            ['Ex\\SoapEnvelope\\Messages\\RequestHeaderOutput'],
            ['Ex\\SoapEnvelope\\Messages\\RequestHeadersInput'],
            ['Ex\\SoapEnvelope\\Messages\\RequestHeadersOutput'],
            ['Ex\\SoapEnvelope\\Messages\\ResponseFaultInput'],
            ['Ex\\SoapEnvelope\\Messages\\ResponseFaultOutput'],
            ['Ex\\SoapEnvelope\\Messages\\ResponseFaultsInput'],
            ['Ex\\SoapEnvelope\\Messages\\ResponseFaultsOutput'],
            ['Ex\\SoapEnvelope\\Messages\\ResponseHaderInput'],
            ['Ex\\SoapEnvelope\\Messages\\ResponseHaderOutput'],
            ['Ex\\SoapEnvelope\\Messages\\OneWayNotifyInput'],
        );
    }

    /**
     * @dataProvider getMessages
     */
    public function testPhpMessages($part)
    {
        $this->assertArrayHasKey($part, self::$php);
        $this->assertTrue(self::$php[$part]->hasProperty('body'));
    }

    public function testJms12()
    {
        $this->assertEquals([
            'Ex\\SoapEnvelope12\\Messages\\DoSomethingInput' =>
                [
                    'xml_root_name' => 'SOAP:Envelope',
                    'xml_root_namespace' => 'http://www.w3.org/2003/05/soap-envelope',
                    'xml_namespaces' => [
                        'SOAP' => 'http://www.w3.org/2003/05/soap-envelope',
                    ],
                    'properties' => [
                        'body' => [
                            'expose' => true,
                            'access_type' => 'public_method',
                            'type' => 'Ex\\SoapParts\\DoSomethingInput',
                            'serialized_name' => 'Body',
                            'xml_element' => [
                                'namespace' => 'http://www.w3.org/2003/05/soap-envelope',
                            ],
                            'accessor' => [
                                'getter' => 'getBody',
                                'setter' => 'setBody',
                            ],
                        ],
                        'header' => [
                            'expose' => true,
                            'access_type' => 'public_method',
                            'type' => 'GoetasWebservices\\SoapServices\\SoapClient\\Arguments\\Headers\\Handler\\HeaderPlaceholder',
                            'serialized_name' => 'Header',
                            'xml_element' => [
                                'namespace' => 'http://www.w3.org/2003/05/soap-envelope',
                            ],
                            'accessor' => [
                                'getter' => 'getHeader',
                                'setter' => 'setHeader',
                            ],
                        ],
                    ],
                ],
        ], self::$jms12['Ex\SoapEnvelope12\Messages\DoSomethingInput']);
    }

    public function testPhpMessagesExtra()
    {
        $this->assertTrue(self::$php['Ex\\SoapEnvelope\\Messages\\RequestHeadersInput']->hasProperty('header'));

        $this->assertTrue(self::$php['Ex\\SoapEnvelope\\Messages\\RequestHeaderInput']->hasProperty('header'));

        $this->assertTrue(self::$php['Ex\\SoapEnvelope\\Messages\\GetSimpleInput']->hasProperty('body'));
        $this->assertTrue(self::$php['Ex\\SoapEnvelope\\Messages\\GetSimpleInput']->hasProperty('header'));
        $this->assertEquals('Ex\SoapParts\GetSimpleInput', self::$php['Ex\\SoapEnvelope\\Messages\\GetSimpleInput']->getProperty('body')->getType()->getFullName());

        $this->assertTrue(self::$php['Ex\\SoapEnvelope\\Messages\\GetSimpleOutput']->hasProperty('body'));
        $this->assertTrue(self::$php['Ex\\SoapEnvelope\\Messages\\GetSimpleOutput']->hasProperty('header'));
        $this->assertEquals('Ex\SoapParts\GetSimpleOutput', self::$php['Ex\\SoapEnvelope\\Messages\\GetSimpleOutput']->getProperty('body')->getType()->getFullName());
    }


    public function getEmptyMessages()
    {
        return array(
            ['Ex\\SoapEnvelope\\Messages\\NoBothInput'],
            ['Ex\\SoapEnvelope\\Messages\\NoBothOutput'],
            ['Ex\\SoapEnvelope\\Messages\\NoInputInput'],
            ['Ex\\SoapEnvelope\\Messages\\NoOutputOutput'],
        );
    }

    /**
     * @dataProvider getEmptyMessages
     */
    public function testPhpEmptyMessages($part)
    {
        $this->assertArrayHasKey($part, self::$php);
        $this->assertFalse(self::$php[$part]->hasProperty('body'));
    }

    /**
     * @dataProvider getParts
     */
    public function testPhpParts($part, $type)
    {
        $this->assertArrayHasKey($part, self::$php);
        $this->assertTrue(self::$php[$part]->hasProperty('parameters'));
        $this->assertEquals($type, self::$php[$part]->getProperty('parameters')->getType()->getFullName());
    }

    public function getParts()
    {
        return array(
            ['Ex\\SoapParts\\DoSomethingInput', 'Ex\\DoSomething',],
            ['Ex\\SoapParts\\DoSomethingOutput', 'Ex\\DoSomethingResponse',],
            ['Ex\\SoapParts\\GetMultiParamInput', 'Ex\\GetMultiParam',],
            ['Ex\\SoapParts\\GetMultiParamOutput', 'Ex\\GetMultiParamResponse',],
            ['Ex\\SoapParts\\GetReturnMultiParamInput', 'Ex\\GetReturnMultiParam',],
            ['Ex\\SoapParts\\GetReturnMultiParamOutput', 'Ex\\GetReturnMultiParamResponse',],
            ['Ex\\SoapParts\\GetSimpleInput', 'Ex\\GetSimple',],
            ['Ex\\SoapParts\\GetSimpleOutput', 'Ex\\GetSimpleResponse',],
            ['Ex\\SoapParts\\NoInputOutput', 'Ex\\NoInputResponse',],
            ['Ex\\SoapParts\\NoOutputInput', 'Ex\\NoOutput',],
            ['Ex\\SoapParts\\RequestHeaderInput', 'Ex\\RequestHeader',],
            ['Ex\\SoapParts\\RequestHeaderOutput', 'Ex\\RequestHeaderResponse',],
            ['Ex\\SoapParts\\RequestHeadersInput', 'Ex\\RequestHeaders',],
            ['Ex\\SoapParts\\RequestHeadersOutput', 'Ex\\RequestHeadersResponse',],
            ['Ex\\SoapParts\\ResponseFaultInput', 'Ex\\ResponseFault',],
            ['Ex\\SoapParts\\ResponseFaultOutput', 'Ex\\ResponseFaultResponse',],
            ['Ex\\SoapParts\\ResponseFaultsInput', 'Ex\\ResponseFaults',],
            ['Ex\\SoapParts\\ResponseFaultsOutput', 'Ex\\ResponseFaultsResponse',],
            ['Ex\\SoapParts\\ResponseHaderInput', 'Ex\\ResponseHader',],
            ['Ex\\SoapParts\\ResponseHaderOutput', 'Ex\\ResponseHaderResponse',],
            ['Ex\\SoapParts\\OneWayNotifyInput', 'Ex\\OneWayNotify',],
        );
    }

    /**
     * @dataProvider getEmptyParts
     */
    public function testPhpEmptyParts($part)
    {
        $this->assertArrayNotHasKey($part, self::$php);
    }

    public function getEmptyParts()
    {
        return array(
            ['Ex\\SoapParts\\NoBothInput'],
            ['Ex\\SoapParts\\NoBothOutput'],
            ['Ex\\SoapParts\\NoInputInput'],
            ['Ex\\SoapParts\\NoOutputOutput'],
        );
    }
}
