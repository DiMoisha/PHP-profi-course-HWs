<?php
    namespace Domain\Interfaces;
    
    interface IDigitable {
        public function getScreenSize();
        public function getMemoryIn();
        public function getRam();
        public function getCountCam();
        public function getAccy();
        public function getProc();
        public function getCountSim();
        public function getOS();
        public function getWeight();
    }