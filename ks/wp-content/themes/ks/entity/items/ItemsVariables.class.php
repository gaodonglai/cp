<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:12
 */

namespace entity\items {

    /**
     * Class 商品变量
     * @package items
     */
    class ItemsVariables
    {
        private $i_v_id;    //主键ID
        private $i_id;  //商品ID gct_items表i_id
        private $i_v_price; //单价
        private $i_v_promotion_price;    //促销价
        private $i_v_stock; //库存
        private $i_v_integral_pay; //现金券购买抵扣
        private $i_v_f_integral; //返现金额
        private $i_v_stock_count;   //促销数量
        private $i_v_start_time;     //促销开始时间
        private $i_v_end_time;  //促销结束时间
        private $i_v_status;     //该变量商品状态（open：打开；close：关闭）
        private $i_v_modify_time;   //该变量商品修改时间（执行动作的时间）
        private $i_v_time;   //该变量商品创建时间
        private $var_photo;  //变量商品图片
        private $table = 'items_variables';    //(当前表)商品变量

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