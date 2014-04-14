<?php

/**
 * fleamarket index ViewModel
 *
 * @author ida
 */
class View_Fleamarket_Index extends ViewModel
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
        $fleamarket = array();
        $fleamarket_about = array();
        $location = array();
        if (! empty($this->fleamarket_id)) {
            $fleamarket = \Model_Fleamarket::findByUserId(
                $this->fleamarket_id, $this->user_id
            )->to_array();

            $fleamarket_about = \Model_Fleamarket_About::findFirstBy(array(
                'fleamarket_id' => $this->fleamarket_id,
                'about_id' => \Model_Fleamarket_About::ACCESS
            ))->to_array();

            $location = \Model_Location::find(
                $fleamarket['location_id']
            )->to_array();
        }
        $fleamarket = array_merge($this->fleamarket, $fleamarket);
        $fleamarket_about = array_merge(
            $this->fleamarket_about, $fleamarket_about
        );
        $location = array_merge($this->location, $location);

        $this->fleamarket = $fleamarket;
        $this->fleamarket_about = $fleamarket_about;
        $this->location = $location;
        $this->prefectures = Config::get('master.prefectures');
    }
}
