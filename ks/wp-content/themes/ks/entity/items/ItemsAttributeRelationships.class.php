<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:33
 */

namespace entity\items {

    /**
     * Class 商品与属性关系
     * @package items
     */
    class ItemsAttributeRelationships
    {
        private $i_id;   //对应商品ID（gct_items表i_id）
        private $i_at_id;   //对应栏目ID（gct_items_attribute表i_at_id）
        private $sort;   //排序
        private $i_v_id;        //对应变量商品表（i_v_id）
        private $table = 'items_attribute_relationships';    //(当前表)商品与属性关系

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