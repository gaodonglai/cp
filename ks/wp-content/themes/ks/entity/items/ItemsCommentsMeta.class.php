<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:45
 */

namespace entity\items {

    /**
     * Class 商品投诉、评论元数据
     * @package items
     */
    class ItemsCommentsMeta
    {
        private $i_c_meta_id;    //主键ID
        private $i_c_id;    //对应评论ID（gct_items_comment表i_c_id）
        private $meta_key;    //键名
        private $meta_value;    //键值

        private $table = 'items_comments_meta';    //(当前表)商品投诉、评论元数据

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