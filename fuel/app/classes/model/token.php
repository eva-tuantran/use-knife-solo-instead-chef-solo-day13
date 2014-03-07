<?php

class Model_Token extends Orm\Model_Soft
{
    protected static $_table_name = 'user_tokens';

    protected static $_primary_key = array('user_token_id');

    protected static $_properties = array(
        'user_token_id',
        'user_id',
        'hash',
        'expired_at',
        'created_at',
        'updated_at',
        'deleted_at',
    );

    protected static $_observers = array(
        'Orm\\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => true,
            'property'        => 'created_at',
        ),
        'Orm\\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => true,
            'property'        => 'updated_at',
        ),
        'Orm\\Observer_Token',
    );

    protected static $_soft_delete = array(
        'deleted_field'   => 'deleted_at',
        'mysql_timestamp' => true,
    );

    protected static $_conditions = array(
        'where' => array(
        ),
    );

    public static function createToken($user_id)
    {
        if(! Model_User::find($user_id)){
            //@TODO: Errorをthrowするか検討
            return false;
        }

        $hash = self::hash($user_id.time());

        $data = array(
            'user_id' => $user_id,
            'hash'    => $hash,
        );

        $new_token = self::forge($data);
        $new_token->save();

        return $new_token;
    }

    public static function hash($str)
    {
        $salt = '5HDJ38xZBJVCwRxthiyB4XTFhdNR0e6tvVXf3aNG';
        $hash = md5($salt.$str);

        return $hash;
    }


    public static function findByUserId($user_id)
    {
        $token = self::find('last', array(
            'where' => array(
                array('user_id' => $user_id),
                array('expired_at', '>', date('Y-m-d H:i:s')),
            ),
        ));

        return $token;
    }


    public static function findByHash($hash)
    {
        $token = self::find('last', array(
            'where' => array(
                array('hash' => $hash),
                array('expired_at', '>', date('Y-m-d H:i:s')),
            ),
        ));

        return $token;
    }





//    public static function _findByUserId($user_id)
//    {
//        $placeholders = array(
//            'user_id' => $user_id,
//        );
//
//        $query = <<<QUERY
//SELECT
//    *
//FROM
//    user_tokens
//WHERE
//    user_id = :user_id AND
//    expired_at > NOW()
//ORDER BY
//    expired_at DESC
//LIMIT
//    1
//QUERY;
//
//        $res = \DB::query($query)->parameters($placeholders)->execute()->as_array();
//
//        if (!empty($res)) {
//            return $res[0];
//        }
//
//        return array();
//    }
//
//
//    public static function _findByHash($hash)
//    {
//        $placeholders = array(
//            'hash' => $hash,
//        );
//
//        $query = <<<QUERY
//SELECT
//    *
//FROM
//    user_tokens
//WHERE
//    hash = :hash AND
//    expired_at > NOW() AND
//    deleted_at IS NULL
//ORDER BY
//    expired_at DESC
//LIMIT
//    1
//QUERY;
//
//        $res = \DB::query($query)->parameters($placeholders)->execute()->as_array();
//
//        if (!empty($res)) {
//            return $res[0];
//        }
//
//        return array();
//    }
//

}
