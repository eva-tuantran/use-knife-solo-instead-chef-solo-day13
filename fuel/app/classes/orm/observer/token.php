<?php 

namespace Orm;

class Observer_Token extends Observer
{

    /**
     * トークンの有効期限付きのものをセットする
     * @TODO: 引数としてproperty_arrayで受け取ったフィールドに対して実行したい
     *
     * @access public
     * @author shimma
     * @param Model_User
     */
    public function before_insert(Model $token)
    {
        $token->expired_at = date('Y-m-d H:i:s', strtotime('+ 3 hour'));
    }

}
