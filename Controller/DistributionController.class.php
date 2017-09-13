<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/9/11
 * Time: 16:55
 * 分销商接口
 */

namespace Controller;


class Distribution
{
    public function __construct()
    {
        $this->user_info = get_user_info();
        //如果没有登录跳转到登录页面
        if(!$this->user_info){
            redirect(_get_home_url('?show=login'));
        }
        $this->model = new \Model\Distribution();

    }

    function main(){
        $user_id = $this->user_info->user_id;
        $this->model->wpdb->query("BEGIN");




        $result1 = $this->model->setPayLog($user_id,100,20,'wechat');

        $result2 = $this->model->setDistributionProfit($user_id,100);

        if($result1 && $result2){
            echo '成功';
            $this->model->wpdb->query("COMMIT");
        }else{
            echo '失败';
            $this->model->wpdb->query("ROLLBACK");
        }
    }





}