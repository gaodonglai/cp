<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:15
 */

namespace entity\items {

    /**
     * Class 商品元数据
     * @package items
     */
    class ItemsMeta
    {
        private $i_meta_id;   //主键ID
        private $i_id;   //商品ID（gct_ items表i_id）
        private $meta_key;   //键名
        private $meta_value;   //键值

        private $table = 'items_meta';    //(当前表)商品元数据

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