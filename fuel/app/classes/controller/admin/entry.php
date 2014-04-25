<?php
/**
 * 
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_Entry extends Controller_Admin_Base_Template
{
    public function action_list()
    {
        $view = View::forge('admin/entry/list');
        $this->template->content = $view;

        $total = Model_Entry::findByKeywordCount(
            Input::all()
        );

        Pagination::set_config(array(
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => 50,
            'total_items'    => $total,
            'name'           => 'pagenation',
        ));

        $entries = Model_Entry::findByKeyword(
            Input::all(),
            Pagination::get('per_page'),
            Pagination::get('offset')
        );
        
        $view->set('entries', $entries, false);

        if (Input::param('fleamarket_id')) {
            $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
            $view->set('fleamarket', $fleamarket, false);
        }

        if (Input::param('user_id')) {
            $user = Model_User::find(Input::param('user_id'));
            $view->set('user', $user, false);
        }
    }

    public function action_csv()
    {
        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
        $csv = Lang::load('admin/csv');

        $data = array($csv['header']);

        $prefectures = Config::get('master.prefectures');
        $entry_styles = Config::get('master.entry_styles');

        foreach ($fleamarket->entries as $entry) {

            if ($entry->user && $entry->fleamarket_entry_style) {
                $data[] = array(
                    $fleamarket->created_at,
                    $fleamarket->event_date,
                    $fleamarket->location->name,
                    $entry->user->user_id,
                    $entry->reservation_number,
                    $entry_styles[$entry->fleamarket_entry_style->entry_style_id],
                    $entry->user->last_name . $entry->user->first_name,
                    $entry->user->zip,
                    $prefectures[$entry->user->prefecture_id],
                    $entry->user->address,
                    $entry->user->email,
                    $entry->user->mobile_email
                );
            }
        }
        return $this->response_csv($data);
    }

    protected function response_csv($data)
    {
        $csv = mb_convert_encoding(
            Format::forge($data)->to_csv(),
            'SJIS-win',
            'UTF-8'
        );

        $response = new Response($csv, 200, array(
            'Content-Type'        => 'application/csv',
            'Content-Disposition' => 'attachment; filename="hoge.csv"',
        ));

        return $response;
    }

    public function action_index()
    {
        $view = View::forge('admin/entry/index');
        $this->template->content = $view;
    }
}
