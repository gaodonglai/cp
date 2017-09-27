<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 21:18
 */

namespace Model;


class BankMg
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
    public function insertBankMgInfo($table,$data_array){
        return $this->wpdb->insert($this->table.$table,$data_array);

    }

    /**
     * 获取交易密码
     * @param $user_id
     * @return null|string
     */
    public function getPayPassword($user_id){
        return $this->wpdb->get_var("SELECT payment_password FROM `{$this->table}account_payment` WHERE `user_id` = {$user_id}");
    }

    //获取待提现的金额
    public function getExtractPendingMoney($user_id){
        return $this->wpdb->get_var("SELECT sum(money+service_charge) FROM `{$this->table}extract_money_log` WHERE `user_id` = {$user_id}");
    }

    /**
     * 更新用户金额(减少)
     * @param $user_id
     * @param $money
     * @return false|int
     */
    function updateAccountMoney($user_id,$money){

        return $this->wpdb->query("UPDATE `{$this->table}account` SET `reward_money`= reward_money - {$money} WHERE `user_id`= {$user_id}");
    }

    /**
     * 获取用户提现记录
     * @param $user_id
     * @return false|int
     */
    function getUserWithdrawRecord($user_id){

        $limit = 5;
        $pagenum = isset( $_GET['page'] ) ? absint( $_GET['page'] ) : 1; //获取分页数
        $offset = ( $pagenum - 1 ) * $limit;

        $content = $this->wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS a.*,b.account_number,b.opening_bank,b.card_type FROM `{$this->table}extract_money_log` as a LEFT JOIN `{$this->table}card_binding` as b on a.bankcard = b.id  WHERE  a.`user_id` = {$user_id} ORDER BY  `a`.`id` DESC limit {$offset},{$limit}");

        $count = $this->wpdb->get_var("SELECT FOUND_ROWS();");
        return array('content'=>$content,'count'=>$count / $limit,'pagenum'=>$pagenum);

    }

}