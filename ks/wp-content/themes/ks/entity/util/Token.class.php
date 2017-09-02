<?php
/**
 * Created by PhpStorm.
 * User: ijita
 * Date: 2016/2/17
 * Time: 15:35
 */

namespace entity\util;


class Token {
    public function __construct() {
        $this->init();
    }
    public function set_token() {
        $_SESSION['token'] = md5(microtime(true));
    }
    public function valid_token() {
        $return = $_REQUEST['token'] === $_SESSION['token'] ? true : false;
        $this->set_token();
        return $return;
    }
    public function init(){
        //如果token为空则生成一个token
        if(!isset($_SESSION['token']) || $_SESSION['token']=='') {
            $this->set_token();
        }
    }
}