<?php

class Model_Base extends \Orm\Model_Soft
{
    protected static $_write_connection = 'master';
    protected static $_connection = 'slave';
}
