<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/2/4
 * Time: 10:27
 */

namespace entity\util {

    /**
     * Class 中华人民共和国省市区地址集合
     * @package entity\util
     */
    class AddressList
    {
        private $id;    //ID
        private $code;  //
        private $parentId;
        private $name;  //名称
        private $level; //等级

        private $table = 'address_list'; //当前表名


        public function __get($name){

            if(isset($this->$name)){
                return($this->$name);
            }else{
                return(NULL);
            }

        }

        public function __set($name, $value){

            $this->$name = $value;

        }

        public  function __isset($name) {

            return isset($this->$name);
        }

        public  function __unset($name) {

            unset($this->$name);
        }


    }
}