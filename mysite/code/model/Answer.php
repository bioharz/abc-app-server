<?php

class Answer extends \SilverStripe\ORM\DataObject
{

    private static $db = [
        'Answer'  => 'Varchar(100)' ,
        'Correct' => 'Boolean'
    ];

    private static $has_one = [
        'Question' => 'Question'
    ];

    private static $belongs_many_many = [
        'TestExecutionAnswers' => 'TestExecutionAnswer'
    ];

    private static $summary_fields = [
        'Answer', 'Correct'
    ];

}