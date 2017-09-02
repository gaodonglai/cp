<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 19:04
 */

namespace entity\other {

    /**
     * Class 邮件、短信发送记录
     * @package sms
     */
    class Sms
    {
        private $sms_id;     //主键ID
        private $sms_type;     //email:邮件；sms:短信
        private $sms_title;     //邮件主题
        private $sms_content;     //邮件内容
        private $sms_recipients;     //收件人邮箱
        private $sms_status;     //发送状态；success：成功；fail：失败
        private $sms_time;     //发送时间

        private $table = 'sms';    //(当前表)订单跟踪记录

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