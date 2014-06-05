<?php

/**
 * Location Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Location extends Controller_Base_Template
{
    public function before()
    {
        parent::before();
    }

    /**
     * 会場詳細
     *
     * @access public
     * @param mixed $location_id 会場ID
     * @param mixed $fleamarket_id フリマID
     * @return void
     * @author ida
     */
    public function action_detail($location_id = null, $fleamarket_id = null)
    {
        if (! $location_id) {
            return $this->forward('errors/notfound', 404);
        }

        \Asset::css('jquery-ui.min.css', array(), 'add_css');
        \Asset::js('jquery-ui.min.js', array(), 'add_js');

        // 会場に紐づくフリマを取得する
        $fleamarket_date_list = \Model_Fleamarket::find('all',
            array(
                'select' => array('fleamarket_id', 'event_date'),
                'where' => array(
                    array('location_id' => $location_id)
                ),
                'order_by' => array('event_date' => 'asc')
            )
        );

        if (! $location_id || ! $fleamarket_date_list) {
            \Response::redirect('errors/notfound');
        }

        if (! $fleamarket_id) {
            $first_fleamarket = end($fleamarket_date_list);
            $fleamarket_id = $first_fleamarket['fleamarket_id'];
        }

        $fleamarket = \Model_Fleamarket::findDetail($fleamarket_id);
        if (! $fleamarket) {
            \Response::redirect('errors/notfound');
        }

        $fleamarket_abouts = \Model_Fleamarket_About::findByFleamarketId(
            $fleamarket_id
        );

        $fleamarket_images = \Model_Fleamarket_Image::findByFleamarketId(
            $fleamarket_id
        );

        $entry_styles = \Model_Fleamarket_Entry_Style::findByFleamarketId(
            $fleamarket_id
        );

        $view_model = \ViewModel::forge('location/detail');
        $view_model->set('fleamarket', $fleamarket, false);
        $view_model->set('fleamarket_date_list', $fleamarket_date_list, false);
        $view_model->set('fleamarket_images', $fleamarket_images, false);
        $view_model->set('fleamarket_abouts', $fleamarket_abouts, false);
        $view_model->set(
            'fleamarket_entry_styles', $entry_styles, false
        );
        $view_model->set(
            'prefectures', \Config::get('master.prefectures'), false
        );
        $view_model->set('user', $this->login_user, false);

        $this->template->content = $view_model;
    }
}
