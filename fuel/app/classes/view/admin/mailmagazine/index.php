<?php

/**
 * View_Admin_Mailmagazine_Index ViewModel
 *
 * @author ida
 */
class View_Admin_Mailmagazine_Index extends \ViewModel
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
        $this->prefectures = \Config::get('master.prefectures');
        $this->mail_magazine_types = \Model_Mail_Magazine::getMailMagazinTypes();
        $this->reservation_fleamarket_list = $this->getReservationFleamarket();
        $this->waiting_fleamarket_list = $this->getWaitingFleamarket();
    }

    /**
     * 出店予約可能のフリマ一覧を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getReservationFleamarket()
    {
        $term = array(
            \DB::expr('CURDATE()'),
            \DB::expr('CURDATE() + INTERVAL 1 MONTH')
        );

        return \Model_Fleamarket::getReservationFleamarket($term);
    }

    /**
     * キャンセル待ちフリマ一覧を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getWaitingFleamarket()
    {
        $result = array();

        $waiting_count_list = \Model_Fleamarket::getWaitingFleamarket();

        if ($waiting_count_list->count() > 0) {
            $reserved_count_list = \Model_Fleamarket::getReservedFleamarket();
            $max_booth_list = \Model_Fleamarket::getFleamarketMaxBooth();

            foreach ($waiting_count_list as $waiting_count) {
                foreach ($reserved_count_list as $reserved_count) {
                    if ($waiting_count->fleamarket_id == $reserved_count->fleamarket_id) {
                        foreach ($max_booth_list as $max_booth) {
                            if ($waiting_count->fleamarket_id == $max_booth->fleamarket_id
                                && ($max_booth->max_booth - $reserved_count->reserved_count) > 0
                            ) {
                                $result[] = $waiting_count;
                                continue 2;
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }
}
