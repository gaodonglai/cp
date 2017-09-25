<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:01
 */
namespace admin\account\action;
use admin\account\model\PayModel;
use libraries\controller\AdminAction;

class AccountAction extends AdminAction
{

    function __construct()
    {

        if(!is_user_logged_in()){
            die('用户未登录');
        }

    }

    /*活动列表*/
    public function setAccount(){

        $user_name = $_POST["user_name"];
        $user_pass = $_POST["user_pass"];
        $user_rePass = $_POST["user_rePass"];

        if( empty($user_name) || empty($user_pass) || empty($user_rePass) ){
            exit(json_encode(array('status'=>'n','info'=>'参数为空')));
        }

        if(!preg_match("/^[\w-\.]{6,16}$/",$user_pass)){
            exit(json_encode(array('status'=>'n','info'=>'用户密码位数不正确')));
        }

        if($user_pass !== $user_rePass){
            exit(json_encode(array('status'=>'n','info'=>'两次输入密码不一致')));
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

        global $wpdb;
        $table = $wpdb->prefix.'account';
        $result = $wpdb->query("INSERT INTO `$table`( `user_name`, `password`,`is_validated`, `reg_time`, `$key` ) VALUES ('$user_name','".adminEncrypt($user_pass)."',1,".time().",'$user_name')");

        if($result){

            exit(json_encode(array('status'=>'y','info'=>'用户添加成功')));//继续完善账户

        }else{
            exit(json_encode(array('status'=>'n','info'=>'注册失败，用户名已被占用')));
        }
        
    }


    public function updateAccount(){

        $user_id = $_POST['user_id'];

        unset($_POST['action']);
        unset($_POST['user_id']);

        global $wpdb;
        //$get_account = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}account where user_id = {$user_id}" );


        $set_content = array();
        foreach ($_POST as $key=> $item) {
            if($item){
                $set_content[$key] = $item;
            }

        }

        $result = $wpdb->update($wpdb->prefix.'account',$set_content,array('user_id'=>$user_id));

        if($result){

            exit(json_encode(array('status'=>'y','info'=>'更新成功')));//继续完善账户

        }else{
            exit(json_encode(array('status'=>'n','info'=>'更新失败，请检查更新内容')));
        }

    }

    /**
     * 人工充值
     */
    public function payAccount(){

        $user_id = $_POST['user_id'];
        $pay_money = $_POST['pay_money'];
        $is_activity = $_POST['is_activity'];

        if(empty($pay_money) || empty($user_id)){
            exit(json_encode(array('status'=>'n','info'=>'请完善信息')));
        }
        //是否参加活动
        if($is_activity){
            //充值活动
            $back_now=0;
        }else{
            //充值活动
            $back_now=0;
        }


        $payModel = new PayModel();
        $payModel->setPayLog($user_id,$pay_money,$back_now,'direct');

        if($payModel){

            exit(json_encode(array('status'=>'y','info'=>'更新成功')));//继续完善账户

        }else{
            exit(json_encode(array('status'=>'n','info'=>'更新失败，请检查更新内容')));
        }
    }


}