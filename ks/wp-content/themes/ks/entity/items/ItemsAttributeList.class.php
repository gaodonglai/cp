<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:31
 */

namespace entity\items {

    /**
     * Class 商品属性列表
     * @package items
     */
    class ItemsAttributeList
    {
        private $i_at_list_id;   //主键自增ID
        private $i_at_list_name;   //变量商品目录名
        private $i_at_list_content;   //目录描述
        private $i_at_id;   //所属栏目，对应gct_items_columns 表items_columns_id
        private $i_id;  //商品id
        private $state; //商品是否启用
        private $sort;   //排序
        private $i_at_list_time;   //插入时间

        private $table = 'items_attribute_list';    //(当前表)商品属性列表

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