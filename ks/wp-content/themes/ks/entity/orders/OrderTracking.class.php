<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 19:01
 */

namespace entity\orders {

    /**
     * Class 订单跟踪记录
     * @package orders
     */
    class OrderTracking
    {
        private $o_t_id;     //主键ID
        private $o_id;     //对应订单ID（gct_order 表o_id）
        private $user_type;     //用户类型（user:管理员用户；consumer:消费者用户; system：系统自动处理，则user_id为空）
        private $user_id;     //用户ID（gct_user表ID,跟user_type相关）
        private $o_prev_status;     //订单操作前状态
        private $o_next_status;     //订单操作后状态
        private $o_t_content;     //订单状态改变原因
        private $o_t_time;     //订单状态改变时间

        private $table = 'order_tracking';    //(当前表)订单跟踪记录

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