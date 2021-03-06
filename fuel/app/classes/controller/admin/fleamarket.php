<?php

/**
 * フリマ管理
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */
class Controller_Admin_Fleamarket extends Controller_Admin_Base_Template
{
    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 50;

    private $fleamarket              = null;
    private $fleamarket_abouts       = array();
    private $fleamarket_entry_styles = array();
    private $fieldsets               = null;

    public function before()
    {
        parent::before();
        if (Input::param('fleamarket_id')) {
            $this->fleamarket =
                \Model_Fleamarket::find(Input::param('fleamarket_id'));
        }

        if ($this->fleamarket) {
            $fleamarket_abouts = $this->fleamarket->fleamarket_abouts;
            foreach ($fleamarket_abouts as $fleamarket_about) {
                $this->fleamarket_abouts[$fleamarket_about->about_id]
                    = $fleamarket_about;
            }

            $fleamarket_entry_styles = $this->fleamarket->fleamarket_entry_styles;
            foreach ($fleamarket_entry_styles as $fleamarket_entry_style) {
                $this->fleamarket_entry_styles[$fleamarket_entry_style->entry_style_id]
                    = $fleamarket_entry_style;
            }
        }
    }

    /**
     * フリマ一覧
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function action_list()
    {
        $conditions = $this->getCondition();
        $condition_list = \Model_Fleamarket::createAdminSearchCondition($conditions);
        $total_count = \Model_Fleamarket::getCountByAdminSearch($condition_list);

        // ページネーション設定
        $pagination = \Pagination::forge(
            'fleamarket_pagination',
            $this->getPaginationConfig($total_count)
        );

        $fleamarkets = \Model_Fleamarket::findAdminBySearch(
            $condition_list,
            $pagination->current_page,
            $this->result_per_page
        );

        $view_model = \ViewModel::forge('admin/fleamarket/list');
        $view_model->set('fleamarkets', $fleamarkets, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('conditions', $conditions, false);
        $this->template->content = $view_model;
   }

    /**
     * 入力画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function action_index()
    {
        $this->setAssets();
        $view_model = \ViewModel::forge('admin/fleamarket/index');
        $view_model->set('fieldsets', $this->getFieldsets(), false);
        $view_model->set('fleamarket', $this->fleamarket, false);
        $view_model->set('location_id', \Input::get('location_id'), false);
        $this->template->content = $view_model;
    }

    /**
     * 確認画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function post_confirm()
    {
        $fieldsets = $this->getFieldsets();
        \Session::set_flash('admin.fleamarket.fieldsets', $fieldsets);

        if ((! $this->validateFleamarket($fieldsets))
            || (! $this->validateFleamarketAbout($fieldsets))
            || (! $this->validateFleamarketEntryStyle($fieldsets))
        ) {
            \Response::redirect(
                'admin/fleamarket/?fleamarket_id=' . Input::post('fleamarket_id','')
            );
        }

        list($is_upload, $files) = $this->moveImages();

        if (! $is_upload) {
            \Response::redirect(
                'admin/fleamarket/?fleamarket_id=' . Input::post('fleamarket_id','')
            );
        }

        $view_model = \ViewModel::forge('admin/fleamarket/confirm');
        $view_model->set('fieldsets', $fieldsets, false);
        $view_model->set('fleamarket', $this->fleamarket, false);
        $view_model->set('files', $files, false);
        $this->template->content = $view_model;
    }

    /**
     * 完了画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        try {
            $db = \Database_Connection::instance('master');
            $db->start_transaction();

            $fleamarket = $this->registerFleamarket();
            $files = $this->storeImages($fleamarket->fleamarket_id);
            if ($files) {
                $this->registerFleamarketImage($fleamarket, $files);
            }
            $this->removeFleamarketImages();
            $this->registerFleamarketAbout($fleamarket);
            $this->registerFleamarketEntryStyle($fleamarket);

            $db->commit_transaction();
        } catch (Exception $e) {
            $db->rollback_transaction();
            throw $e;
        }

        $view = View::forge('admin/fleamarket/thanks');
        $this->template->content = $view;
    }

    /**
     * 会場検索
     *
     * ダイアログ表示のHTMLを返答する
     *
     * @access public
     * @param
     * @return string
     * @author ida
     */
    public function action_searchlocation()
    {
        $this->template = '';

        $prefecture_id = \Input::post('prefecture_id');
        $name = \Input::post('name');

        $query = \Model_Location::query()->select(
            'location_id', 'name', 'address'
        );

        if ($prefecture_id) {
            $query->where(array('prefecture_id' => $prefecture_id));
        }
        if ($name) {
            $query->where(array('name', 'LIKE', '%' . $name . '%'));
        }
        $locations = $query->get();

        $view_model = \ViewModel::forge('admin/fleamarket/searchlocation');
        $view_model->set('location_list', $locations, false);

        return $view_model;
    }

