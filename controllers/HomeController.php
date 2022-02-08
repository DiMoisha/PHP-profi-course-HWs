<?php
    class HomeController extends Controller
    {
        public $view = 'Home';
        public $title;
        public $heading;

        function __construct()
        {
            parent :: __construct();
            $this -> title .= ' | Главная';
            $this -> heading = 'Домашняя работа № 5';
        }

        //метод, который отправляет в представление информацию в виде переменной content_data
        function index($data){
            return '<p><b>Используйте меню для авторизации и регистрации!</b></p>';
        }
    }

    //site/index.php?path=index/test/5