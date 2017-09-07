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
     * 查询用户分享是否存在
     * @return false|int 用户分享信息
     */
    public function getAccountLinkShare($user_id){

        return $this->wpdb->get_row("SELECT * FROM `{$this->table}account_link_share` WHERE `user_id` = {$user_id}");

        //phpqrcode('http://www.baidu.com');

    }

    /**
     * @param $user_id
     * 创建用户分享
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
     * 更新用户分享
     * @return false|int 用户分享信息
     */
    public function updateAccountLinkShare($user_id,$valid_time){

        $time = strtotime("+{$valid_time} min");

        $reg_code = wpEncrypt($user_id.$time);

        return $this->wpdb->query("UPDATE `{$this->table}account_link_share` SET `reg_code`='{$reg_code}',`end_time`={$time} WHERE `user_id`= {$user_id}");

    }


    /**
     * 更新用户信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function updateAccountInfo($table,$data_array,$where_clause){
        return $this->wpdb->update($this->table.$table,$data_array,$where_clause);

    }


}
