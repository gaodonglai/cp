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

}