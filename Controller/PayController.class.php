<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 18:05
 * 银行卡与提现管理
 */

namespace Controller;


class Pay
{
    public $model;
    public $user_info;

    function __construct(){

        $this->user_info = get_user_info();
        //如果没有登录跳转到登录页面
        if(!$this->user_info){
            redirect(_get_home_url('?show=login'));
        }
        $this->model = new \Model\Pay();

    }

    /**
     * 人工充值审核提交
     */
    function setArtificialPay(){
        //rand(10,100)


        $pay_money = $_POST['pay_money'];
        if(!is_numeric($pay_money)){
            exit(json_encode(array('status'=>'n','info'=>'请填写数字')));
        }

        $pay_money = $pay_money.'.'.rand(10,99);

        $user_id = $this->user_info->user_id;
        $args = array(
            'user_id'=>$user_id,
            'pay_money'=>$pay_money,
            'time'=>date('Y-m-d H:i:s',time())
        );

        $result = $this->model->insertPyaInfo('artificial_pay',$args);

        if($result=1){

            exit(json_encode(array('status'=>'y','info'=>$pay_money)));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'添加失败，请重试')));
        }

    }



}