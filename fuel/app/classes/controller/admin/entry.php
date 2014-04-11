<?php
/**
 * 
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_Entry extends Controller_Admin_Base_Template
{
    public function action_list()
    {
        $view = View::forge('admin/entry/list');

        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
        if ($fleamarket) {
            $view->set('fleamarket', $fleamarket, false);
        }
        
        $this->template->content = $view;
    }
}
