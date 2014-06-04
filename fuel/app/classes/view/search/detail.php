<?php

/**
 * View_Search_Detail ViewModel
 *
 * @author ida
 */
class View_Search_Detail extends ViewModel
{
    /**
     * view method
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        $fleamarket = $this->getFleamarketEntryStyle($this->fleamarket);
        $fleamarket['abouts'] = $this->createAbouts();
        $this->fleamarket = $fleamarket;
        $this->week_list = \Config::get('master.week');
        $this->event_statuses = \Model_Fleamarket::getEventStatuses();
        $this->entry_styles = \Config::get('master.entry_styles');
        $this->image_files = $this->createFileNames($this->fleamarket_images);
        $this->image_path = '/' . \Config::get('master.image_path.store');
    }

    private function createFileNames($images)
    {
        $result = array();
        if (! $images) {
            return $result;
        }

        foreach ($images as $image) {
            $result[] = $image['file_name'];
        }

        return $result;
    }

    /**
     * フリーマーケット情報に紐づくフリーマーケット出店形態情報を取得する
     *
     * @access private
     * @param array $fleamarket フリーマーケット情報
     * @return array
     * @author ida
     */
    private function getFleamarketEntryStyle($fleamarket)
    {
        if (! $fleamarket) {
            return false;
        }

        $entry_style_fields = array(
            'field' => array(
                'entry_style_id',
                'booth_fee',
                'max_booth',
                'reservation_booth_limit',
            )
        );
        $entry_styles = \Model_Fleamarket_Entry_Style::findByFleamarketId(
            $fleamarket['fleamarket_id'], $entry_style_fields
        );
        $fleamarket['entry_styles'] = $entry_styles;

        $total_reserved_booth = 0;
        $entry = \Model_Entry::getTotalEntryByFleamarketId(
            $fleamarket['fleamarket_id'], false
        );
        if ($entry) {
            $total_reserved_booth = $entry[0]['reserved_booth'];
        }
        $fleamarket['total_reserved_booth'] = $total_reserved_booth;

        return $fleamarket;
    }

    /**
     * フリーマーケット説明情報を説明IDをキーにした配列に置き換える
     *
     * @param array $fleamarket
     * @return array
     * @author ida
     */
    private function createAbouts()
    {
        $abouts = array();

        if (count($this->fleamarket_abouts) > 0) {
            $fleamarket_abouts = Config::get('master.fleamarket_abouts');

            $abouts = array();
            foreach ($this->fleamarket_abouts as $about) {
                if (! isset($about['about_id'])) {
                    continue;
                }

                $abouts[$about['about_id']] = array(
                    'title' => $about['title'],
                    'description' => $about['description']
                );
            }
        }

        return $abouts;
    }
}
