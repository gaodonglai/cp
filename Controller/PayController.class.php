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
        if(in_array("",$_POST)){
            exit(json_encode(array('status'=>'n','info'=>'请完善信息')));
        }
        $type_id = $_POST['type'];
        if(!is_numeric($type_id)){
            exit(json_encode(array('status'=>'n','info'=>'请完成支付类型的选择')));
        }

        $money = $_POST['pay_money'];
        if(!is_numeric($money)){
            exit(json_encode(array('status'=>'n','info'=>'请填写金额')));
        }

        $user_id = $this->user_info->user_id;
        $type = $this->model->getAccountBank($user_id,$type_id);
        if(empty($type)){
            exit(json_encode(array('status'=>'n','info'=>'充值方式有误')));
        }


        //这段代码只是为了做一些简单的防重复，足够用了。
        $flag = 1;
        while($flag <100) {
            $pay_money = $money.'.'.sprintf("%02d",rand(1,30));
            $getToday = $this->model->getTodayPayMoney($pay_money);
            if(empty($getToday)){
                break;
            }

            if($flag == 99){
                exit(json_encode(array('status'=>'n','info'=>'抱歉今天充值的'.$money.'数额已经不能再进行充值')));
            }
            $flag++;
        }

        $args = array(
            'user_id'=>$user_id,
            'pay_type'=>$type_id,
            'pay_money'=>$pay_money,
            'time'=>date('Y-m-d H:i:s',time())
        );

        $result = $this->model->insertPyaInfo('artificial_pay',$args);

        if($result){


            exit(json_encode(array('status'=>'y','info'=>'提交成功')));

        }else{
            exit(json_encode(array('status'=>'n','info'=>'添加失败，请重试')));
        }



    }


    /**
     * 取消本次充值
     */
    public function cancelPay(){
        $pay_id = $_POST['pay_id'];
        if(!is_numeric($pay_id)){
            exit(json_encode(array('status'=>'n','info'=>'参数错误')));
        }
        $user_id = $this->user_info->user_id;
        $result = $this->model->getArtificialPayLog($user_id,$pay_id);


        if(empty($result)){
            exit(json_encode(array('status'=>'n','info'=>'没有充值记录')));
        }

        $result = $this->model->updateArtificialPayLog($user_id,$pay_id);
        if($result){
            exit(json_encode(array('status'=>'y','info'=>'取消成功')));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'取消失败，请重试')));
        }


    }



}