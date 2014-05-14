<?php

/**
 * Locations Model
 *
 * 開催地情報テーブル
 *
 * @author ida
 */
class Model_Location extends Model_Base
{
    /**
     * 登録タイプ 1:運営者,2:ユーザ投稿
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    protected static $_table_name = 'locations';

    protected static $_primary_key  = array('location_id');

    protected static $_properties = array(
        'location_id' => array(
            'form'  => array('type' => false)
        ),
        'branch_id' => array(
            'form'  => array('type' => false)
        ),
        'name' => array(
            'label' => '会場名',
            'validation' => array(
                'required', 'max_length' => array(50)
            )
        ),
        'zip' => array(
            'label' => '郵便番号',
            'validation' => array(
                'required', 'valid_zip', 'max_length' => array(8)
            ),
        ),
        'prefecture_id' => array(
            'label' => '都道府県',
            'validation' => array('required')
        ),
        'address' => array(
            'label' => '住所',
            'validation' => array(
                'required',
                'max_length' => array(100)
            )
        ),
        'googlemap_address' => array(
            'validation' => array(
                'max_length' => array(100)
            )
        ),
        'register_type' => array(
            'form'  => array('type' => false)
        ),
        'created_user' => array(
            'form'  => array('type' => false)
        ),
        'updated_user' => array(
            'form'  => array('type' => false)
        ),
        'created_at' => array(
            'form'  => array('type' => false)
        ),
        'updated_at' => array(
            'form'  => array('type' => false)
        ),
        'deleted_at' => array(
            'form'  => array('type' => false)
        ),
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
    );

    /**
     * 登録タイプ一覧
     */
    private static $register_types = array(
        self::REGISTER_TYPE_ADMIN => '運営事務局',
        self::REGISTER_TYPE_USER => 'ユーザ投稿',
    );

    /**
     * 登録タイプリストを取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getRegisterTypes()
    {
        return self::$register_types;
    }

    /**
     * 指定された条件で会場一覧を取得する
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
    location_id,
    name,
    zip,
    prefecture_id,
    address,
    register_type
FROM
    locations
WHERE
    deleted_at IS NULL
{$where}
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
     * 指定された条件で会場情報の件数を取得する
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
    COUNT(location_id) AS cnt
FROM
    locations
WHERE
    deleted_at IS NULL
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
                case 'name':
                    $condition_list['name'] = array(
                        ' LIKE ', '%' . $condition . '%'
                    );
                    break;
                case 'prefecture_id':
                    $condition_list['prefecture_id'] = array(
                        $operator, $condition
                    );
                    break;
                case 'address':
                    $condition_list['address'] = array(
                        ' LIKE ', '%' . $condition . '%'
                    );
                    break;
                case 'register_type':
                    $condition_list['register_type'] = array(
                        $operator, $condition
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
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function createFieldset()
    {
        $fieldset = \Fieldset::forge('location');
        $fieldset->add_model('Model_Location');
        $fieldset->field('prefecture_id')
            ->add_rule('array_key_exists', \Config::get('master.prefectures'));

        return $fieldset;
    }
}
