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


class Login
{

    function main(){
        /*$sd =  wpEncrypt(940423);
        echo $sd;
        echo wpDecode(940423,$sd);*/

    }

    /**
     * 登入账号
     */
    function login(){
        $user_name = $_POST["user_name"];
        $user_pass = $_POST["user_pass"];
        if( empty($user_name) || empty($user_pass)){
            exit(json_encode(array('status'=>'n','info'=>'参数为空')));
        }

        if(get_user_info()){
            exit(json_encode(array('status'=>'y','info'=>'用户已登录','url'=>_get_home_url())));
        }

        global $wpdb;
        $get_result =  $wpdb->get_row("SELECT user_id,password,status FROM `{$wpdb->prefix}account` WHERE user_name = '{$user_name}'");
        if($get_result){

            if(wpDecode($user_pass,$get_result->password)){

                //更改最后登录时间
                $wpdb->query("UPDATE `{$wpdb->prefix}account` SET `last_login`= ".time().",`last_ip`='".ip()."' WHERE `user_id` = {$get_result->user_id}");
                $_SESSION['user_id'] = $get_result->user_id;

                if(get_user_info()->status == 0){
                    exit(json_encode(array('status'=>'y','info'=>'登陆成功','url'=>_get_home_url('account/perfectInfo'))));//继续完善账户
                }

                exit(json_encode(array('status'=>'y','info'=>'登陆成功','url'=>_get_home_url())));
            }else{
                exit(json_encode(array('status'=>'n','info'=>'用户名或密码不正确')));
            }


        }else{
            exit(json_encode(array('status'=>'n','info'=>'用户名或密码不正确')));
        }
    }

    /**
     * 登出
     */
    public function logout(){
        session_destroy();
        session_unset();
        unset($_SESSION['user_id']);
        //setcookie('user','',time()-1,'/');

        redirect(_get_home_url());
    }

    /**
     * 密码找回页面
     */
    public function retrievePassword(){

        $user_name = $_POST["user_name"];
        $rand_code = $_POST["rand_code"];
        $user_answer = $_POST["user_answer"];

        if($user_name){

            if(!preg_match( "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $user_name ) ||  !preg_match( '/^\+?\d{11}$/', $user_name)){
                $content = '用户名格式错误';
            }

            if($user_answer){
                if($_SESSION['rand_code'] == $rand_code){

                    global $wpdb;
                    $table = $wpdb->prefix.'account';
                    $get_answer = $wpdb->get_var("SELECT answer FROM $table WHERE `user_name` = {$user_name}");

                    if($get_answer == $user_answer){
                        $answer = true;
                    }else{
                        $question = $wpdb->get_var("SELECT question FROM $table WHERE `user_name` = {$user_name}");
                        $content = '答案错误';
                    }
                }else{

                    $verify_code = '验证码错误';
                }

            }else{

                if($_SESSION['rand_code'] == $rand_code){

                        global $wpdb;
                        $table = $wpdb->prefix.'account';
                        $question = $wpdb->get_var("SELECT question FROM $table WHERE `user_name` = {$user_name}");

                        $_SESSION['user_name'] = $user_name;

                }else{
                    $verify_code = '验证码错误';
                }

            }


        }

        $args = array(
            'question'=>$question,
            'answer'=>$answer,
            'content'=>$content,
            'verify_code'=>$verify_code
        );

        get_header_front();
        display_show('retrievePassword',$args);
        get_footer_front();
    }

    /**
     * 查询密保问题
     */
    function getEncrypted(){
        $user_name = $_POST["user_name"];
        $rand_code = $_POST["rand_code"];
        $password = $_POST["password"];
        $re_password = $_POST["re_password"];

        if( empty($rand_code) || empty($password) || empty($re_password) || empty($user_name)){
            exit(json_encode(array('status'=>'n','info'=>'参数为空')));
        }

        if(!preg_match("/^[\w-\.]{6,16}$/",$password)){
            exit(json_encode(array('status'=>'n','info'=>'用户密码位数不正确')));
        }

        if($password !== $re_password){
            exit(json_encode(array('status'=>'n','info'=>'两次输入密码不一致')));
        }

        if($_SESSION['rand_code'] != $rand_code){
            exit(json_encode(array('status'=>'n','info'=>'验证码错误')));
        }

        if($_SESSION['user_name'] != $user_name){
            exit(json_encode(array('status'=>'n','info'=>'参数错误')));
        }

        global $wpdb;
        $table = $wpdb->prefix.'account';
        $result = $wpdb->query("UPDATE $table SET `password`='".wpEncrypt($password)."' WHERE `user_name` = {$user_name}");

        if($result){

            exit(json_encode(array('status'=>'y','info'=>'密码修改成功','url'=>_get_home_url('?show=login'))));//继续完善账户

        }else{
            exit(json_encode(array('status'=>'n','info'=>'密码修改失败，请重试')));
        }


    }





}