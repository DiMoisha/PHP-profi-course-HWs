<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use App\Lib as lib;
use App;

require 'autoload.php';

abstract class BaseTest extends TestCase //PHPUnit_Framework_TestCase
{
    protected function setUp() : void
    {
        lib\App::Init();
    }

}