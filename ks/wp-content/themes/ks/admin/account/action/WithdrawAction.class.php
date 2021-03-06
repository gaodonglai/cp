<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:01
 * 取现管理
 */
namespace admin\account\action;
use admin\account\model\WithdrawModel;
use libraries\controller\AdminAction;

class WithdrawAction extends AdminAction
{

    function __construct()
    {

        if(!is_user_logged_in()){
            die('用户未登录');
        }
        $this->model = new WithdrawModel();
    }

    /*
     * 用户取现确认
     */
    public function withdrawConfirm(){

        $flag = array();

        $user_id = $_POST['user_id'];
        $id = $_POST['id'];
        $cancel_content = $_POST['cancel_content'];
        $submit_type = $_POST['submit_type'];

        $extract_log = $this->model->wpdb->get_row( "SELECT * FROM {$this->model->wpdb->prefix}extract_money_log where user_id = {$user_id} and id= {$id}" );

        if(empty($extract_log)){
            exit(json_encode(array('status'=>'n','info'=>'信息有误，请刷新页面再试')));
        }

        if($submit_type == 'confirm'){//确认
            $operation_record = array(
                'users_id'=>get_current_user_id(),//操作人员id
                'record'=>'取现状态：user_id='.$user_id,
                'front'=>1,
                'behind'=>2,
                'ip'=>'',
                'time'=>time(),
            );

            $update_log = array(
                'status'=>2
            );

        } else{
            exit(json_encode(array('status'=>'n','info'=>'信息有误，请刷新页面再试')));
        }


        $this->model->wpdb->query("BEGIN");

        $flag[] = $this->model->updateWithdrawInfo('extract_money_log',$update_log,array('user_id'=>$user_id,'id'=>$id));
        $flag[] = $this->model->insertWithdrawInfo('operation_record',$operation_record);//管理员操作记录

        if(!in_array("", $flag)){
            $this->model->wpdb->query("COMMIT");
            exit(json_encode(array('status'=>'y','info'=>'确认成功')));//继续完善账户
        }else{
            $this->model->wpdb->query("ROLLBACK");

            exit(json_encode(array('status'=>'n','info'=>'确认失败请重试')));
        }

    }

    /**
     * 取消并把金额返还到用户账户
     */
    function withdrawCancel(){

        $flag = array();

        $user_id = $_POST['user_id'];
        $id = $_POST['id'];
        $cancel_content = $_POST['cancel_content'];

        $extract_log = $this->model->wpdb->get_row( "SELECT * FROM {$this->model->wpdb->prefix}extract_money_log where user_id = {$user_id} and id= {$id}" );

        if(empty($extract_log)){
            exit(json_encode(array('status'=>'n','info'=>'信息有误，请刷新页面再试')));
        }

        $money = $extract_log->money;

        $data_array1 = array(
            'user_id'=>$user_id,
            'cash_record_type'=>'+',
            'cash_record_cost'=>$money,
            'cost_type'=>'cash',
            'cash_record_time'=>date('Y-m-d H:i:s')
        );

        $operation_record = array(
            'users_id'=>get_current_user_id(),//操作人员id
            'record'=>'取现状态：user_id='.$user_id,
            'front'=>1,
            'behind'=>3,
            'ip'=>'',
            'time'=>time(),
        );

        $update_log = array(
            'status'=>3,
            'refuse_reason'=>$cancel_content
        );

        $this->model->wpdb->query("BEGIN");
        $flag[] = $this->model->updateWithdrawInfo('extract_money_log',$update_log,array('user_id'=>$user_id,'id'=>$id));
        $flag[] = $this->model->insertWithdrawInfo("cash_record",$data_array1);//用户账户金额记录
        $flag[] =  $this->model->updateAccountMoney($user_id,$money);//加上用户账户金额
        $flag[] = $this->model->insertWithdrawInfo('operation_record',$operation_record);//管理员操作记录

        if(!in_array("",$flag)){
            $this->model->wpdb->query("COMMIT");
            exit(json_encode(array('status'=>'y','info'=>'取消成功')));
        }else{
            $this->model->wpdb->query("ROLLBACK");
            exit(json_encode(array('status'=>'n','info'=>'取消失败，请重试')));
        }
    }

    public function quotaSetting(){

        $quota_money = $_POST['quota_money'];

        if(!is_numeric($quota_money)){
            exit(json_encode(array('status'=>'n','info'=>'请完善信息')));
        }

        $quota = update_option('withdraw_quota_setting',(int)$quota_money);//分销比例

        if($quota){

            exit(json_encode(array('status'=>'y','info'=>'设置成功')));
        }else{

            exit(json_encode(array('status'=>'n','info'=>'设置失败，请重试')));
        }
    }

}