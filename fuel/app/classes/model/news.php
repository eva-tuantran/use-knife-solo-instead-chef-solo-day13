<?php

/**
 * 新着ニュース表示モデル
 *
 * @author shimma
 * @todo 他にもrssフィード取得増えるタイミングで抽象化させる
 * @todo rssのfeedの取得先をconfigに移動
 */
class Model_News extends \Model
{

    public static function getHeadlines($page = 1, $row_count = 5)
    {
        //@todo: ここを適切なconfigに移動する
        $rss_url = 'http://www.rakuichi-rakuza.jp/blog/feed/';

        /**
         * 以前rss経由で表示が止まってしまうことがあったので非同期通信の処理を他プロジェクトからコピー
         * curlで代替できるような気はするので、調査する必要あり
         */
        try {
            $ch = curl_init();

            $options = array(
                CURLOPT_URL             => $rss_url,
                CURLOPT_HEADER          => false,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_MAXREDIRS       => 1,
                CURLOPT_TIMEOUT         => 5,
                CURLOPT_CONNECTTIMEOUT  => 5,
            );
            curl_setopt_array($ch, $options);

            $rss = curl_exec($ch);
            $curl_info = curl_getinfo($ch);
            curl_close($ch);

            if ($curl_info['http_code'] == 200 && $curl_info['size_download'] > 0) {
                $control_code = array(
                    "\x00", "\x01", "\x02", "\x03", "\x04",
                    "\x05", "\x06", "\x07", "\x08", "\x0b",
                    "\x0c", "\x0e", "\x0f"
                );
                $rss = str_replace($control_code, '', $rss);
                $xml = simplexml_load_string($rss, 'SimpleXMLElement');
            }
        } catch (Exception $e) {
            return array();
        }

        $feed = array();
        if (! empty($xml)) {
            $count = 1;
            foreach ($xml->channel->item as $item) {
                $feed[] = array(
                    'title' => strval($item->title),
                    'url'   => strval($item->link),
                    'date'  => date('Y年m月d日', strtotime(strval($item->pubDate))),
                );

                if ($count >= $row_count) {
                    break;
                }
                $count++;
            }
        }

        return $feed;
    }
}
