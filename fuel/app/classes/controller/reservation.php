<?php
/**
 * お問い合わせフォーム
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Reservation extends Controller_Base_Template
{
    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $this->setMetaTag('reservation/index');
        $view = View::forge('reservation/index');
        $fieldset = $this->createFieldset();
        $fieldset->repopulate();
        $view->set('fieldset', $fieldset, false);
        $this->template->content = $view;


        $fleamarket = Model_Fleamarket::find(1);
        var_dump($fleamarket->fleamarket_entry_styles);
    }
    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function post_confirm()
    {
        $fieldset = $this->createFieldset();
        Session::set_flash('reservation.fieldset',$fieldset);
        
        if (! $fieldset->validation()->run()) {
            return Response::redirect('reservation');
        }

        $view = View::forge('reservation/confirm');
        $view->set('fieldset', $fieldset, false);

        $this->setMetaTag('reservation/confirm');
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

        $view = View::forge('reservation/thanks');
        $this->setMetaTag('reservation/thanks');

        $this->template->content = $view;

        try {
            $entry = $this->registerEntry();
            $this->sendMailToUserAndAdmin($entry);
        } catch ( Exception $e ) {
            $view->set('error',$e,false);
        }
    }

    /**
     * fieldsetの作成
     *
     * @access private
     * @return Fieldsetオブジェクト
     */
    private function createFieldset()
    {
        $fieldset = Session::get_flash('reservation.fieldset');

        if (! $fieldset) {
            //$fieldset = Model_Entry::createFieldset();
            $fieldset = Fieldset::forge();
        }

        return $fieldset;
    }

    /**
     * entries テーブルへの登録
     *
     * @access private
     * @return Model_Entryオブジェクト
     */
    private function registerEntry()
    {
        $data = $this->getEntryData();
        if (! $data) {
            throw new Exception();
        } else {
            $entry = Model_Entry::forge();
            $entry->set($data);
            $entry->save(NULL, true);

            return $entry;
        }
    }

    /**
     * セッションからentryのデータを取得、整形
     *
     * @access private
     * @return array entryのデータ
     */
    private function getEntryData()
    {
        $fieldset = Session::get_flash('reservation.fieldset');

        if (! $fieldset) {
            return false;
        }

        $input = $fieldset->validation()->validated();

        if ($input) {
            $input['user_id'] = Auth::get_user_id();
        }

        return $input;
    }
}
