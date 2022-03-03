<?php
require_once "tests/BaseTest.php";

use App\Controllers as controllers;

class HomeControllerTest extends BaseTest
{
    /**
     * @dataProvider providerHomeController
     */
    public function testIndex($a){
        $cc = new controllers\HomeController();
        $cc_result = $cc->index($a);

        $this->assertNotNull($cc_result);
    }

    public function providerHomeController(){
        return array (
            array (["id" => 0]),
            array (["id" => 1]),
            array (["id" => 2])
        );
    }
}