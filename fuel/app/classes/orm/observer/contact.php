<?php 

namespace Orm;

class Observer_Contact extends Observer
{
    public function before_insert(Model $contact)
    {
        $contact->inquiry_datetime = \Date::forge()->format('mysql');
    }
    public function after_load(Model $contact)
    {
        $contact->inquiry_type_label = \Model_Contact::inquiry_type_to_label($contact->inquiry_type);
    }
}
