<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/9/11
 * Time: 17:01
 */

namespace Model;


class Distribution
{

    function __construct()
    {

        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix;

    }


    /**
     * @param $user_id 当前注册用户id
     * @param $parent_id 直接推广者id
     */
    function setRegiterDrp($user_id,$parent_id){

        $flag = array();
        $data_log1 = array(
            'user_id'=>$user_id,
            'money'=>'0',
            'increase_money'=>'0',
            'is_official'=>'0',
            'rank'=>1,
            'rank_user_id'=>$parent_id,
            'time'=>date('Y-m-d H:i:s')
        );
        $flag[] = $this->insertDistributionInfo("drp_log",$data_log1);

        //获取间接推广者id
        $getProfit2Id =  $this->getSuperior($parent_id);
        if($getProfit2Id){
            $data_log1 = array(
                'user_id'=>$user_id,
                'money'=>'0',
                'increase_money'=>'0',
                'is_official'=>'0',
                'rank'=>2,
                'rank_user_id'=>$getProfit2Id,
                'time'=>date('Y-m-d H:i:s')
            );
            $flag[] = $this->insertDistributionInfo("drp_log",$data_log1);
        }

    }

    function getSuperior($user_id){
        return $this->wpdb->get_var("SELECT `parent_id` FROM `{$this->table}account` WHERE `user_id`= {$user_id}");;
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


    /**
     * 获取下级分销商
     * @param $user_id
     * @param $rank 级别 1/2
     */
    function getMyMember($user_id,$rank){
        $limit = 10;
        //获取分页数
        $pagenum = isset( $_GET['page'] ) ? absint( $_GET['page'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;
        return $this->wpdb->get_results("SELECT sum(increase_money) as increase_money,b.user_name,b.reg_time FROM `{$this->table}drp_log` as a left join `{$this->table}account` as b on a.user_id = b.user_id WHERE a.rank_user_id={$user_id} and a.rank ={$rank} group by a.user_id  ORDER BY a.id DESC  limit {$offset},{$limit}");

    }

    /**
     * 我的佣金明细
     * @param $user_id
     */
    function getMyCommissionDetail($user_id){

        $limit = 5;
        $pagenum = isset( $_GET['detail_page'] ) ? absint( $_GET['detail_page'] ) : 1; //获取分页数
        $offset = ( $pagenum - 1 ) * $limit;

        $content = $this->wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS a.increase_money,a.money,a.rank,a.time,b.user_name FROM `{$this->table}drp_log` as a left join `{$this->table}account` as b on a.user_id = b.user_id WHERE a.rank_user_id={$user_id} and a.is_official = 1  ORDER BY a.time DESC  limit {$offset},{$limit}");

        $count = $this->wpdb->get_var("SELECT FOUND_ROWS();");
        return array('content'=>$content,'count'=>$count / $limit,'pagenum'=>$pagenum);
    }

    /**
     * 获取总佣金
     * @param $user_id
     * @return mixed
     */
    function getMyCommission($user_id){
        return $this->wpdb->get_var("SELECT sum(increase_money) as increase_money FROM `{$this->table}drp_log` WHERE rank_user_id={$user_id} and is_official = 1");
    }

    /**
     * 获取今日佣金
     * @param $user_id
     * @return mixed
     */
    function getMyTodayCommission($user_id){
        return $this->wpdb->get_var("SELECT sum(increase_money) as increase_money FROM `{$this->table}drp_log` WHERE rank_user_id={$user_id} and is_official = 1 and  TO_DAYS(time) = TO_DAYS(NOW())");
    }

}