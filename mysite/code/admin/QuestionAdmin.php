<?php

class QuestionAdmin extends \SilverStripe\Admin\ModelAdmin
{

    private static $managed_models = [
        'Question'
    ];

    private static $url_segment = 'questions';
    private static $menu_title = 'Questions';

}