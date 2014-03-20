<?php

/**
 * ユーザ認証用トークンモデル
 *
 */
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

    /**
     * 特定のユーザIDに対する認証用トークンを発行します。
     * 成功時にはModel_Tokenオブジェクトをリターンします。
     *
     * @todo エラーのハンドリングについて番号含めて調整
     * @param int $user_id
     * @static
     * @access public
     * @return Model_Token $token
     * @author shimma
     */
    public static function generate($user_id)
    {
        if (! Model_User::find($user_id)) {
            throw new Exception('E00001');
        }

        $unique_hash = self::getUniqueHash($user_id);

        $data = array(
            'user_id' => $user_id,
            'hash'    => $unique_hash,
        );

        try {
            $new_token = self::forge($data);
            $new_token->save();
        } catch (Exception $e) {
            throw new Exception('E00002');
        }

        return $new_token;
    }

    /**
     * 引数として与えられた文字列を基準にユニークなmd5ハッシュ値を作成します
     *
     * @param string $str
     * @static
     * @access public
     * @return string
     * @author shimma
     */
    public static function getUniqueHash($str = '')
    {
        $salt = '5HDJ38xZBJVCwRxthiyB4XTFhdNR0e6tvVXf3aNG';
        $random_hash = md5($salt.$str.time());

        return $random_hash;
    }

    /**
     * ユーザIDから指定するトークンを取得します
     *
     * @param int $user_id
     * @static
     * @access public
     * @return Model_Token $token
     * @author shimma
     */
    public static function findByUserId($user_id)
    {
        $token = self::find('last', array(
            'where' => array(
                array('user_id' => $user_id),
                array('expired_at', '>', Date::forge()->format('mysql')),
            ),
        ));

        return $token;
    }

    /**
     * トークンのハッシュ値から最新のトークンモデルを取得します
     *
     * @param int $user_id
     * @static
     * @access public
     * @return Model_Token $token
     * @author shimma
     */
    public static function findByHash($hash)
    {
        $token = self::find('last', array(
            'where' => array(
                array('hash' => $hash),
                array('expired_at', '>', Date::forge()->format('mysql')),
            ),
        ));

        return $token;
    }
}
