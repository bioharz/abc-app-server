<?php

class ApiController extends \SilverStripe\Control\Controller
{
    public function index() {
        $code = $this->getRequest()->param('code');
        $response = $this->getResponse();

        if ($this->getRequest()->isPOST()) {
            $response = $this->createTest();
        } elseif ($this->getRequest()->isGET()) {
            $response = $this->retrieveTest($code);
        } elseif ($this->getRequest()->isPUT()) {
            $response = $this->saveTest($code);
        }

        $response->addHeader('Content-type', 'application/json');
        $response->addHeader('Access-Control-Allow-Origin', $this->getRequest()->getHeader('Origin'));
        $response->addHeader('Access-Control-Allow-Headers', '*');
        $response->addHeader('Access-Control-Allow-Methods', '*');
        $response->addHeader('Access-Control-Max-Age', '86400');

        return $response;
    }

    protected function saveTest($code) {
        $response = [];

        try {
            $testExecution = TestExecution::findTestExecutionByCode($code);
            $answers = json_decode($this->getRequest()->getBody(), true);

            foreach ($answers as $questionId => $answerIds) {
                $testExecution->saveQuestionWithAnswers($questionId, $answerIds);
            }
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(400);
            $response['error'] = 'Wrong or missing data';
        }

        $this->getResponse()->setBody(json_encode($response));
        return $this->getResponse();
    }

    protected function retrieveTest($code) {
        $response = [];

        try {
            $testExecution = TestExecution::findTestExecutionByCode($code);

            if ($testExecution) {
                $response['person']    = $testExecution->Person;
                $response['title']     = $testExecution->Test()->Title;
                $response['questions'] = $testExecution->Test()->formatQuestions();
            } else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(400);
            $response['error'] = 'Wrong or missing data';
        }

        $this->getResponse()->setBody(json_encode($response));
        return $this->getResponse();
    }

    protected function createTest() {
        $response = [];

        try {
            $body = json_decode($this->getRequest()->getBody(), true);
            $test = Test::get()->filter('Code', $body['code'])->first();
            $person = $body['person'];

            if ($test && !empty($person)) {
                $testExecution = TestExecution::findTestExecution($person, $test->ID);

                if (!$testExecution) {
                    $testExecution = TestExecution::create();
                    $testExecution->Person = $person;
                    $testExecution->TestID = $test->ID;
                    $testExecution->write();
                }

                $response['code'] = $testExecution->Code;
            } else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(400);
            $response['error'] = 'Wrong or missing data';
        }

        $this->getResponse()->setBody(json_encode($response));
        return $this->getResponse();
    }

}
