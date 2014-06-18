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
            throw new \SystemException(\Model_Error::ER00501);
        }

        $input = $this->fieldset->input();
        $fleamarket = \Model_Fleamarket::find($input['fleamarket_id']);

        if (! $fleamarket) {
            throw new \SystemException(\Model_Error::ER00501);
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
        $fleamarket_id = $this->fleamarket->fleamarket_id;
        $has_empty_booth = \Model_Fleamarket::hasEmptyBooth($fleamarket_id);
        $can_reserve = $this->canReserve($fleamarket_id, $has_empty_booth);

        $view_model = \ViewModel::forge('reservation/index');
        $view_model->set('fieldset', $this->fieldset, false);
        $view_model->set('fleamarket', $this->fleamarket, false);
        $view_model->set('user', $this->login_user, false);
        $view_model->set('item_categories', \Model_Entry::getItemCategories(), false);
        $view_model->set('item_genres', \Model_Entry::getItemGenres(), false);

        $view_model->set('has_empty_booth', $has_empty_booth, false);
        $view_model->set('can_reserve', $can_reserve, false);
        $this->template->content = $view_model;
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
        \Session::set_flash('reservation.fieldset', $this->fieldset);

        $fleamarket_id = $this->fleamarket->fleamarket_id;
        $has_empty_booth = \Model_Fleamarket::hasEmptyBooth($fleamarket_id);
        $can_reserve = $this->canReserve($fleamarket_id, $has_empty_booth);

        if (! $can_reserve || ! $this->fieldset->validation()->run()) {
            \Session::set_flash('cannot_reserve', true);
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
        if (! \Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        $fleamarket_id = $this->fleamarket->fleamarket_id;
        $has_empty_booth = \Model_Fleamarket::hasEmptyBooth($fleamarket_id);
        $can_reserve = $this->canReserve($fleamarket_id, $has_empty_booth);

        if (! $can_reserve) {
            \Response::redirect('reservation');
        }

        $data = $this->getEntryData();
        if (! $data) {
            throw new \SystemException(\Model_Error::ER00502);
        }

        try {
            $db = \Database_Connection::instance('master');
            $db->start_transaction();

            $entry = $this->registerEntry($data);
            if (! $entry) {
                throw new \SystemException(\Model_Error::ER00503);
            }

            $db->commit_transaction();
        } catch (\Exception $e) {
            $db->rollback_transaction();
            throw new \SystemException(\Model_Error::ER00504);
        }

        if ($entry){
            try {
                $entry->sendmail($this->login_user);
            } catch (\Exception $e) {
                throw new \SystemException(\Model_Error::ER00507);
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
        if (! \Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        try {
            $entry = $this->registerWaitingEntry();
        } catch (\Exception $e) {
            throw new \SystemException(\Model_Error::ER00505);
        }

        if ($entry){
            try {
                $entry->sendmail($this->login_user);
            } catch (\Exception $e) {
                throw new \SystemException(\Model_Error::ER00508);
            }
        } elseif (! $entry) {
            throw new \SystemException(\Model_Error::ER00506);
        }

        $view = \View::forge('reservation/waiting');
        $view->set('entry', $entry, false);
        $this->template->content = $view;
    }

    /**
     * 出店予約判定
     *
     * @access private
     * @param mixed $fleamarket_id フリマID
     * @param bool $is_booth_empty 空きブース
     * @return bool
     * @author ida
     */
    private function canReserve($fleamarket_id, $has_empty_booth)
    {
        $result = $this->fleamarket->canReserve();

        if ($this->login_user->hasReserved($fleamarket_id)) {
            $result = false;
        } elseif ($this->login_user->hasWaiting($fleamarket_id)) {
            if ($has_empty_booth) {
                $result = true;
            } else {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * 出店予約情報の登録
     *
     * @access private
     * @param array $data 登録データ
     * @return object
     * @author kobayashi
     * @author ida
     */
    private function registerEntry($data)
    {
        // 予約番号の採番
        $data['reservation_number'] = $this->fleamarket->makeReservationNumber();

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

        $this->fleamarket->updateEventReservationStatus(false);
        $this->fleamarket->save();

        if ($entry->fleamarket_entry_style->isOverReservationLimit('master')) {
            return false;
        } else {
            return $entry;
        }
    }

    /**
     * 出店予約情報の登録
     *
     * @access private
     * @param
     * @return object
     * @author kobayashi
     * @author ida
     */
    private function registerWaitingEntry()
    {
        $fleamarket_id = \Input::post('fleamarket_id');
        $fleamarket_entry_style_id = \Input::post('fleamarket_entry_style_id');

        $fleamarket_entry_style = \Model_Fleamarket_Entry_Style::find('first', array(
            'where' => array(
                'fleamarket_entry_style_id' => $fleamarket_entry_style_id,
                'fleamarket_id'             => $fleamarket_id,
            )
        ));
        if (! $fleamarket_entry_style) {
            return false;
        }

        $condition = array(
            'user_id'                   => $this->login_user->user_id,
            'fleamarket_id'             => $fleamarket_id,
            'fleamarket_entry_style_id' => $fleamarket_entry_style_id,
        );
        $entry = \Model_Entry::findBy($condition);

        if ($entry) {
            $entry->set(array(
                'entry_status' => Model_Entry::ENTRY_STATUS_WAITING,
                'updated_user' => $this->login_user->user_id,
            ));
        } else {
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
        }
        $entry->save();

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
     * フィールドセットを入力データから作成する
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
}
