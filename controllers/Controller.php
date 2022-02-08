<?php
    class Controller
    {
        public $view = 'account';
        public $title;
        public $heading;

        function __construct()
        {
            $this -> title = Config :: get('sitename');
        }

        public function index($data) {
            return [];
        }

        protected function isPost() {
            return $_SERVER['REQUEST_METHOD'] == 'POST';
        }
    }