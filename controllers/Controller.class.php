<?php
namespace App\Controllers\Base;

use App\Lib as lib;
use App\Models as models;

class Controller
{
    public $pageTitle;
    public $metaDescription;
    public $metaKeywords;
    public $pageCanonical;
    public $menuItem;
    public $pageHeading;
    public $view = 'Home';

    function __construct()
    {
        $this -> pageTitle = lib\Config::get('sitename');
    }

    public function Index($data) {
        return [];
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
}