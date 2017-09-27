<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 18:05
 * 银行卡与提现管理
 */

namespace Controller;


class BankMg
{
    public $model;
    public $user_info;
    public $status = array('1'=>'待处理','2'=>'通过','3'=>'未通过');
    public $type = array('bank'=>'银行卡','wechat'=>'微信','alipay'=>'支付宝');

    function __construct(){

        $this->user_info = get_user_info();
        //如果没有登录跳转到登录页面
        if(!$this->user_info){
            redirect(_get_home_url('?show=login'));
        }
        $this->model = new \Model\BankMg();

    }



    /**
     * 提现申请
     */
    function withdrawalApp(){

        if(in_array("",$_POST)){
            exit(json_encode(array('status'=>'n','info'=>'请完善填写内容')));
        }
        $flag = array();

        $bankcard = $_POST['bank'];//银行id
        $money = $_POST['money'];//提现金额
        $deal_password = $_POST['deal_password'];
        $manner = $_POST['payment_ype'];//提现方式
        $service_charge = 0;//手续费

        $user_id = $this->user_info->user_id;
        $reward_money = $this->user_info->reward_money;

        if(!wpDecode($deal_password,$this->model->getPayPassword($user_id))){
            exit(json_encode(array('status'=>'n','info'=>'交易密码错误')));
        }

        //最低限制
        $quota = get_option('withdraw_quota_setting');//提现限额

        if($quota > $money){
            exit(json_encode(array('status'=>'n','info'=>'提现金额不能低于最低提现额度')));
        }

        if($reward_money  < $money){
            exit(json_encode(array('status'=>'n','info'=>'提现金额超出可提现总额')));
        }

        $this->model->wpdb->query("BEGIN");
        $extract_money = array(
             'user_id'=>$user_id,
             'money'=>$money,
             'service_charge'=>$service_charge,//手续费
             'bankcard'=>$bankcard,
             'manner'=>$manner,
             'time'=>date('Y-m-d H:i:s'),
        );
        $flag[] =  $this->model->insertBankMgInfo('extract_money_log',$extract_money);//插入提现记录中

        $data_array1 = array(
            'user_id'=>$user_id,
            'cash_record_type'=>'-',
            'cash_record_cost'=>$money,
            'cost_type'=>'cash',
            'cash_record_time'=>date('Y-m-d H:i:s')
        );
        $flag[] = $this->model->insertBankMgInfo("cash_record",$data_array1);//用户账户金额记录
        $flag[] =  $this->model->updateAccountMoney($user_id,$money);//减去用户账户金额

        if(!in_array("",$flag)){
            $this->model->wpdb->query("COMMIT");
            exit(json_encode(array('status'=>'s','info'=>'提现申请成功')));
        }else{
            $this->model->wpdb->query("ROLLBACK");
            exit(json_encode(array('status'=>'n','info'=>'提现申请失败，请重试')));
        }
    }

}