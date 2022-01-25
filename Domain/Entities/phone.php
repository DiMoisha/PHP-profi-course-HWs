<?php
    namespace Domain\Entities;

    include_once 'Domain/Abstracts/product.php';
    include_once 'Domain/Interfaces/idigitable.php';
    use \Domain\Abstracts as myAbstract;
    use \Domain\Interfaces as myInterfaces;

    class Phone extends myAbstract\Product implements myInterfaces\IDigitable {
        private $screenSize;
        private $memoryIn;
        private $ram;
        private $countCam;
        private $accy;
        private $proc;
        private $countSim;
        private $os;
        private $weight;

        // Экран	6.5" (2400x1080) IPS 90 Гц
        // Встроенная память	64 ГБ
        // Оперативная память	4 ГБ
        // 4 камеры	50 МП, 8 МП, 2 МП, 2 МП
        // Аккумулятор	5000 мА·ч
        // Процессор
        // MediaTek Helio G88
        // SIM-карты	2 (nano SIM)
        // Операционная система	Android 11
        // Вес	181 г

        function __construct($productId, $productName, $descr, $price, 
            $screenSize,$memoryIn,$ram,$countCam,$accy,$proc,$countSim,$os,$weight) {
            parent::__construct($productId, $productName, $descr, $price);
            $this -> screenSize = $screenSize;
            $this -> memoryIn = $memoryIn;
            $this -> ram = $ram;
            $this -> countCam = $countCam;
            $this -> accy = $accy;
            $this -> proc = $proc;
            $this -> countSim = $countSim;
            $this -> os = $os;
            $this -> weight = $weight;
        }

        protected function setDiscount(): void {
            $this -> discount = 0.5;
        }

        protected function getDiscount($quantity = 1) {
            return $this -> discount;
        }

        function getPrice($quantity = 1) {
            return ($this -> price * $this -> getDiscount(1));
        }

        function getScreenSize() {
            return $this -> screenSize;
        }

        function getMemoryIn() {
            return $this -> memoryIn;
        }

        function getRam() {
            return $this -> ram;
        }

        function getCountCam() {
            return $this -> countCam;
        }

        function getAccy() {
            return $this -> accy;
        }

        function getProc() {
            return $this -> proc;
        }

        function getCountSim() {
            return $this -> countSim;
        }

        function getOS() {
            return $this -> os;
        }

        function getWeight() {
            return $this -> weight;
        }
    }