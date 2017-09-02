<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:39
 */

namespace entity\live {

    /**
     * Class 商品投诉、评论
     * @package items
     */
    class Live
    {
        private $id;    //ID自增
        private $live_name;    //对应商品ID（gct_items表ID）
        private $live_link;    //评论用户类型（consumer:消费者；user:管理员；）
        private $live_overview;    //用户id(根据用户类型对应不同的用户表);
        private $live_status;    //发布状态（publish：发布；trash：回收站； close：关闭）
        private $start_time;    //check：审核；processed：已处理；waiting：等待
        private $end_time;    //类型（comment：评论；complain：投诉；suggest：反馈或建议;admin:平台运维人员回复）
        private $creat_time;    //评论标题
        private $table = 'warehouse_live';    //(当前表)商品投诉、评论
        private $live_picture; //图片
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