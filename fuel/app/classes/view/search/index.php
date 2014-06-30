<?php

/**
 * View_Search_Index ViewModel
 *
 * @author ida
 */
class View_Search_Index extends ViewModel
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
        $fleamarket_list = $this->getFleamarketEntryStyle(
            $this->fleamarket_list
        );
        $this->fleamarket_list = $fleamarket_list;
        $this->week_list = \Config::get('master.week');
        $this->entry_styles = \Config::get('master.entry_styles');
        $this->regions = \Config::get('master.regions');
        $this->image_path = '/' . \Config::get('master.image_path.store');
        $this->prefectures = \Config::get('master.prefectures');
        $this->getAreaName = function ($area) {
            $result = null;

            if (false !== ($key = array_search($area, \Config::get('master.alphabet_regions')))) {
                $regions = \Config::get('master.regions');
                $result = $regions[$key];
            } elseif (false !== ($key = array_search($area, \Config::get('master.alphabet_prefectures')))) {
                $prefectures = \Config::get('master.prefectures');
                $result = $prefectures[$key];
            }

            return $result;
        };
        $this->getExplain  = function () use ($fleamarket_list) {
            $result = array();
            foreach ($fleamarket_list as $fleamarket) {
                $result[] = $fleamarket['location_name'];
            }

            if (! empty($result)) {
                $result = array_slice(array_unique($result, SORT_STRING), 0, 5);
            }

            return $result;
        };
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
            $entry_styles = \Model_Fleamarket_Entry_Style::findByFleamarketId(
                $fleamarket['fleamarket_id'], $entry_style_fields
            );
            $fleamarket['entry_styles'] = $entry_styles;

            $total_reserved_booth = 0;
            $entry = \Model_Entry::getTotalEntryByFleamarketId(
                $fleamarket['fleamarket_id'], false
            );
            if ($entry) {
                $total_reserved_booth = $entry[0]['reserved_booth'];
            }
            $fleamarket['total_reserved_booth'] = $total_reserved_booth;

            $result[] = $fleamarket;
        }

        return $result;
    }
}
