<?php 

namespace Orm;

class Observer_User extends Observer
{

    //@TODO: 共通利用したいのでsaltの固定値として外出し
    private $password_salt = '3xfAqSZRzxZttfqRkpwA3dwtV688R5ubyNEVUH2m';

    /**
     * パスワードをDB登録前にsalt付きmd5でハッシュ化する
     *
     * @access public
     * @author shimma
     * @param Model_User
     */
    public function before_insert(Model $user)
    {
        $user->password = md5($user->password.$this->password_salt);
    }

}