    /**
     * js、cssを追加する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function setAssets()
    {
        \Asset::css('jquery-ui.min.css', array(), 'add_css');
        \Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        \Asset::js('jquery-ui.min.js', array(), 'add_js');
        \Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        \Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        \Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');
    }

    /**
     * アップロードファイルを指定のフォルダに移動する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function moveImages()
    {
        $options = array(
            'path' => DOCROOT . \Config::get('master.image_path.temporary_admin'),
            'max_size' => 2048000,
            'create_path' => true,
        );
        list($is_upload, $upload_files) = \Model_Fleamarket_Image::moveUploadedFile($options);
        \Session::set_flash('admin.fleamarket.files', $upload_files);

        return array($is_upload, $upload_files);
    }

    /**
     * アップロードファイルを指定のフォルダに移動する
     *
     * @access private
     * @param mixed $fleamarket_id フリマID
     * @return void
     * @author kobayashi
     */
    private function storeImages($fleamarket_id)
    {
        $files = \Session::get_flash('admin.fleamarket.files');

        if (! $files) {
            return false;
        }

        $tmp_path = \Config::get('master.image_path.temporary_admin');
        $src_path = DOCROOT . $tmp_path;
        $store_path = \Config::get('master.image_path.store');
        $dest_path = DOCROOT . $store_path . $fleamarket_id . '/';

        \Model_Fleamarket_Image::storeUploadFile($files, $src_path, $dest_path);

        return $files;
    }

    /**
     * 画像を削除する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function removeFleamarketImages()
    {
        $fieldsets = $this->getFieldsets();
        $fieldset  = $fieldsets['fleamarket'];
        $input = $fieldset->input();

        if ($input['delete_priorities']) {
            foreach ($input['delete_priorities'] as $priority) {
                $query = \Model_Fleamarket_Image::query()
                    ->where('fleamarket_id', Input::post('fleamarket_id'))
                    ->where('priority', $priority)
                    ->delete();
            }
        }
    }

    /**
     * fleamarkets テーブルへの登録
     *
     * @access private
     * @param
     * @return Model_Fleamarketオブジェクト
     * @author kobayashi
     */
    private function registerFleamarket()
    {
        $data = $this->getFleamarketData();
        if (! $data) {
            throw new \Exception(\Model_Error::ER00502);
        }

        $fleamarket = \Model_Fleamarket::find(
            \Input::post('fleamarket_id')
        );

        $administrator_id = $this->administrator->administrator_id;
        if ($fleamarket) {
            $data['updated_user'] = $administrator_id;
        }else{
            $fleamarket = \Model_Fleamarket::forge();
            $data['reservation_serial'] = 1;
            $data['created_user'] = $administrator_id;
        }
        $fleamarket->set($data)->save();

        return $fleamarket;
    }

    /**
     * ファイル名をフリマ画像情報に登録する
     *
     * @access private
     * @param object $fleamarket フリマ情報
     * @param array $files フリマ画像情報
     * @return void
     * @author kobayashi
     */
    private function registerFleamarketImage($fleamarket, $files)
    {
        foreach ($files as $file) {
            $matches = array();
            if (preg_match('/^upload(\d+)$/', $file['field'], $matches)) {
                $priority = $matches[1];
                $data = array(
                    'fleamarket_id' => $fleamarket->fleamarket_id,
                    'file_name' => $file['saved_as'],
                    'priority' => $priority
                );

                $fleamarket_image = \Model_Fleamarket_Image::query()
                    ->where('fleamarket_id', $fleamarket->fleamarket_id)
                    ->where('priority', $priority)
                    ->get_one();

                $administrator_id = $this->administrator->administrator_id;
                if ($fleamarket_image) {
                    $data['updated_user'] = $administrator_id;
                }else{
                    $fleamarket_image = \Model_Fleamarket_Image::forge(array(
                        'fleamarket_id' => $fleamarket->fleamarket_id,
                        'priority' => $priority
                    ));
                    $data['created_user'] = $administrator_id;
                }
                $fleamarket_image->set($data)->save();
            }
        }
    }

    /**
     * フリマ説明情報を登録する
     *
     * @access private
     * @param object フリマ情報
     * @return void
     * @author kobayashi
     * @author ida
     */
    private function registerFleamarketAbout($fleamarket)
    {
        $fieldsets = $this->getFieldsets();

        foreach (\Model_Fleamarket_About::getAboutTitles() as $id => $title) {
            $fieldset = $fieldsets['fleamarket_abouts'][$id];
            $input = $fieldset->input();

            $data = array(
                'title'        => $title,
                'description'  => $input['description'],
            );

            $fleamarket_about = \Model_Fleamarket_About::find('first',array(
                'where' => array(
                    'fleamarket_id' => $fleamarket->fleamarket_id,
                    'about_id'      => $id
                )
            ));

            $administrator_id = $this->administrator->administrator_id;
            if ($fleamarket_about) {
                $data['updated_user'] = $administrator_id;
            } else {
                $fleamarket_about = \Model_Fleamarket_About::forge(array(
                    'fleamarket_id' => $fleamarket->fleamarket_id,
                    'about_id' => $id
                ));
                $data['created_user'] = $administrator_id;
            }

            $fleamarket_about->set($data)->save();
        }
    }

