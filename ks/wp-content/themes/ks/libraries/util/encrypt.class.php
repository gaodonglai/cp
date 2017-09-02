<?php

namespace libraries\util;
   /**
   * 数据加密
   * 
   * 
   */
   class encrypt{
    
        //密钥
        public $key = "jctjk@2016";
        //加密
        public function encode($data,$expire = 0)
        {
              $key  = $this->key;
              $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
              $data = base_encode($data);
              $x    = 0;
              $len  = strlen($data);
              $l    = strlen($key);
              $char = '';
              for ($i = 0; $i < $len; $i++) {
                if ($x == $l) $x = 0;
                $char .= substr($key, $x, 1);
                $x++;
             }
             $str = sprintf('%010d', $expire ? $expire + time():0);
             for ($i = 0; $i < $len; $i++) {
                $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
            }
            return str_replace(array('+','/','='),array('-','_',''),base_encode($str));
        }
        //解密
        public function decode($data){
        $key = $this->key;
        $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
        $data   = str_replace(array('-','_'),array('+','/'),$data);
        $mod4   = strlen($data) % 4;
        if ($mod4) {
           $data .= substr('====', $mod4);
        }
        $data   = base_decode($data);
        $expire = substr($data,0,10);
        $data   = substr($data,10);
        if($expire > 0 && $expire < time()) {
            return '';
        }
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $char   = $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base_decode($str);
    }



  }