<?php

class Model_Contact extends Model_Base
{
    protected static $_primary_key = array('contact_id');

    protected static $_properties = array(
        'contact_id' => array(
            'label' => 'contact_id',
        ),
        'user_id' => array(
            'label' => 'user_id',
        ),
        'inquiry_type' => array(
            'label' => 'お問い合わせの種類',
            'validation' => array(
                'required',
                'numeric_min' => array(1),
                'numeric_max' => array(4),
                'valid_string' => array('numeric')
            ),
        ),
        'inquiry_datetime' => array(
            'label' => 'inquiry_datetime',
        ),
        'subject' => array(
            'label' => '件名',
            'validation' => array(
                'required',
                'max_length' => array(50),
            ),
        ),
        'email' => array(
            'label' => 'メールアドレス',
            'validation' => array(
                'required',
                'valid_email',
                'max_length' => array(255),
            ),
        ),
        'tel' => array(
            'label' => '電話番号',
            'validation' => array(
                'max_length' => array(20),
            ),
        ),
        'contents' => array(
            'label' => '内容',
            'validation' => array(
                'required',
            ),
        ),
        'last_name' => array(
            'label' => '名前',
            'validation' => array(
                'max_length' => array(50),
            ),
        ),
        'first_name' => array(
            'label' => '名前',
            'validation' => array(
                'max_length' => array(50),
            ),
        ),
        'created_at',
        'updated_at',
        'deleted_at',
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property' => 'created_at',
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => true,
            'property' => 'updated_at',
        ),
        'Orm\Observer_Contact',
    );
    protected static $_table_name = 'contacts';

    /*
     * お問い合わせの種類 の名前定義
     *
     * @access protected
     */
    protected static $inquiry_type_label_define = array(
        1 => '楽市楽座について',
        2 => 'フリーマーケットについて',
        3 => '楽市楽座のウェブサイトについて',
        4 => 'そのほかのお問い合わせについて',
    );

    /*
     * お問い合わせの種類の番号から名前に変換する
     *
     * @param  int (お問い合わせ種類)
     * @access public
     * @return string
     */
    public static function inquiry_type_to_label($inquiry_type)
    {
        return self::$inquiry_type_label_define[$inquiry_type];
    }

    /*
     * お問い合わせの種類の名前を返す
     *
     * @access public
     * @return string
     */
    public function inquiry_type_label()
    {
        return self::inquiry_type_to_label($this->inquiry_type);
    }

    /*
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @return string
     */
    public static function createFieldset()
    {
        $contact = self::forge();
        $fieldset = Fieldset::forge();
        $fieldset->add_model($contact);
        $fieldset->add('email2', 'メールアドレス確認用')
            ->add_rule('required')
            ->add_rule('match_field', 'email');

        return $fieldset;
    }
}
