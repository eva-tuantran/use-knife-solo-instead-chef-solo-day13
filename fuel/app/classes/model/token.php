<?php

/**
 * ユーザ認証用トークンモデル
 *
 * @author shimma
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
     * @param int $user_id
     * @static
     * @access public
     * @return Model_Token $token
     * @author shimma
     */
    public static function generate($user_id)
    {
        if (! Model_User::find($user_id)) {
            throw new SystemException('該当ユーザが見つかりません');
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
            throw new SystemException('トークン作成に失敗しました');
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
     *
     * @todo 日本語で書かれているExceptionを分かるように記述を変更
     */
    public static function findByUserId($user_id)
    {
        $token = self::find('last', array(
            'where' => array(
                array('user_id' => $user_id),
            ),
        ));

        if (! $token) {
            throw new SystemException('該当ユーザのトークンが発行されておりません');
        }

        if ($token->expired_at < Date::forge()->format('mysql')) {
            throw new SystemException('トークンが有効期限切れです');
        }

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
     *
     * @todo 日本語で書かれているExceptionを分かるように記述を変更
     */
    public static function findByHash($hash)
    {
        $token = self::find('last', array(
            'where' => array(
                array('hash' => $hash),
            ),
        ));

        if (! $token) {
            throw new SystemException('トークンが存在しておりません');
        }

        if ($token->expired_at < Date::forge()->format('mysql')) {
            throw new SystemException('トークンが有効期限切れです');
        }

        return $token;
    }


    /**
     * 各種認証用のURLを取得します
     *
     * @access public
     * @return void
     * @todo getVelificationUrlと統合
     */
    public function getActivationUrl()
    {
        if (! $this->hash) {
            return false;
        }

        return Uri::base().'signup/activate?token='.$this->hash;
    }


    /**
     * 各種認証用のURLを取得します
     *
     * @access public
     * @return void
     */
    public function getVelificationUrl($type)
    {
        if (! $this->hash) {
            return false;
        }

        switch ($type) {
            case 'signup':
                $activation_url = Uri::base().'signup/activate?token='.$this->hash;
                break;
            case 'reset_password':
                $activation_url = Uri::base().'reminder/change?token='.$this->hash;
                break;
            default:
                $activation_url = Uri::base().'signup/activate?token='.$this->hash;
                break;
        }


        return $activation_url;
    }


}
