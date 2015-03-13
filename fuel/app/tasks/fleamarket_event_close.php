<?php
namespace Fuel\Tasks;

/**
 * Fleamarket_Event_Close class
 *
 * 開催日が過ぎたフリーマーケットのevent_statusを更新する
 *
 * @author ida
 */
class Fleamarket_Event_Close
{
    /**
     * メイン
     *
     * 以下の条件にあてはまるフリーマーケットの
     * 開催状況(event_status)を4:開催終了に更新する
     *  開催日(task実行日の前日)
     *  開催終了時間(23:59:59未満)
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function run()
    {
        $fleamarkets = $this->getFleamarkets();

        if ($fleamarkets) {
            foreach ($fleamarkets as $fleamarket) {
                $fleamarket->event_status = \Model_Fleamarket::EVENT_STATUS_CLOSE;
                $fleamarket->save();
            }
        }
    }

    /**
     * 対象のフリマを取得
     *
     * @access private
     * @return Model_Fleamarket array
     */
    private function getFleamarkets()
    {
        $target_event_statuses = array(
            \Model_Fleamarket::EVENT_STATUS_SCHEDULE,
            \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT,
            \Model_Fleamarket::EVENT_STATUS_RECEIPT_END
        );

        $date = \Date::forge(strtotime('- 1 day'));
        $fleamarkets = \Model_Fleamarket::find('all', array(
            'select' => array('fleamarket_id', 'event_status'),
            'where' => array(
                array(
                    'event_date', '<=', $date->format('mysql'),
                ),
                array(
                    'register_type', '=', \Model_Fleamarket::REGISTER_TYPE_ADMIN,
                ),
                array(
                    'event_time_end', '<=', $date::time()->format('mysql'),
                ),
                array(
                    'event_status', 'IN', $target_event_statuses,
                ),
            ),
        ));

        return $fleamarkets;
    }
}
