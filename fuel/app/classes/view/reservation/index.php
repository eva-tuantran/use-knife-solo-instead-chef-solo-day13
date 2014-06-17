<?php

/**
 * View_Search_Index ViewModel
 *
 * @author ida
 */
class View_Reservation_Index extends ViewModel
{
    public function view()
    {
        $fleamarket = $this->fleamarket;

        $reservation_booth_limit = array();
        $remain_booth_list = array();
        foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style) {
            $fleamarket_entry_style_id = $fleamarket_entry_style->fleamarket_entry_style_id;
            $reservation_booth_limit[$fleamarket_entry_style_id] = $fleamarket_entry_style->reservation_booth_limit;
            $remain_booth_list[$fleamarket_entry_style_id] = $fleamarket_entry_style->remainBooth();
        }

        $input  = $this->fieldset->input();
        $errors = $this->fieldset->validation()->error_message();
        $fleamarket_id = $this->fleamarket->fleamarket_id;

        $input_genres = array();
        if ($input['item_genres']) {
            foreach ($input['item_genres'] as $item_genre) {
                $input_genres[$item_genre] = 1;
            }
        }

        $this->set('input', $input, false);
        $this->set('errors', $errors, false);
        $this->set('fleamarket_id', $fleamarket_id, false);
        $this->set('nomail', \Session::get('admin.user.nomail'), false);

        $this->set('input_genres', $input_genres, false);
        $this->set('reservation_booth_limit', $reservation_booth_limit, false);
        $this->set('remain_booth_list', $remain_booth_list, false);
        $this->set('entry_styles', \Config::get('master.entry_styles'), false);
    }
}
