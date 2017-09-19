<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:01
 */
namespace admin\account\model;

class PayModel
{

    function __construct()
    {

        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix;

    }

    /**
     * 设置充值金额并记录
     * @param $user_id 用户id
     * @param $money 充值金额
     * @param $back_now 充值返现金额
     * @param $recharge_type bank：银行卡，wechat:微信支付，alipay：支付宝;qq:qq钱包,artificial:人工
     * @return mixed
     */
    function setPayLog($user_id,$money,$back_now,$recharge_type){

        $data_array = array(
            'user_id'=>$user_id,
            'recharge_money'=>$money,
            'back_now'=>$back_now,
            'recharge_type'=>$recharge_type,
            'recharge_time'=>date('Y-m-d H:i:s')
        );

        $flag[] =  $this->insertDistributionInfo('recharge',$data_array);//充值记录
        $flag[] =  $this->updateAccountMoney($user_id,$money+$back_now);

        $data_array1 = array(
            'user_id'=>$user_id,
            'cash_record_type'=>'+',
            'cash_record_cost'=>$money+$back_now,
            'cost_type'=>'cash',
            'cash_record_time'=>date('Y-m-d H:i:s')
        );
        $flag[] = $this->insertDistributionInfo("cash_record",$data_array1);//用户积分、现金记录

        if(!in_array("", $flag)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 设置用户上级分销利润
     * @param int $money 金额
     */
    function setDistributionProfit($user_id,$money){
        $flag = array();

        //获取分成 分成是以百分数来算
        $Profit = json_decode('{}');
        $Profit->profit1 = 2;//直接推广
        $Profit->profit2 = 1;//间接推广


        //获取直接推广者id
        $getProfit1Id =  $this->getSuperior($user_id);
        if($getProfit1Id){

            $cash_record_cost = ($Profit->profit1 / 100) * $money;
            $data_array = array(
                'user_id'=>$getProfit1Id,
                'cash_record_type'=>'+',
                'cash_record_cost'=>$cash_record_cost,
                'cost_type'=>'cash',
                'cash_record_time'=>date('Y-m-d H:i:s')
            );

            $flag[] = $this->insertDistributionInfo("cash_record",$data_array);
            $flag[] = $this->updateAccountMoney($getProfit1Id,$cash_record_cost);
            $data_log = array(
                'user_id'=>$user_id,
                'money'=>$money,
                'increase_money'=>$cash_record_cost,
                'rank'=>1,
                'rank_user_id'=>$getProfit1Id,
                'time'=>date('Y-m-d H:i:s')
            );

            $flag[] = $this->insertDistributionInfo("drp_log",$data_log);

            //获取间接推广者id
            $getProfit2Id =  $this->getSuperior($getProfit1Id);
            if($getProfit2Id){

                $cash_record_cost1 = ($Profit->profit2 / 100) * $money;
                $data_array1 = array(
                    'user_id'=>$getProfit2Id,
                    'cash_record_type'=>'+',
                    'cash_record_cost'=>$cash_record_cost1,
                    'cost_type'=>'cash',
                    'cash_record_time'=>date('Y-m-d H:i:s')
                );
                $flag[] = $this->insertDistributionInfo("cash_record",$data_array1);
                $flag[] = $this->updateAccountMoney($getProfit2Id,$cash_record_cost);
                $data_log1 = array(
                    'user_id'=>$user_id,
                    'money'=>$money,
                    'increase_money'=>$cash_record_cost1,
                    'rank'=>2,
                    'rank_user_id'=>$getProfit2Id,
                    'time'=>date('Y-m-d H:i:s')
                );
                $flag[] = $this->insertDistributionInfo("drp_log",$data_log1);

            }

        }

        if(!in_array("", $flag)){
            return true;
        }else{
            return false;
        }


    }

    /**
     * 插入信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function insertDistributionInfo($table,$data_array){
        return $this->wpdb->insert($this->table.$table,$data_array);

    }

    function getSuperior($user_id){
        return $this->wpdb->get_var("SELECT `parent_id` FROM `{$this->table}account` WHERE `user_id`= {$user_id}");;
    }

    /**
     * 更新用户金额
     * @param $user_id
     * @param $money
     * @return false|int
     */
    function updateAccountMoney($user_id,$money){

        return $this->wpdb->query("UPDATE `{$this->table}account` SET `user_money`= user_money+ {$money} WHERE `user_id`= {$user_id}");
    }


}