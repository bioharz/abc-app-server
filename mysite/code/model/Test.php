<?php

class Test extends \SilverStripe\ORM\DataObject
{

    private static $db = [
        'Title' => 'Varchar(100)' ,
        'Code'  => 'Varchar(10)'
    ];

    private static $many_many = [
        'Questions' => 'Question'
    ];

    protected function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (empty($this->Code)) {
            $this->Code = substr(md5(time()), 0, 10);
        }
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Code')->setDisabled(true);

        return $fields;
    }

    public function formatQuestions()
    {
        $questions = [];

        foreach ($this->Questions() as $idx => $question) {

            $questions[$idx]['question'] = [
                'id' => $question->ID ,
                'question' => $question->Question
            ];
            $questions[$idx]['answers'] = [];

            foreach ($question->Answers() as $answer) {
                $questions[$idx]['answers'][] = [
                    'id' => $answer->ID ,
                    'answer' => $answer->Answer
                ];
            }
        }

        return $questions;
    }

}