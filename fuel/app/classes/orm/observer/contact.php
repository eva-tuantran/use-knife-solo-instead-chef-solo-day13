<?php 

namespace Orm;

class Observer_Contact extends Observer
{
    public function before_insert(Model $contact)
    {
        $contact->inquiry_datetime = \Date::forge()->format('mysql');
    }
}
