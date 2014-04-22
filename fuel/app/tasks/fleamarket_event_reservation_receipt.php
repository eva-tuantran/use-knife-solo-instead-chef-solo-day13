<?php
namespace Fuel\Tasks;

/**
 * Fleamarket_Event_Reservation_Receipt class
 *
 * 出店予約が開始されるフリーマーケットのevent_statusを更新する
 *
 * @author ida
 */
class Fleamarket_Event_Reservation_Receipt
{
    /**
     * メイン
     *
     * 以下の条件にあてはまるフリーマーケットの
     * 開催状況(event_status)を2:予約受付中に更新する
     *  予約開始日(task実行日)
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
                $fleamarket->event_status = \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT;
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
        );

        $date = \Date::forge(strtotime('- 1 day'));
        $fleamarkets = \Model_Fleamarket::find('all', array(
            'select' => array('fleamarket_id', 'event_status'),
            'where' => array(
                array(
                    'reservation_start', '<=', $date->format('mysql')
                ),
                array(
                    'event_status', 'IN', $target_event_statuses,
                ),
                array(
                    'register_type', '=', \Model_Fleamarket::REGISTER_TYPE_ADMIN,
                ),
            ),
        ));

        return $fleamarkets;
    }
}
