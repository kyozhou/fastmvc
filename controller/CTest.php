<?php

require dirname(__FILE__) . '/CBase.php';

class CTest extends CBase {

    function show() {
        $this->loadModel('MTest');
        $test = new MTest();
        print_r($test->test());
        $this->view('index');
    }

}