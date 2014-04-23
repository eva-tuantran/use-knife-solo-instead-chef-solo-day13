<?php
/**
 * The development database settings. These get merged with the global settings.
 *
 * grant all privileges on rakuichi.* to rakuichi@'192.168.%' identified by 'rakuichi';
 *
 */

return array(
    'default' => array(
        'type' => 'mysqli',
        'connection'  => array(
            'hostname' => 'localhost',
            'database' => 'rakuichi-rakuza',
            'username' => 'rr_readonly',
            'password' => '6bd369abc23fc87abf191566348a69798d85092e',
        ),
        'identifier'     => '`',
        'table_prefix'   => '',
        'charset'        => 'utf8',
    ),
    'master' => array(
        'type' => 'mysqli',
        'connection'  => array(
            'hostname' => 'localhost',
            'database' => 'rakuichi-rakuza',
            'username' => 'rr_admin',
            'password' => 'f8f4316c0ad0ce4939fd2966b9aff60e271ffe68',
        ),
        'identifier'     => '`',
        'table_prefix'   => '',
        'charset'        => 'utf8',
    ),
    'slave' => array(
        'type' => 'mysqli',
        'connection'  => array(
            'hostname' => 'localhost',
            'database' => 'rakuichi-rakuza',
            'username' => 'rr_readonly',
            'password' => '6bd369abc23fc87abf191566348a69798d85092e',
        ),
        'identifier'     => '`',
        'table_prefix'   => '',
        'charset'        => 'utf8',
    ),
);
