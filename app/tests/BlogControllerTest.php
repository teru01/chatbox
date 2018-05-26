<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../mvc/Controller.php';
require_once __DIR__ . '/../controllers/BlogController.php';

class BlogControllerTest extends TestCase{
    private $blogController;
    private $target = [1 => 1, 3 => 3];
    private $expect = [1 => 1, 2 => 0, 3 => 3, 4 => 0];
    private $expect_nullinput = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
    private $reactions = ["like" => 1, "surprise" => 2, "laugh" => 3, "dislike" => 4];

    public function setUp(){

    }

    public function testFormatAry(){
        $this->assertEquals($this->expect, BlogController::formatAry($this->target, $this->reactions));
        $this->assertEquals($this->expect_nullinput, BlogController::formatAry(null, $this->reactions));
    }
}