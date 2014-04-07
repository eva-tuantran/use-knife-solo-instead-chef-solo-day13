<?php

/**
 * 共通ログインコントローラ
 * 基本的にFuelのAuthを楽市楽座のデータベース仕様に拡張しており、Authに準拠しています。
 *
 * @see http://fuelphp.jp/docs/1.6/packages/auth/intro.html
 * @author Ricky <master@mistdev.com>
 */
class Auth_Login_BaseAuth extends Auth\Auth_Login_Driver
{

    protected $config = array(
        'drivers' => array(
            'group' => array('BaseAuth')
        )
    );

    protected $user;

    /**
     * perform_check。Auth::check()で動くオーバーライドです。
     *
     * @todo セキュリティ強化にsaltを入れるのか否か検討
     * @todo sqlではなくOrm\Model_Userを利用して取得しないか検討
     * @todo 仮登録ユーザの取り扱い(ログインできないようにする？)
     * @access protected
     * @return void
     */
    protected function perform_check()
    {
        $current_user = Session::get('current_user');

        //@TODO: エラーが出ていないか確認
        if (empty($current_user['user_id'])) {
            return false;
        }

        $placeholders = array(
            'user_id' => $current_user['user_id'],
        );

        $query = <<<QUERY
SELECT
    *
FROM
    users
WHERE
    user_id = :user_id AND
    deleted_at IS NULL
QUERY;

        //1段階強化するのであれば、salt =:salt AND を入れて、2つのキーから内容をチェックする
        $users = \DB::query($query)->parameters($placeholders)->as_object('Model_User')->execute()->as_array();

        if (!is_null($users) && count($users) === 1) {
            $this->user = reset($users);
            $this->user->last_login = Date::forge()->format('mysql');
            // $this->user->salt       = $this->create_salt();
            $this->user->save();

            return true;
        }

        return false;
    }


    /**
     * validate_user
     *
     * @todo sqlではなくOrm\Model_Userを利用して取得しないか検討
     * @param string $username_or_email
     * @param string $password
     * @access public
     * @return bool
     */
    public function validate_user($username_or_email = '', $password = '')
    {

        if (empty($username_or_email) || empty($password)) {
            return false;
        }

        $username_or_email = trim($username_or_email);
        $password          = trim($password);
        $password          = \Auth::hash_password($password);

        $placeholders = array(
            'username_or_email' => $username_or_email,
            'password'          => $password,
        );

        $query = <<<QUERY
SELECT
    *
FROM
    users
WHERE
    email = :username_or_email AND
    password = :password AND
    deleted_at IS NULL
QUERY;

        $users = \DB::query($query)->parameters($placeholders)->as_object('Model_User')->execute()->as_array();

        if (!is_null($users) && count($users) === 1) {
            $this->user = reset($users);
            $this->user->last_login = Date::forge()->format('mysql');
            // $this->user->salt       = $this->create_salt();
            $this->user->save();

            Session::set('current_user', array(
                'user_id'    => $this->user->user_id,
                // 'salt' => $this->user->salt,
            ));

            return true;
        }

        return false;
    }

    /**
     * login
     *
     * @param string $username_or_email
     * @param string $password
     * @access public
     * @return bool
     */
    public function login($username_or_email = '', $password = '')
    {
        return $this->validate_user($username_or_email, $password);
    }

    /**
     * logout
     *
     * @access public
     * @return bool
     */
    public function logout()
    {
        Session::delete('current_user');

        return true;
    }

    /**
     * get_user_id
     *
     * @access public
     * @return mixed
     */
    public function get_user_id()
    {
        if (!empty($this->user) && isset($this->user['user_id'])) {
            return (int) $this->user['user_id'];
        }

        return null;
    }

    /**
     * get_groups
     * Auth\Auth_Login_Driverにデフォルトで用意されているため、一応オーバーライドしていますが未使用。
     *
     * @access public
     * @return void
     */
    public function get_groups()
    {
        if (!empty($this->user) && isset($this->user['group'])) {
            return array(array('BaseAuth', $this->user['group']));
        }

        return null;
    }

    /**
     * has_access
     * Auth\Auth_Login_Driverにデフォルトで用意されているため、一応オーバーライドしていますが未使用。
     *
     * @param mixed $condition
     * @param mixed $driver
     * @param mixed $entity
     * @access public
     * @return void
     */
    public function has_access($condition, $driver = null, $entity = null)
    {
        if (is_null($entity) && !empty($this->user)) {
            $groups = $this->get_groups();
            $entity = reset($groups);
        }

        return parent::has_access($condition, $driver, $entity);
    }

    /**
     * get_email
     *
     * @access public
     * @return string
     */
    public function get_email()
    {
        if (!empty($this->user) && isset($this->user['email'])) {
            return $this->user['email'];
        }

        return null;
    }

    /**
     * get_screen_name
     *
     * @access public
     * @return string
     */
    public function get_screen_name()
    {
        if (!empty($this->user) && isset($this->user['nick_name'])) {
            return $this->user['nick_name'];
        }

        return null;
    }


    /**
     * get_user_instance
     *
     * @access public
     * @return string
     */
    public function get_user_instance()
    {
        if (empty($this->user)) {
            return false;
        };

        return $this->user;
    }


    /**
     * ユーザが予約しているフリマの予約数
     *
     * @access public
     * @return int
     */
    public function getReservedEntryCount()
    {
        return $this->user->getReservedEntryCount();
    }

    /**
     * ユーザが予約しているフリマの予約数
     *
     * @access public
     * @return int
     */
    public function getFinishedEntryCount()
    {
        return $this->user->getFinishedEntryCount();
    }

