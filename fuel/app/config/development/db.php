<?php
/**
 * The development database settings. These get merged with the global settings.
 *
 * grant all privileges on rakuichi.* to rakuichi@'192.168.%' identified by 'rakuichi';
 *
 */

return array(
    'default' => array(
        'connection'  => array(
            'dsn'        => 'mysql:host=localhost;dbname=rakuichi-rakuza',
            'username'   => 'rakuichi',
            'password'   => 'rakuichi',
        ),
    ),
);
