<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 17:53
 */

namespace entity\consumer {

    /**
     * Class 消费者常用地址
     * @package consumer
     */
    class ConsumerAddress
    {
        private $c_ad_id;    //主键ID
        private $c_id;    //消费者用户ID（gct_consumer表c_id）
        private $c_ad_name;    //姓名
        private $c_ad_default;    //默认地址；1表示消费者默认地址
        private $c_ad_phone;    //手机
        private $c_ad_zip;    //邮编
        private $c_ad_country;    //国家
        private $c_ad_province;    //省（直辖市）
        private $c_ad_city;    //市
        private $c_ad_county;    //区（县）
        private $c_ad_street;    //镇（街道）
        private $c_ad_details;    //详细地址
        private $email;    //联系邮箱

        private $table = 'consumer_address';    //(当前表)消费者常用地址

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