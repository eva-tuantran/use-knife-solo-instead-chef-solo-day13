<?php

/**
 * 出店予約
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */
class Controller_Reservation extends Controller_Base_Template
{
    protected $_login_actions = array(
        'index', 'confirm', 'thanks', 'waiting',
    );

    protected $_secure_actions = array(
        'index', 'confirm', 'thanks', 'waiting',
    );

    private $fleamarket = null;
    private $fleamarket_entry_style = null;
    private $fieldset = null;

    public function before()
    {
        parent::before();

        $this->fieldset = $this->getFieldset();
        if (! $this->fieldset) {
            throw new \SystemException(\Model_Error::ER00601);
        }

        $input = $this->fieldset->input();
        $fleamarket = \Model_Fleamarket::find($input['fleamarket_id']);

        if (! $fleamarket) {
            throw new \SystemException(\Model_Error::ER00601);
        }
        $this->fleamarket = $fleamarket;

        if ($input['fleamarket_entry_style_id']) {
            $this->fleamarket_entry_style = \Model_Fleamarket_Entry_Style::find('first', array(
                'where' => array(
                    'fleamarket_entry_style_id' => $input['fleamarket_entry_style_id'],
                    'fleamarket_id'             => $input['fleamarket_id'],
                )
            ));
        }
    }

    /**
     * 入力
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_index()
    {
        $view = \View::forge('reservation/index');
        $view->set('fieldset', $this->fieldset, false);
        $view->set('fleamarket', $this->fleamarket, false);
        $view->set('user', $this->login_user, false);
        $view->set('item_categories', \Model_Entry::getItemCategories(), false);
        $view->set('item_genres', \Model_Entry::getItemGenres(), false);
        $this->template->content = $view;
    }

    /**
     * 確認
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function post_confirm()
    {
        Session::set_flash('reservation.fieldset', $this->fieldset);

        if (! $this->fieldset->validation()->run() || ! $this->canReserve()) {
            \Session::set_flash('reservation.error', true);
            \Response::redirect('reservation');
        }

        if (! $this->fleamarket_entry_style) {
            throw new \SystemException(\Model_Error::ER00601);
        }

        $view = \View::forge('reservation/confirm');
        $view->set('fieldset', $this->fieldset, false);
        $view->set('fleamarket_entry_style',$this->fleamarket_entry_style);

        $this->template->content = $view;
    }

    /**
     * 完了
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        if (! $this->canReserve()){
            \Response::redirect('reservation');
        }

        $data = $this->getEntryData();
        if (! $data) {
            throw new \SystemException(\Model_Error::ER00605);
        }

        try {
            $entry = $this->registerEntry($data);
        } catch (\Exception $e) {
            throw new \SystemException(\Model_Error::ER00603);
        }

        if ($entry && ! \Session::get('admin.user.nomail')){
            try {
                $entry->sendmail($this->login_user);
            } catch (\Exception $e) {
                throw new \SystemException(\Model_Error::ER00604);
            }
        }

        $view = \View::forge('reservation/thanks');
        $view->set('entry', $entry, false);
        $this->template->content = $view;
    }

    /**
     * キャンセル待ち登録
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function post_waiting()
    {
        if (! Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        try {
            $entry = $this->registerWaitingEntry();
        } catch (\Exception $e) {
            throw new \SystemException(\Model_Error::ER00603);
        }

        if ($entry && ! \Session::get('admin.user.nomail')){
            try {
                $entry->sendmail($this->login_user);
            } catch (\Exception $e) {
                throw new \SystemException(\Model_Error::ER00604);
            }
        } elseif (! $entry) {
            throw new \SystemException(\Model_Error::ER00603);
        }

        $view = \View::forge('reservation/waiting');
        $view->set('entry', $entry, false);
        $this->template->content = $view;
    }

    /**
     * entries テーブルへの登録
     *
     * @access private
     * @param array $data 登録データ
     * @return object
     * @author kobayashi
     * @author ida
     */
    private function registerEntry($data)
    {
        $db = \Database_Connection::instance('master');
        $db->start_transaction();

        $fleamarket = \Model_Fleamarket::find($data['fleamarket_id']);

        $data['reservation_number'] = sprintf(
            '%05d-%05d',
            $data['fleamarket_id'],
            $fleamarket->reservation_serial
        );

        $condition = array(
            'user_id'                   => $data['user_id'],
            'fleamarket_id'             => $data['fleamarket_id'],
            'fleamarket_entry_style_id' => $data['fleamarket_entry_style_id'],
        );
        $entry = \Model_Entry::findBy($condition);
        if (! $entry) {
            $entry = \Model_Entry::forge();
        }

        $entry->set($data)->save();

        $fleamarket->incrementReservationSerial(false);
        $fleamarket->updateEventReservationStatus(false);
        $fleamarket->save();

        if ($entry->fleamarket_entry_style->isOverReservationLimit('master')) {
            $db->rollback_transaction();
            return false;
        } else {
            $db->commit_transaction();
            return $entry;
        }
    }

