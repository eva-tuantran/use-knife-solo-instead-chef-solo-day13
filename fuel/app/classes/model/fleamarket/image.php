<?php

class Model_Fleamarket_Image extends Model_Base
{
    protected static $_table_name = 'fleamarket_images';

    protected static $_primary_key  = array('fleamarket_image_id');

    protected static $_properties = array(
        'fleamarket_image_id',
        'fleamarket_id',
        'priority',
        'file_name',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
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

    protected static $_soft_delete = array(
        'deleted_field'   => 'deleted_at',
        'mysql_timestamp' => true,
    );

    /**
     * 指定されたフリーマーケットIDでフリーマーケット画像情報を取得する
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @void array
     * @author ida
     */
    public static function findByFleamarketId($fleamarket_id)
    {
        $result = self::find('all', array(
            'select' => array(
                'fleamarket_image_id', 'fleamarket_id', 'file_name'
            ),
            'where' => array(
                array('fleamarket_id', $fleamarket_id),
            ),
        ));

        return $result;
    }

    /**
     * アップロードファイルを指定のフォルダに移動する
     *
     * @access public
     * @param array $options アップロードの設定
     * @return void
     * @author kobayashi
     * @author ida
     */
    public static function move($options)
    {
        $default = array(
            'ext_whitelist' => array('jpg'),
            'randomize'      => true,
        );
        $options = $default + $options;

        \Upload::process($options);

        $result = array();
        if (\Upload::is_valid()) {
            \Upload::save();
            $files = \Upload::get_files();

            foreach ($files as $file) {
                $result[$file['field']] = $file;
            }
        } else {
            foreach (\Upload::get_errors() as $file) {
                foreach ($file['errors'] as $error) {
                    if ($error['error'] != \Upload::UPLOAD_ERR_NO_FILE) {
                        return false;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * アップロードファイルを指定のフォルダに移動する
     *
     * @access private
     * @param array $files アップロードファイル情報
     * @return void
     * @author kobayashi
     * @author ida
     */
    public static function store($files, $src, $dest)
    {
        if (! $files) {
            return false;
        }

        self::checkPath($src);
        self::checkPath($dest);

        foreach ($files as $file) {
            \File::rename(
                DOCROOT . 'files/admin/fleamarket/img/' . $file['saved_as'],
                DOCROOT . 'files/fleamarket/img/'       . $file['saved_as']
            );
            $this->makeThumbnail($file['saved_as']);
        }

        return $files;
    }

    /**
     * パスの存在チェック
     *
     * 存在しない場合は作成する
     *
     * @access private
     * @param string $path チェックするパス
     * @return void
     * @author ida
     */
    private static function checkPath($path)
    {
        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }

    /**
     * 保存先URL(path)を取得する
     *
     * @access public
     * @param
     * @return string
     * @author kobayashi
     * @author ida
     */
    public function Url()
    {
        $path = \Config::get('master.image_path.store');
        $path .= $this->fleamarket_id .'/';

        return $path . $this->file_name;
    }
}
