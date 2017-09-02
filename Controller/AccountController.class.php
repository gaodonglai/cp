<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:07
 */

namespace Controller;


class Account
{
    function __construct()
    {
        //如果没有登录跳转到登录页面

    }

    function main(){

        $this->my();
    }


    /**
     *投注
     */
    function bet(){

        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountBet');

        get_footer_front();
    }

    /**
     *银行卡管理
     */
    function bankCard(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountBankCard');

        get_footer_front();
    }

    /**
     *提现申请
     */
    function extractMoney(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountExtractMoney');

        get_footer_front();
    }

    /**
     *资金明细
     */
    function fcDetails(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountFcDetails');

        get_footer_front();
    }

    /**
     *我的账户
     */
    function my(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountMy');

        get_footer_front();
    }

    /**
     *密码修改
     */
    function passwordUp(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountPasswordUp');

        get_footer_front();
    }

    /**
     *支付
     */
    function pay(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountPay');

        get_footer_front();
    }

    /**
     *充值返现活动
     */
    function payActivity(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountPayActivity');

        get_footer_front();
    }





}