<?php
use \Controller\Base_Template;

/**
 * Controller_Fleamarket_Latest.
 *
 * 最新のフリマ
 *
 * @extends  Controller_Base_Template
 */
class Controller_Fleamarket_Latest extends Controller_Base_Template
{
    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 10;

    public function before()
    {
        parent::before();
    }

    /**
     * 最新のフリマ画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function get_index()
    {
        $fleamarket_list = \Model_Fleamarket::findLatest(
            $this->result_per_page
        );

        if ($fleamarket_list) {
            $fleamarket_list = $this->setRemainingBooth($fleamarket_list);
        }

        $data = array(
            'fleamarket_list' => $fleamarket_list,
            'event_statuses' => \Model_Fleamarket::getEventStatuses(),
            'prefectures' => \Config::get('master.prefectures'),
        );

        return new Response(View::forge('fleamarket/latest/index', $data));
    }

    /**
     * 残りブース数を取得する
     *
     * @access private
     * @param array $fleamarket_list フリーマーケット情報
     * @return array
     * @author ida
     */
    private function setRemainingBooth($fleamarket_list)
    {
        $result = array();
        foreach ($fleamarket_list as $fleamarket) {
            $fleamarket_id = $fleamarket['fleamarket_id'];
            $entry_styles =
                \Model_Fleamarket_Entry_Style::getMaxBoothByFleamarketId(
                    $fleamarket_id, false
                );

            $max_booth = 0;
            if (isset($entry_styles[0]['max_booth'])) {
                $max_booth = $entry_styles[0]['max_booth'];
            }

            $fleamarket['max_booth'] = $max_booth;
            $result[] = $fleamarket;
        }

        return $result;
    }
}