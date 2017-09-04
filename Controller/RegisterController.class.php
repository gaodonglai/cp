<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2017/9/1
 * Time: 下午3:05
 * Created people: gaodonglai
 * pageName:用户登录
 */

namespace Controller;


class Register
{

    /**
     * 用户注册页面
     */
    function main(){

    }

    /**
     * 注册录入
     */
    function entering(){
        $_POST['user_name'] = '15388234018';
        $_POST['user_pass'] = '940423';
        $_POST['user_rePass'] = '940423';

        $user_name = $_POST["user_name"];
        $user_pass = $_POST["user_pass"];
        $user_rePass = $_POST["user_rePass"];


        if( empty($user_name) || empty($user_pass) || empty($user_rePass) ){
            exit(json_encode(array('status'=>'n','content'=>'参数为空')));
        }

        if($user_pass < 6){
            exit(json_encode(array('status'=>'n','content'=>'用户密码位数不能少于6位')));
        }

        if($user_pass !== $user_rePass){
            exit(json_encode(array('status'=>'n','content'=>'两次输入密码不一致')));
        }

        //判断是否是邮箱
        if(preg_match( '/^\w[_\-\.\w]+@\w+\.([_-\w]+\.)*\w{2,4}$/', $user_name )){

            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            //判断邮箱是否正确
            if( !preg_match( $pattern, $user_name ) ){
                exit(json_encode(array('status'=>'n','content'=>'邮箱不正确')));
            }

            $key = 'email';//附加
        }else if( preg_match( '/^\+?\d{11}$/', $user_name) ){//判断是否是手机号
            //判断手机是否正确
            if( !preg_match("/^1[34578]\d{9}$/", $user_name) ){
                exit(json_encode(array('status'=>'n','content'=>'手机号不正确')));
            }

            $key = 'mobile_phone';//附加


        }else{
            exit(json_encode(array('status'=>'n','content'=>'用户名格式不正确')));
        }


        //echo wpDecode(1234567,wpEncrypt(1234567));

        global $wpdb;

        $table = $wpdb->prefix.'account';

        $result = $wpdb->query("INSERT INTO `$table`( `user_name`, `password`, `reg_time`, `$key` ) VALUES ($user_name,'".wpEncrypt($user_pass)."',".time().",$user_name)");

        if($result){
            exit(json_encode(array('status'=>'y','content'=>'注册成功')));
        }else{
            exit(json_encode(array('status'=>'n','content'=>'注册失败，用户名已被占用')));
        }




    }






}