    /**
     * フリマ出店形態情報を登録する
     *
     * @access private
     * @param object フリマ情報
     * @return void
     * @author kobayashi
     * @author ida
     */
    private function registerFleamarketEntryStyle($fleamarket)
    {
        $entry_styles = \Config::get('master.entry_styles');
        $fieldsets = $this->getFieldsets();

        foreach ($entry_styles as $id => $entry_style) {
            $fieldset = $fieldsets['fleamarket_entry_styles'][$id];
            $input = $fieldset->input();

            $fleamarket_entry_style = \Model_Fleamarket_Entry_Style::find('first',array(
                'where' => array(
                    'fleamarket_id'  => $fleamarket->fleamarket_id,
                    'entry_style_id' => $id
                )
            ));

            $data = array(
                'booth_fee'     => $input['booth_fee'],
                'max_booth'     => $input['max_booth'],
                'reservation_booth_limit' => $input['reservation_booth_limit'],
            );

            if (strlen($input['booth_fee'])) {
                $administrator_id = $this->administrator->administrator_id;
                if ($fleamarket_entry_style) {
                    $data['updated_user'] = $administrator_id;
                } else {
                    $fleamarket_entry_style = \Model_Fleamarket_Entry_Style::forge(array(
                        'fleamarket_id'     => $fleamarket->fleamarket_id,
                        'entry_style_id'    => $id
                    ));
                    $data['created_user'] = $administrator_id;
                }
                $fleamarket_entry_style->set($data)->save();
            } else {
                if ($fleamarket_entry_style) {
                    $fleamarket_entry_style->delete();
                }
            }
        }
    }

    /**
     * フリマ情報のバリデーション
     *
     * @access public
     * @param object $fieldsets フィールドセットオブジェクト
     * @return void
     * @author kobayashi
     */
    private function validateFleamarket($fieldsets)
    {
        return $fieldsets['fleamarket']->validation()->run();
    }

    /**
     * フリマ説明情報のバリデーション
     *
     * @access public
     * @param object $fieldsets フィールドセットオブジェクト
     * @return void
     * @author kobayashi
     * @author ida
     */
    private function validateFleamarketAbout($fieldsets)
    {
        $is_valid = false;
        foreach ($fieldsets['fleamarket_abouts'] as $id => $fieldset) {
            $input = array(
                'description' => Input::post("fleamarket_about_${id}_description"),
            );

            if ($fieldset->validation()->run($input)) {
                $is_valid = true;
            }
        }

        return $is_valid;
    }

    /**
     * フリマ出店形態情報のバリデーション
     *
     * @access public
     * @param object $fieldsets フィールドセットオブジェクト
     * @return void
     * @author kobayashi
     * @author ida
     */
    private function validateFleamarketEntryStyle($fieldsets)
    {
        $is_valid = false;
        $entry_styles = \Config::get('master.entry_styles');
        foreach ($entry_styles as $id => $entry_style) {
            $input = array();
            $fields = array(
                'booth_fee', 'max_booth', 'reservation_booth_limit'
            );
            foreach ($fields as $field) {
                $field_name = "fleamarket_entry_style_{$id}_{$field}";
                $input[$field] = \Input::post($field_name);
            }

            $fieldset = $fieldsets['fleamarket_entry_styles'][$id];

            if ($fieldset->validation()->run($input)) {
                $is_valid = true;
            }
        }

        return $is_valid;
    }

