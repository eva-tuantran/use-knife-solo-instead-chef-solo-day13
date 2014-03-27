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

    /**
     * 事前処理
     *
     * アクション実行前の共通処理
     *
     * @access public
     * @return void
     * @author ida
     */
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
        $fleamarket_list = \Model_Fleamarket::findByLatest(
            $this->result_per_page
        );

        if ($fleamarket_list) {
            $this->setRemainingBooth($fleamarket_list);
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
     * @return void
     * @author ida
     */
    private function setRemainingBooth(&$fleamarket_list)
    {
        foreach ($fleamarket_list as &$fleamarket) {
            $fleamarket_id = $fleamarket['fleamarket_id'];
            $entries = \Model_Entry::getTotalEntryByFleamarketId(
                $fleamarket_id, false
            );
            $entry_styles = \Model_Fleamarket_Entry_Style::getMaxBoothByFleamarketId(
                $fleamarket_id, false
            );

            $reserved_booth = 0;
            if (isset($entries[0]['reserved_booth'])) {
                $reserved_booth = $entries[0]['reserved_booth'];
            }

            $max_booth = 0;
            if (isset($entry_styles[0]['max_booth'])) {
                $max_booth = $entry_styles[0]['max_booth'];
            }

            $fleamarket['remaining_booth'] = ($max_booth - $reserved_booth);
        }
    }
}