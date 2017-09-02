<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 15-7-20
 * Time: 上午10:07
 * 线程模拟
 */
namespace libraries\util {
    class simulationThread{

        public function openThread($data,$urlThread){
            $port = $_SERVER['SERVER_PORT'] ?  $_SERVER['SERVER_PORT'] : '80';
            $host = $_SERVER['SERVER_NAME'];
            //$port = '8890';
            $errno = '';
            $errstr = '';
            $timeout = 30;

            $url = $urlThread;

            $param = $data;

            $data = http_build_query($param);

            // create connect
            $fp = fsockopen($host, $port, $errno, $errstr, $timeout);

            if(!$fp){
                return false;
            }
            // send request
            $out = "POST ".$url." HTTP/1.1\r\n";
            $out .= "Host:".$host."\r\n";
            $out .= "Content-type:application/x-www-form-urlencoded\r\n";
            $out .= "Content-length:".strlen($data)."\r\n";
            $out .= "Connection:close\r\n\r\n";
            $out .= $data;

            fputs($fp, $out);

            // get response
            $response = '';
            while($row=fread($fp, 4096)){
                $response .= $row;
            }
            fclose($fp);
            $pos = strpos($response, "\r\n\r\n");
            $response = substr($response, $pos+4);


            echo $response;
            exit;
        }
    }
}

