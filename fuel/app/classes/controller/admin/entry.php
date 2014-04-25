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
        $view->set('item_categories', \Model_Entry::getItemCategoryDefine());
        $view->set('entry_statuses', \Model_Entry::getEntryStatuses());
        $view->set('total', $total);
        $this->template->content = $view;
    }

    public function action_csv()
    {
        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
        $csv = Lang::load('admin/csv');

        $data = array($csv['header']);

        $prefectures = Config::get('master.prefectures');
        $entry_styles = Config::get('master.entry_styles');
        $entry_statuses = \Model_Entry::getEntryStatuses();

        foreach ($fleamarket->entries as $entry) {
            if ($entry->user && $entry->fleamarket_entry_style) {
                $prefecture_id = $entry->user->prefecture_id;
                if (! isset($prefectures[$prefecture_id])) {
                    $prefecture_name = '-';
                } else {
                    $prefecture_name = $prefectures[$prefecture_id];
                }
                $data[] = array(
                    $fleamarket->created_at,
                    $fleamarket->event_date,
                    $fleamarket->name,
                    $entry->user->user_id,
                    $entry->reservation_number,
                    $entry_styles[$entry->fleamarket_entry_style->entry_style_id],
                    $entry->user->last_name . $entry->user->first_name,
                    $entry->user->zip,
                    $prefecture_name,
                    $entry->user->address,
                    $entry->user->email,
                    $entry->user->mobile_email,
                    $entry_statuses[$entry->entry_status]
                );
            }
        }

        return $this->response_csv($data, $fleamarket->name);
    }

    protected function response_csv($data, $fleamarket_name)
    {
        $csv = mb_convert_encoding(
            Format::forge($data)->to_csv(),
            'SJIS-win',
            'UTF-8'
        );

        $file_name = $fleamarket_name . '_エントリ一覧.csv';
        $response = new Response($csv, 200, array(
            'Content-Type'        => 'application/csv',
            'Content-Disposition' => 'attachment; filename="' . $file_name . '"',
        ));

        return $response;
    }

    public function action_index()
    {
        $view = View::forge('admin/entry/index');
        $this->template->content = $view;
    }
}
