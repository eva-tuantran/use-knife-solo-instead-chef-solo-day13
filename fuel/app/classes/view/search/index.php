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
        $this->title = 'フリーマーケット検索結果';
        $this->setDisplayString();
    }

    /**
     * 表示用の文字列を取得する
     *
     * 出店形態、出店料金、残りブース
     *
     * @access private
     * @return void
     * @author ida
     */
    private function setDisplayString()
    {
        if (! $this->fleamarket_list) {
            return;
        }

        foreach ($this->fleamarket_list as &$fleamarket) {
            $strings = $this->createDisplayStrings($fleamarket);
            list($style_string, $fee_string, $booth_string) = $strings;

            $fleamarket['style_string'] = implode('／' , $style_string);
            $fleamarket['fee_string'] = implode('／' , $fee_string);
            $fleamarket['booth_string'] = implode('／' , $booth_string);
        }
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
                    $entry_style_id,
                    $style_name,
                    $entry_style['reservation_booth_limit']
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
    private function createStyleString($style_name) {
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
    private function createFeeString($style_name, $booth_fee) {
        $fee_string = $style_name . ':';
        $fee_string .= number_format($booth_fee) . '円';

        return $fee_string;
    }

    /**
     * 残りブース数の文字列を生成する
     *
     * @access private
     * @param array $entries 出店予約情報
     * @param string $entry_style_id 出店形態ID
     * @param string $style_name 出店形態名
     * @param int $booth_limit 出店形態別ブース数
     * @author ida
     */
    private function createBoothString(
        &$entries, $entry_style_id, $style_name, $booth_limit
    ) {
        $booth_string = '';
        if (! $entries) {
            return $booth_string;
        }

        foreach ($entries as $entry) {
            if ($entry_style_id !== $entry['fleamarket_entry_style_id']) {
                continue;
            }

            $booth_string = $style_name . ':';
            $booth_number = ($booth_limit - $entry['reserved_booth']);
            $booth_string .= '残り ' . $booth_number . 'ブース';
        }

        return $booth_string;
    }
}
