<?php
/**
 * 
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_Fleamarket extends Controller_Admin_Base_Template
{
    protected $fleamarket = null;

    public function before()
    {
        parent::before();
        if (Input::param('fleamarket_id')) {
            $this->fleamarket = 
                Model_Fleamarket::find(Input::param('fleamarket_id'));
        }
    }

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');

        $view = View::forge('admin/fleamarket/index');
        $fieldset = $this->getFieldset();
        $view->set('fieldset', $fieldset, false);
        $view->set('fleamarket', $this->fleamarket, false);
        $this->template->content = $view;
    }
    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function post_confirm()
    {
        $fieldset = $this->getFieldset();
        Session::set_flash('admin.fleamarket.fieldset', $fieldset);

        if (! $fieldset->validation()->run()) {
            return Response::redirect('admin/fleamarket?fleamarket_id=' . Input::param('fleamarket_id',''));
        }

        $files = $this->saveUploadedImages();

        if(! is_array($files)){
            return Response::redirect('admin/fleamarket?fleamarket_id=' . Input::param('fleamarket_id',''));
        }

        $view = View::forge('admin/fleamarket/confirm');
        $view->set('fieldset', $fieldset, false);
        $view->set('fleamarket', $this->fleamarket, false);
        $view->set('files', $files, false);

        $this->template->content = $view;
    }

    /**
     * 完了画面
     *
     * @access public
     * @return void
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            return Response::redirect('errors/doubletransmission');
        }

        $view = View::forge('admin/fleamarket/thanks');
        $this->template->content = $view;

        $this->removeFleamarketImages();
        $files = $this->moveUploadedImages();
        
        try {
            $fleamarket = $this->registerFleamarket();
            if ($files) {
                $this->registerFleamarketImage($fleamarket, $files);
            }
        } catch ( Exception $e ) {
            throw $e;
            //$view->set('error', $e, false);
        }
    }

    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = Session::get_flash('admin.fleamarket.fieldset');
            if (! $fieldset) {
                $fieldset = $this->createFieldset();
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = Session::get_flash('admin.fleamarket.fieldset');
        }
        return $fieldset;
    }

    /**
     * fieldsetの作成
     *
     * @access private
     * @return Fieldsetオブジェクト
     */
    private function createFieldset()
    {
        if ($this->fleamarket) {
            $fieldset = Fieldset::forge('fleamarket');
            $fieldset->add_model($this->fleamarket)->populate($this->fleamarket,true);

            foreach (array('event_time_start','event_time_end') as $column) {
                $value = $fieldset->field($column)->value;
                $matches = array();
                if (preg_match('/(^\d{2}:\d{2})/',$value,$matches)) {
                    $value = $matches[1];
                }
                $fieldset->field($column)->set_value($value);
            }
            foreach (array('reservation_start','reservation_end') as $column) {
                $value = $fieldset->field($column)->value;
                $matches = array();
                if (preg_match('/(^\d{4}-\d{2}-\d{2})/',$value,$matches)) {
                    $value = $matches[1];
                }
                $fieldset->field($column)->set_value($value);
            }
        } else {
            $fieldset = Model_Fleamarket::createFieldset(true);
        }

        $fieldset->add('fleamarket_image_id');
        
        $fieldset->repopulate();
        $fieldset->validation()->add_callable('Custom_Validation');

        return $fieldset;
    }

    /**
     * fleamarkets テーブルへの登録
     *
     * @access private
     * @return Model_Fleamarketオブジェクト
     */
    private function registerFleamarket()
    {
        $data = $this->getFleamarketData();
        if (! $data) {
            throw new Exception();
        } else {
            if (Input::param('fleamarket_id')) {
                $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
            } else {
                $fleamarket = Model_Fleamarket::forge();
            }
            if ($fleamarket) {
                $fleamarket->set($data);
                $fleamarket->save();
            }
            return $fleamarket;
        }
    }

    /**
     * セッションからfleamarketのデータを取得、整形
     *
     * @access private
     * @return array fleamarketのデータ
     */
    private function getFleamarketData()
    {
        $fieldset = $this->getFieldset();

        if (! $fieldset) {
            return false;
        }

        $input = $fieldset->validation()->validated();

        $input['created_user'] = 1;
        $input['updated_user'] = 1;
        $input['location_id'] = 1;
        $input['group_code'] = '';

        return $input;
    }

    public function saveUploadedImages()
    {
        Upload::process(array(
            'path' => DOCROOT . 'files/admin/fleamarket/img/',
            'ext_whitelist' => array('jpg'),
            'randomize'      => true,
        ));

        if (Upload::is_valid()) {
            Upload::save();
            $files = Upload::get_files();
            Session::set_flash('admin.fleamarket.files', $files);
            return $files;
        } else {
            foreach (Upload::get_errors() as $file) {
                foreach ($file['errors'] as $error){
                    if( $error['error'] != Upload::UPLOAD_ERR_NO_FILE) {
                        return false;
                    }
                }
            }
            return array();
        }
    }

    public function moveUploadedImages()
    {
        $files = Session::get_flash('admin.fleamarket.files');
        if (! $files) {
            return false;
        }
        
        foreach ($files as $file) {
            File::rename(
                DOCROOT . 'files/admin/fleamarket/img/' . $file['saved_as'],
                DOCROOT . 'files/fleamarket/img/'       . $file['saved_as']
            );
            $this->makeThumbnail($file['saved_as']);
        }
        return $files;
    }

    public function registerFleamarketImage($fleamarket, $files)
    {
        foreach ($files as $file) {
            $fleamarket_image = Model_Fleamarket_Image::forge(array(
                'fleamarket_id' => $fleamarket->fleamarket_id,
                'file_name' => $file['saved_as'],
                'created_user' => 1,
                'updated_user' => 1,
            ));
            $fleamarket_image->save();
        }
    }

    public function makeThumbnail($image_filename)
    {
        $sizes = array(
            array('width' => 100, 'height' => 65, 'suffix' => '_small'),
        );

        foreach ($sizes as $size) {
            $image = imagecreatefromjpeg(DOCROOT . 'files/fleamarket/img/' . $image_filename);
            $x = imagesx($image);
            $y = imagesy($image);

            $resize = imagecreatetruecolor($size['width'], $size['height']);
            imagecopyresampled($resize, $image, 0, 0, 0, 0, $size['width'], $size['height'], $x, $y);

            $matches = array();
            if (preg_match('/^(\w+)\.jpg$/',$image_filename,$matches)) {
                $filename = DOCROOT . 'files/fleamarket/img/' . $matches[1] . $size['suffix'] . '.jpg';
                imagejpeg($resize, $filename);
            }
            imagedestroy($image);
            imagedestroy($resize);
        }
    }

    public function removeFleamarketImages()
    {
        $input = $this->getFieldset()->input();
        if ($input['fleamarket_image_id']) {
            foreach ($input['fleamarket_image_id'] as $fleamarket_image_id) {
                $query = Model_Fleamarket_Image::query()
                    ->where('fleamarket_image_id',$fleamarket_image_id);
                $query->delete();
            }
        }
    }
}
