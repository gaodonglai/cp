<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:36
 */

namespace entity\items {

    /**
     * Class 商品变量与属性列表关系
     * @package items
     */
    class ItemsVariablesListRelationships
    {
        private $i_v_id;     //对应变量商品ID（gct_items_variables表item_variables_id）
        private $i_at_list_id;   //对应属性列表ID（gct_items_columns_term表i_at_list_id）

        private $table = 'items_variables_list_relationships';    //(当前表)商品变量与属性列表关系

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