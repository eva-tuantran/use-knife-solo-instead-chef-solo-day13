<?php

/**
 * View_Search_Detail ViewModel
 *
 * @author ida
 */
class View_Search_Detail extends ViewModel
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
        $this->title = '開催情報概要';
        $this->setItemsForDisplay();
    }

    /**
     * 表示用に加工する
     *
     * @access private
     * @return void
     * @author ida
     */
    private function setItemsForDisplay()
    {
        if (empty($this->fleamarket)) {
            return;
        }

        // フリーマーケット説明情報をabout_idをキーに
        $this->fleamarket['abouts'] = $this->createAbouts();

        // 出店形態、出店料金、残りブース
        $entry_style_strings = $this->createEntryStyleStrings();
        list($style_list, $fee_list, $booth_list) = $entry_style_strings;
        $this->fleamarket['style_string'] = implode('／' , $style_list);
        $this->fleamarket['fee_string'] = implode('／' , $fee_list);
        $this->fleamarket['booth_string'] = implode('／' , $booth_list);
    }

    /**
     * フリーマーケット説明情報を説明IDをキーにした配列に置き換える
     *
     * @param array $fleamarket
     * @return array
     * @author ida
     */
    private function createAbouts()
    {
        $abouts = array();

        if (count($this->fleamarket['fleamarket_abouts']) > 0) {
            $fleamarket_abouts = Config::get('master.fleamarket_abouts');

            $abouts = array();
            foreach ($this->fleamarket['fleamarket_abouts'] as &$about) {
                if (! isset($about['about_id'])) {
                    continue;
                }

                $abouts[$about['about_id']] = array(
                    'title' => $about['title'],
                    'description' => $about['description']
                );
            }
        }

        return $abouts;
    }

    /**
     * 表示用の文字列を生成する
     *
     * 出店形態、出店料金、残りブース
     *
     * @access private
     * @param array $fleamarket フリーマーケット情報
     * @return array
     * @author ida
     */
    private function createEntryStyleStrings()
    {
        $style_list = array();
        $fee_list = array();
        $booth_list = array();

        if (count($this->fleamarket['entry_styles']) > 0) {
            $entry_styles = Config::get('master.entry_styles');

            foreach ($this->fleamarket['entry_styles'] as &$entry_style) {
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
                    $this->fleamarket['entries'],
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
     * @return string
     * @author ida
     */
    private function createBoothString(
        &$entries, $entry_style_id, $style_name, $booth_limit
    ) {
        if (count($entries) == 0) {
            return;
        }

        foreach ($entries as $entry) {
            if ($entry_style_id != $entry['fleamarket_entry_style_id']) {
                continue;
            }

            $booth_string = $style_name . ':';
            $booth_number = ($booth_limit - $entry['reserved_booth']);
            $booth_string .= '残り ' . $booth_number . 'ブース';
        }

        return $booth_string;
    }
}