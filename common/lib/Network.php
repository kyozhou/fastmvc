<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhoubin
 * Date: 13-12-19
 * Time: 下午3:16
 * To change this template use File | Settings | File Templates.
 */


class Network {
    static function curl($url, $method = 'get', $wait = 0, $headerObj = array()) {
        $ch = curl_init();
        $cookie = '';
        if (!empty($headerObj['cookie'])) {
            $cookie = $headerObj['cookie'];
        } else {
            foreach($_COOKIE as $key => $value){
                $cookie .= "$key=$value; ";
            }
        }
        $host = empty($headerObj['host']) ? parse_url($url, PHP_URL_HOST) : $headerObj['host'];
        $header[]= 'Accept: image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/x-shockwave-flash, text/html, */* ';
        $header[]= 'Accept-Language: zh-cn ';
        $header[]= 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36';
        $header[]= 'Host: '.$host;
        $header[]= 'Referer: '. (empty($headerObj['referer']) ? 'http://www.liba.com' : $headerObj['referer']);
        $header[]= 'Connection: Keep-Alive ';
        $header[]= 'Cookie: '.$cookie;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, $method === 'post' ? CURLOPT_POST : CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $wait);
        $output = curl_exec($ch);
        curl_close($ch);
        return trim($output);
    }

    /**
     * @return ip地址，错误时为unknown
     */
    static function GetIP() {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return ($ip);
    }
}