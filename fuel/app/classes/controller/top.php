<?php

/**
 * トップページ
 *
 * @ida
 */
class Controller_Top extends Controller_Base_Template
{
    public function before()
    {
        parent::before();
    }

    public function action_in()
    {
        $db = \Database_Connection::instance('master');
        for ($i = 202000; $i < 207000; $i++) {
        $sql = <<< "SQL"
INSERT INTO `users` VALUES (
    {$i},NULL,'てすと','新間','楽市','シンマ','ラクイチ',NULL,1,'160-0001',13,'渋谷区道玄坂1-14-6 ヒューマックス渋谷ビル6階','03-1212-1212','','shimma+{$i}@aucfan.com','',0,1,NULL,NULL,NULL,NULL,'16nrX3dJVQ209+hKgM/j0HSn1WSaAhq3hgiuYyZsOwg=','',0,1,'2014-06-11 16:57:32',NULL,NULL,'0000-00-00 00:00:00','2014-06-11 16:57:32',NULL);
SQL;
            $statement = $db->query(\DB::INSERT, $sql, false);
        }

        $db = \Database_Connection::instance('master');
        for ($i = 207000; $i < 210000; $i++) {
        $sql = <<< "SQL"
INSERT INTO `users` VALUES (
    {$i},NULL,'てすと','新間','楽市','シンマ','ラクイチ',NULL,1,'160-0001',13,'渋谷区道玄坂1-14-6 ヒューマックス渋谷ビル6階','03-1212-1212','','shimma+{$i}@aucfan.com','',0,1,NULL,NULL,NULL,NULL,'16nrX3dJVQ209+hKgM/j0HSn1WSaAhq3hgiuYyZsOwg=','',0,1,'2014-06-11 16:57:32',NULL,NULL,'0000-00-00 00:00:00','2014-06-11 16:57:32',NULL);
SQL;
            $statement = $db->query(\DB::INSERT, $sql, false);
        }

        var_dump('complete');
        exit;
    }

    /**
     * トップページ
     *
     * @access public
     * @return void
     * @author ida
     * @author shimma
     */
    public function action_index()
    {
        $view_model = ViewModel::forge('top/index');

        $view_model->set('news_headlines', \Model_News::getHeadlines());
        $view_model->set(
            'upcomming', \ViewModel::forge('component/upcomming'), false
        );
        $view_model->set(
            'calendar', \ViewModel::forge('component/calendar'), false
        );
        $view_model->set(
            'popular_ranking', \ViewModel::forge('component/popular'), false
        );
        $view_model->set(
            'latest', \ViewModel::forge('component/latest'), false
        );

        Asset::js('jquery.carouFredSel.js', array(), 'add_js');
        Asset::js('jquery.rwdImageMaps.min.js', array(), 'add_js');
        Asset::js('top.js', array(), 'add_js');
        Asset::css('top.css', array(), 'add_css');

        $this->template->content = $view_model;
    }
}
