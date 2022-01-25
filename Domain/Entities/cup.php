<?php
    namespace Domain\Entities;

    include_once 'Domain/Abstracts/product.php';
    include_once 'Domain/Interfaces/ipieceable.php';
    use \Domain\Abstracts as myAbstract;
    use \Domain\Interfaces as myInterfaces;

    class Cup extends myAbstract\Product implements myInterfaces\IPieceable {
        private $color;
        private $material;
        private $volume;
        private $height;
        private $dia;

        // цвет: черный и золото
        // материал: бессвинцовый хрусталь
        // объем (мл): 300
        // высота (см): 7.5
        // диаметр (см): 14.5

        function __construct($productId, $productName, $descr, $price, $color,$material,$volume,$height,$dia) {
            parent::__construct($productId, $productName, $descr, $price);
            $this -> color = $color;
            $this -> material = $material;
            $this -> volume = $volume;
            $this -> height = $height;
            $this -> dia = $dia;
        }

        protected function setDiscount(): void {
            $this -> discount = 1;
        }

        protected function getDiscount($quantity = 1) {
            return $this -> discount;
        }

        function getPrice($quantity = 1) {
            return ($this -> price * $this -> getDiscount(1));
        }

        function getColor() {
            return $this -> color;
        }

        function getMaterial() {
            return $this -> material;
        }

        function getVolume() {
            return $this -> volume;
        }

        function getHeight() {
            return $this -> height;
        }

        function getDia() {
            return $this -> dia;
        }
    }