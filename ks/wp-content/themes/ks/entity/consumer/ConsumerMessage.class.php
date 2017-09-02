<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/14
 * Time: 17:46
 */

namespace entity\consumer{

    /**
     * Class 消费者现金券以及成长值记录
     * @package consumer
     */
    class ConsumerMessage
    {
        private $id;   //主键ID
        private $uid;   //企业ID
        private $cid;   //消费者ID
        private $title;   //标题
        private $content;   //内容
        private $status;   //信息状态 1 未读 2 已读
        private $tab;   //是否标记 1标记；
        private $time;   //插入时间（执行动作的时间）
        private $istop;   //是否置顶 1 是

        private $table = 'consumer_message';    //(当前表)消费者现金券以及成长值记录表

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