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
    class marketActivity{

        private $id;  //主键ID（消费者用户ID）
        private $mobile;   //手机号
        private $isOnly;    //是否老用户
        private $activity_id;    //活动ID
        private $date;   //时间
        
        private $table = 'market_activity';    //(当前表)消费者用户

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