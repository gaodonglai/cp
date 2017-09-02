<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:59
 */

namespace entity\orders {

    /**
     * Class 订单元数据
     * @package orders
     */
    class OrderMeta
    {
        private $o_meta_id;     //主键ID
        private $o_id;     //对应订单ID（gct_order 表o_id）
        private $meta_key;     //键名
        private $meta_value;     //键值

        private $table = 'order_meta';    //(当前表)订单元数据

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