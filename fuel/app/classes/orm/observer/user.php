<?php 

namespace Orm;

class Observer_User extends Observer
{

    //@TODO: 中でbefore_insertするとわかりにくくなるので一旦廃止
    //@TODO: auth::instanceで動作確認中
    //@TODO: 共通利用したいのでsaltの固定値として外出し
    // private $password_salt = '3xfAqSZRzxZttfqRkpwA3dwtV688R5ubyNEVUH2m';

    /**
     * パスワードをDB登録前にAuthクラスを利用してpasswordをhash化する
     *
     * @access public
     * @author shimma
     * @param Model_User
     */
    public function before_insert(Model $user)
    {
        // $user->password = md5($user->password.$this->password_salt);
        // $user->password = Auth::instance()->hash_password($user->password);
    }

}
