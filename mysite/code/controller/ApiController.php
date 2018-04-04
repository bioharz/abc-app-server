<?php

class ApiController extends \SilverStripe\Control\Controller
{
    public function index() {
        $code = $this->getRequest()->param('code');

        $this->getResponse()->addHeader('Access-Control-Allow-Origin', '*');
        $this->getResponse()->addHeader('Content-type', 'application/json');

        if ($this->getRequest()->isPOST()) {
            return $this->createTest();
        } elseif ($this->getRequest()->isGET()) {
            return $this->retrieveTest($code);
        }
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
