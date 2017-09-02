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
    class OrdersItems
    {
        private $o_i_id;     //主键ID
        private $o_id;     //订单id;对应gct_orders表o_id
        private $bus_id;     //发货商id
        private $o_i_type;     //项目类别；item：商品；franking：邮费；coupon ：优惠券；integral ：现金券；other:其他；
        private $o_i_title;     //项目名称
        private $o_i_content;     //项目描述
        private $i_id;     //对应商品ID（gct_items 表item_id），其他为空
        private $o_i_price;     //对应商品ID（gct_items 表item_id），其他为空
        private $o_i_real_price;     //商品实际价格
        private $o_i_count;     //购买商品数量
        private $o_i_integral_return;     //返现的现金券
        private $o_i_integral_pay;     //可使用购买的现金券
        private $o_i_integral_f;     //现金券是否返现
        private $o_i_status;     //商品状态；当个商品退换货；对应订单状态gct_order 表order_status
        private $comment;       //评论状态
        private $express_number;       //运单号
        private $table = 'orders_items';    //(当前表)订单项

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