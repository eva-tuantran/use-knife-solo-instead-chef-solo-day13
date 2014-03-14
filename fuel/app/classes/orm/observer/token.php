<?php 

namespace Orm;

/**
 * 自動的に有効期限を設定するオブザーバ
 *
 */
class Observer_Token extends Observer
{

    /**
     * トークンの有効期限付きのものをセットする
     *
     * @todo 引数としてproperty_arrayで受け取ったフィールドに対して実行したい
     * @todo トークン有効期限の外出し
     * @access public
     * @param Model_User
     * @author shimma
     */
    public function before_insert(Model $token)
    {
        $token->expired_at = \Date::forge(strtotime('+ 3 hour'))->format('mysql');
    }

}
