<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 21:18
 */

namespace Model;


class Register
{

     function __construct()
     {

          global $wpdb;
          $this->wpdb = $wpdb;
          $this->table = $this->wpdb->prefix;

     }


    /**
     * @param $code
     * 查询用户分享是否存在
     * @return false|int 用户分享信息
     */
    public function getAccountLinkShare($code){

        return $this->wpdb->get_row("SELECT * FROM `{$this->table}account_link_share` WHERE `reg_code` = '{$code}'");

    }

}
