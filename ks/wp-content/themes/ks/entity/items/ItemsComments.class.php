<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:39
 */

namespace entity\items {

    /**
     * Class 商品投诉、评论
     * @package items
     */
    class ItemsComments
    {
        private $i_c_id;    //ID自增
        private $i_id;    //对应商品ID（gct_items表ID）
        private $user_type;    //评论用户类型（consumer:消费者；user:管理员；）
        private $user_id;    //用户id(根据用户类型对应不同的用户表);
        private $i_c_status;    //发布状态（publish：发布；trash：回收站； close：关闭）
        private $i_c_operation;    //check：审核；processed：已处理；waiting：等待
        private $i_c_type;    //类型（comment：评论；complain：投诉；suggest：反馈或建议;admin:平台运维人员回复）
        private $i_c_title;    //评论标题
        private $i_c_content;    //评论内容
        private $i_c_score;    //评分
        private $i_c_ip;    //评论用户ip
        private $i_c_img;    //评论图片
        private $i_c_agent;    //评论者浏览器、系统等
        private $i_c_parent;    //父评论ID，为0时代表顶级评论(当前表主键ID i_c_id )
        private $i_c_time;    //评论时间
        private $o_id;    //对应订单ID


        private $table = 'items_comments';    //(当前表)商品投诉、评论

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