<?php

/**
 * 楽市楽座会員基本モデル
 *
 * @author shimma
 *
 */
class Model_User extends Orm\Model_Soft
{
    protected static $_table_name = 'users';

    protected static $_primary_key = array('user_id');

    protected static $_has_many = array(
        'mylists' => array(
            'key_from' => 'user_id',
        ),
    );

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
                'strip_tags',
                'max_length' => array(10),
            ),
            'form' => array(
                'type' => 'text'
            ),
        ),
        'gender' => array(
            'label' => '性別',
            'validation' => array(
                'trim',
                'strip_tags',
                'numeric_min'  => array(0),
                'numeric_max'  => array(5),
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
            'form' => array(
                'type' => 'text'
            ),
        ),
        'tel' => array(
            'label' => '電話番号',
            'validation' => array(
                'trim',
                'max_length' => array(15),
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
            'label' => 'メールアドレス',
            'validation' => array(
                'required',
                'trim',
                'valid_email',
                'max_length' => array(50),
            ),
            'form'       => array(
                'type'  => 'text',
                'class' => 'pretty_input',
                'style' => 'ime-mode:disabled',
            ),
        ),
        'mobile_email' => array(
            'label' => '携帯電話アドレス',
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
                'type'  => 'text',
            ),
        ),
        'mm_flag' => array(
            'label' => 'メールマガジン',
            'validation' => array(
                'trim',
                'numeric_min'  => array(0),
                'numeric_max'  => array(100),
                'valid_string' => array('numeric'),
            ),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    1 => '購読する',
                    2 => '未購読しない',
                ),
            ),
        ),
        'mm_device' => array(
            'label' => 'メルマガ端末',
            'validation' => array(
                'trim',
            ),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    1 => 'PC',
                    2 => '携帯電話',
                    3 => '両方',
                ),
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
                'type' => 'select',
                'options' => array(
                    1 => 'docomo',
                    2 => 'au',
                    3 => 'softbank',
                    4 => 'emobile',
                    5 => 'その他',
                ),
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
                // 'required', //現在passwordのrequiredをどうするか検討中
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
    );

    protected static $_conditions = array(
        'where' => array(
        ),
    );


    /**
     * 登録ステータス 0:仮登録,1:本登録.2:退会,3:強制退会
     *
     */
    const REGISTER_STATUS_INACTIVATED = 0;
    const REGISTER_STATUS_ACTIVATED   = 1;
    const REGISTER_STATUS_STOPPED     = 2;
    const REGISTER_STATUS_BANNED      = 3;


    /**
     * 新しいパスワードをセットします
     * パスワードの強制的な上書きなどに利用します。
     * ただし基本的にFuelのAuthで用意されているので、そちらを活用します。
     *
     * @param string $new_password 新パスワード
     * @access public
     * @return void
     * @author shimma
     */
    public function setPassword($new_password)
    {
        $this->password = \Auth::hash_password($new_password);;
    }

    /**
     * getBaseFieldset
     *
     * @todo カスタムフィールドセット(メールアドレスの重複セット)が正常に動作するか確認
     * @todo 現状未使用
     * @param \Fieldset $fieldset
     * @static
     * @access public
     * @return Fieldset fieldset
     * @author shimma
     */
    public static function getBaseFieldset(\Fieldset $fieldset)
    {
        $fieldset->validation()->add_callable('Model_User');
        $fieldset->add_model('Model_User');

        return $fieldset;
    }

    /**
     * ユーザ名がユニークか否かvalidationで判定します
     *
     * @todo 他所を参考にソースを引っ張ってきてまだ動作未確認および未使用
     * @param string $username
     * @param Model_User $user
     * @static
     * @access public
     * @return bool
     * @author shimma
     */
    public static function _validation_unique_username($username, Model_User $user)
    {
        if ( ! $user->is_new() and $user->username === $username) {
            return true;
        }

        $exists = DB::select(DB::expr('COUNT(*) as total_count'))->from($user->table())->where('username', '=', $username)->execute()->get('total_count');

        return (bool) !$exists;

    }

    /**
     * ユーザにテンプレートのメールを送信します
     * lang/ja/email配下のテンプレートを利用します。
     *
     * @param string $subject
     * @param string $body
     * @access public
     * @return bool
     * @author shimma
     *
     */
    public function sendmail($template_name, $params = array())
    {
        $email = new \Model_Email();
        $email->sendMailByParams($template_name, $params, $this->email);
    }


    /**
     * エントリーしたフリーマーケットの最新情報を取得します
     *
     * @access public
     * @return mixed
     * @author shimma
     */
    public function getEntries($page = 1, $row_count = 30)
    {
        $entries = \Model_Entry::getUserEntries($this->user_id, $page, $row_count);

        return $entries;
    }

    /**
     * これまで参加したフリマの数を取得します
     *
     * @access public
     * @return int
     * @author shimma
     */
    public function getFinishedEntryCount()
    {
        $count = \Model_Entry::getUserFinishedEntryCount($this->user_id);

        return $count;
    }

    /**
     * 現在予約中のフリマの数を取得します
     *
     * @access public
     * @return int
     * @author shimma
     */
    public function getReservedEntryCount()
    {
        $count = \Model_Entry::getUserReservedEntryCount($this->user_id);

        return $count;
    }


    /**
     * マイリスト(お気に入り)数を取得します
     *
     * @access public
     * @return int
     * @author shimma
     */
    public function getMylistCount()
    {
        $count = \Model_Mylist::getUserMylistCount($this->user_id);

        return $count;
    }

    /**
     * 対象のフリマIDのフリマ予約をキャンセルします
     *
     * @param int $fleamarket_id
     * @access public
     * @return void
     * @author shimma
     */
    public function cancelEntry($fleamarket_id)
    {
        return \Model_Entry::cancelUserEntry($this->user_id, $fleamarket_id);
    }


    /**
     * ユーザのお気に入り情報を取得します
     *
     * @access public
     * @return mixed
     * @author shimma
     */
    public function getMylists($page = 1, $row_count = 30)
    {
        $mylists = \Model_Mylist::getUserMylists($this->user_id, $page, $row_count);

        return $mylists;
    }



}
