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

class DrpAction extends AdminAction
{

    function __construct()
    {

        if(!is_user_logged_in()){
            die('用户未登录');
        }
        $this->model = new WithdrawModel();
    }

    /*
     * 保存默认分销比例
     */
    public function drpConfirm(){

        if(in_array("",$_POST)){
            exit(json_encode(array('status'=>'n','info'=>'请完善信息')));
        }

        $distribution_one = $_POST['distribution_one'];
        $distribution_two = $_POST['distribution_two'];

        $proportion = update_option('drp_proportion_content',array('distribution_one'=>$distribution_one,'distribution_two'=>$distribution_two));//分销比例

        if($proportion){

            exit(json_encode(array('status'=>'y','info'=>'设置成功')));
        }else{

            exit(json_encode(array('status'=>'n','info'=>'设置失败，请重试')));
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



}