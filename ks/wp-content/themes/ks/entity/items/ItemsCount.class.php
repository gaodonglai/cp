<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:50
 */

namespace entity\items {

    /**
     * Class 订单
     * @package orders
     */
    class ItemsCount
    {
        private $o_meta_id;   //主键ID
        private $name;   //
        private $count;   //

        private $table = 'items_count';    //(当前表)订单

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