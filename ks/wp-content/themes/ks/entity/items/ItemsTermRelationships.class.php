<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:27
 */

namespace entity\items {

    /**
     * Class 商品与分类关系表
     * @package items
     */
    class ItemsTermRelationships
    {
        private $i_id;   //对应商品ID（gct_items表i_id）
        private $i_term_id;   //对应分类ID（gct_items_term表i_term_id）
        private $i_term_type; //分类类型（tag:标签；cat:分类目录;可扩展其他自定义类型）；
        private $table = 'items_term_relationships';    //(当前表)商品与分类关系表

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