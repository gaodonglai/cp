<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 21:18
 */

namespace Model;


class Pay
{

    function __construct()
    {

        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix;

    }

    /**
     * 插入信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function insertPyaInfo($table,$data_array){
        return $this->wpdb->insert($this->table.$table,$data_array);

    }

    /**
     * 获取当天所有充值金额
     */
    public function getTodayPayMoney($pay_money){

        return $this->wpdb->get_results("select pay_money from {$this->table}artificial_pay where status='s' and pay_money ={$pay_money} and to_days(time) = to_days(now());");
    }


    /**
     * 查询银行卡是否存在
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function getAccountBank($user_id,$bank_id){
        return $this->wpdb->get_var("SELECT card_type FROM `{$this->table}card_binding` WHERE `user_id`= {$user_id} and`id`= {$bank_id}");

    }

    /**
     * 查询用户提现记录是否存在
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function getArtificialPayLog($user_id,$bank_id){
        return $this->wpdb->get_row("SELECT * FROM `{$this->table}artificial_pay` WHERE `user_id`= {$user_id} and`id`= {$bank_id} and status='s'");

    }

    /**
     * 查询用户提现记录是否存在
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function updateArtificialPayLog($user_id,$id){
        return $this->wpdb->query("UPDATE `{$this->table}artificial_pay` SET `status`= 'n',`remarks`= '用户取消' WHERE `user_id`= {$user_id} and`id`= {$id}");

    }
}