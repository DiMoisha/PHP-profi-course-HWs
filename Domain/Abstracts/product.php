<?php
    namespace Domain\Abstracts;
    
    abstract class Product {
        const PROFITPERCENT = 20.0;
        protected $productId;
        protected $productName;
        protected $descr;
        protected $price;
        protected $discount;

        function __construct($productId, $productName, $descr, $price) {
            $this -> productId = $productId;
            $this -> productName = $productName;
            $this -> descr = $descr;
            $this -> price = $price;
            $this -> setDiscount();
        }

        public function getProductId() {
            return $this -> productId;
        }

        public function getProductName() {
            return $this -> productName;
        }

        public function getDescr() {
            return $this -> descr;
        }

        abstract protected function setDiscount();
        abstract protected function getDiscount($quantity);
        abstract public function getPrice($quantity);
    }