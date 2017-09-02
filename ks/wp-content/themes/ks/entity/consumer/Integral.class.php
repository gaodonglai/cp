<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 17:46
 */

namespace entity\consumer{

    /**
     * Class 企业兑换码表
     * @package consumer
     */
    class Integral
    {
        private $id;   //主键ID
        private $bId;   //企业ID
        private $parValue;   //面值
        private $randCode;   //随机码
        private $randIncode;   //验证码
        private $originTime;   //生成月份
        private $verify;   //是否验证
        private $lastTime;   //最后验证时间
        private $storageTime; //生成时间

        private $table = 'integral';

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