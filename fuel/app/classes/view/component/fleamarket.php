<?php

/**
 * Base
 *
 * @author shimma
 */
class View_Component_fleamarket extends ViewModel
{

    public function view()
    {

        $this->fleamarket = $this->addDisplayStrings($this->fleamarket);

        $this->render_status = function($fleamarket) {
            if (! empty($fleamarket['event_status'])) {
                echo 'status' . $fleamarket['event_status'];
            }
        };

        $this->is_official = function($fleamarket) {
            if (! empty($fleamarket['register_type']) ) {
                if ($fleamarket['register_type'] == \Model_Fleamarket::REGISTER_TYPE_ADMIN) {
                    return true;
                }
            }

            return false;
        };

    }

    /**
     * 数字で渡ってくるパラメータを文字列に変換したものを付与します。
     *
     * @access private
     * @return void
     * @author shimma
     */
    public function addDisplayStrings($fleamarket)
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
        if (! empty($fleamarket['fleamarket_entry_style_id'])) {
            $fleamarket['fleamarket_entry_style_name'] = Config::get("master.entry_styles.$fleamarket[fleamarket_entry_style_id]", '-');
        }

        /**
         *  エントリー費用
         *  現在の所、車出店など横に出している
         */
        if (isset($fleamarket['booth_fee']) && isset($fleamarket['fleamarket_entry_style_name'])) {
            $fleamarket['booth_fee_string'] = $this->createFeeString($fleamarket['fleamarket_entry_style_name'], $fleamarket['booth_fee']);
        } else {
            $fleamarket['booth_fee_string'] = 'お問い合わせ';
        }


        //@todo 果たしてfleamarketで丸ごとarrayを渡すのはいいのか確認
        $fleamarket['entry_styles'] = \Model_Fleamarket_Entry_Style::getFleamarketEntryStyle($fleamarket);
        $fleamarket['total_booth'] = \Model_Fleamarket_Entry_Style::getTotalBooth($fleamarket);

        return $fleamarket;
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

        if (! is_numeric($booth_fee) ){
            $fee_string .= '-';
        } else {
            if ( $booth_fee == 0 ) {
                $fee_string .= '無料';
            } else {
                $fee_string .= number_format($booth_fee) . '円';
            }
        }

        return $fee_string;
    }

}
