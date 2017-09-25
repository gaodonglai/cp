<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:01
 */
namespace admin\account\model;

class WithdrawModel
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
    public function insertWithdrawInfo($table,$data_array){
        return $this->wpdb->insert($this->table.$table,$data_array);

    }

    /**
     * 插入信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function updateWithdrawInfo($table,$data_array,$where_array){
        return $this->wpdb->update($this->table.$table,$data_array,$where_array);

    }

    /**
     * 更新用户金额(增加)
     * @param $user_id
     * @param $money
     * @return false|int
     */
    function updateAccountMoney($user_id,$money){

        return $this->wpdb->query("UPDATE `{$this->table}account` SET `reward_money`= reward_money + {$money} WHERE `user_id`= {$user_id}");
    }

}