<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 18:06
 */

namespace entity\marketing {

    /**
     * Class 邮费模板
     * @package PostageTemplate
     */
    class PostageTemplate
    {
        private $p_id;          //主键ID
        private $p_parent;     //是否为模板下二级模板，主模板id
        private $p_title;       //模板名称
        private $p_content;       //模板描述
        private $logistics;     //物流公司
        private $MajorTariff;     //主要资费
        private $number;   //续费数量
        private $renew;        //续费
        private $status;        //续费
        private $time;      //创建时间

        private $table = 'postagetemplate';   //(当前表)商品

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