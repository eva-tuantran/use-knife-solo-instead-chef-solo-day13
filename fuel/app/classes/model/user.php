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
     * 性別 1:男性,2:女性
     */
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * 登録元 0:不明,1:WEB,3:電話
     */
    const DEVICE_OTHER = 0;
    const DEVICE_WEB = 1;
    const DEVICE_TEL = 2;

    /**
     * メールマガジン 0:不要,1:必要
     */
    const MM_FLAG_NG = 0;
    const MM_FLAG_OK = 1;

    /**
     * 企業・団体 0:個人,1:企業・団体
     */
    const ORGANIZATION_FLAG_OFF = 0;
    const ORGANIZATION_FLAG_ON = 1;

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
        ),
        'first_name' => array(
            'label' => '名',
            'validation' => array(
                'trim',
                'required',
                'max_length' => array(50),
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
        ),
        'first_name_kana' => array(
            'label' => 'メイ',
            'validation' => array(
                'trim',
                'max_length' => array(10),
                'required',
                'valid_kana',
            ),
        ),
        'nick_name' => array(
            'label' => 'ニックネーム',
            'validation' => array(
                'trim',
                'required',
                'max_length' => array(50),
            ),
        ),
        'birthday' => array(
            'label' => '誕生日',
            'validation' => array(
                'trim',
                'strip_tags',
                'max_length' => array(10),
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
                'max_length' => array(20),
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
        ),
        'mobile_email' => array(
            'label' => '携帯電話アドレス',
            'validation' => array(
                'trim',
                'valid_email',
                'max_length'    => array(30),
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
        ),
        'mm_device' => array(
            'label' => 'メルマガ端末',
            'validation' => array(
                'trim',
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
                // 'required', //現在passwordのrequiredをどうするか検討中
                'min_length' => array(6),
                'max_length' => array(50),
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
                'numeric_max' => array(3),
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
     * ユーザがキャンセル待ちしたフリマ
     *
     * @var array
     */
    protected $has_waiting = array();

    /**
     * 性別一覧
     */
    private static $gender_list = array(
        self::GENDER_MALE => '男性',
        self::GENDER_FEMALE => '女性',
    );

    /**
     * 登録元一覧
     */
    private static $devices = array(
        self::DEVICE_OTHER => '不明',
        self::DEVICE_WEB => 'WEB',
        self::DEVICE_TEL => '電話',
    );

    /**
     * 登録ステータス一覧
     */
    private static $register_statuses = array(
        self::REGISTER_STATUS_INACTIVATED => '仮登録',
        self::REGISTER_STATUS_ACTIVATED   => '本登録',
//        self::REGISTER_STATUS_STOPPED     => '退会',
//        self::REGISTER_STATUS_BANNED      => '強制退会',
    );

    /**
     * 性別一覧を取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getGenderList()
    {
        return self::$gender_list;
    }

    /**
     * 登録元一覧を取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getDevices()
    {
        return self::$devices;
    }

    /**
     * 登録ステータス一覧を取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getRegisterStatuses()
    {
        return self::$register_statuses;
    }

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
     * @param mixed $prefecture_id 都道府県IDリスト
     * @param mixed $organization_flag 都道府県ID
     * @return array
     * @author ida
     */
    public static function getMailMagazineUserBy(
        $prefecture_ids, $organization_flag
    ) {
        $placeholders = array(
            ':mm_flag' => self::MM_FLAG_OK,
            ':register_status' => self::REGISTER_STATUS_ACTIVATED,
        );

        $where = '';
        if (! empty($prefecture_ids)) {
            $placeholder_list = array();
            foreach ($prefecture_ids as $prefecture_id) {
                $placeholder = ':prefecture_id' . $prefecture_id;
                $placeholders[$placeholder] = $prefecture_id;
                $placeholder_list[] = $placeholder;
            }
            $placeholder_string = implode(',', $placeholder_list);
            $where = ' AND prefecture_id IN (' . $placeholder_string . ')';

        }
        if (isset($organization_flag) && $organization_flag !== '') {
            $placeholder = ':organization_flag';
            $placeholders[$placeholder] = $organization_flag;
            $where = ' AND organization_flag = ' . $placeholder;
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
        } catch (\Exception $e) {
            throw new \SystemException(\Model_Error::ER00303);
        }
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
     * これまで参加したフリマの数を取得します
     *
     * @access public
     * @param
     * @return int
     * @author ida
     */
    public function getFinishedEntries($page = 1, $row_count = 30)
    {
        return \Model_Entry::getUserFinishedEntries($this->user_id, $page, $row_count);
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
     * @access public
     * @param int $fleamarket_id
     * @return void
     * @author shimma
     */
    public function cancelEntry($entry_id, $updated_user = null)
    {
        return \Model_Entry::cancel($entry_id, $updated_user);
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

    /**
     * 指定された条件でユーザ一覧を取得する
     *
     * 予約履歴一覧
     *
     * @param array $condition_list 検索条件
     * @param mixed $page ページ
     * @param mixed $row_count ページあたりの行数
     * @return array
     * @author ida
     */
    public static function findAdminBySearch(
        $condition_list, $page = 0, $row_count = 0
    ) {
        $search_where = self::buildAdminSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' AND ';
            $where .= implode(' AND ', $conditions);
        }

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $sql = <<<"SQL"
SELECT
    u.user_id,
    u.user_old_id,
    u.last_name,
    u.first_name,
    u.last_name_kana,
    u.first_name_kana,
    u.gender,
    u.prefecture_id,
    u.address,
    u.email,
    u.tel,
    u.device,
    u.organization_flag,
    u.register_status,
    u.created_at,
    u.updated_at
FROM
    users AS u
WHERE
    u.deleted_at IS NULL
{$where}
ORDER BY
    u.created_at DESC
{$limit}
SQL;

$db = \Database_Connection::instance();
        $query = \DB::query($sql)->parameters($placeholders);
        $result = $query->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }

    /**
     * 指定された条件でユーザ情報の件数を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @return int
     * @author ida
     */
    public static function getCountByAdminSearch($condition_list)
    {
        $search_where = self::buildAdminSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' AND ';
            $where .= implode(' AND ', $conditions);
        }

        $sql = <<<"SQL"
SELECT
    COUNT(u.user_id) AS cnt
FROM
    users AS u
WHERE
    u.deleted_at IS NULL
{$where}
SQL;

        $query = \DB::query($sql)->parameters($placeholders);
        $result = $query->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows[0]['cnt'];
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param array $condition_list 検索条件
     * @return array 検索条件
     * @author ida
     */
    public static function createAdminSearchCondition(
        $conditions = array()
    ) {
        $condition_list = array();

        if (! $conditions) {
            return $condition_list;
        }

        foreach ($conditions as $field => $condition) {
            if ($condition == '') {
                continue;
            }

            $operator = '=';
            switch ($field) {
                case 'user_id':
                    $condition_list['u.user_id'] = array(
                        ' LIKE ', $condition . '%'
                    );
                    break;
                case 'user_old_id':
                    $condition_list['u.user_old_id'] = array(
                        ' LIKE ', $condition . '%'
                    );
                    break;
                case 'user_name':
                    $field = \DB::expr('CONCAT(u.last_name, u.first_name)');
                    $condition = str_replace(' ', '', mb_convert_kana($condition, 's'));

                    $condition_list[$field->value()] = array(
                        ' LIKE ', '%' . $condition . '%'
                    );
                    break;
                case 'prefecture_id':
                    $condition_list['u.prefecture_id'] = array(
                        $operator, $condition
                    );
                    break;
                case 'email':
                    $condition_list['u.email'] = array(
                        ' LIKE ', '%' . $condition . '%'
                    );
                    break;
                case 'tel':
                    $field = \DB::expr("REPLACE(u.tel, '-', '')");
                    $condition = str_replace('-', '', $condition);

                    $condition_list[$field->value()] = array(
                        ' LIKE ', '%' . $condition . '%'
                    );
                    break;
                default:
                    break;
            }
        }

        return $condition_list;
    }

    /**
     * 指定された検索条件よりWHERE句とプレースホルダ―を生成する
     *
     * @access private
     * @param array $condition_list
     * @return array
     * @author ida
     */
    private static function buildAdminSearchWhere($condition_list)
    {
        $conditions = array();
        $placeholders = array();

        if (empty($condition_list)) {
            return array($conditions, $placeholders);
        }

        foreach ($condition_list as $field => $condition) {

            $operator = $condition[0];
            if (count($condition) == 1) {
                $conditions[$field] = $field . $condition[0];
            } elseif ($operator === 'IN') {
                $placeholder = ':' . $field;
                $values = $condition[1];
                $placeholder_list = array();
                foreach ($values as $key => $value) {
                    $placeholder_in = $placeholder . $key;
                    $placeholder_list[] = $placeholder_in;
                    $placeholders[$placeholder_in] = $value;
                }
                $value = implode(',', $values);
                $placeholder_string = implode(',', $placeholder_list);
                $conditions[$field] = $field . ' '
                              . $operator . ' '
                              . '(' . $placeholder_string . ')';
            } else {
                $placeholder = ':' . $field;
                $value = $condition[1];
                $conditions[$field] = $field . $operator . $placeholder;
                $placeholders[$placeholder] = $value;
            }
        }

        return array($conditions, $placeholders);
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

    /**
     * キャンセル待ちか
     *
     * @access public
     * @param mixed $fleamarket_id
     * @return bool
     * @author kobayasi
     */
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

    /**
     * 予約判定
     *
     * @access public
     * @param mixed $fleamarket_id
     * @return bool
     * @author kobayasi
     */
    public function canReserve($fleamarket)
    {
        return
            (! $this->hasEntry($fleamarket->fleamarket_id)) &&
            (! $this->hasWaiting($fleamarket->fleamarket_id));
    }
}
