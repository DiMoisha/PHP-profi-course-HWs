<?php
    trait MyTrait {
        public function myFunc() {
            static $obj;

            public static function getObject(){
                if(self::$obj == null){
                    self::$obj = new DB();
                }
                return self::$obj;
            }
        }
    }
    
    class DB{
        use MyTrait;	

        static $connect;

        private function __construct()
        {
            self::$connect = "...";
        }

        function select(){

        }
        function update(){

        }
        function delete(){

        }
        function insert(){

        }

    }

    class Test{
        private $db;
        function __construct()
        {
            $this->db = DB::getObject();
        }

        function showGoods(){
            $this->db->select();
            $this->db->update();
        }
    }