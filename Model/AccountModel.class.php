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
     *获取充值记录
     * @param $user_id
     */
    public function getPayLog($user_id){

        $limit = 10;
        $pagenum = isset( $_GET['page'] ) ? absint( $_GET['page'] ) : 1; //获取分页数
        $offset = ( $pagenum - 1 ) * $limit;

        $content = $this->wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM `{$this->table}recharge` WHERE `user_id`={$user_id} ORDER BY `id` DESC limit {$offset},{$limit}");

        $count = $this->wpdb->get_var("SELECT FOUND_ROWS();");
        return array('content'=>$content,'count'=>$count / $limit,'pagenum'=>$pagenum);
    }
    /**
     *获取现金与积分记录
     * @param $user_id
     */
    public function getCashRecord($user_id){
        $limit = 10;
        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1; //获取分页数
        $offset = ( $pagenum - 1 ) * $limit;

        $content = $this->wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS  * FROM `{$this->table}cash_record` WHERE `user_id`={$user_id} ORDER BY `cash_record_time` DESC limit {$offset},{$limit}");

        $count = $this->wpdb->get_var("SELECT FOUND_ROWS();");
        return array('content'=>$content,'count'=>$count / $limit,'pagenum'=>$pagenum);
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

        return $this->wpdb->get_results("SELECT * FROM `{$this->table}card_binding` WHERE `user_id`={$user_id} and  card_state = 'y'");

    }

    /**
     * 查询正在充值的记录
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function getArtificialPay($user_id){

        return $this->wpdb->get_row("SELECT a.*,b.account_number,b.opening_bank,b.card_type FROM `{$this->table}artificial_pay` as a INNER JOIN {$this->table}card_binding as b on a.pay_type=b.id and a.user_id = b.user_id WHERE a.user_id={$user_id} and status = 's'");

    }
    /**
     * 获取交易密码
     * @param $user_id
     * @return array
     */
    public function getAccountPayment($user_id){

        return $this->wpdb->get_row("SELECT * FROM `{$this->table}account_payment` WHERE `user_id`={$user_id}");

    }



}
