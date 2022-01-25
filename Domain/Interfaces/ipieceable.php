<?php
    namespace Domain\Interfaces;

    interface IPieceable {
        public function getColor();
        public function getMaterial();
        public function getVolume();
        public function getHeight();
        public function getDia();
    }