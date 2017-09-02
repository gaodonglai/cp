<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 17:34
 */

namespace entity\consumer {

    /**
     * Class 消费者用户元数据
     * @package consumer
     */
    class LookNotes{

        private $id; //主键ID
        private $ip;  
        private $address;  
        private $minute; 
        private $device;
        private $date;   

        private $table = 'look_notes';   //(当前表)消费者用户元数据

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