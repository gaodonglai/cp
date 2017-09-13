<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 21:18
 */

namespace Model;


class Account
{

     function __construct()
     {

          global $wpdb;
          $this->wpdb = $wpdb;
          $this->table = $this->wpdb->prefix;

     }


    /**
     * @param $user_id
     * 查询用户名片
     * @return false|int 用户分享信息
     */
    public function getAccountLinkShare($user_id){

        return $this->wpdb->get_row("SELECT * FROM `{$this->table}account_link_share` WHERE `user_id` = {$user_id}");

        //phpqrcode('http://www.baidu.com');

    }

    /**
     * @param $user_id
     * 创建用户名片
     * @return false|int 用户分享信息
     */
    public function setAccountLinkShare($user_id,$valid_time){

        $time = strtotime("+{$valid_time} min");

        $reg_code = wpEncrypt($user_id.$time);

        return $this->wpdb->query("INSERT INTO `{$this->table}account_link_share`( `user_id`, `reg_code`, `end_time`) VALUES ({$user_id},'{$reg_code}',{$time})");

        //phpqrcode('http://www.baidu.com');

    }

    /**
     * @param $user_id
     * 更新用户名片
     * @return false|int 用户分享信息
     */
    public function updateAccountLinkShare($user_id,$valid_time){

        $time = strtotime("+{$valid_time} min");

        $reg_code = wpEncrypt($user_id.$time);

        return $this->wpdb->query("UPDATE `{$this->table}account_link_share` SET `reg_code`='{$reg_code}',`end_time`={$time} WHERE `user_id`= {$user_id}");

    }


    /**
     * 更新信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function updateAccountInfo($table,$data_array,$where_clause){
        return $this->wpdb->update($this->table.$table,$data_array,$where_clause);

    }


    /**
     * 插入信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function insertAccountInfo($table,$data_array){
        return $this->wpdb->insert($this->table.$table,$data_array);

    }

    /**
     * 查询银行卡数量
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function getBankCardCount($user_id,$type){

        return $this->wpdb->get_var("SELECT COUNT(*) FROM `{$this->table}card_binding` WHERE `user_id`={$user_id} and `card_type`='{$type}'");

    }

    /**
     * 查询银行信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function getBankCardAll($user_id){

        return $this->wpdb->get_results("SELECT * FROM `{$this->table}card_binding` WHERE `user_id`={$user_id}");

    }
    /**
     * 获取交易密码
     * @param $user_id
     * @return array
     */
    public function getAccountPayment($user_id){

        return $this->wpdb->get_row("SELECT * FROM `{$this->table}account_payment` WHERE `user_id`={$user_id}");

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
