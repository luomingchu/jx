<?php

return [
    'common' => [
        // 合作身份者id，以2088开头的16位纯数字
        'partner' => '2088011699303532',
        // 安全检验码，以数字和字母组成的32位字符，如果签名方式设置为“MD5”时，请设置该参数
        'key' => '45zkbh90ej54lvfycgq1s90wf0zqm240',
        // 卖家支付宝账号
        'email' => '516161567@qq.com',
        // 商户的私钥（后缀是.pen）文件相对路径，如果签名方式设置为“0001”时，请设置该参数
        'private_key_path' => getcwd().'\\key/my.secret',
        // 支付宝公钥（后缀是.pen）文件相对路径,如果签名方式设置为“0001”时，请设置该参数
        'ali_public_key_path' => getcwd().'\\key/rsa_public_key.pem',
        // 签名方式
        'sign_type' => 'MD5',
        // 字符编码格式 目前支持 gbk 或 utf-8
        'input_charset' => 'utf-8',
        // ca证书路径地址，用于curl中ssl校验，请保证cacert.pem文件在当前文件夹目录中
        'cacert' => getcwd().'\\key/cacert.pem',
        // 访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        'transport' => 'http'
    ],
    // 客户配置，如与通用配置不同，直接设置相同的key就可以直接覆盖common里面的设置
    'customer' => [
        'woaiwocha' => [
            'partner' => '2088011699303532',
            'key' => '45zkbh90ej54lvfycgq1s90wf0zqm240',
            'email' => '516161567@qq.com'
        ],
        'woaiwochatest' => [
            'partner' => '2088011699303532',
            'key' => '45zkbh90ej54lvfycgq1s90wf0zqm240',
            'email' => '516161567@qq.com'
        ],
        'own' => [
            'partner' => '2088011699303532',
            'key' => '45zkbh90ej54lvfycgq1s90wf0zqm240',
            'email' => '516161567@qq.com'
        ],
    ]
];