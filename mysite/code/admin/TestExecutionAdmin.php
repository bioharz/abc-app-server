<?php

class TestExecutionAdmin extends \SilverStripe\Admin\ModelAdmin
{

    private static $managed_models = [
        'TestExecution'
    ];

    private static $url_segment = 'executions';
    private static $menu_title = 'Test Executions';

}