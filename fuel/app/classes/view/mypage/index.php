<?php

/**
 * View_Mypage_Index ViewModel
 *
 * @author shimma
 */
class View_Mypage_Index extends ViewModel
{

    /**
     * view method
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function view()
    {
        foreach ($this->entries as &$entry) {
            $this->addDisplayStrings($entry);
        }
        unset($entry);


        foreach ($this->mylists as &$mylist) {
            $this->addDisplayStrings($mylist);
        }
        unset($mylist);


        foreach ($this->myfleamarkets as &$myfleamarket) {
            $this->addDisplayStrings($myfleamarket);
        }
        unset($myfleamarket);

        $this->flagcheck = function($flag) {
            if (! $flag) {
                echo "off";
            }
        };
    }

    /**
     * 数字で渡ってくるパラメータを文字列に変換したものを付与します。
     *
     * @access private
     * @return void
     * @author shimma
     */
    public function addDisplayStrings(&$entry)
    {
        /**
         * エントリースタイル名
         * '1' => '手持ち出店',
         * '2' => '手持ち出店（プロ）',
         * '3' => '車出店',
         * '4' => '車出店（プロ）',
         * '5' => '企業手持ち出店',
         * '6' => '企業車出店',
         * '7' => '飲食店',
         */
        if (isset($entry['fleamarket_entry_style_id'])) {
            $entry['fleamarket_entry_style_name'] = Config::get("master.entry_styles.$entry[fleamarket_entry_style_id]", '-');
        }

        /**
         *  エントリー費用
         *  現在の所、車出店など横に出している
         */
        if (isset($entry['booth_fee']) && isset($entry['fleamarket_entry_style_name'])) {
            $entry['booth_fee_string'] = $this->createFeeString($entry['fleamarket_entry_style_name'], $entry['booth_fee']);
        } else {
            $entry['booth_fee_string'] = '未設定';
        }

    }


    /**
     * 出店予約できる出店形態ごと出店料金の文字列を生成する
     *
     * @access private
     * @param string $style_name 出店形態名
     * @param int $booth_fee 出店料金
     * @author ida
     * @author shimma
     *
     * @todo searchからcopyして持ってきたのでどこかviewのhelperでまとめたい
     */
    private function createFeeString($style_name, $booth_fee)
    {
        // $fee_string = $style_name . ':';
        $fee_string = '';

        if ( $booth_fee == 0 ) {
            $fee_string .= '無料';
        } else {
            $fee_string .= number_format($booth_fee) . '円';
        }

        return $fee_string;
    }

}
