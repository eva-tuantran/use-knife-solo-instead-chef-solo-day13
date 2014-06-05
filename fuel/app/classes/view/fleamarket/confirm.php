<?php

/**
 * fleamarket confirm ViewModel
 *
 * @author ida
 */
class View_Fleamarket_Confirm extends ViewModel
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
        $fleamarket_images = \Model_Fleamarket_Image::findByFleamarketId(
            $this->fleamarket_id
        );

        $this->set('location_fieldset', $this->fieldsets['location'], false);
        $this->set('fleamarket_fieldset', $this->fieldsets['fleamarket'], false);
        $this->set('fleamarket_about_fieldset', $this->fieldsets['fleamarket_about'], false);
        $this->set('fleamarket_images', $fleamarket_images, false);

        $this->prefectures = \Config::get('master.prefectures');
        $this->image_store_path = '/' . \Config::get('master.image_path.temporary_user');
        $this->image_temporary_path = '/' . \Config::get('master.image_path.temporary_user');
        $this->upload_file_limit = \Model_Fleamarket_Image::UPLOAD_FILE_LIMIT;

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
}
