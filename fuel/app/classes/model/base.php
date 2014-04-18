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

    // Model_Soft::query が write_connection を考慮していない不具合があるため上書き

	public static function query($options = array())
	{
        //$query = Query_Soft::forge(get_called_class(), static::connection(), $options);
		$query = \Orm\Query_Soft::forge(get_called_class(), array(static::connection(), static::connection(true)), $options);
        
		if (static::get_filter_status())
		{
			//Make sure we are filtering out soft deleted items
			$query->set_soft_filter(static::soft_delete_property('deleted_field', static::$_default_field_name));
		}

		return $query;
	}
}
