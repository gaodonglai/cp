<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:14
 * pageName:充值页面
 */

?>

<!--个人中心内容-->
<main class="personal_main">
    <?php
    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--立即充值-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>立即充值</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla rig_main_capital Recharge_header">
                    <a class="tab1 betting_top-active" href="#Recharge_tab1">支付宝微信扫码充值</a>
                    <a class="tab2" href="#Recharge_tab2">QQ钱包充值</a>
                    <a class="tab3" href="#Recharge_tab3">银行卡充值</a>
                    <a class="tab4" href="#Recharge_tab4">大额人工服务充值</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active table_capital_main" id="Recharge_tab1">
                        <p>支付宝微信扫码充值</p>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Recharge_tab2">
                        <p>QQ钱包充值</p>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Recharge_tab3">
                        <dl class="auto_in_tab">
                            <dt>尊敬的用户，平台充值系统已升级，请按以下充值流程进行操作：</dt>
                            <dd><img src="View/pc/image/cz_bank.png" class="cz_bank">绑定本人银行卡</dd>
                            <dd><img src="View/pc/image/cz_jt.png"  class="cz_jt"></dd>
                            <dd><img src="View/pc/image/cz_zz.png" class="cz_bank">使用已选择的银行卡充值</dd>
                            <dd><img src="View/pc/image/cz_jt.png"  class="cz_jt"></dd>
                            <dd><img src="View/pc/image/cz_auto.png" class="cz_bank">系统自动入账</dd>
                        </dl>
                        <div class="blankRemittance">
                            <div class="blankRemittance_bg">
                                <ul>
                                    <li><img src="View/pc/image/icon_h_recharge.png"  class="icon_h_recharge"><span class="h_title">充值提醒</span></li>
                                    <li class="word">
                                        <p>抱歉，当前账户暂时未绑定银行卡，请添加银行卡后进行充值。</p>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="blankRemittance_a">添加银行卡</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Recharge_tab4">
                        <p>大额人工服务充值</p>
                        <div class="basic_information">
                            <p class="color_red_mddd2">请完成下面充值金额确认后再进行转账</p>
                        </div>
                        <form action="<?=_get_home_url('pay/setArtificialPay')?>" class="artificial_pay basic_information_form Withdrawals_bind_form registerform">
                            <ul>

                            <li class="basic_information_d">
                                <label for="" style="width: 111px;">充值金额(￥)：</label>
                                <input type="number" name="pay_money" value="" datatype="n3-11">
                                <span class="Validform_checktip" style="    width: 400px;height: 66px;">为了尽快确认您的订单，我们会在充值金额后面添加随机小数点。如充值100会有返回的充值金额如100.23。</span>
                            </li>

                            <li class="basic_information_i">
                                <label for=""></label>
                                <button class="modify_sub">确认充值</button>
                            </li>

                            </ul>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var url_status = $.getUrlParam('Recharge');
    if(url_status){
        $(".rig_main_capital a").removeClass("betting_top-active");
        $('.'+url_status).addClass("betting_top-active");
        $(".table_capital_main").removeClass("table_betting_active");
        $(".brigtinh_main_cen").fadeOut(300);
        $('#Recharge_'+url_status).delay(300).fadeIn();
    }



    $(".artificial_pay").on("submit",function(){

        var _this = $(this);
        $.ajax({
            type : 'POST',  //提交方式
            dataType:'json',
            url : _this.attr('action'),//路径
            data:_this.serializeArray(),//
            success : function(data) {//返回数据根据结果进行相应的处理

                if ( data.status == 'y') {
                    $('#Recharge_tab4').html("");
                    $('#Recharge_tab4').html('<div class="blankRemittance"> <div class="blankRemittance_bg"> <ul> <li><img src="<?=_get_home_url()?>View/pc/image/icon_h_recharge.png"  class="icon_h_recharge"><span class="h_title">充值提醒</span></li> <li class="word"> <p>充值金额：<span class="h_title">'+data.info+'</span>请按照本次显示的金额进行充值。</p> </li> <li> <a href="javascript:void(0)" class="blankRemittance_a">添加银行卡</a> </li> </ul> </div> </div>');


                } else {
                    $.alerts(data.info)
                }
            }
        });
        return false;

    });
</script>