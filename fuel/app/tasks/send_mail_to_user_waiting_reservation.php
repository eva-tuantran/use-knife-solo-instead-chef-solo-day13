<?php
namespace Fuel\Tasks;

  /**
   * キャンセル待ちユーザーメール送信task
   *
   * @author kobayasi
   */
class send_mail_to_user_waiting_reservation
{
    /**
     * メイン
     *
     */
    public function run()
    {
        $fleamarkets = $this->getFleamarkets();
        foreach ($fleamarkets as $fleamarket) {
            $fleamarket_entry_styles = $fleamarket->fleamarket_entry_styles;
            foreach ($fleamarket_entry_styles as $fleamarket_entry_style) {
                $this->sendMailByFleamarketEntryStyle($fleamarket, $fleamarket_entry_style);
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
        $fleamarkets = \Model_Fleamarket::query()
            ->where(
                array('event_date',\DB::expr('ADDDATE(CURDATE(),INTERVAL 7 DAY)'))
            )
            ->get();
        return $fleamarkets;
    }

    /**
     * Model_Fleamarket_Entry_Style ごとにメールを送信
     *
     * @access private
     * @param Model_Fleamarket, Model_Fleamarket_Entry_Style
     * @return Model_Fleamarket array
     */
    private function sendMailByFleamarketEntryStyle($fleamarket, $fleamarket_entry_style)
    {
        if (! $fleamarket_entry_style->isNeedWaiting()){
            $entries = $fleamarket_entry_style->getWaitingEntry();
            foreach ($entries as $entry) {
                $this->sendMailToUser(array(
                    'fleamarket'             => $fleamarket, 
                    'fleamarket_entry_style' => $fleamarket_entry_style,
                    'entry'                  => $entry
                ));
            }
        }
    }
    
    /**
     * ユーザーにメールを送信
     *
     * @access private
     * @param array
     * @return bool
     */
    private function sendMailToUser($args)
    {
        $email = new \Model_Email();

        $params = array();
        foreach ($args as $key => $value) {
            foreach (array_keys($value->properties()) as $column) {
                $params["{$key}.{$column}"] = $value->get($column);
            }
        }

        try {
            $email->sendMailByParams(
                'send_mail_to_user_waiting_reservation',
                $params,
                $args['entry']->user->email
            );
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
