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
        $rss_url = 'http://aucfan.com/article/feed/';

        /**
         * 以前rss経由で表示が止まってしまうことがあったので非同期通信の処理を他プロジェクトからコピー
         * curlで代替できるような気はするので、調査する必要あり
         */
        $rfd = fopen($rss_url, 'r');
        stream_set_blocking($rfd, true);
        stream_set_timeout($rfd, 5);
        $data = stream_get_contents($rfd);
        $status = stream_get_meta_data($rfd);
        fclose($rfd);

        if (! $status['timed_out']) {
            $xml = simplexml_load_string($data);
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
