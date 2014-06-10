<?php

/**
 * View_Admin_Fleamarket_Index ViewModel
 *
 * @author ida
 */
class View_Admin_Fleamarket_Index extends \ViewModel
{
    /**
     * view method
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        $this->fleamarket_id = \Input::param('fleamarket_id');
        $this->prefectures = \Config::get('master.prefectures');
        $this->entry_styles = \Config::get('master.entry_styles');
        $this->event_statuses = \Model_Fleamarket::getEventStatuses();
        $this->locations = \Model_Location::find('all');
        $this->link_from_list = $this->getLinkFromList();
    }

    /**
     * 反響項目を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getLinkFromList()
    {
        if (! empty($this->fleamarket_id)) {
            $link_from_list = $this->fieldsets['fleamarket']->field('link_from_list');
            $result = \Model_Fleamarket::explodeLinkFromList($link_from_list->value);
        } else {
            $result = \Model_Entry::getLinkFromList();
        }

        return $result;
    }
}
