<?php
/**
 * 
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_Fleamarket extends Controller_Admin_Base_Template
{
    protected $fleamarket              = null;
    protected $fleamarket_abouts       = array();
    protected $fleamarket_entry_styles = array();
    protected $fieldsets               = null;

    public function before()
    {
        parent::before();
        if (Input::param('fleamarket_id')) {
            $this->fleamarket = 
                Model_Fleamarket::find(Input::param('fleamarket_id'));

            if ($this->fleamarket) {
                foreach ($this->fleamarket->fleamarket_abouts as $fleamarket_about){
                    $this->fleamarket_abouts[$fleamarket_about->about_id] 
                        = $fleamarket_about;
                }
                foreach ($this->fleamarket->fleamarket_entry_styles as $fleamarket_entry_style){
                    $this->fleamarket_entry_styles[$fleamarket_entry_style->entry_style_id] 
                        = $fleamarket_entry_style;
                }
            }
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
        $this->setAssets();
        $view = View::forge('admin/fleamarket/index');
        $fieldsets = $this->getFieldsets();
        $view->set('locations',Model_Location::find('all'));
        $view->set('fieldsets', $fieldsets, false);
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
        $fieldsets = $this->getFieldsets();
        Session::set_flash('admin.fleamarket.fieldsets', $fieldsets);

        if ((! $this->validate_fleamarket($fieldsets)) ||
            (! $this->validate_fleamarket_about($fieldsets)) ||
            (! $this->validate_fleamarket_entry_style($fieldsets)) ){
            return Response::redirect(
                'admin/fleamarket/?fleamarket_id=' . Input::param('fleamarket_id','')
            );
        }

        $files = $this->saveUploadedImages();

        if(! is_array($files)){
            return Response::redirect(
                'admin/fleamarket/?fleamarket_id=' . Input::param('fleamarket_id','')
            );
        }

        $view = View::forge('admin/fleamarket/confirm');
        $view->set('locations',Model_Location::find('all'));
        $view->set('fieldsets', $fieldsets, false);
        $view->set('fleamarket', $this->fleamarket, false);
        $view->set('files', $files, false);

        $this->template->content = $view;
    }

    public function validate_fleamarket($fieldsets)
    {
        return $fieldsets['fleamarket']->validation()->run();
    }
    
    public function validate_fleamarket_about($fieldsets)
    {
        $is_valid = true;
        foreach ($fieldsets['fleamarket_abouts'] as $id => $fieldset) {
            $input = array(
                'description' => Input::param("fleamarket_about_${id}_description"),
            );
            
            if (! $fieldset->validation()->run($input)) {
                $is_valid = false;
            }
        }
        return $is_valid;
    }

    public function validate_fleamarket_entry_style($fieldsets)
    {
        $is_valid = true;
        $entry_styles = Config::get('master.entry_styles');
        foreach ($entry_styles as $id => $entry_style) {
            $input = array();
            foreach (array('booth_fee', 'max_booth', 'reservation_booth_limit') as $column) {
                $input[$column] = Input::param("fleamarket_entry_style_${id}_${column}");
            }
            
            $fieldset = $fieldsets['fleamarket_entry_styles'][$id];

            if (! $fieldset->validation()->run($input)) {
                $is_valid = false;
            }
        }
        return $is_valid;
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
 
        $db = Database_Connection::instance();
        $db->start_transaction();
       
        try {
            $fleamarket = $this->registerFleamarket();
            if ($files) {
                $this->registerFleamarketImage($fleamarket, $files);
            }
            $this->registerFleamarketAbout($fleamarket);
            $this->registerFleamarketEntryStyle($fleamarket);
        } catch ( Exception $e ) {
            $db->rollback_transaction();
            throw $e;
        }
        $db->commit_transaction();
     }

    private function getFieldsets()
    {
        if (! $this->fieldsets) {
            if ($this->request->action == 'index') {
                $fieldsets = Session::get_flash('admin.fleamarket.fieldsets');
                if (! $fieldsets) {
                    $fieldsets = $this->createFieldsets();
                }
            } elseif ($this->request->action == 'confirm') {
                $fieldsets = $this->createFieldsets();
            } elseif ($this->request->action == 'thanks') {
                $fieldsets = Session::get_flash('admin.fleamarket.fieldsets');
            }
            $this->fieldsets = $fieldsets;
        }
        return $this->fieldsets;
    }

    private function createFieldsets()
    {
        return array(
            'fleamarket'              => $this->createFieldsetFleamarket(),
            'fleamarket_abouts'       => $this->createFieldsetFleamarketAbouts(),
            'fleamarket_entry_styles' => $this->createFieldsetFleamarketEntryStyles()
        );
    }

    private function createFieldsetFleamarket()
    {
        $fieldset = Fieldset::forge('fleamarket');

        if ($this->fleamarket) {
            $fieldset->add_model($this->fleamarket)->populate($this->fleamarket,false);

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
            $fieldset->add_model('Model_Fleamarket');
        }

        $fieldset->validation()->add_callable('Custom_Validation');
        $fieldset->add('fleamarket_image_id');
        $fieldset->repopulate();

        return $fieldset;
    }

    private function createFieldsetFleamarketAbouts()
    {
        $fieldsets = array();
        foreach (Model_Fleamarket_About::getAboutTitles() as $id => $about) {
            $fieldset = Fieldset::forge("fleamarket_about_${id}");

            if (isset($this->fleamarket_abouts[$id])) {
                $fieldset
                    ->add_model($this->fleamarket_abouts[$id])
                    ->populate($this->fleamarket_abouts[$id],false);
            }else{
                $fieldset->add_model('Model_Fleamarket_About');
            }

            if (Input::method() == 'POST') {
                $fieldset
                    ->field('description')
                    ->set_value(Input::param("fleamarket_about_${id}_description"));
            }

            $fieldsets[$id] = $fieldset;
        }

        return $fieldsets;
    }

    private function createFieldsetFleamarketEntryStyles()
    {
        $entry_styles = Config::get('master.entry_styles');
        $fieldsets = array();

        foreach ($entry_styles as $id => $entry_stype) {
            $fieldset = Fieldset::forge("fleamarket_entry_style_${id}");

            if (isset($this->fleamarket_entry_styles[$id])) {
                $fieldset
                    ->add_model($this->fleamarket_entry_styles[$id])
                    ->populate($this->fleamarket_entry_styles[$id],false);
            }else{
                $fieldset->add_model('Model_Fleamarket_Entry_Style');
            }

            if (Input::method() == 'POST') {
                foreach (array('booth_fee','max_booth','reservation_booth_limit') as $column) {
                    $fieldset
                        ->field($column)
                        ->set_value(Input::param("fleamarket_entry_style_${id}_${column}"));
                }
            }

            $fieldsets[$id] = $fieldset;
        }

        return $fieldsets;
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
        $fieldsets = $this->getFieldsets();

        if (! $fieldsets) {
            return false;
        }

        $fieldset = $fieldsets['fleamarket'];

        $input = $fieldset->validation()->validated();

        $input['created_user'] = 1;
        $input['updated_user'] = 1;
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

        if(! file_exists(DOCROOT . 'files/fleamarket/img/') ){
            mkdir(DOCROOT . 'files/fleamarket/img/', 0777, true);
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
        $fieldsets = $this->getFieldsets();
        $fieldset  = $fieldsets['fleamarket'];
        $input = $fieldset->input();
        if ($input['fleamarket_image_id']) {
            foreach ($input['fleamarket_image_id'] as $fleamarket_image_id) {
                $query = Model_Fleamarket_Image::query()
                    ->where('fleamarket_image_id',$fleamarket_image_id);
                $query->delete();
            }
        }
    }

    public function setAssets()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');
    }

    public function registerFleamarketAbout($fleamarket)
    {
        $fieldsets = $this->getFieldsets();

        foreach (Model_Fleamarket_About::getAboutTitles() as $id => $title) {
            $fieldset = $fieldsets['fleamarket_abouts'][$id];
            $input = $fieldset->input();

            $fleamarket_about = Model_Fleamarket_About::find('first',array(
                'where' => array(
                    'fleamarket_id' => $fleamarket->fleamarket_id,
                    'about_id' => $id
                )
            ));

            if (! $fleamarket_about) {
                $fleamarket_about = Model_Fleamarket_About::forge(array(
                    'fleamarket_id' => $fleamarket->fleamarket_id,
                    'about_id' => $id
                ));
            }

            $fleamarket_about->set(array(
                'title'        => $title,
                'description'  => $input['description'],
                'created_user' => 1,
                'updated_user' => 1
            ));
            
            $fleamarket_about->save();
        }
    }

    public function registerFleamarketEntryStyle($fleamarket)
    {
        $fieldsets = $this->getFieldsets();
        $entry_styles = Config::get('master.entry_styles');

        foreach ($entry_styles as $id => $entry_style) {
            $fieldset = $fieldsets['fleamarket_entry_styles'][$id];
            $input = $fieldset->input();

            $fleamarket_entry_style = Model_Fleamarket_Entry_Style::find('first',array(
                'where' => array(
                    'fleamarket_id'  => $fleamarket->fleamarket_id,
                    'entry_style_id' => $id
                )
            ));

            if (strlen($input['booth_fee'])) {
                if (! $fleamarket_entry_style) {
                    $fleamarket_entry_style = Model_Fleamarket_Entry_Style::forge(array(
                        'fleamarket_id' => $fleamarket->fleamarket_id,
                        'entry_style_id'      => $id
                    ));
                }
                $fleamarket_entry_style->set(array(
                    'booth_fee'               => $input['booth_fee'],
                    'max_booth'               => $input['max_booth'],
                    'reservation_booth_limit' => $input['reservation_booth_limit'],
                    'created_user'            => 1,
                    'updated_user'            => 1
                ));
                $fleamarket_entry_style->save();
            }else{
                if ($fleamarket_entry_style) {
                    $fleamarket_entry_style->delete();
                }
            }
        }
    }

    public function action_list()
    {
        $view = View::forge('admin/fleamarket/list');
        $this->template->content = $view;

        $total = Model_Fleamarket::query()->count();

        Pagination::set_config(array(
            'pagination_url' => 'admin/fleamarket/list',
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => 50,
            'total_items'    => $total,
            'name'           => 'pagenation',
        ));
        
        $fleamarkets = Model_Fleamarket::query()
            ->order_by('fleamarket_id')
            ->limit(Pagination::get('per_page'))
            ->offset(Pagination::get('offset'))
            ->get();
        
        $view->set('fleamarkets', $fleamarkets);
   }
}
