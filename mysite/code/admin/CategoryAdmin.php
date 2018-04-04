<?php

class CategoryAdmin extends \SilverStripe\Admin\ModelAdmin
{

    private static $managed_models = [
        'Category'
    ];

    private static $url_segment = 'categories';

    private static $menu_title = 'Categories';

}