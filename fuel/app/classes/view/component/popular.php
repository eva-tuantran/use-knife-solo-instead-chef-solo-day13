<?php

/**
 * View_Top_Popular ViewModel
 *
 * @author ida
 */
class View_Component_Popular extends ViewModel
{
    /**
     * 1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 3;

    /**
     * view method
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        $fleamarket_list = \Model_Fleamarket::findPopular(
            $this->result_per_page
        );

        $fleamarket_list = $this->getFleamarketRelatedData($fleamarket_list);
        $fleamarket_list = $this->setItemsForDisplay($fleamarket_list);
        $this->fleamarket_list = $fleamarket_list;
    }

    /**
     * 表示用の文字列を取得する
     *
     * 出店形態、出店料金、残りブース
     *
     * @access private
     * @param array $fleamarket_list フリーマーケット情報
     * @return void
     * @author ida
     */
    private function setItemsForDisplay($fleamarket_list)
    {
        if (! $fleamarket_list) {
            return;
        }

        $result = array();
        foreach ($fleamarket_list as $fleamarket) {
            $strings = $this->createDisplayStrings($fleamarket);
            list($style_list, $fee_list, $booth_list) = $strings;

            $fleamarket['style_string'] = implode('／' , $style_list);
            $fleamarket['fee_string'] = implode('／' , $fee_list);
            $fleamarket['booth_string'] = implode('／' , $booth_list);
            $result[] = $fleamarket;
        }

        return $result;
    }

    /**
     * フリーマーケット情報に紐づくフリーマーケット出店形態情報を取得する
     *
     * @access private
     * @param array $fleamarket_list フリーマーケット情報
     * @return array
     * @author ida
     */
    private function getFleamarketRelatedData($fleamarket_list)
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

            $entries = \Model_Entry::getTotalEntryByFleamarketId(
                $fleamarket['fleamarket_id']
            );
            $fleamarket['entries'] = $entries;
            $result[] = $fleamarket;
        }

        return $result;
    }

    /**
     * 表示用の文字列を生成する
     *
     * 出店形態、出店料金、残りブース
     *
     * @access private
     * @return array
     * @author ida
     */
    private function createDisplayStrings($fleamarket)
    {
        $style_list = array();
        $fee_list = array();
        $booth_list = array();

        if ($fleamarket['entry_styles']) {
            $entry_styles = Config::get('master.entry_styles');

            foreach ($fleamarket['entry_styles'] as &$entry_style) {
                if (! isset($entry_style['entry_style_id'])) {
                    continue;
                }

                $entry_style_id = $entry_style['entry_style_id'];
                $style_name = $entry_styles[$entry_style_id];

                $style_list[] = $this->createStyleString($style_name);

                $fee_list[] = $this->createFeeString(
                    $style_name, $entry_style['booth_fee']
                );

                $booth_list[] = $this->createBoothString(
                    $fleamarket['entries'],
                    $entry_style,
                    $style_name
                );
            }
        }

        return array($style_list, $fee_list, $booth_list);
    }

    /**
     * 出店予約できる出店形態の文字列を生成する
     *
     * @access private
     * @param string $style_name 出店形態名
     * @author ida
     */
    private function createStyleString($style_name)
    {
        return $style_name;
    }

    /**
     * 出店予約できる出店形態ごと出店料金の文字列を生成する
     *
     * @access private
     * @param string $style_name 出店形態名
     * @param int $booth_fee 出店料金
     * @author ida
     */
    private function createFeeString($style_name, $booth_fee)
    {
        $fee_string = $style_name . ':';
        $fee_string .= number_format($booth_fee) . '円';

        return $fee_string;
    }

    /**
     * 残りブース数の文字列を生成する
     *
     * @access private
     * @param array $entries 出店予約情報
     * @param array $entry_style 出店形態
     * @param string $style_name 出店形態名
     * @author ida
     */
    private function createBoothString($entries, $entry_style, $style_name)
    {
        $booth_string = '';
        if (! $entries) {
            $booth_string = $style_name . ':' . $entry_style['max_booth'];
        } else {
            $entry_style_id = $entry_style['entry_style_id'];
            foreach ($entries as $entry) {
                if ($entry_style_id !== $entry['fleamarket_entry_style_id']) {
                    continue;
                }

                $max_booth = $entry_style['max_booth'];
                $reserved_booth = $entry['reserved_booth'];
                $booth_string = $style_name . ':';
                $booth_number = $max_booth - $reserved_booth;
                $booth_string .= '残り ' . $booth_number;
            }
        }

        return $booth_string;
    }
}