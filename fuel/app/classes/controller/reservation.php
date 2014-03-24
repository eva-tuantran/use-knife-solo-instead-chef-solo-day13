<?php
/**
 * お問い合わせフォーム
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Reservation extends Controller_Base_Template
{
/*
    protected $_login_actions = array(
        'index',
        'confirm',
        'thanks',
    );
*/
    private $fleamarket = null;
    private $fieldset = null;

    public function before()
    {
        parent::before();

        $this->fieldset = $this->createFieldset();
        $this->fieldset->repopulate();
        $input = $this->fieldset->input();

        $this->fleamarket = Model_Fleamarket::find($input['fleamarket_id']);
        if (! $this->fleamarket) {
            return Response::redirect('/');
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
        $this->setMetaTag('reservation/index');
        $view = View::forge('reservation/index');
        $this->template->content = $view;
        $view->set('fieldset', $this->fieldset, false);
        $view->set('fleamarket', $this->fleamarket,false);
    }
    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function post_confirm()
    {
        Session::set_flash('reservation.fieldset',$this->fieldset);
        
        if (! $this->fieldset->validation()->run()) {
            return Response::redirect('reservation');
        }

        $view = View::forge('reservation/confirm');
        $view->set('fieldset', $this->fieldset, false);

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
        } catch (Exception $e) {
            $view->set('error',$e,false);
            throw $e;
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
            $fieldset = Model_Entry::createFieldset(Input::all());
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
            $item_genres_define = Model_Entry::getItemGenresDefine();
            $to_label = function($value) use ($item_genres_define) {
                return $item_genres_define[$value];
            };

            $user_id = 1;// Auth::get_user_id();

            $input_other = array_merge($input,array(
                'user_id'            => $user_id,
                'reservation_number' => 1,
                'link_from'          => '',
                'entry_status'       => '',
                'created_user'       => $user_id,
                'updated_user'       => $user_id,
                'item_genres'        => implode(',',array_map($to_label, $input['item_genres'])),
            ));
            $input = array_merge($input, $input_other);
        }

        return $input;
    }
}