    /**
     * entries テーブルへの登録
     *
     * @access private
     * @param
     * @return Model_Entryオブジェクト
     * @author kobayashi
     * @author ida
     */
    public function registerWaitingEntry()
    {
        try {
            $db = \Database_Connection::instance('master');
            $db->start_transaction();

            $fleamarket_entry_style = Model_Fleamarket_Entry_Style::find('first', array(
                'where' => array(
                    'fleamarket_entry_style_id' => \Input::param('fleamarket_entry_style_id'),
                    'fleamarket_id'             => \Input::param('fleamarket_id'),
                )
            ));
            if (! $fleamarket_entry_style) {
                return false;
            }

            $condition = array(
                'user_id'                   => $this->login_user->user_id,
                'fleamarket_id'             => \Input::param('fleamarket_id'),
                'fleamarket_entry_style_id' => \Input::param('fleamarket_entry_style_id'),
            );
            $entry = \Model_Entry::findBy($condition);
            if ($entry) {
                return false;
            }

            $entry = \Model_Entry::forge($condition);
            $entry->set(array(
                'reservation_number' => '',
                'entry_status'       => Model_Entry::ENTRY_STATUS_WAITING,
                'item_category'      => '',
                'item_genres'        => '',
                'reserved_booth'     => 0,
                'link_from'          => '',
                'remarks'            => '',
                'created_user'       => $this->login_user->user_id,
            ));
            $entry->save();

            $db->commit_transaction();
        } catch (\Exceptio $e) {
            $db->rollback_transaction();
        }

        return $entry;
    }

    /**
     * セッションからentryのデータを取得、整形
     *
     * @access private
     * @param
     * @return array entryのデータ
     * @author kobayashi
     * @author ida
     */
    private function getEntryData()
    {
        $input = $this->fieldset->validation()->validated();
        unset($input["updated_user"]);
        unset($input["created_at"]);
        unset($input["updated_at"]);
        unset($input["deleted_at"]);

        if ($input) {
            $item_genres = \Model_Entry::getItemGenres();
            $to_label = function($value) use ($item_genres) {
                return $item_genres[$value];
            };

            $entry_status = \Model_Entry::ENTRY_STATUS_RESERVED;
            $item_genre_names = implode(',', array_map($to_label, $input['item_genres']));
            $link_from = $input['link_from'];

            $input_other = array(
                'user_id'            => $this->login_user->user_id,
                'reservation_number' => '',
                'link_from'          => $link_from,
                'entry_status'       => $entry_status,
                'created_user'       => $this->login_user->user_id,
                'item_genres'        => $item_genre_names,
            );
            $input = array_merge($input, $input_other);
        }

        return $input;
    }

    /**
     * アクションに応じたfieldsetを取得する
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = Session::get_flash('reservation.fieldset');
            if (! $fieldset || (! Session::get_flash('reservation.error'))) {
                $fieldset = $this->createFieldset();
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = Session::get_flash('reservation.fieldset');
        } elseif ($this->request->action == 'waiting' ){
            $fieldset = $this->createFieldset();
        }

        return $fieldset;
    }

    /**
     * fieldsetをInput::allから作成する
     *
     * @access private
     * @param
     * @return Fieldsetオブジェクト
     * @author kobayashi
     */
    private function createFieldset()
    {
        $fieldset = \Model_Entry::createFieldset(\Input::all());
        $fieldset->repopulate();

        return $fieldset;
    }

    public function canReserve()
    {
        return
            $this->login_user->canReserve($this->fleamarket) &&
            $this->fleamarket->canReserve() &&
            (! $this->fleamarket_entry_style->isFullBooth());
    }
}
