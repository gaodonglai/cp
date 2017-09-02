<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:28
 */

namespace entity\items {

    /**
     * Class 商品属性
     * @package items
     */
    class ItemsAttribute
    {
        private $i_at_id;    //主键ID
        private $i_at_slug;    //不可重复
        private $i_at_name;    //不可重复
        private $i_at_content;    //栏目概述
        private $i_at_count;    //目录数量
        private $i_at_time;    //插入时间

        private $table = 'items_attribute';    //(当前表)商品属性

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