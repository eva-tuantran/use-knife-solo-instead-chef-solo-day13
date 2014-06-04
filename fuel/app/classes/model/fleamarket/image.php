<?php

class Model_Fleamarket_Image extends Model_Base
{
    /**
     * アップロードファイル数
     */
    const UPLOAD_FILE_LIMIT = 4;

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
     * 指定されたフリIDでフリーマーケット画像情報を取得する
     *
     * @access public
     * @param mixed $fleamarket_id フリID
     * @void array
     * @author ida
     */
    public static function findByFleamarketId($fleamarket_id)
    {
        $result = self::find('all', array(
            'select' => array(
                'fleamarket_image_id', 'fleamarket_id', 'file_name', 'priority'
            ),
            'where' => array(
                array('fleamarket_id', $fleamarket_id),
            ),
            'order_by' => array('priority' => 'asc'),
        ));

        return $result;
    }

    /**
     * アップロードファイルを指定のフォルダに移動する
     *
     * @access public
     * @param array $config アップロードの設定
     * @return void
     * @author kobayashi
     * @author ida
     */
    public static function moveUploadedFile($config)
    {
        $default = array(
            'ext_whitelist' => array('jpg'),
            'randomize' => true,
        );
        $config = array_merge($default, $config);

        \Upload::process($config);

        $is_upload = false;
        $result = array();
        if (\Upload::is_valid()) {
            \Upload::save();
            $files = \Upload::get_files();

            foreach ($files as $file) {
                $result[$file['field']] = $file;
            }
            $is_upload = true;
        } else {
            $error_files = \Upload::get_errors();
            foreach ($error_files as $file) {
                foreach ($file['errors'] as $error) {
                    if ($error['error'] != \Upload::UPLOAD_ERR_NO_FILE) {
                        $result[$file['field']] = $file;
                        $is_upload = false;
                    }
                }
            }
            if (empty($result)) {
                $is_upload = true;
            }
        }

        return array($is_upload, $result);
    }

    /**
     * アップロードファイルを指定のフォルダに移動する
     *
     * @access private
     * @param array $files アップロードファイル情報
     * @param string $src_path コピー元パス
     * @param string $dest_path コピー先パス
     * @return void
     * @author kobayashi
     * @author ida
     */
    public static function storeUploadFile($files, $src_path, $dest_path)
    {
        if (! $files) {
            return false;
        }

        if (! (self::checkPath($src_path, true) && self::checkPath($dest_path, true))) {
            return false;
        }

        foreach ($files as $file) {
            $file_name = $file['saved_as'];
            \File::rename($src_path . $file_name, $dest_path . $file_name);
            self::makeThumbnail($dest_path, $file['saved_as']);
        }

        return $files;
    }

    /**
     * アップロードされた画像のサムネイルを生成する
     *
     * @access private
     * @param string $filename ファイル名
     * @return void
     * @author kobayashi
     */
    public static function makeThumbnail($path, $filename)
    {
        $size_list = array(
            array('width' => 100, 'height' =>  65, 'prefix' => 'ss_'),
            array('width' => 180, 'height' => 135, 'prefix' => 's_'),
            array('width' => 200, 'height' => 150, 'prefix' => 'm_'),
            array('width' => 460, 'height' => 300, 'prefix' => 'l_'),
        );

        foreach ($size_list as $size) {
            $image = imagecreatefromjpeg($path . $filename);
            $x = imagesx($image);
            $y = imagesy($image);

            $resize = imagecreatetruecolor($size['width'], $size['height']);
            imagecopyresampled($resize, $image, 0, 0, 0, 0, $size['width'], $size['height'], $x, $y);

            $matches = array();
            if (preg_match('/^(\w+)\.jpg$/', $filename, $matches)) {
                $new_name = $path . $size['prefix'] . $matches[1] . '.jpg';
                imagejpeg($resize, $new_name);
            }
            imagedestroy($image);
            imagedestroy($resize);
        }
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
    private static function checkPath($path, $create = false)
    {
        if (file_exists($path)) {
            return true;
        }
        if ($create) {
            return mkdir($path, 0755, true);
        }

        return false;
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
        $path = '/' . \Config::get('master.image_path.store');
        $path .= $this->fleamarket_id .'/';

        return $path . $this->file_name;
    }

    /**
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @param
     * @return array
     * @author ida
     * @author kobayasi
     */
    public static function createFieldset()
    {
        $fieldset = \Fieldset::forge('fleamarket_image');
        $fieldset->add_model('Model_Fleamarket_Image');

        return $fieldset;
    }
}
