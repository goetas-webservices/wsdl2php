<?php return [
    'test' => [
        'testSOAP' => [
            'operations' => [
                'getSimple' => [
                    'action' => 'http://www.example.org/test/getSimple',
                    'style' => 'rpc',
                    'name' => 'getSimple',
                    'method' => 'getSimple',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\GetSimpleInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\GetSimpleInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\GetSimpleInput',
                        'parts' => [
                            'parameters' => 'GetSimple',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\GetSimpleOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\GetSimpleOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\GetSimpleOutput',
                        'parts' => [
                            'parameters' => 'GetSimpleResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'getMultiParam' => [
                    'action' => 'http://www.example.org/test/getMultiParam',
                    'style' => 'rpc',
                    'name' => 'getMultiParam',
                    'method' => 'getMultiParam',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\GetMultiParamInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\GetMultiParamInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\GetMultiParamInput',
                        'parts' => [
                            'parameters' => 'GetMultiParam',
                            'other-param' => 'StringType',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\GetMultiParamOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\GetMultiParamOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\GetMultiParamOutput',
                        'parts' => [
                            'parameters' => 'GetMultiParamResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'getReturnMultiParam' => [
                    'action' => 'http://www.example.org/test/getReturnMultiParam',
                    'style' => 'rpc',
                    'name' => 'getReturnMultiParam',
                    'method' => 'getReturnMultiParam',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\GetReturnMultiParamInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\GetReturnMultiParamInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\GetReturnMultiParamInput',
                        'parts' => [
                            'parameters' => 'GetReturnMultiParam',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\GetReturnMultiParamOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\GetReturnMultiParamOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\GetReturnMultiParamOutput',
                        'parts' => [
                            'parameters' => 'GetReturnMultiParamResponse',
                            'other-param' => 'StringType',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'requestHeader' => [
                    'action' => 'http://www.example.org/test/requestHeader',
                    'style' => 'rpc',
                    'name' => 'requestHeader',
                    'method' => 'requestHeader',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\RequestHeaderInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\RequestHeaderInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\RequestHeaderInput',
                        'parts' => [
                            'parameters' => 'RequestHeader',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\RequestHeaderOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\RequestHeaderOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\RequestHeaderOutput',
                        'parts' => [
                            'parameters' => 'RequestHeaderResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'requestHeaders' => [
                    'action' => 'http://www.example.org/test/requestHeaders',
                    'style' => 'rpc',
                    'name' => 'requestHeaders',
                    'method' => 'requestHeaders',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\RequestHeadersInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\RequestHeadersInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\RequestHeadersInput',
                        'parts' => [
                            'parameters' => 'RequestHeaders',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\RequestHeadersOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\RequestHeadersOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\RequestHeadersOutput',
                        'parts' => [
                            'parameters' => 'RequestHeadersResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'responseHader' => [
                    'action' => 'http://www.example.org/test/responseHader',
                    'style' => 'rpc',
                    'name' => 'responseHader',
                    'method' => 'responseHader',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\ResponseHaderInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\ResponseHaderInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\ResponseHaderInput',
                        'parts' => [
                            'parameters' => 'ResponseHader',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\ResponseHaderOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\ResponseHaderOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\ResponseHaderOutput',
                        'parts' => [
                            'parameters' => 'ResponseHaderResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'responseFault' => [
                    'action' => 'http://www.example.org/test/responseFault',
                    'style' => 'rpc',
                    'name' => 'responseFault',
                    'method' => 'responseFault',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\ResponseFaultInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\ResponseFaultInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\ResponseFaultInput',
                        'parts' => [
                            'parameters' => 'ResponseFault',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\ResponseFaultOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\ResponseFaultOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\ResponseFaultOutput',
                        'parts' => [
                            'parameters' => 'ResponseFaultResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'responseFaults' => [
                    'action' => 'http://www.example.org/test/responseFaults',
                    'style' => 'rpc',
                    'name' => 'responseFaults',
                    'method' => 'responseFaults',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\ResponseFaultsInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\ResponseFaultsInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\ResponseFaultsInput',
                        'parts' => [
                            'parameters' => 'ResponseFaults',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\ResponseFaultsOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\ResponseFaultsOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\ResponseFaultsOutput',
                        'parts' => [
                            'parameters' => 'ResponseFaultsResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'noInput' => [
                    'action' => 'http://www.example.org/test/noInput',
                    'style' => 'rpc',
                    'name' => 'noInput',
                    'method' => 'noInput',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\NoInputInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\NoInputInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\NoInputInput',
                        'parts' => [
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\NoInputOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\NoInputOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\NoInputOutput',
                        'parts' => [
                            'parameters' => 'NoInputResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'noOutput' => [
                    'action' => 'http://www.example.org/test/noOutput',
                    'style' => 'rpc',
                    'name' => 'noOutput',
                    'method' => 'noOutput',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\NoOutputInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\NoOutputInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\NoOutputInput',
                        'parts' => [
                            'parameters' => 'NoOutput',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\NoOutputOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\NoOutputOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\NoOutputOutput',
                        'parts' => [
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'noBoth' => [
                    'action' => 'http://www.example.org/test/noBoth',
                    'style' => 'rpc',
                    'name' => 'noBoth',
                    'method' => 'noBoth',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\NoBothInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\NoBothInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\NoBothInput',
                        'parts' => [
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\NoBothOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\NoBothOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\NoBothOutput',
                        'parts' => [
                        ],
                    ],
                    'fault' => [
                    ],
                ],
                'oneWayNotify' => [
                    'action' => 'http://www.example.org/test/oneWayNotify',
                    'style' => 'rpc',
                    'name' => 'oneWayNotify',
                    'method' => 'oneWayNotify',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\OneWayNotifyInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\OneWayNotifyInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\OneWayNotifyInput',
                        'parts' => [
                        ],
                    ],
                    'fault' => [
                    ],
                ],
            ],
            'endpoint' => 'http://www.example.org/',
            'unwrap' => false,
        ],
    ],
    'alternativeTest' => [
        'aPort' => [
            'operations' => [
            ],
            'endpoint' => 'http://www.example.org/',
            'unwrap' => false,
        ],
        'otherPort' => [
            'operations' => [
                'doSomething' => [
                    'action' => 'http://www.example.org/test/doSomething',
                    'style' => 'rpc',
                    'name' => 'doSomething',
                    'method' => 'doSomething',
                    'input' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\DoSomethingInput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\DoSomethingInput',
                        'part_fqcn' => 'TestNs\\SoapParts\\DoSomethingInput',
                        'parts' => [
                            'parameters' => 'DoSomething',
                        ],
                    ],
                    'output' => [
                        'message_fqcn' => 'TestNs\\SoapEnvelope\\Messages\\DoSomethingOutput',
                        'headers_fqcn' => 'TestNs\\SoapEnvelope\\Headers\\DoSomethingOutput',
                        'part_fqcn' => 'TestNs\\SoapParts\\DoSomethingOutput',
                        'parts' => [
                            'parameters' => 'DoSomethingResponse',
                        ],
                    ],
                    'fault' => [
                    ],
                ],
            ],
            'endpoint' => 'http://www.example.org/',
            'unwrap' => false,
        ],
        'http' => [
            'operations' => [
            ],
            'endpoint' => NULL,
            'unwrap' => false,
        ],
    ],
];
