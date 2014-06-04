<?php

/**
 * View_Component_Fleamarket ViewModel
 *
 * @author shimma
 * @author ida
 *
 */
class View_Component_Fleamarket extends \ViewModel
{
    public function view()
    {
        $this->fleamarket = $this->addInformation($this->fleamarket);
        $this->week_list = \Config::get('master.week');

        $render_status = '';
        if (! empty($this->fleamarket['event_status'])) {
            $render_status = 'status' . $this->fleamarket['event_status'];
        }
        $this->render_status = $render_status;

        $is_official = false;
        if (! empty($this->fleamarket['register_type'])) {
            if ($this->fleamarket['register_type'] == \Model_Fleamarket::REGISTER_TYPE_ADMIN) {
                $is_official = true;
            }
        }
        $this->is_official = $is_official;
        $this->image_path = '/' . \Config::get('master.image_path.store');
    }

    /**
     * 数字で渡ってくるパラメータを文字列に変換したものを付与します。
     *
     * @access private
     * @return void
     * @author shimma
     * @author ida
     */
    public function addInformation($fleamarket)
    {
        //@todo 果たしてfleamarketで丸ごとarrayを渡すのはいいのか確認
        $fleamarket['entry_styles'] = $this->getFleamarketEntryStyle(
            $fleamarket['fleamarket_id']
        );
        $fleamarket['total_booth'] = $this->getTotalBooth($fleamarket);

        if (! empty($fleamarket['entry_styles'])) {
            $entry_styles = \Config::get('master.entry_styles');

            $entry_style_name = array();
            $booth_fee = array();
            foreach ($fleamarket['entry_styles'] as $entry_style) {
                $entry_style_id = $entry_style['entry_style_id'];
                $entry_style_name_list[] = $entry_styles[$entry_style_id];
                $booth_fee_list[] = $this->createFeeString(
                    $entry_style['booth_fee']
                );
            }

            $fleamarket['entry_style_name_list'] = $entry_style_name_list;
            $fleamarket['booth_fee_list'] = $booth_fee_list;
        }

        return $fleamarket;
    }


    /**
     * フリーマーケット情報に紐づくフリーマーケット出店形態情報を取得する
     *
     * @access private
     * @param array $fleamarket フリーマーケット情報
     * @return array
     * @author shimma
     * @author ida
     */
    private function getFleamarketEntryStyle($fleamarket_id)
    {
        if (empty($fleamarket_id)) {
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

        $result = \Model_Fleamarket_Entry_Style::findByFleamarketId(
            $fleamarket_id, $entry_style_fields
        );

        return $result;
    }

    /**
     * フリマのトータルブース数を取得します
     *
     * @param mixed $fleamarkets
     * @access private
     * @return void
     * @author shimma
     */
    private function getTotalBooth($fleamarket)
    {
        $total_booth = 0;
        if (! empty($fleamarket['entry_styles'])) {
            foreach ($fleamarket['entry_styles'] as $entry_style) {
                $total_booth += $entry_style['max_booth'];
            }
        }

        return $total_booth;
    }

    /**
     * 出店予約できる出店形態ごと出店料金の文字列を生成する
     *
     * @access private
     * @param string $style_name 出店形態名
     * @param int $booth_fee 出店料金
     * @author ida
     * @author shimma
     */
    private function createFeeString($booth_fee, $style_name = null)
    {
        // $fee_string = $style_name . ':';
        $fee_string = '';

        if ($booth_fee > 0) {
            $fee_string .= number_format($booth_fee) . '円';
        } else {
            $fee_string .= '無料';
        }

        return $fee_string;
    }
}
