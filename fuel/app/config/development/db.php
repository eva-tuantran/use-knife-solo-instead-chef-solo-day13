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
            'username'   => 'readonly',
            'password'   => '',
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
            'username'   => 'root',
            'password'   => '',
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
            'username'   => 'readonly',
            'password'   => '',
        ),
        'identifier'     => '`',
        'table_prefix'   => '',
        'charset'        => 'utf8',
    ),
);
