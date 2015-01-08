<?php

$api_path = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : Config::get('app.api_url');

return array(
    'enable' => Config::get('app.debug'),

    'prefix' => 'api-docs',

    'paths' => [
        app_path('routes'),
        base_path('../admin/app/models')
    ],
    'output' => 'docs',
    'exclude' => null,
    //'default-base-path' => Config::get('app.api_url'),
    'default-base-path' => $api_path,
    'default-api-version' => null,
    'default-swagger-version' => null,
    'api-doc-template' => null,
    'suffix' => '.{format}',

    'title' => 'Swagger UI'
);