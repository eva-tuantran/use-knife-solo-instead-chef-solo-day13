<?php

/**
 * View_Component_Popular ViewModel
 *
 * 人気のフリーマーケットランキング
 *
 * @author ida
 */
class View_Component_Popular extends ViewModel
{
    /**
     * 取得する件数
     *
     * @var int
     */
    private $result_number = 3;

    /**
     * view method
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        if (isset($this->number) && is_int($this->number)) {
            $this->result_number = $this->number;
        }

        $fleamarket_list = \Model_Fleamarket::findPopular(
            $this->result_number
        );
        $fleamarket_list = $this->getFleamarketEntryStyle($fleamarket_list);
        // $fleamarket_list = \Model_Fleamarket_Entry_Style::getFleamarketEntryStyle($fleamarket_list);

        $this->fleamarket_list = $fleamarket_list;
        $this->week_list = \Config::get('master.week');
        $this->entry_styles = \Config::get('master.entry_styles');
        $this->image_path = '/' . \Config::get('master.image_path.store');
    }

    /**
     * フリーマーケット情報に紐づくフリーマーケット出店形態情報を取得する
     *
     * @access private
     * @param array $fleamarket_list フリーマーケット情報
     * @return array
     * @author ida
     */
    private function getFleamarketEntryStyle($fleamarket_list)
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

            $result[] = $fleamarket;
        }

        return $result;
    }
}
