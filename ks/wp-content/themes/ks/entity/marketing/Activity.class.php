<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:06
 */

namespace entity\marketing {

    /**
     * Class 活动
     * @package activity
     */
    class Activity
    {
        private $av_id;          //主键ID
        private $av_title;     //活动名称
        private $av_content;       //活动概述
        private $img;       //图片
        private $discount;  //折扣
        private $fullcut;  //满减
        private $starttime;       //开始时间
        private $endtime;     //结束时间
        private $time;     //创建时间
        private $status;   //close:关闭；open:打开；trash：回收站
        private $pick;        //open:允许；close:不允许；only：只支持自提

        private $table = 'activity';   //活动表

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