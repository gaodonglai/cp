<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:50
 */

namespace entity\orders {

    /**
     * Class 订单
     * @package orders
     */
    class Orders
    {
        private $o_id;   //主键ID
        private $order_number;   //唯一订单号，10位时间戳（当前表time字段）+订单ID%1万【保证4位，0000-9999】
        private $user_type;   //用户类型（consumer:消费者；user:管理员用户；预防后期有非平台商品）
        private $user_id;   //用户ID（gct_user表ID,跟user_type相关）
        private $o_title;   //订单名
        private $o_content;   //订单描述
        private $o_p_type;   //alipay：支付宝; wechat：微信支付；integral：现金券支付
        private $o_total;   //订单总金额
        private $o_count;   //商品个数
        private $o_status;   //订单状态（cart : 购物车; payment:等待付款；processed：等待处理；delivered:已发货；recipient：等待收货；complete：已完成；refund_processing：等待退款；refund:正在退款；refund_failed：退款失败；refund_success:退款成功；order_exception：订单异常）
        private $oa_status;   //订单操作状态。publish :正常；trash：回收站； close：删除订单；[用户删除的订单]
        private $notice_status;//订单通知操作状态 y:已操作 n:未操作
        private $o_time;   //商品创建时间

        private $table = 'orders';    //(当前表)订单

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