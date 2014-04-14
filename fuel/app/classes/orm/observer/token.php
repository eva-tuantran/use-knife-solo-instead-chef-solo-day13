<?php 

namespace Orm;

/**
 * 自動的に有効期限を設定するオブザーバ
 *
 * @author shimma
 */
class Observer_Token extends Observer
{

    /**
     * トークンの有効期限付きのものをセットする
     *
     * @todo 引数としてproperty_arrayで受け取ったフィールドに対して実行したい
     * @access public
     * @param Model_User
     * @author shimma
     */
    public function before_insert(Model $token)
    {
        $token->expired_at = \Date::forge(strtotime($token->expiration_date))->format('mysql');
    }

}
