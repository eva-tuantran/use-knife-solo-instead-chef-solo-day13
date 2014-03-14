<?php

class model_contact extends \Orm\Model
{
    protected static $_primary_key = array('contact_id');

    protected static $_properties = array(
        'contact_id' => array(
            'label' => 'contact_id',
            'form'  => array(
                'type' => false,
            ),
        ),
        'user_id' => array(
            'label' => 'user_id',
            'form'  => array(
                'type' => false,
            ),
        ),
        'inquiry_type' => array(
            'label' => 'お問い合わせの種類',
            'validation' => array(
                'required',
                'numeric_min' => array(1),
                'numeric_max' => array(4),
                'valid_string' => array('numeric')
            ),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    '1' => '楽市楽座について',
                    '2' => 'フリーマーケットについて',
                    '3' => '楽市楽座のウェブサイトについて',
                    '4' => 'そのほかのお問い合わせ',
                ),
            ),
        ),
        'inquiry_datetime' => array(
            'label' => 'inquiry_datetime',
            'form' => array(
                'type' => false,
            ),
        ),

        'subject' => array(
            'label' => '件名',
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'required',
                'max_length' => array(50),
            ),
        ),
        'email' => array(
            'label' => 'メールアドレス',
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'required',
                'valid_email',
                'max_length' => array(255),
            ),
        ),
        'tel' => array(
            'label' => '電話番号',
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'max_length' => array(20),
            ),
        ),
        'contents' => array(
            'label' => '内容',
            'form' => array(
                'type' => 'textarea',
                'cols' => '80',
                'rows' => '10',
            ),
            'validation' => array(
                'required',
            ),
        ),
/*
        'last_name' => array(
            'label' => '姓',
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'max_length' => array(50),
            ),
        ),
        'first_name' => array(
            'label' => '名',
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'max_length' => array(50),
            ),
        ),
*/
        'created_user' => array(
            'form' => array(
                'type' => false,
            ),
        ),
        'updated_user' => array(
            'form' => array(
                'type' => false,
            ),
        ),
        'created_at' => array(
            'form' => array(
                'type' => false,
            ),
        ),
        'updated_at' => array(
            'form' => array(
                'type' => false,
            ),
        ),
        'deleted_at' => array(
            'form' => array(
                'type' => false,
            ),
        ),
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

    public static function to_inquiry_type_label($inquiry_type)
    {
        $properties = self::properties();

        return $properties['inquiry_type']['form']['options'][$inquiry_type];
    }

    public function inquiry_type_label()
    {
        return self::to_inquiry_type_label($this->inquiry_type);
    }
}
