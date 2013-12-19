<?php

/**
 * user table
 *
 * by kyozhou@sina.com
 * at 20130520
 * 
 */
include dirname(__FILE__) . '/MBase.php';

class MTest extends MBase {

    function test() {
        $sql = "SELECT * FROM `test` ";
        return $this->db->fetchFirst($sql);
    }

}