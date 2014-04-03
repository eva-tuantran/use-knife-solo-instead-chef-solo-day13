<?php
/**
 * お問い合わせフォーム
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Reservation extends Controller_Base_Template
{
    protected $_login_actions = array(
        'index',
        'confirm',
        'thanks',
    );

    private $fleamarket = null;
    private $fieldset = null;

    public function before()
    {
        parent::before();

        $this->fieldset = $this->getFieldset();
        if (! $this->fieldset) {
            return Response::redirect('/');
        }

        $input = $this->fieldset->input();
        $fleamarket = Model_Fleamarket::find($input['fleamarket_id']);

        if (! $fleamarket) {
            return Response::redirect('/');
        }

        $this->fleamarket = $fleamarket;
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

        $fleamarket_entry_style = Model_Fleamarket_Entry_Style::query()
            ->where(array(
                'fleamarket_id'             => Input::param('fleamarket_id'),
                'fleamarket_entry_style_id' => Input::param('fleamarket_entry_style_id'),
            ))
            ->get_one();

        $view = View::forge('reservation/confirm');
        $view->set('fieldset', $this->fieldset, false);
        $view->set('fleamarket_entry_style',$fleamarket_entry_style);
        
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
            $this->sendMailToUser($entry);
        } catch (Exception $e) {
            $view->set('error', $e, false);
            throw $e;
        }
        $view->set('entry', $entry, false);
    }

    /**
     * アクションに応じたfieldsetを取得する
     *
     * @access public
     * @return void
     */
    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = Session::get_flash('reservation.fieldset');
            if (! $fieldset) {
                $fieldset = $this->createFieldset();
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = Session::get_flash('reservation.fieldset');
        }
        return $fieldset;
    }

    /**
     * fieldsetをInput::allから作成する
     *
     * @access private
     * @return Fieldsetオブジェクト
     */
    private function createFieldset()
    {
        $fieldset = Model_Entry::createFieldset(Input::all());
        $fieldset->repopulate();
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
            $db = Database_Connection::instance();
            $db->start_transaction();

            $condition = array(
                'user_id'                   => $data['user_id'],
                'fleamarket_id'             => $data['fleamarket_id'],
                'fleamarket_entry_style_id' => $data['fleamarket_entry_style_id'],
            );

            $entry = Model_Entry::find('first',$condition);
            if ($entry) {
                $entry->set($data);
                $entry->save();
            } else {
                $entry = Model_Entry::find_deleted('first',$condition);
                if ($entry) {
                    $entry->set($data);
                    $entry->restore();
                } else {
                    $entry = Model_Entry::forge($data);
                    $entry->save();
                }
            }

            $entry->fleamarket->updateEventReservationStatus();

            if (! Input::post('cancel') && 
                $entry->fleamarket_entry_style->isOverReservationLimit()) {
                $db->rollback_transaction();
                return false;
            }else{
                $db->commit_transaction();
                return $entry;
            }
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
        $input = $this->fieldset->validation()->validated();

        if ($input) {
            $item_genres_define = Model_Entry::getItemGenresDefine();
            $to_label = function($value) use ($item_genres_define) {
                return $item_genres_define[$value];
            };

            $user_id = Auth::get_user_id();

            $input_other = array_merge($input,array(
                'user_id'            => $user_id,
                'reservation_number' => 1,
                'link_from'          => '',
                'entry_status'       => Input::post('cancel') ?
                Model_Entry::ENTRY_STATUS_WAITING : Model_Entry::ENTRY_STATUS_RESERVED,
                'created_user'       => $user_id,
                'updated_user'       => $user_id,
                'item_genres'        => implode(',',array_map($to_label, $input['item_genres'])),
            ));
            $input = array_merge($input, $input_other);
        }

        return $input;
    }

    /**
     * ユーザーにメールを送信
     *
     * @para $entry
     * @access private
     * @return void
     */
    private function sendMailToUser($entry)
    {
        $params = array();
        foreach (array_keys($entry->properties()) as $column) {
            $params[$column] = $entry->get($column);
        }
        $this->login_user->sendmail("reservation" , $params);
    }
}
