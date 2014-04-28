<?php

/**
 * View_Admin_Fleamarket_List ViewModel
 *
 * @author ida
 */
class View_Admin_Fleamarket_List extends ViewModel
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
        $this->week_list = \Config::get('master.week');
        $this->entry_styles = \Config::get('master.entry_styles');
        $this->prefectures = \Config::get('master.prefectures');
        $this->event_statuses = \Model_Fleamarket::getEventStatuses();
        $this->register_types = \Model_Fleamarket::getRegisterTypes();
        $this->fleamarket_list = $this->getFleamarketEntryStyle(
            $this->fleamarkets
        );
    }

    /**
     * フリーマーケット情報に紐づくフリーマーケット出店形態情報を取得する
     *
     * @access private
     * @param array $fleamarket_list フリーマーケット情報
     * @return array
     * @author ida
     */
    private function getFleamarketEntryStyle($fleamarket_list = array())
    {
        if (! $fleamarket_list) {
            return false;
        }

        $entry_style_fields = array(
            'field' => array(
                'entry_style_id',
                'booth_fee',
                'max_booth',
                'reservation_booth_limit',
            )
        );

        $result = array();
        foreach ($fleamarket_list as $fleamarket) {
            $fleamarket_entry_styles = \Model_Fleamarket_Entry_Style::find('all', array(
                'where' => array(
                    array('fleamarket_id', $fleamarket['fleamarket_id']),
                ),
                'order_by' => array('entry_style_id'),
            ));
            $results = $this->createReservation(
                $fleamarket_entry_styles
            );

            list($entry_styles, $total_reseved_booth, $total_booth) = $results;
            $fleamarket['total_reseved_booth'] = $total_reseved_booth;
            $fleamarket['total_booth'] = $total_booth;
            $fleamarket['entry_styles'] = $entry_styles;
            $result[] = $fleamarket;
        }

        return $result;
    }

    /**
     * フリーマーケット出店形態情報を取得する
     *
     * @access private
     * @param array $fleamarket_entry_styles フリーマーケット出店形態情報
     * @return array
     * @author ida
     */
    private function createReservation($fleamarket_entry_styles = array())
    {
        $result = array();
        $total_booth = 0;
        $total_reseved_booth = 0;

        if ($fleamarket_entry_styles) {
            foreach ($this->entry_styles as $entry_style_id => $entry_style_name) {
                $reseved_booth = 0;
                foreach ($fleamarket_entry_styles as $entry_style) {
                    if ($entry_style_id == $entry_style['entry_style_id']) {
                        if (0 < ($sum_reserved_booth = $entry_style->sumReservedBooth())) {
                            $reseved_booth = $sum_reserved_booth;
                            $total_reseved_booth += $sum_reserved_booth;
                        }
                        $entry_style['reseved_booth'] = (int) $reseved_booth;
                        $total_booth += (int) $entry_style['max_booth'];
                        break;
                    }
                }
                $result[] = $entry_style;
            }
        }

        return array(
            $result, $total_reseved_booth, $total_booth,
        );
    }
}