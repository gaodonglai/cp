<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/25
 * Time: 13:42
 */

namespace libraries\util {

    /**
     * Class 数据验证类
     * @package libraries\util
     */
    class VerifyData
    {
        //保存类实例的静态成员变量
        private static $_instance;

        //数据类型
        private $data_type = array(
            "*"=>'/[\w\W]+/',//检测是否有输入，可以输入任何字符，不留空即可通过验证；
            "*all"=>'/^[\w\W]{replace}$/',
            'n'=>'/^\d+$/',//数字类型
            'nall'=>'/^\d{replace}$/',//数字类型
            's'=>'/^[\xa1-\xff0-9A-Za-z\.\s]+$/',//字符串类型
           // 'u'=>'/^[a-zA-Z_][\w_]{6,16}$/',//用户名
            'u'=>'/^[a-zA-z][a-zA-Z0-9_-]{5,13}$/',//用户名  (6-14位)
            'pass'=>'/^[A-Za-z0-9_\,\.\;\\\'\?]{6,20}$/',//密码
            'p'=>'/^[0-9]{6}$/',//验证是否为邮政编码
            'm'=>'/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}|18[0-9]{9}$/',//手机号码格式
            'e' => "/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.(?:com|cn)$/",//email格式
            'url'=>'/^(\w+:\/\/)?\w+(\.\w+)+.*$/',//验证字符串是否为网址
            'idcard'=>'/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'//验证身份证
        );

        private function __construct()
        {

        }

        /**
         *单例模式
         * @return 对象
         */
        public static function getInstance(){

            if(!(self::$_instance instanceof self)){

                self::$_instance = new self;
            }

            return self::$_instance;
        }

        /**
         * 表单处理
         * @param 需要处理的内容
         * @param 处理方式
         * @param 需要规定的参数
         */
        public function formHandler($con,$key,$param = null){
            if(empty($this->data_type[$key])){
                exit('温馨提示：需要验证的类型不存在');
            }

            if($param){
                $e = str_replace('replace',$param,$this->data_type[$key]);
            }else{
                $e = $this->data_type[$key];
            }
            if(preg_match($e,$con)){
                //echo '验证成功';
                return true;
            }else{
                //echo '验证失败';
                return false;
            }
        }


    }
}