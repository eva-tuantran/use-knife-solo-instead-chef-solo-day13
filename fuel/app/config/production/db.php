<?php
/**
 * 本番DB設定:
 * 基本的に4.201だけがMasterとなります(書き込みも可能)
 * 細かいDBのユーザ作成設定などは全てChef側のファイルに内包されています
 *
 */

return array(
    'default' => array(
        'type' => 'mysqli',
        'connection'  => array(
            'hostname' => 'rakuichi-rakuza.cnceg4b5jglv.ap-northeast-1.rds.amazonaws.com',
            'database' => 'rakuichi_rakuza',
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
            'hostname' => 'rakuichi-rakuza.cnceg4b5jglv.ap-northeast-1.rds.amazonaws.com',
            'database' => 'rakuichi_rakuza',
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
            'hostname' => 'rakuichi-rakuza.cnceg4b5jglv.ap-northeast-1.rds.amazonaws.com',
            'database' => 'rakuichi_rakuza',
            'username' => 'rr_readonly',
            'password' => '6bd369abc23fc87abf191566348a69798d85092e',
        ),
        'identifier'     => '`',
        'table_prefix'   => '',
        'charset'        => 'utf8',
    ),
);
