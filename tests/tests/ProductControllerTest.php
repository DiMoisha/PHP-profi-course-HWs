<?php
namespace tests;
require_once "BaseTest.php";

use App;
use App\lib;
use App\Controllers as controllers;

class ProductControllerTest extends BaseTest
{
    /**
     * @dataProvider providerProductController
     */
    public function testProduct($a)
    {
        $cc = new controllers\ProductController();
        $cc_result = $cc->Product($a);

        $this->assertNotNull($cc_result);
        $this->assertArrayHasKey("productid", $cc_result);
        $this->assertArrayHasKey("productname", $cc_result);
        $this->assertArrayHasKey("tabindex", $cc_result);
        $this->assertArrayHasKey("unit", $cc_result);
        $this->assertArrayHasKey("descr", $cc_result);
        $this->assertArrayHasKey("pricewonds", $cc_result);
    }

    public function providerProductController(): array
    {
        return array (
            array (["id" => 1]),
            array (["id" => 6]),
            array (["id" => 12])
        );
    }
}