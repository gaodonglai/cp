<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:06
 */

namespace entity\marketing {

    /**
     * Class 邮费模板外键
     * @package PostageAddress
     */
    class PostageAddress
    {
        private $p_id;          //邮费模板id
        private $code;     //区域代码
        private $status;       //close:该地区不支持，all：该区域下全部支持；open:该区域支持

        private $table = 'postage_address';   //(当前表)商品

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