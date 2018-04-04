<?php
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase{
    private $view;
    public function setUp(){
        $this->view = new View("views", null);

    }
    public function testRender(){

    }

}