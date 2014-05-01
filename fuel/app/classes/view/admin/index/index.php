<?php

/**
 * View_Admin_Index_Index ViewModel
 *
 * @author ida
 */
class View_Admin_Index_Index extends \ViewModel
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
        $this->new_member_count = $this->getNewMemberCount();
    }

    /**
     * 新規会員数
     */
    public function getNewMemberCount()
    {
        $date = \Date::forge(strtotime('- 1 day'));
        $field = \DB::expr("DATE_FORMAT(created_at, '%Y-%m-%d')");

        $query = \Model_User::query();
        $query->where($field, $date->format('%Y-%m-%d'));
        $count = $query->count();

        return $count;
    }
}
