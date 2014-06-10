<?php
namespace Fuel\Tasks;

/**
 * イメージ画像のディレクトリ移動
 *
 * イメージ画像のディレクトリ構成変更に伴うバッチ
 *
 * @author kobayasi
 */
class Mail_Magazine
{
    /**
     * 移動
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function run()
    {
        $fleamarket_images = \Model_Fleamarket_Image::find('all');
        if (! $fleamarket_images) {
            echo 'フリマのイメージ画像はありません';
            return;
        }

        $old_dir = DOCROOT . 'files/fleamarket/img/';
        $new_dir = DOCROOT . 'files/fleamarket/';
        foreach ($fleamarket_images as $fleamarket_image_id => $fleamarket_image) {
            echo $fleamarket_image_id . '=:' . $fleamarket_image->file_name;
            echo "\n-----\n";

            self::checkPath($new_dir . $fleamarket_image->fleamarket_id , true);
            $old_path = $old_dir . $fleamarket_image->file_name;
            $new_path = $new_dir . $fleamarket_image->fleamarket_id . '/' . $fleamarket_image->file_name;
            if (! copy ($old_path, $new_dir)) {
                echo 'Error =: ' . $fleamarket_image_id;
                return false;
            }
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
    private function checkPath($path, $create = false)
    {
        if (file_exists($path)) {
            return true;
        }
        if ($create) {
            return mkdir($path, 0755, true);
        }

        return false;
    }
}