    /**
     * フィールドセットを取得する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function getFieldsets()
    {
        if (! $this->fieldsets) {
            if ($this->request->action == 'index') {
                $fieldsets = \Session::get_flash('admin.fleamarket.fieldsets');
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

    /**
     * フィールドセットを生成する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function createFieldsets()
    {
        return array(
            'fleamarket'              => $this->createFieldsetFleamarket(),
            'fleamarket_abouts'       => $this->createFieldsetFleamarketAbouts(),
            'fleamarket_entry_styles' => $this->createFieldsetFleamarketEntryStyles()
        );
    }

    /**
     * フリマ情報のフィールドセットを生成する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    private function createFieldsetFleamarket()
    {
        $fieldset = \Fieldset::forge('fleamarket');

        if ($this->fleamarket) {
            $fieldset->add_model($this->fleamarket)->populate($this->fleamarket, false);

            foreach (array('event_time_start', 'event_time_end') as $field) {
                $value = $fieldset->field($field)->value;
                $matches = array();
                if (preg_match('/(^\d{2}:\d{2})/', $value, $matches)) {
                    $value = $matches[1];
                }
                $fieldset->field($field)->set_value($value);
            }

            foreach (array('reservation_start','reservation_end') as $field) {
                $value = $fieldset->field($field)->value;
                $matches = array();
                if (preg_match('/(^\d{4}-\d{2}-\d{2})/', $value, $matches)) {
                    $value = $matches[1];
                }
                $fieldset->field($field)->set_value($value);
            }
        } else {
            $fieldset->add_model('Model_Fleamarket');
        }

        $fieldset->validation()->add_callable('Custom_Validation');
        $fieldset->field('location_id')
            ->add_rule('location_exists');

        $fieldset->add('delete_priorities');
        $fieldset->repopulate();

        return $fieldset;
    }

    /**
     * フリマ説明情報のフィールドセットを生成する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function createFieldsetFleamarketAbouts()
    {
        $fieldsets = array();
        foreach (\Model_Fleamarket_About::getAboutTitles() as $id => $title) {
            $fieldset = Fieldset::forge("fleamarket_about_{$id}");

            if (isset($this->fleamarket_abouts[$id])) {
                $fieldset->add_model($this->fleamarket_abouts[$id])
                    ->populate($this->fleamarket_abouts[$id],false);
            } else {
                $fieldset->add_model('Model_Fleamarket_About');
            }

            if (\Input::method() == 'POST') {
                $fieldset->field('description')
                    ->set_value(\Input::post("fleamarket_about_{$id}_description"));
            }

            $fieldsets[$id] = $fieldset;
        }

        return $fieldsets;
    }

    /**
     * フリマ出店形態情報のフィールドセットを生成する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function createFieldsetFleamarketEntryStyles()
    {
        $entry_styles = \Config::get('master.entry_styles');
        $fieldsets = array();

        foreach ($entry_styles as $id => $entry_stype) {
            $fieldset = \Fieldset::forge("fleamarket_entry_style_${id}");

            if (isset($this->fleamarket_entry_styles[$id])) {
                $fieldset->add_model($this->fleamarket_entry_styles[$id])
                    ->populate($this->fleamarket_entry_styles[$id],false);
            }else{
                $fieldset->add_model('Model_Fleamarket_Entry_Style');
            }

            if (Input::method() == 'POST') {
                $fields = array(
                    'booth_fee','max_booth','reservation_booth_limit'
                );
                foreach ($fields as $field) {
                    $fieldset->field($field)
                        ->set_value(Input::post("fleamarket_entry_style_{$id}_{$field}"));
                }
            }

            $fieldsets[$id] = $fieldset;
        }

        return $fieldsets;
    }

    /**
     * セッションからフリマ情報のデータを取得、整形
     *
     * @access private
     * @param
     * @return array fleamarketのデータ
     * @author kobayashi
     */
    private function getFleamarketData()
    {
        $fieldsets = $this->getFieldsets();

        if (! $fieldsets) {
            return false;
        }

        $fieldset = $fieldsets['fleamarket'];
        $input = $fieldset->validation()->validated();
        $input['link_from_list'] = \Model_Fleamarket::implodeLinkFromList(
            $input['link_from_list']
        );
        $input['group_code'] = '';

        if (empty($input['reservation_start'])) {
            unset($input['reservation_start']);
        }
        if (empty($input['reservation_end'])) {
            unset($input['reservation_end']);
        }
        unset($input['reservation_serial']);
        unset($input['event_number']);
        unset($input['created_user']);
        unset($input['updated_user']);
        unset($input['created_at']);
        unset($input['updated_at']);
        unset($input['deleted_at']);

        return $input;
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getCondition()
    {
        $conditions = Input::post('c', array());

        $result = array();
        foreach ($conditions as $field => $value) {
            if ($value !== '') {
                $result[$field] = $value;
            }
        }

        if (! isset($result['register_type'])) {
            $result['register_type'] = \Model_Fleamarket::REGISTER_TYPE_ADMIN;
        }

        if (! isset($result['event_status'])) {
            $result['event_status'] =
                \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT;
        }

        return $result;
    }

    /**
     * ページネーション設定を取得する
     *
     * @access private
     * @param int $count 総行数
     * @return array
     * @author ida
     */
    private function getPaginationConfig($count)
    {
        $result_per_page = \Input::post('result_per_page');
        if ($result_per_page) {
            $this->result_per_page = $result_per_page;
        }

        return array(
            'pagination_url' => 'admin/fleamarket/list',
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => $this->result_per_page,
            'total_items'    => $count,
        );
    }
}
