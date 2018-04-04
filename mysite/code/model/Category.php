<?php

class Category extends \SilverStripe\ORM\DataObject
{

    private static $db = [
        'Title' => 'Varchar(100)'
    ];

    private static $has_many = [
        'Questions' => 'Question'
    ];

}