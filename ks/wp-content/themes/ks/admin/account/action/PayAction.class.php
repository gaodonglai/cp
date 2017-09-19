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

class PayAction extends AdminAction
{

    function __construct()
    {

        if(!is_user_logged_in()){
            die('用户未登录');
        }

        $this->model = new PayModel();
    }


    //更新状态
    public function updaTeartificialPay(){

        $id = $_POST['id'];
        $pay_money = $_POST['pay_money'];


        if(is_numeric($id) && is_numeric($pay_money)){

            global $wpdb;
            $flag = array();

            $artificial_pay = $wpdb->get_row("SELECT *  FROM `{$wpdb->prefix}artificial_pay` WHERE `id` = $id");

            if($artificial_pay->pay_money != $pay_money){
                exit(json_encode(array('status'=>'n','info'=>'传入参数有误')));
            }

            $set_content = array(
                'status'=>'y'
             );

            $act_zs = 10;//活动赠送
            $money = $artificial_pay->pay_money;

            $user_id =$artificial_pay->user_id;

            $this->model->wpdb->query("BEGIN");

            $flag[] = $this->model->setPayLog($user_id,$money,$act_zs,'artificial');

            $flag[] = $this->model->setDistributionProfit($user_id,$money);

            $flag[] = $wpdb->update($wpdb->prefix.'artificial_pay',$set_content,array('id'=>$id));

            if(!in_array("", $flag)){
                $this->model->wpdb->query("COMMIT");
                exit(json_encode(array('status'=>'y','info'=>'确认成功')));//继续完善账户
            }else{
                $this->model->wpdb->query("ROLLBACK");

                exit(json_encode(array('status'=>'n','info'=>'确认失败请重试')));
            }


        }




    }


}