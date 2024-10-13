<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default LDAP Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the LDAP connections below you wish
    | to use as your default connection for all LDAP operations. Of
    | course you may add as many connections you'd like below.
    |
    */

    'default' => env('LDAP_CONNECTION', 'Argon'),

    /*
    |--------------------------------------------------------------------------
    | LDAP Connections
    |--------------------------------------------------------------------------
    |
    | Below you may configure each LDAP connection your application requires
    | access to. Be sure to include a valid base DN - otherwise you may
    | not receive any results when performing LDAP search operations.
    |
    */

    'connections' => [

        /**Conexion Directorio Activo de Pruebas */
        /*'default' => [
            'hosts' => [env('LDAP_HOST', 'ldap.forumsys.com')],
            'username' => env('LDAP_USERNAME', 'cn=read-only-admin,dc=example,dc=com'),
            'password' => env('LDAP_PASSWORD', 'password'),
            'port' => env('LDAP_PORT', 389),
            'base_dn' => env('LDAP_BASE_DN', 'dc=example,dc=com'),
            'timeout' => env('LDAP_TIMEOUT', 5),
            'use_ssl' => env('LDAP_SSL', false),
            'use_tls' => env('LDAP_TLS', false),
        ],*/

        /**Conexion Directorio Activo Empresa Local*/

        /* 'Argon' => [
            'hosts' => [env('LDAP_HOST', '10.0.2.11')],
            'username' => env('LDAP_USERNAME', 'cn=Aplicaciones TI, cn=users, dc=acs, dc=local'),
            'password' => env('LDAP_PASSWORD', '4v10m4r$2021'),
            'port' => env('LDAP_PORT', 389),
            'base_dn' => env('LDAP_BASE_DN', 'dc=acs, dc=local'),
            'timeout' => env('LDAP_TIMEOUT', 3),
            'use_ssl' => env('LDAP_SSL', false),
            'use_tls' => env('LDAP_TLS', false),
            'version' => 3,
        ], */

        /**Conexion Directorio Activo Empresa Publico*/

        'Argon' => [
            'hosts' => [env('LDAP_HOST', '186.29.91.155')],
            'username' => env('LDAP_USERNAME', 'cn=Aplicaciones TI, cn=users, dc=acs, dc=local'),
            'password' => env('LDAP_PASSWORD', '4v10m4r$2021'),
            'port' => env('LDAP_PORT', 9271),
            'base_dn' => env('LDAP_BASE_DN', 'dc=acs, dc=local'),
            'timeout' => env('LDAP_TIMEOUT', 3),
            'use_ssl' => env('LDAP_SSL', false),
            'use_tls' => env('LDAP_TLS', false),
            'version' => 3,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | LDAP Logging
    |--------------------------------------------------------------------------
    |
    | When LDAP logging is enabled, all LDAP search and authentication
    | operations are logged using the default application logging
    | driver. This can assist in debugging issues and more.
    |
    */

    'logging' => [
        'enabled' => env('LDAP_LOGGING', true),
        'channel' => env('LOG_CHANNEL', 'stack'),
        'level' => env('LOG_LEVEL', 'info'),
    ],

    /*
    |--------------------------------------------------------------------------
    | LDAP Cache
    |--------------------------------------------------------------------------
    |
    | LDAP caching enables the ability of caching search results using the
    | query builder. This is great for running expensive operations that
    | may take many seconds to complete, such as a pagination request.
    |
    */

    'cache' => [
        'enabled' => env('LDAP_CACHE', false),
        'driver' => env('CACHE_DRIVER', 'file'),
    ],

];
