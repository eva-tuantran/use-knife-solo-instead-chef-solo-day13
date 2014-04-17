<?php

class Model_Base extends \Orm\Model_Soft
{
    protected static $_write_connection = 'master';
    protected static $_connection       = 'slave';

    public static function use_master()
    {
        static::$_write_connection = 'master';
        static::$_connection       = 'master';
    }
    
    public static function use_master_and_slave()
    {
        static::$_write_connection = 'master';
        static::$_connection       = 'slave';
    }
}
