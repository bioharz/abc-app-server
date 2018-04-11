<?php

class TestExecutionAnswer extends \SilverStripe\ORM\DataObject
{
    private static $summary_fields = [
        'TestExecutionQuestion.Question'
    ];

    private static $has_one = [
        'TestExecution' => 'TestExecution' ,
        'TestExecutionQuestion' => 'Question'
    ];

    private static $many_many = [
        'TestExecutionAnswers' => 'Answer'
    ];
}