    /**
     * ユーザが予約しているフリマの予約数
     *
     * @access public
     * @return int
     */
    public function getFavoriteCount()
    {
        return $this->user->getFavoriteCount();
    }



    /**
     * create_salt
     * 今のところ未使用。saltでユーザログイン認証を強化するのであれば、利用する。
     *
     * @todo sessionのチェックでsaltを利用するのか検討
     * @access public
     * @return void
     */
    public function create_salt()
    {
        if (empty($this->user)) {
            throw new Exception();
        }

        return sha1(Config::get('baseauth.login_hash_salt').$this->user->last_login);
    }


    /**
     * Change a user's password
     *
     * @param   string
     * @param   string
     * @param   string  username or null for current user
     * @return  bool
     *
     * @todo: 実装中 
     */
    public function change_password($old_password, $new_password, $username = null)
    {
        try {
            return (bool) $this->update_user(array('old_password' => $old_password, 'password' => $new_password), $username);
        } catch (SimpleUserWrongPassword $e) {
            return false;
        }
    }

    /**
     * Update a user's properties
     * Note: Username cannot be updated, to update password the old password must be passed as old_password
     *
     * @param   Array  properties to be updated including profile fields
     * @param   string
     * @return  bool
     *
     * @todo: 実装中 
     */
    public function update_user($values, $username = null)
    {
        $username = $username ?: $this->user['username'];
        $current_values = \DB::select_array(\Config::get('baseauth.table_columns', array('*')))
            ->where('username', '=', $username)
            ->from(\Config::get('baseauth.table_name'))
            ->execute(\Config::get('baseauth.db_connection'));

        if (empty($current_values))
        {
            throw new \SimpleUserUpdateException('Username not found', 4);
        }

        $update = array();
        if (array_key_exists('username', $values))
        {
            throw new \SimpleUserUpdateException('Username cannot be changed.', 5);
        }
        if (array_key_exists('password', $values))
        {
            if (empty($values['old_password'])
                or $current_values->get('password') != $this->hash_password(trim($values['old_password'])))
            {
                throw new \SimpleUserWrongPassword('Old password is invalid');
            }

            $password = trim(strval($values['password']));
            if ($password === '')
            {
                throw new \SimpleUserUpdateException('Password can\'t be empty.', 6);
            }
            $update['password'] = $this->hash_password($password);
            unset($values['password']);
        }
        if (array_key_exists('old_password', $values))
        {
            unset($values['old_password']);
        }
        if (array_key_exists('email', $values))
        {
            $email = filter_var(trim($values['email']), FILTER_VALIDATE_EMAIL);
            if ( ! $email)
            {
                throw new \SimpleUserUpdateException('Email address is not valid', 7);
            }
            $matches = \DB::select()
                ->where('email', '=', $email)
                ->where('id', '!=', $current_values[0]['id'])
                ->from(\Config::get('baseauth.table_name'))
                ->execute(\Config::get('baseauth.db_connection'));
            if (count($matches))
            {
                throw new \SimpleUserUpdateException('Email address is already in use', 11);
            }
            $update['email'] = $email;
            unset($values['email']);
        }
        if (array_key_exists('group', $values))
        {
            if (is_numeric($values['group']))
            {
                $update['group'] = (int) $values['group'];
            }
            unset($values['group']);
        }
        if ( ! empty($values))
        {
            $profile_fields = @unserialize($current_values->get('profile_fields')) ?: array();
            foreach ($values as $key => $val)
            {
                if ($val === null)
                {
                    unset($profile_fields[$key]);
                }
                else
                {
                    $profile_fields[$key] = $val;
                }
            }
            $update['profile_fields'] = serialize($profile_fields);
        }

        $update['updated_at'] = \Date::forge()->get_timestamp();

        $affected_rows = \DB::update(\Config::get('baseauth.table_name'))
            ->set($update)
            ->where('username', '=', $username)
            ->execute(\Config::get('baseauth.db_connection'));

        // Refresh user
        if ($this->user['username'] == $username)
        {
            $this->user = \DB::select_array(\Config::get('baseauth.table_columns', array('*')))
                ->where('username', '=', $username)
                ->from(\Config::get('baseauth.table_name'))
                ->execute(\Config::get('baseauth.db_connection'))->current();
        }

        return $affected_rows > 0;
    }


    /**
     * Force login user
     *
     * @param   string
     * @return  bool
     */
    public function force_login($user_id)
    {
        try {
            $user = Model_User::find($user_id);
            $this->user = $user;
            $this->user->last_login = Date::forge()->format('mysql');
            $this->user->save();
            Session::set('current_user', array('user_id' => $this->user->user_id,));

            return true;
        } catch (Exception $e) {
            throw SystemException('E001');
        }

        return false;
    }


    /**
     * oil経由で実行するための関数 [未実装]
     * 法人IDの一括発行をコマンドライン生成できるようになるので、必要になったら実装する
     *
     * @todo 実装完了およびテスト
     * @param mixed $username
     * @param mixed $password
     * @param mixed $email
     * @access public
     * @return int
     */
    public function create_user($username, $password, $email)
    {
        $password = trim($password);
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        if (empty($username) or empty($password) or empty($email)) {
            throw new Exception('Username, password or email address is not given, or email address is invalid');
        }

        $data = array(
            'usename'  => '',
            'email'    => '',
            'password' => '',
        );

        $user = Model_User::forge($data);

        try {
            $user->save();
        } catch (Exception $e) {
            throw new Exception('create user registry error');
        }

        return 1;
    }

}
