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
            $this->fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
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
            return Response::redirect('admin/fleamarket');
        }

        $view = View::forge('admin/fleamarket/confirm');
        $view->set('fieldset', $fieldset, false);

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

        try {
            $fleamarket = $this->registerFleamarket();
        } catch ( Exception $e ) {
            $view->set('error', $e, false);
        }
    }

    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = Session::get_flash('admin.fleamarket.fieldset');
            if (! $fieldset) {
                $fieldset = $this->createFieldset();
                if ($this->fleamarket) {
                    $fieldset->add_model($this->fleamarket)->populate($this->fleamarket,true);
                }
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = Session::set_flash('admin.fleamarket.fieldset', $fieldset);
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
        $fieldset = Model_Fleamarket::createFieldset(true);
        $fieldset->repopulate();
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
            $fleamarket = Model_Fleamarket::forge();
            $fleamarket->set($data);
            $fleamarket->save();

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
        $fieldset = Session::get_flash('admin.fleamarket.fieldset');

        if (! $fieldset) {
            return false;
        }

        $input = $fieldset->validation()->validated();

        if ($input) {
//            unset($input['email2']);
//            $input['user_id'] = Auth::get_user_id();
        }

        return $input;
    }
}

