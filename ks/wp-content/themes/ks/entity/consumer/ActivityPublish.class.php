<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 17:46
 */

namespace entity\consumer{

    /**
     *集市活动发布
     * 
     */
    class ActivityPublish
    {
        private $id;   //主键ID
        private $title;   //活动名字
        private $outline;   //活动概述
        private $grade;   //活动积分
        private $max_num;   //最大参与人数
        private $max_units;   //单体最大数
        private $start_time;   //开始时间
        private $end_time;   //结束时间
        private $status;   //1开启/2关闭
        private $time;   //生成时间

        private $table = 'activity_publish';

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