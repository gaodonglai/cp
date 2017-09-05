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
        $sd =  wpEncrypt(940423);
        echo $sd;
        echo wpDecode(940423,$sd);

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
        $get_result =  $wpdb->get_row("SELECT user_id,password FROM `{$wpdb->prefix}account` WHERE user_name = '{$user_name}'");
        if($get_result){

            if(wpDecode($user_pass,$get_result->password)){

                $_SESSION['user_id'] = $get_result->user_id;

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






}