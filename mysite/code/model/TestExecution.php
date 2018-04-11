<?php

use SilverStripe\ORM\DataObject;

class TestExecution extends DataObject
{
    private static $summary_fields = ['Test.Title', 'Person'];
    private static $searchable_fields = ['Test.Title'];

    private static $db = [
        'Person'  => 'Varchar(30)' ,
        'Code'    => 'Varchar(10)'
    ];

    private static $has_one = [
        'Test' => 'Test'
    ];

    private static $has_many = [
        'TestExecutionAnswers' => 'TestExecutionAnswer'
    ];

    /**
     * @param $code
     * @return TestExecution | null
     */
    public static function findTestExecutionByCode($code)
    {
        $testExecution = TestExecution::get()
                            ->filter('Code', $code)
                            ->first();

        if ($testExecution) {
            return $testExecution;
        }

        return null;
    }

    public static function findTestExecution($person, $testId)
    {
        $testExecution = TestExecution::get()
            ->filter([
                'Person' => $person ,
                'TestID' => $testId
            ])
            ->first();

        if ($testExecution) {
            return $testExecution;
        }

        return null;
    }

    public function saveQuestionWithAnswers($questionId, array $answerIds) {
        $answer = TestExecutionAnswer::get()
            ->filter([
                'TestExecutionID' => $this->ID ,
                'TestExecutionQuestionID' => $questionId
            ])->first();

        if (!$answer) {
            $answer = TestExecutionAnswer::create();
            $answer->TestExecutionID = $this->ID;
            $answer->TestExecutionQuestionID = $questionId;
            $answer->write();
        } else {
            $answer->TestExecutionAnswers()->removeAll();
        }

        foreach ($answerIds as $answerId) {
            $a = Answer::get()->byID($answerId);

            if ($a) {
                $answer->TestExecutionAnswers()->add($a);
            }
        }
    }

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
        $fields->dataFieldByName('Person')->setDisabled(true);

        return $fields;
    }

}