<?php

/**
 * 楽市楽座会員基本モデル
 *
 * @author shimma
 *
 */
class Model_User extends Model_Base
{

    /**
     * メールマガジン 0:不要,1:必要
     */
    const MM_FLAG_NG = 0;
    const MM_FLAG_OK = 1;

    /**
     * 登録ステータス 0:仮登録,1:本登録.2:退会,3:強制退会
     */
    const REGISTER_STATUS_INACTIVATED = 0;
    const REGISTER_STATUS_ACTIVATED   = 1;
    const REGISTER_STATUS_STOPPED     = 2;
    const REGISTER_STATUS_BANNED      = 3;

    protected static $_table_name = 'users';

    protected static $_primary_key = array('user_id');

    protected static $_has_many = array(
        'favorites' => array(
            'key_from' => 'user_id',
        ),
        'entries' => array(
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
                'required',
                'valid_kana',
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
                'required',
                'valid_kana',
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
                'required',
                'valid_zip',
                'max_length' => array(10),
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
            ),
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
                'required',
                'max_length' => array(20),
                'valid_tel',
            ),
        ),
        'mobile_tel' => array(
            'label' => '携帯電話番号',
            'validation' => array(
                'trim',
                'max_length' => array(10),
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
            'default' => self::REGISTER_STATUS_INACTIVATED,
            'validation' => array(
                'numeric_min' => array(0),
                'numeric_max' => array(5),
            ),
            'form' => array(
                'type' => false,
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

    /**
     * ユーザが出店予約したフリマ
     *
     * @var array
     */
    protected $has_entry = array();

    /**
     * ユーザがキャンセル中のフリマ
     *
     * @var array
     */
    protected $has_waiting = array();

    /**
     * 登録ステータスが本登録のユーザを取得する
     *
     * $_soft_deleteを削除する場合、whereに以下を追記
     *  'deleted_at' => NULL
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getActiveUsers()
    {
        $placeholders = array(
            ':register_status' => self::REGISTER_STATUS_ACTIVATED,
        );

        $query = <<<"QUERY"
SELECT
    user_id,
    last_name,
    first_name,
    email
FROM
    users
WHERE
    register_status = :register_status
    AND deleted_at IS NULL
QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }

    /**
     * 特定の都道府県のユーザを取得する
     *
     * $_soft_deleteを削除する場合、whereに以下を追記
     *  'deleted_at' => NULL
     *
     * @access public
     * @param mixed $prefecture_id 都道府県ID
     * @return array
     * @author ida
     */
    public static function getUsersByPrefectureId($prefecture_id)
    {
        $placeholders = array(
            ':mm_flag' => self::MM_FLAG_OK,
            ':register_status' => self::REGISTER_STATUS_ACTIVATED,
        );

        $where = '';
        if ($prefecture_id != '99') {
            $placeholders[':prefecture_id'] = $prefecture_id;
            $where = ' AND prefecture_id = :prefecture_id';

        }

        $query = <<<"QUERY"
SELECT
    user_id,
    last_name,
    first_name,
    email
FROM
    users
WHERE
    mm_flag = :mm_flag
    AND register_status = :register_status
    AND deleted_at IS NULL
    {$where}
QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }

    /**
     * 新しいパスワードをセットします
     * パスワードの強制的な上書きなどに利用します。
     *
     * @param string $new_password 新パスワード
     * @access public
     * @return void
     * @author shimma
     */
    public function setPassword($new_password)
    {
        try {
            $this->password = \Auth::hash_password($new_password);
            $this->save();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * パスワード変更関数
     *
     * @param mixed $email
     * @param mixed $password
     * @param mixed $properties
     * @static
     * @access public
     * @return void
     * @author shimma
     */
    public function changePassword($old_password, $new_password)
    {
        if ($this->password == \Auth::hash_password($old_password)) {
            return $this->setPassword($new_password);
        }

        return false;
    }

    /**
     * createNewUser
     *
     * @param mixed $email
     * @param mixed $password
     * @param mixed $properties
     * @static
     * @access public
     * @return void
     * @author shimma
     *
     * @todo 日本語で書かれているExceptionを分かるように記述を変更
     */
    public static function createNewUser($email, $password, $properties)
    {
        $password = trim($password);
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        try {
            $new_user = Model_User::forge($properties);
            $new_user->email = $email;
            $new_user->setPassword(trim($password));

            return $new_user;
        } catch (Exception $e) {
            throw new SystemException(\Model_Error::ER00304);
        }
    }

    /**
     * getBaseFieldset
     *
     * @param \Fieldset $fieldset
     * @static
     * @access public
     * @return Fieldset fieldset
     * @author shimma
     */
    public static function createFieldset()
    {
        $fieldset = Fieldset::forge();
        $fieldset->add_model(self::forge());

        return $fieldset;
    }

    /**
     * emailアドレスがユニークかどうか調査します
     *
     * @access public
     * @param  int
     * @return bool
     * @author shimma
     */
    public static function _validation_unique_email($email)
    {
        $count = self::query()->where(array(
            'email' => $email,
        ))->count();

        return empty($count);
    }

    /**
     * ユーザにテンプレートのメールを送信します
     * lang/ja/email配下のテンプレートを利用します。
     *
     * @access public
     * @param string $subject
     * @param string $body
     * @return bool
     * @author shimma
     *
     * @todo 日本語のエラー表示を正しいものに変換する
     */
    public function sendmail($template_name, $params = array())
    {
        try {
            $email = new \Model_Email();
            $email->sendMailByParams($template_name, $params, $this->email);
        } catch (Exception $e) {
            throw new SystemException(\Model_Error::ER00303);
        }
    }

    /**
     * これまで参加したフリマの数を取得します
     *
     * @access public
     * @param
     * @return int
     * @author shimma
     */
    public function getFinishedEntryCount()
    {
        return \Model_Entry::getUserFinishedEntryCount($this->user_id);
    }

    /**
     * エントリーしたフリーマーケットの最新情報を取得します
     *
     * @access public
     * @param int $page ページ
     * @param int $row_count 1ページの件数
     * @return mixed
     * @author shimma
     */
    public function getReservedEntries($page = 1, $row_count = 30)
    {
        return \Model_Entry::getUserReservedEntries($this->user_id, $page, $row_count);
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
        return \Model_Entry::getUserReservedEntryCount($this->user_id);
    }

    /**
     * 現在キャンセル待ちのフリマの数を取得します
     *
     * @access public
     * @return int
     * @author shimma
     */
    public function getWaitingEntryCount()
    {
        return \Model_Entry::getUserWaitingEntryCount($this->user_id);
    }

    /**
     * ユーザのお気に入り情報を取得します
     *
     * @access public
     * @param int $page ページ
     * @param int $row_count 1ページの件数
     * @return mixed $favorites
     * @author shimma
     */
    public function getFavorites($page = 1, $row_count = 30)
    {
        return \Model_Favorite::getUserFavorites($this->user_id, $page, $row_count);
    }

    /**
     * マイリスト(お気に入り)数を取得します
     *
     * @access public
     * @param
     * @return int
     * @author shimma
     */
    public function getFavoriteCount()
    {
        return \Model_Favorite::getUserFavoriteCount($this->user_id);
    }

    /**
     * エントリーした全てのフリーマーケットの情報を取得します
     *
     * @access public
     * @param int $page ページ
     * @param int $row_count 1ページの件数
     * @return mixed
     * @author shimma
     */
    public function getEntries($page = 1, $row_count = 30)
    {
        return \Model_Entry::getUserEntries($this->user_id, $page, $row_count);
    }

    /**
     * キャンセル待ちした全てのフリーマーケットの情報を取得します
     *
     * @access public
     * @param int $page ページ
     * @param int $row_count 1ページの件数
     * @return mixed
     * @author kobayasi
     */
    public function getWaitingEntries($page = 1, $row_count = 30)
    {
        return \Model_Entry::getUserWaitingEntries($this->user_id, $page, $row_count);
    }

    /**
     * フリマ参加総数を取得します
     *
     * @access public
     * @param
     * @return int
     * @author shimma
     */
    public function getEntryCount()
    {
        return \Model_Entry::getUserEntryCount($this->user_id);
    }

    /**
     * ユーザの投稿したフリマの詳細情報を取得します
     *
     * @access public
     * @param int $page ページ
     * @param int $row_count 1ページの件数
     * @return mixed
     * @author shimma
     */
    public function getMyFleamarkets($page = 1, $row_count = 30)
    {
        return \Model_Fleamarket::getUserFleamarkets($this->user_id, $page, $row_count);
    }

    /**
     * 自分で投稿したフリマの総数の取得
     *
     * @access public
     * @param
     * @return int
     * @author shimma
     * @author ida
     */
    public function getMyFleamarketCount()
    {
        return \Model_Fleamarket::getUserMyFleamarketCount($this->user_id);
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
     * 現在のユーザをアクティベートさせ正規に利用できるユーザにします
     *
     * @access public
     * @return void
     * @author shimma
     *
     * @todo エラーの日本語表記を正しいエラーコードに変換する
     */
    public function activate()
    {
        try {
            $this->register_status = self::REGISTER_STATUS_ACTIVATED;
            $this->save();
        } catch (Exception $e) {
            throw new SystemException(\Model_Error::ER00305);
        }
    }

    private static function getFindByKeywordQuery($input)
    {
        $query = static::query();

        if(! empty($input['name'])){
            $query->and_where_open();
            $query->where('first_name', 'LIKE', static::makeLikeValue($input['name']));
            $query->or_where('last_name', 'LIKE', static::makeLikeValue($input['name']));
            $query->and_where_close();
        }

        foreach (array('address', 'email', 'tel', 'user_old_id') as $field) {
            if(! empty($input[$field])){
                $query->where($field, 'LIKE', static::makeLikeValue($input[$field]));
            }
        }

        return $query;
    }

    private static function makeLikeValue($word)
    {
        $like = preg_replace('/([_%\\\\])/','\\\\${1}',$word);
        $like = "%${like}%";
        return $like;
    }

    public static function findByKeyword($input, $limit, $offset)
    {
        $query = static::getFindByKeywordQuery($input)
            ->limit($limit)
            ->offset($offset);

        return $query->get();
    }

    public static function findByKeywordCount($input)
    {
        return static::getFindByKeywordQuery($input)->count();
    }

    /**
     * 予約済みか
     *
     * @access public
     * @param mixed $fleamarket_id
     * @return bool
     * @author kobayasi
     */
    public function hasEntry($fleamarket_id)
    {
        if (! $this->has_entry) {
            $has_entry = array();
            foreach ($this->entries as $entry) {
                if ($entry->entry_status == Model_Entry::ENTRY_STATUS_RESERVED) {
                    $has_entry[] = $entry->fleamarket_id;
                }
            }
            $this->has_entry = $has_entry;
        }

        return in_array($fleamarket_id, $this->has_entry);
    }

    public function hasWaiting($fleamarket_id)
    {
        if (! $this->has_waiting) {
            $has_waiting = array();
            foreach ($this->entries as $entry) {
                if ($entry->entry_status == Model_Entry::ENTRY_STATUS_WAITING) {
                    $has_waiting[] = $entry->fleamarket_id;
                }
            }
            $this->has_waiting = $has_waiting;
        }

        return in_array($fleamarket_id, $this->has_waiting);
    }
}
