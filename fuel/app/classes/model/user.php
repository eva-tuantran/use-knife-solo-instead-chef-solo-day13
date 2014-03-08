<?php

class Model_User extends Orm\Model_Soft
{
    protected static $_table_name = 'users';

    protected static $_primary_key = array('user_id');

    protected static $_properties = array(
        'user_id' => array(
            'label' => 'ユーザID',
            'form' => array(
                'type' => false
            ),
        ),
        'last_name' => array(
            'label' => '姓',
            'validation' => array(
                'trim',
                'required',
                'max_length' => array(50),
            ),
            'form' => array(
                'type' => 'text'
            ),
        ),
        'first_name' => array(
            'label' => '名',
            'validation' => array(
                'trim',
                'required',
                'max_length' => array(50),
            ),
            'form' => array(
                'type' => 'text'
            ),
        ),
        'last_name_kana' => array(
            'label' => 'セイ',
            'validation' => array(
                'trim',
                'max_length' => array(10),
            ),
            'form' => array(
                'type' => 'text'
            ),
        ),
        'first_name_kana' => array(
            'label' => 'メイ',
            'validation' => array(
                'trim',
                'max_length' => array(10),
            ),
            'form' => array(
                'type' => 'text'
            ),
        ),
        'nick_name' => array(
            'label' => 'ニックネーム',
            'validation' => array(
                'trim',
                'required',
                'max_length' => array(50),
            ),
            'form' => array(
                'type' => 'text'
            ),
        ),
        'birthday' => array(
            'label' => '誕生日',
            'validation' => array(
                'trim',
                'max_length' => array(10),
            ),
            'form' => array(
                'type' => false
            ),
        ),
        'gender' => array(
            'label' => '性別',
            'validation' => array(
                'trim',
                'strip_tags',
                'numeric_min' => array(0),
                'numeric_max' => array(5),
                'valid_string' => array('numeric'),
            ),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    '1' => '男性',
                    '2' => '女性',
                ),
            ),
        ),
        'zip' => array(
            'label' => '郵便番号',
            'validation' => array(
                'trim',
                'max_length'   => array(10),
                'valid_string' => array('alpha','numeric'),
            ),
            'form'       => array(
                'type'  => 'text',
                'class' => 'pretty_input',
                'style' => 'ime-mode:disabled',
            ),
        ),
        'prefecture_id' => array(
            'label' => '都道府県',
            'validation' => array(
                'trim',
                'numeric_min'  => array(0),
                'numeric_max'  => array(48),
                'valid_string' => array('numeric'),
            ),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    '1'  => '北海道',
                    '2'  => '青森県', '3'  => '岩手県', '4'  => '宮城県',
                    '5'  => '秋田県', '6'  => '山形県', '7'  => '福島県',
                    '8'  => '茨城県', '9'  => '栃木県', '10' => '群馬県',
                    '11' => '埼玉県', '12' => '千葉県', '13' => '東京都', '14' => '神奈川県',
                    '15' => '新潟県', '16' => '富山県', '17' => '石川県',
                    '18' => '福井県', '19' => '山梨県', '20' => '長野県',
                    '21' => '岐阜県', '22' => '静岡県', '23' => '愛知県', '24' => '三重県',
                    '25' => '滋賀県', '26' => '京都府', '27' => '大阪府',
                    '28' => '兵庫県', '29' => '奈良県', '30' => '和歌山県',
                    '31' => '鳥取県', '32' => '島根県', '33' => '岡山県',
                    '34' => '広島県', '35' => '山口県',
                    '36' => '徳島県', '37' => '香川県', '38' => '愛媛県', '39' => '高知県',
                    '40' => '福岡県', '41' => '佐賀県', '42' => '長崎県',
                    '43' => '熊本県', '44' => '大分県', '45' => '宮崎県', '46' => '鹿児島県',
                    '47' => '沖縄県',
                )
            )
        ),
        'address' => array(
            'label'      => '住所',
            'validation' => array(
                'trim',
                'max_length' => array(100),
            ),
            'form'       => array(
                'type'       => 'text'
            ),
        ),
        'tel' => array(
            'label' => '電話番号',
            'validation' => array(
                'trim',
                'max_length'    => array(10),
            ),
        ),
        'mobile_tel' => array(
            'label' => '携帯電話番号',
            'validation' => array(
                'trim',
                'max_length'    => array(10),
            ),
        ),
        'email' => array(
            'label'      => 'メールアドレス',
            'validation' => array(
                'required',
                'trim',
                'valid_email',
                'max_length'    => array(50),
            ),
            'form'       => array(
                'type'  => 'text',
                'class' => 'pretty_input',
                'style' => 'ime-mode:disabled',
            ),
        ),
        'mobile_email' => array(
            'label'      => '携帯電話アドレス',
            'validation' => array(
                'trim',
                'valid_email',
                'max_length'    => array(30),
            ),
            'form'       => array(
                'type'  => 'text',
                'class' => 'pretty_input',
                'style' => 'ime-mode:disabled',
            ),
        ),
        'device' => array(
            'label' => '携帯端末',
            'form' => array(
                'type' => false
            ),
        ),
        'mm_flag' => array(
            'label' => 'メールマガジン',
            'validation' => array(
                'trim',
                'numeric_min'  => array(0),
                'numeric_max'  => array(100),
                'valid_string' => array('alpha','numeric'),
            ),
            'form' => array(
                'type' => false,
                // 'type' => 'select',
                'options' => array(
                    1 => '未購読しない',
                    2 => '購読する',
                ),
            ),
        ),
        'mm_device' => array(
            'label' => 'メルマガ端末',
            'validation' => array(
                'trim',
            ),
            'form' => array(
                'type' => false,
            ),
        ),
        'mm_error_flag' => array(
            'label' => 'メルマガエラーフラグ',
            'form' => array(
                'type' => false
            ),
        ),
        'mobile_carrier' => array(
            'label' => '携帯キャリア',
            'form' => array(
                'type' => false
            ),
        ),
        'mobile_uid' => array(
            'label' => '携帯UID',
            'form' => array(
                'type' => false
            ),
        ),
        'password' => array(
            'label' => 'パスワード',
            'validation' => array(
                'required',
                'min_length' => array(6),
                'max_length' => array(50),
            ),
            'form' => array(
                'type' => 'password',
                'style' => 'ime-mode:disabled',
            ),
        ),
        'admin_memo' => array(
            'label' => '管理者メモ',
            'form' => array(
                'type' => false,
            ),
        ),
        'organization_flag' => array(
            'label' => '組織フラグ',
            'form' => array(
                'type' => false,
            ),
        ),
        'register_status' => array(
            'label' => '会員登録状況',
            'validation' => array(
                'numeric_min' => array(0),
                'numeric_max' => array(5),
            ),
            'form' => array(
                'type' => false,
                // 'type' => 'select',
                'options' => array(
                    \REGISTER_STATUS_INACTIVATED => '仮登録',
                    \REGISTER_STATUS_ACTIVATED   => '正規ユーザ',
                    \REGISTER_STATUS_STOPPED     => '停止',
                    \REGISTER_STATUS_BANNED      => '強制停止',
                 ),
            ),
        ),
        'last_login' => array(
            'form' => array(
                'type' => false
            ),
        ),
        'created_user' => array(
            'form' => array(
                'type' => false
            ),
        ),
        'updated_user' => array(
            'form' => array(
                'type' => false
            ),
        ),
        'created_at' => array(
            'form' => array(
                'type' => false
            ),
        ),
        'updated_at' => array(
            'form' => array(
                'type' => false
            ),
        ),
        'deleted_at' => array(
            'form' => array(
                'type'  => false,
            ),
        ),
    );

    //@TODO:動作確認
    protected static $_soft_delete = array(
        'deleted_field'   => 'deleted_at',
        'mysql_timestamp' => true,
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
        'Orm\\Observer_Validation' => array(
            'events'          => array('before_save'),
        ),
        'Orm\\Observer_User',
    );


    protected static $_conditions = array(
        'where' => array(
        ),
    );


    protected static $_password_salt = '3xfAqSZRzxZttfqRkpwA3dwtV688R5ubyNEVUH2m';

    public function setPassword($password)
    {
        $this->password = Auth::instance()->hash_password($password);;
    }

    // public static function password_hash($password)
    // {
        // return md5(self::_password_salt.$password);
    // }


    //@TODO: カスタムフィールドセットを用意したいために残っている(メールアドレス重複チェックなど)
    public static function getBaseFieldset(\Fieldset $fieldset)
    {
        $fieldset->validation()->add_callable('Model_User');
        $fieldset->add_model('Model_User');

        return $fieldset;
    }


    //@TODO: 未使用(ソースを参考にコピーしてきたのみ)
    public static function _validation_unique_username($username, Model_User $user)
    {
        if ( ! $user->is_new() and $user->username === $username){
            return true;
        }

        $exists = DB::select(DB::expr('COUNT(*) as total_count'))->from($user->table())->where('username', '=', $username)->execute()->get('total_count');

        return (bool) !$exists;

    }

    public function sendmail($subject, $body)
    {
        $email = \Email::forge();
        $email->from(\DEFAULT_EMAIL, \DEFAULT_EMAIL_NAME);
        $email->to($this->email);
        $email->subject($subject);
        $email->body(mb_convert_encoding($body, 'jis'));
        try{
            $email->send();
        }catch(\EmailValidationFailedException $e) {
            return false;
        }catch(\EmailSendingFailedException $e) {
            return false;
        }

        return true;
    }

    // public static function create($array = array())
    // {

        // $return = \DB::insert('user_id', 'email', 'familyname', 'firstname', 'privilege')->from('users')
        // ->where_open()
        // ->where('email', $email)
        // ->and_where('password', $this->getSaltedPassword($password))
        // ->and_where('record_status', \VALID_RECORD)
        // ->where_close()
        // ->limit(1)->execute();

        // if (! empty($return[0])) {
            // return $return[0];
        // }

        // return false;

        // return $this;
    // }


    // public static function auth($name, $password)
    // {
        // $return = \DB::select('user_id', 'email')->from('users')
        // ->where_open()
        // ->where('email', $email)
        // ->and_where('password', self::getSaltedPassword($password))
        // ->and_where('record_status', \VALID_RECORD)
        // ->where_close()
        // ->limit(1)->execute();

        // if (! empty($return[0])) {
            // return $return[0];
        // }

        // return false;
    // }

}
