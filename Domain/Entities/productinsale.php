<?php
    namespace Domain\Entities;

    class ProductInSale {
        public $product;
        private $quantity;
        private $sm;

        function __construct($product, $quantity) {
            $this -> product = $product;
            $this -> quantity = $quantity;
            $this -> calc();
        }

        private function calc(): void {
            $this -> sm = ($this -> quantity * $this -> getPrice());
        } 

        public function getProfit() {
            return ($this -> sm * $this -> product::PROFITPERCENT / 100); 
        }

        public function getQuantity() {
            return $this -> quantity;
        }

        public function getSm() {
            return $this -> sm;
        }

        public function getPrice() {
            return $this -> product -> getPrice($this -> quantity);
        }
    }