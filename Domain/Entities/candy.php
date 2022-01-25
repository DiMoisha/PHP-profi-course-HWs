<?php
    namespace Domain\Entities;

    include_once 'Domain/Abstracts/product.php';
    include_once 'Domain/Interfaces/iweightable.php';
    use \Domain\Abstracts as myAbstract;
    use \Domain\Interfaces as myInterfaces;

    class Candy extends myAbstract\Product implements myInterfaces\IWeightable {
        private $brand;
        private $typOf;
        private $compound;
        private $typeOfPack;
              
        // Бренд - Ferrero Rocher
        // Вид конфет - шоколадные/глазированные
        // Вкус/начинка конфет - орехи
        // Вид упаковки - пластик

        function __construct($productId,$productName,$descr,$price,$brand,$typOf,$compound,$typeOfPack) {
            parent::__construct($productId, $productName, $descr, $price);
            $this -> brand = $brand;
            $this -> typOf = $typOf;
            $this -> compound = $compound;
            $this -> typeOfPack = $typeOfPack;
        }

        protected function setDiscount(): void {
            $this -> discount = [
                                    1 => 1,
                                    2 => 0.9,
                                    3 => 0.8,
                                    5 => 0.7,
                                    8 => 0.6,
                                    10 => 0.5
                                ];
        }

        protected function getDiscount($quantity) {
            $discount = 1;
            $prevkey = 0;

            foreach ($this -> discount as $key => $value) {
                if ($prevkey < $quantity && $key >= $quantity) {
                    $discount = $value;
                    $prevkey = $key;
                }
            }

            return $discount;
        }

        function getPrice($quantity = 1) {
            return ($this -> price * $this -> getDiscount($quantity));
        }

        function getBrand() {
            return $this -> brand;
        }

        function getTypOf() {
            return $this -> typOf;
        }

        function getCompound() {
            return $this -> compound;
        }

        function getTypeOfPack() {
            return $this -> typeOfPack;
        }
    }