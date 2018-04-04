<?php

class TestAdmin extends \SilverStripe\Admin\ModelAdmin
{

    private static $managed_models = [
        'Test'
    ];

    private static $url_segment = 'tests';
    private static $menu_title = 'Tests';

}