<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:06
 */

namespace entity\items {

    /**
     * Class 商品
     * @package items
     */
    class SearchRecord
    {
        private $id;          //主键ID
        private $name;     //用户类型（user:管理员用户； 预防后期有非平台商品）
        private $num;       //用户ID（gct_user表ID,跟user_type相关）

        private $table = 'search_record';   //(当前表)商品

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