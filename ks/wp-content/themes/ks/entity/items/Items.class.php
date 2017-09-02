<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:06
 */

namespace entity\items {

    /**
     * Class 商品
     * @package items
     */
    class Items
    {
        private $i_id;          //主键ID
        private $user_type;     //用户类型（user:管理员用户； 预防后期有非平台商品）
        private $user_id;       //用户ID（gct_user表ID,跟user_type相关）
        private $bus_id;        //供应商id
        private $i_title;       //商品名
        private $i_content;     //商品概述
        private $i_excerpts;     //商品摘要
        private $i_default_id;   //默认变量商品
        private $i_v_id;        //默认的变量产品 对应 gct_items_variables 表 item_v_id
        private $i_status;      //发布状态（publish：发布；trash：回收站；draft：草稿；check：审核；close：关闭[下架]）
        private $c_status;      //评论状态（open：打开；close：关闭）
        private $c_count;       //商品评论数
		private $i_is_simple;   //是否变量商品
        //private $is_not_integral;   //是否支持现金券购买
        //private $i_f_integral;   //现金券数量
        private $i_modify_time; //商品修改时间（执行动作的时间）
        private $i_time;        //商品创建时间

        private $table = 'items';   //(当前表)商品

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