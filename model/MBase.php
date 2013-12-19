<?php
include_once dirname(dirname(__FILE__)) . '/common/common.php';

/**
 * 模型层基类
 *
 * by kyozhou@sina.com
 * at 20130614
 */
class MBase {

    protected $db = null;

    function __construct() {
        Loader::includeLib('DB');
        $this->db = DB::get(APP_DB);
    }

    function exception($exceptionString) {
        die($exceptionString);
    }

    protected function buildSelectSql($tableName, $where) {
        if (!empty($tableName)) {
            $whereString = "";
            if (is_string($where)) {
                $whereString = $where;
            } elseif (is_array($where)) {
                $whereArray = array();
                foreach ($where as $field => $value) {
                    $whereArray[] = "`$field`='$value'";
                }
                $whereString = implode(' AND ', $whereArray);
            }
            $sql = "SELECT * FROM $tableName "
                    . (empty($where) ? '' : ' WHERE '. $whereString);
            return $sql;
        } else {
            return '';
        }
    }

    protected function buildInsertSql($tableName, $data) {
        if (!empty($data) && !empty($tableName)) {
            $fieldArray = array();
            $valueArray = array();
            foreach ($data as $field => $value) {
                $fieldArray[] = "`$field`";
                $valueArray[] = "'$value'";
            }
            $sql = "INSERT INTO `$tableName`("
                    . (implode(', ', $fieldArray))
                    . ")VALUES(" . (implode(',', $valueArray)) . ")";
            return $sql;
        } else {
            return '';
        }
    }

    protected function buildUpdateSql($tableName, $data, $where) {
        if (!empty($data) && !empty($tableName) && !empty($where)) {
            $setArray = array();
            foreach ($data as $field => $value) {
                $setArray[] = "`$field`='$value'";
            }
            $whereString = "";
            if (is_string($where)) {
                $whereString = $where;
            } elseif (is_array($where)) {
                $whereArray = array();
                foreach ($where as $field => $value) {
                    $whereArray[] = "`$field`='$value'";
                }
                $whereString = implode(' AND ', $whereArray);
            }
            $sql = "UPDATE `$tableName` SET "
                    . implode(', ', $setArray) . " WHERE $whereString";
            return $sql;
        } else {
            return '';
        }
    }

    protected function buildDeleteSql($tableName, $where) {
        if (!empty($tableName) && !empty($where)) {
            $whereString = "";
            if (is_string($where)) {
                $whereString = $where;
            } elseif (is_array($where)) {
                $whereArray = array();
                foreach ($where as $field => $value) {
                    $whereArray[] = "`$field`='$value'";
                }
                $whereString = implode(' AND ', $whereArray);
            }
            $sql = "DELETE FROM `$tableName` WHERE $whereString";
            return $sql;
        } else {
            return '';
        }
    }

}
