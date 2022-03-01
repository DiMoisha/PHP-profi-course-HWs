<?php
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
            $this -> pageTitle = Config::get('sitename');
        }

        public function Index($data) {
            return [];
        }

        protected function isPost() {
                return $_SERVER['REQUEST_METHOD'] == 'POST';
            }
    }