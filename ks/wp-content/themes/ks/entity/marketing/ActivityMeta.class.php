<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:06
 */

namespace entity\marketing {

    /**
     * Class 活动外键
     * @package ActivityMeta
     */
    class ActivityMeta
    {
        private $av_id;          //跟活动外键ID
        private $items;
       // private $full;     //满
       // private $reduce;       //减
        //private $strategy;       //discount：折扣；amount：金额
        //private $type;     //total:总价；postage:邮费

        private $table = 'activity_meta';   //活动外键表

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