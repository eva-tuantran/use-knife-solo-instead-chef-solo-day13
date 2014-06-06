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
        $this->mm_member_count = $this->getMailMagazieCount();
    }

    /**
     * 新規会員数
     *
     * @access private
     * @param
     * @return int
     * @author ida
     */
    private function getNewMemberCount()
    {
        $date = \Date::forge(strtotime('- 1 day'));
        $field = \DB::expr("DATE_FORMAT(created_at, '%Y-%m-%d')");

        $query = \Model_User::query();
        $query->where($field, $date->format('%Y-%m-%d'));
        $count = $query->count();

        return $count;
    }

    /**
     * 新規会員数
     *
     * @access private
     * @param
     * @return int
     * @author ida
     */
    private function getMailMagazieCount()
    {
        $query = \Model_User::query();
        $query->where(array(
            array('mm_flag', \Model_User::MM_FLAG_OK),
            array('register_status', 'IN', array(
                \Model_User::REGISTER_STATUS_INACTIVATED,
                \Model_User::REGISTER_STATUS_ACTIVATED,
            ))
        ));
        $count = $query->count();

        return $count;
    }
}
