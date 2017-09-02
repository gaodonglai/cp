<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:22
 */

namespace entity\items {

    use libraries\util\VerifyData;

    /**
     * Class 商品分类、标签等
     * @package items
     */
    class ItemsTerm
    {
        private $i_term_id;  //主键自增ID
        private $i_term_name;  //商品分类名
        private $i_term_content;  //分类描述
        private $i_term_parent;  //父分类ID(当前表i_term_id)
        private $i_term_type;  //分类类型（tag:标签；cat:分类目录;可扩展其他自定义类型）；
        private $photo;         //分类图片
        private $i_term_time;  //插入时间

        private $table = 'items_term';    //(当前表)商品分类、标签等

        public function __get($name){


            if(isset($this->$name)){


                if ($this->$name != base_encode(base_decode($this->$name))) {
                   // return $this->$name = base_encode($this->$name);

                }else{
                    return($this->$name);

                }
                return($this->$name);

            }else{
                return null;
            }

        }

        public function __set($name, $value){

            //调用验证数据类
            $from = VerifyData::getInstance();
            switch($name){

                case 'i_term_name':

                    $res = $from->formHandler($value,'*all','1,100');
                    if(!$res){
                        exit(json_encode(array('status'=>'n','info'=>'名称不能为空或不能太长')));
                    }
                    break;
              
                case 'i_term_type':
                    $res = $from->formHandler($value,'*');
                    if(!$res){
                         exit(json_encode(array('status'=>'n','info'=>'类型不能为空')));
                    }
                    break;
              
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
}