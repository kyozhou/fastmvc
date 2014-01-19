<?php

include_once dirname(dirname(__FILE__)) . '/common/lib/Util.php';

class CBase {

    public $defaultValues = array();
    public $values = array();

    function __construct() {
        
    }

    function initValues($values) {
        $this->defaultValues = $values;
    }

    function filtVars($data, $type = 'string', $keys = array()) {
        if (!empty($data)) {
            if (is_array($data)) {
                if (!empty($keys)) {
                    $dataFilted = array();
                    foreach ($keys as $key) {
                        $dataFilted[$key] = empty($data[$key]) ? null : $this->filtVars($data[$key], $type);
                    }
                    return $dataFilted;
                } else {
                    foreach ($data as $key => $value) {
                        $data[$key] = empty($value) ? null : $this->filtVars($value, $type);
                    }
                    return $data;
                }
            } else {
                switch ($type) {
                    case 'string':
                        return !empty($data) ? $data : '';
                        break;
                    case 'int':
                        return !empty($data) && is_numeric($data) ? $data : 0;
                        break;
                    case 'uint':
                        return !empty($data) && is_numeric($data) && intval($data) >= 0 ? $data : 0;
                        break;
                    default:
                        return false;
                        break;
                }
            }
        } else {
            return false;
        }
    }

    function filtPost($keys = array(), $type = 'string', $defaultValue = null) {
        return $this->filtRequest($keys, $type, $_POST, $defaultValue);
    }

    function filtGet($keys = array(), $type = 'string', $defaultValue = null) {
        return $this->filtRequest($keys, $type, $_GET, $defaultValue);
    }

    function filtRequest($keys = array(), $type = 'string', $inputArray = array(), $defaultValue = null) {
        $request = empty($inputArray) ? array_merge($_GET, $_POST) : $inputArray;
        if (!empty($request)) {
            if (is_array($keys)) {
                if (!empty($keys)) {
                    $dataFilted = array();
                    foreach ($keys as $key) {
                        $dataFilted[$key] = empty($request[$key]) ? null : $this->filtRequest($request[$key], $type);
                    }
                    return $dataFilted;
                } else {
                    foreach ($request as $key => $value) {
                        $request[$key] = empty($value) ? null : $this->filtRequest($value, $type);
                    }
                    return $request;
                }
            } else {
                $data = !empty($request[$keys]) ? $request[$keys] : '';
                switch ($type) {
                    case 'string':
                        $defaultValue = $defaultValue === null ? '' : $defaultValue;
                        return !empty($data) ? $data : $defaultValue;
                        break;
                    case 'int':
                        $defaultValue = $defaultValue === null ? 0 : $defaultValue;
                        return !empty($data) && is_numeric($data) ? $data : $defaultValue;
                        break;
                    case 'uint':
                        $defaultValue = $defaultValue === null ? 0 : $defaultValue;
                        return !empty($data) && is_numeric($data) && intval($data) >= 0 ? $data : $defaultValue;
                        break;
                    case 'array':
                        $defaultValue = $defaultValue === null ? array() : $defaultValue;
                        return !empty($data) && is_array($data) ? $data : $defaultValue;
                        break;
                    default:
                        return $defaultValue;
                        break;
                }
            }
        } else {
            return $defaultValue;
        }
    }

    function checkLogin($type = 'json') {
        if ($this->defaultValues['user']['id'] == 0) {
            if($type == 'json'){
                $this->dieJSON(array('error' => '用户未登录'));
            }elseif($type == 'bool'){
                return false;
            }elseif($type == 'redirect'){
                $this->redirect(PASSPORT_URL);
            }else {
                return false;
            }
        }else{
            return true;
        }
    }

    function view($name = 'index') {
        $values = array_merge($this->defaultValues, $this->values);
        foreach ($values as $key => $value) {
            $$key = $value;
        }
        require dirname(dirname(__FILE__)) . "/view/$name.php";
    }

    function dieJSON($array) {
        die(json_encode($array));
    }

    function redirect($url, $message='') {
        $url = !empty($_GET['c']) && strpos($url, 'c=' . $_GET['c']) > 0 ? SITE_URL : $url;
        die('<script>'.(!empty($message)?'alert("'.$message.'")':'').';window.location.href="' . $url . '"</script>');
    }
    
    function loadModel($names){
        Loader::includeFile($names, '/model/');
    }
    
    function loadLib($names){
        Loader::includeFile($names, '/common/lib/');
    }

}
