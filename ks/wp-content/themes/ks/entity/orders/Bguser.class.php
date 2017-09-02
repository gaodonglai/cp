<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:50
 */

namespace entity\orders {

    /**
     * Class 订单
     * @package orders
     */
    class Bguser
    {
        private $ID;   //主键ID
        private $user_login;
        private $user_pass;
        private $user_nicename;
        private $user_email;
        private $user_url;
        private $user_registered;
        private $user_activation_key;
        private $user_status;
        private $display_name;
        private $table = 'users';    //(当前表)订单

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