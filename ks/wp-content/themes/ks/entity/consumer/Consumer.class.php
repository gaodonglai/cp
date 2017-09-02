<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 17:34
 */

namespace entity\consumer{

    use libraries\util\VerifyData;


    /**
     * Class 消费者用户
     * @package consumer
     */
    class Consumer{

        private $c_id;  //主键ID（消费者用户ID）
        private $c_login;   //消费者用户名
        private $c_pass;    //消费者用户密码
        private $c_nicename;    //消费者用户昵称
        private $c_real_name;    //消费者用户昵称
        private $c_email;   //消费者用户email
        private $c_phone;   //手机
        private $c_avatar;  //头像路径
        private $c_role;    //消费者角色权限（暂定1-10）
        private $c_integral;    //消费者用户现金券
        private $c_growth;  //成长值
        private $c_from_id; //由谁推荐（对应当前表ID，可无）
        private $c_status;  //消费者用户状态（1：正常；-1锁定）
        private $loginUpdate;  //用户名修改锁定
        private $c_registered;  //注册时间
        private $isonline;  //唯一登录码
        private $table = 'consumer';    //(当前表)消费者用户

        public function __get($name){

            if(isset($this->$name)){
                return($this->$name);
            }else{
                return(NULL);
            }

        }

        public function __set($name, $value){
            //调用验证数据类
            $from = VerifyData::getInstance();

            switch($name){
                case 'c_id':


                    break;
                case 'c_login':


                    break;
                /*case 'c_pass':

                    $res = $from->formHandler($value,'nall','6,16');

                    if(!$res){
                        exit('密码格式不正确');
                    }
                    break;*/
                case 'c_nicename':


                    break;
                case 'c_email':


                    break;
                case 'c_phone':
                    $res =$from->formHandler($value,'m');
                    if(!$res){
                        exit('手机格式不正确');
                    }
                    break;
                case 'c_avatar':


                    break;
                case 'c_role':


                    break;
                case 'c_integral':


                    break;
                case 'c_growth':


                    break;
                case 'c_from_id':


                    break;
                case 'c_status':


                    break;
                default:

            }

            $this->$name = $value;

        }

        public  function __isset($name) {

            return isset($this->$name);
        }

        public  function __unset($name) {

            unset($this->$name);
        }
    }

}?>