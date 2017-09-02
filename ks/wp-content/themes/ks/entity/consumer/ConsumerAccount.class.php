<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 17:46
 */

namespace entity\consumer{

    /**
     * Class 消费者现金券以及成长值记录
     * @package consumer
     */
    class ConsumerAccount
    {
        private $c_account_id;   //主键ID
        private $c_id;   //消费者用户ID（gct_consumer表c_id）
        private $c_a_type;   //growth：成长值；integral：现金券
        private $c_a_amount;   //增加或者较少的现金券量;+1或者-1
        private $c_a_content;   //增加或者较少的原因
        private $c_a_surplus;   //加减后的总量
        private $c_a_status;   //状态，c：取消；s：成功；
        private $o_id;      //订单id

        private $time;   //插入时间（执行动作的时间）

        private $table = 'consumer_account';    //(当前表)消费者现金券以及成长值记录表

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