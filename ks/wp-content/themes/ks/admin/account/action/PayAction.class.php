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

        $update_money = $_POST['update_money'];


        if(is_numeric($id) && is_numeric($pay_money)){

            global $wpdb;
            $flag = array();

            $artificial_pay = $wpdb->get_row("SELECT *  FROM `{$wpdb->prefix}artificial_pay` WHERE `id` = $id");
            $user_id =$artificial_pay->user_id;

            $user_money = $wpdb->get_var("SELECT user_money  FROM `{$wpdb->prefix}account` WHERE `user_id` = {$user_id}");//用户当前的金额

            if($artificial_pay->pay_money != $pay_money){
                exit(json_encode(array('status'=>'n','info'=>'传入参数有误')));
            }

            $set_content = array(
                'status'=>'y'
             );

            //充值活动
            $act_zs = 10;//活动赠送金额

            //如果有修改金额
            if(is_numeric($update_money)){

                $money = $update_money;
                $set_content['pay_money'] = $money;

            }else{
                $money = $artificial_pay->pay_money;
            }


            $this->model->wpdb->query("BEGIN");

            $flag[] = $this->model->setPayLog($user_id,$money,$act_zs,'artificial');

            $flag[] = $this->model->setDistributionProfit($user_id,$money);

            $flag[] = $wpdb->update($wpdb->prefix.'artificial_pay',$set_content,array('id'=>$id));

            $operation_record = array(
                'users_id'=>get_current_user_id(),//操作人员id
                'record'=>'充值：user_id='.$user_id,
                'front'=>$user_money,
                'behind'=>$user_money+$money,
                'ip'=>'',
                'time'=>time(),
            );
            $flag[] = $this->model->insertDistributionInfo('operation_record',$operation_record);

            if(!in_array("", $flag)){
                $this->model->wpdb->query("COMMIT");
                exit(json_encode(array('status'=>'y','info'=>'确认成功')));//继续完善账户
            }else{
                $this->model->wpdb->query("ROLLBACK");

                exit(json_encode(array('status'=>'n','info'=>'确认失败请重试')));
            }


        }




    }

    /**
     * 收款银行卡设置
     */
    public function patheringBankCard(){

        $set_array = array();

        foreach ($_POST['bank_card'] as $key => $item) {
            $set_array[$key] = array('bank_card'=>$item,'bank_name'=>$_POST['bank_name'][$key],'bank_nickname'=>$_POST['bank_nickname'][$key]);
        }

        if($set_array){
            $result = update_option('admin_pathering_bank',$set_array);

            if($result){
                $this->model->wpdb->query("COMMIT");
                exit(json_encode(array('status'=>'y','info'=>'设置成功')));//继续完善账户
            }else{
                $this->model->wpdb->query("ROLLBACK");

                exit(json_encode(array('status'=>'n','info'=>'设置失败，请重试')));
            }
        }

    }

    /**
     * 取消用户申请
     */
    public function canceleErtificialPay(){

        $pay_id = $_POST['pay_id'];
        $user_id = $_POST['user_id'];
        $cancel_content = $_POST['cancel_content'];
        if(!is_numeric($pay_id)){
            exit(json_encode(array('status'=>'n','info'=>'参数错误')));
        }

        $operation_record = array(
            'users_id'=>get_current_user_id(),//操作人员id
            'record'=>'充值取消：user_id='.$user_id,
            'front'=>'s',
            'behind'=>'n',
            'ip'=>'',
            'time'=>time(),
        );


        $result = $this->model->updateArtificialPayLog($user_id,$pay_id,$cancel_content);
        if($result){
            $flag = $this->model->insertDistributionInfo('operation_record',$operation_record);//管理员操作记录

            exit(json_encode(array('status'=>'y','info'=>'取消成功')));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'取消失败，请重试')));
        }
    }
}