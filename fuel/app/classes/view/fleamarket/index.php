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
        $location_fieldset = $this->fieldsets['location'];
        $fleamarket_fieldset = $this->fieldsets['fleamarket'];
        $fleamarket_about_fieldset = $this->fieldsets['fleamarket_about'];

        if (! empty($this->fleamarket)) {
            $fleamarket_fieldset->populate($this->fleamarket);

            $location = $this->getLocation($this->fleamarket['location_id']);
            $location_fieldset->populate($location);
            $this->location_id = $location->location_id;

            $fleamarket_about = $this->getFleamarketAbout($this->fleamarket_id);
            $fleamarket_about_fieldset->populate($fleamarket_about);
            $this->fleamarket_about_id = $fleamarket_about->fleamarket_about_id;
        }

        $this->set('location_fieldset', $this->fieldsets['location'], false);
        $this->set('fleamarket_fieldset', $this->fieldsets['fleamarket'], false);
        $this->set('fleamarket_about_fieldset', $this->fieldsets['fleamarket_about'], false);

        $this->prefectures = \Config::get('master.prefectures');
        $this->image_store_path = '/' . \Config::get('master.image_path.store');
        $this->upload_file_limit = \Model_Fleamarket_Image::UPLOAD_FILE_LIMIT;

        $fleamarket_images = $this->fleamarket_images;
        $this->getFleamarketImageByPriority = function ($priority) use ($fleamarket_images) {
            if (! $fleamarket_images) {
                return null;
            }
            foreach ($fleamarket_images as $fleamarket_image) {
                if ($priority == $fleamarket_image['priority']) {
                    return $fleamarket_image;
                }
            }
        };
    }

    /**
     * 会場情報を取得する
     *
     * @access private
     * @param mixed $location_id 会場ID
     * @return object
     * @author ida
     */
    private function getLocation($location_id)
    {
        $result = \Model_Location::find($location_id);

        return $result;
    }

    /**
     * フリマ説明情報を取得する
     *
     * @access private
     * @param mixed fleamarket_id
     * @return object
     * @author ida
     */
    private function getFleamarketAbout($fleamarket_id)
    {
        $result =\Model_Fleamarket_About::findFirstBy(array(
            'fleamarket_id' => $fleamarket_id,
            'about_id' => \Model_Fleamarket_About::ACCESS
        ));

        return $result;
    }
}
