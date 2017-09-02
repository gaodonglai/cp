<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:55
 */

namespace entity\orders {

    /**
     * Class 订单项
     * @package orders
     */
    class OrderExpressList
    {
        private $id;     //主键ID
        private $number;     //运单号
        private $status;     //状态
        private $info;     //运单详情
        private $time;     //项目名称

        private $table = 'order_express_list';    //(当前表)订单项

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