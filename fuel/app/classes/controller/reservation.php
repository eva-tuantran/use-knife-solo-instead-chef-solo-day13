<?php
/**
 * フリマ予約
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
            throw new SystemException(\Model_Error::ER00601);
        }

        $input = $this->fieldset->input();
        $fleamarket = Model_Fleamarket::find($input['fleamarket_id']);

        if (! $fleamarket) {
            throw new SystemException(\Model_Error::ER00601);
        }
        $this->fleamarket = $fleamarket;

        if ($input['fleamarket_entry_style_id']) {
            $this->fleamarket_entry_style = 
                Model_Fleamarket_Entry_Style::find('first',array(
                    'where' => array(
                        'fleamarket_entry_style_id' => $input['fleamarket_entry_style_id'],
                        'fleamarket_id'             => $input['fleamarket_id'],
                    )));
        }
    }

    /**
     * 初期画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_index()
    {
        $view = View::forge('reservation/index');
        $view->set('fieldset', $this->fieldset, false);
        $view->set('fleamarket', $this->fleamarket, false);
        $view->set('user', $this->login_user, false);
        $this->template->content = $view;
    }

    /**
     * 確認画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function post_confirm()
    {
        Session::set_flash('reservation.fieldset',$this->fieldset);

/*
        //var_dump($this->fleamarket->event_status             == Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT);exit;
        var_dump($this->fleamarket->event_reservation_status != Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL);exit;

        var_dump($this->fleamarket->canReserve());exit;
        var_dump($this->canReserve());exit;
*/
        if (! $this->fieldset->validation()->run() ||
            ! $this->canReserve()){
            Session::set_flash('reservation.error', true);
            return Response::redirect('reservation');
        }
        
        if (! $this->fleamarket_entry_style) {
            throw new SystemException(\Model_Error::ER00601);
        }

        $view = View::forge('reservation/confirm');
        $view->set('fieldset', $this->fieldset, false);
        $view->set('fleamarket_entry_style',$this->fleamarket_entry_style);

        $this->template->content = $view;
    }

    /**
     * 完了画面
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
            return \Response::redirect('errors/doubletransmission');
        }

        if (! $this->canReserve()){
            return Response::redirect('reservation');
        }

        try {
            $entry = $this->registerEntry();
        } catch (Exception $e) {
            throw new SystemException(\Model_Error::ER00603);
        }
        if ($entry && ! Session::get('admin.user.nomail')){
            try {
                $this->sendMailToUser($entry);
            } catch (Exception $e) {
                throw new SystemException(\Model_Error::ER00604);
            }
        }

        $view = \View::forge('reservation/thanks');
        $view->set('entry', $entry, false);
        $this->template->content = $view;
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
    private function registerEntry()
    {
        $data = $this->getEntryData();
        if (! $data) {
            throw new SystemException(\Model_Error::ER00605);
        } else {
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

        if ($input) {
            $item_genres_define = \Model_Entry::getItemGenresDefine();
            $to_label = function($value) use ($item_genres_define) {
                return $item_genres_define[$value];
            };

            $user_id = Auth::get_user_id();
            $entry_status = Model_Entry::ENTRY_STATUS_RESERVED;
            $item_genres = implode(',', array_map($to_label, $input['item_genres']));

            $input_other = array_merge($input, array(
                'user_id'            => $user_id,
                'reservation_number' => '',
                'link_from'          => '',
                'entry_status'       => $entry_status,
                'created_user'       => $user_id,
                'updated_user'       => $user_id,
                'item_genres'        => $item_genres,
            ));
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

    /**
     * ユーザーにメールを送信
     *
     * @access private
     * @para $entry
     * @return void
     * @author kobayashi
     */
    private function sendMailToUser($entry)
    {
        $params = array();

        $objects = array(
            'entry'                  => $entry,
            'fleamarket'             => $entry->fleamarket,
            'fleamarket_entry_style' => $entry->fleamarket_entry_style,
            'user'                   => $entry->user,
            'location'               => $entry->fleamarket->location,
        );

        $fleamarket_abouts = array();
        foreach ($entry->fleamarket->fleamarket_abouts as $fleamarket_about) {
            $fleamarket_abouts[$fleamarket_about->about_id] = $fleamarket_about;
        }

        foreach (Model_Fleamarket_About::getAboutTitles() as $id => $title){
            if (isset($fleamarket_abouts[$id])) {
                $objects["fleamarket_about_${id}"] = $fleamarket_abouts[$id];
            }else{
                $params["fleamarket_about_${id}.description"] = '';
            }
        }

        foreach ($objects as $name => $obj) {
            foreach (array_keys($obj->properties()) as $column) {
                $params["${name}.${column}"] = $obj->get($column);
            }
        }

        $entry_styles = Config::get('master.entry_styles');
        $params['fleamarket_entry_style.entry_style_name']
            = $entry_styles[$entry->fleamarket_entry_style->entry_style_id];

        $params['fleamarket_entry_styles.entry_style_name']
            = implode('/',array_map(function($obj) use ($entry_styles){
                        return $entry_styles[$obj->entry_style_id];
                    },$entry->fleamarket->fleamarket_entry_styles));

        $params['fleamarket_entry_styles.fee']
            = implode('/',array_map(function($obj) use ($entry_styles){
                        return sprintf('%s:%d円',$entry_styles[$obj->entry_style_id],$obj->booth_fee);
                    },$entry->fleamarket->fleamarket_entry_styles));

        foreach (array('fleamarket.event_time_start','fleamarket.event_time_end') as $column) {
            $params[$column] = substr($params[$column],0,5);
        }

        if ($entry->entry_status == Model_Entry::ENTRY_STATUS_RESERVED) {
            $this->login_user->sendmail("reservation" , $params);
        } elseif ($entry->entry_status == Model_Entry::ENTRY_STATUS_WAITING) {
            $this->login_user->sendmail("waiting" , $params);
        }
    }

    private function get_user_id()
    {
        return Auth::get_user_id();
    }

    public function post_waiting()
    {
        if (! Security::check_token()) {
            return \Response::redirect('errors/doubletransmission');
        }

        try {
            $entry = $this->registerWaitingEntry();
        } catch (Exception $e) {
            throw $e;
            throw new SystemException(\Model_Error::ER00603);
        }
        if ($entry && ! Session::get('admin.user.nomail')){
            try {
                $this->sendMailToUser($entry);
            } catch (Exception $e) {
                throw $e;
                throw new SystemException(\Model_Error::ER00604);
            }
        } elseif (! $entry) {
            throw new SystemException(\Model_Error::ER00603);
        }

        $view = \View::forge('reservation/waiting');
        $view->set('entry', $entry, false);
        $this->template->content = $view;
    }

    public function registerWaitingEntry()
    {
        $db = \Database_Connection::instance('master');
        $db->start_transaction();

        $fleamarket_entry_style = 
            Model_Fleamarket_Entry_Style::find('first',array(
                'where' => array(
                    'fleamarket_entry_style_id' => Input::param('fleamarket_entry_style_id'),
                    'fleamarket_id'             => Input::param('fleamarket_id'),
                )));
        if (! $fleamarket_entry_style) {
            return false;
        }
                
        $condition = array(
            'user_id'                   => $this->login_user->user_id,
            'fleamarket_id'             => Input::param('fleamarket_id'),
            'fleamarket_entry_style_id' => Input::param('fleamarket_entry_style_id'),
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
            'updated_user'       => $this->login_user->user_id,
        ));
        $entry->save();

        $db->commit_transaction();
        return $entry;
    }

    public function canReserve()
    {
        return 
            $this->login_user->canReserve($this->fleamarket) &&
            $this->fleamarket->canReserve() &&
            (! $this->fleamarket_entry_style->isFullBooth());
    }
}
