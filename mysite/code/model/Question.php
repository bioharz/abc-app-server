<?php

class Question extends \SilverStripe\ORM\DataObject
{

    private static $db = [
        'Question' => 'Varchar(100)'
    ];

    private static $has_one = [
        'Category' => 'Category'
    ];

    private static $has_many = [
        'Answers' => 'Answer'
    ];

    private static $summary_fields = [
        'Question'
    ];

    public function getTitle() {
        return $this->getField('Question');
    }

}
