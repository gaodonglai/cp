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
<main">
<div class="personal_main">
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
                    <a class="tab1 " href="#Recharge_tab1">支付宝微信扫码充值</a>
                    <a class="tab2" href="#Recharge_tab2">QQ钱包充值</a>
                    <a class="tab3" href="#Recharge_tab3">银行卡充值</a>
                    <a class="tab4 betting_top-active" href="#Recharge_tab4">人工服务充值</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main  table_capital_main" id="Recharge_tab1">
                        <p class="color_red_mddd2">支付宝微信扫码充值暂未开通，请暂时使用人工充值</p>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Recharge_tab2">
                        <p class="color_red_mddd2">QQ钱包充值暂未开通，请暂时使用人工充值</p>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Recharge_tab3">
                        <p class="color_red_mddd2">支付宝微信扫码充值暂未开通，请暂时使用人工充值</p>
                        <!--<dl class="auto_in_tab">
                            <dt>尊敬的用户，平台充值系统已升级，请按以下充值流程进行操作：</dt>
                            <dd><img src="View/pc/image/cz_bank.png" class="cz_bank">绑定本人银行卡</dd>
                            <dd><img src="View/pc/image/cz_jt.png"  class="cz_jt"></dd>
                            <dd><img src="View/pc/image/cz_zz.png" class="cz_bank">使用已选择的银行卡充值</dd>
                            <dd><img src="View/pc/image/cz_jt.png"  class="cz_jt"></dd>
                            <dd><img src="View/pc/image/cz_auto.png" class="cz_bank">系统自动入账</dd>
                        </dl>-->
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
                    <div class="table_betting_main table_betting_active table_capital_main" id="Recharge_tab4">
                        <?php

                        if($artificial_pay){

                            if($artificial_pa->card_type == 'bank'){
                                $pathering_bank = get_option('admin_pathering_bank');//获取银行卡
                                if($pathering_bank){
                                    $count = count($pathering_bank);

                                    if($count == 1){
                                        $rand = 0;
                                    }else{
                                        $rand = rand(0,$count);
                                    }
                                    $pathering_bank = $pathering_bank[$rand];

                                }
                                echo '<div class="blankRemittance"> 
                                    <div class="blankRemittance_bg"> 
                                        <ul>
                                             <li><img src="'._get_home_url().'View/pc/image/icon_h_recharge.png"  class="icon_h_recharge"><span class="h_title">充值列表</span></li> 
                                             <li class=""> <p>银行：<span class="">'.$pathering_bank['bank_name'].'</span></p> </li>
                                             <li class=""> <p>卡号：<span class="">'.$pathering_bank['bank_card'].'</span></p> </li>
                                             <li class=""> <p>姓名：<span class="">'.$pathering_bank['bank_nickname'].'</span></p> </li>
                                             <li class=""> <p>充值金额：<span class="h_title">'.$artificial_pay->pay_money.'</span>请按照本次显示的金额往以上的账户进行转账，以便快速确认</p> </li>
                                             <li class=""> <p><button data-id="'.$artificial_pay->id.'" class="cancel_pay modify_sub">取消本次</button></p> </li>
                                
                                       </ul>
                                    </div>
                                 </div>';
                            }else{
                                echo '<div class="blankRemittance blankRemittanceaa"> 
                                    <div class="blankRemittance_bg"> 
                                        <ul>
                                             <li><img src="'._get_home_url().'View/pc/image/icon_h_recharge.png"  class="icon_h_recharge"><span class="h_title">充值列表</span></li> 
                                             <li class=""> <p>公司名称：<span class="">四川成都美誉艺术品</span></p> </li>
                                             <li class=""><img style="    width: 40%;" src="'._get_home_url().'View/pc/image/支付宝与微信收款.png"  class="icon_h_recharge"> </li>
                                              
                                             <li class=""> <p>充值金额：<span class="h_title">'.$artificial_pay->pay_money.'</span>请按照本次显示的金额往以上的账户进行转账，以便快速确认</p> </li>
                                             <li class=""> <p><button data-id="'.$artificial_pay->id.'" class="cancel_pay modify_sub">取消本次</button></p> </li>
                                
                                       </ul>
                                    </div>
                                 </div>';
                            }

                        }else{

                            ?>
                        <div class="basic_information">
                            <p class="color_red_mddd2">提示：该方式为用户转账方式，请完成下面充值金额确认后再进行转账</p>
                        </div>
                        <form action="<?=_get_home_url('pay/setArtificialPay')?>" class="artificial_pay basic_information_form Withdrawals_bind_form registerform">
                        <ul>
                            <?php
                            if($content){
                                ?>
                                <li class="basic_information_d">
                                    <label for="" style="width: 111px;">充值方式：</label>
                                    <select name="type">
                                        <option value="">请选择</option>
                                        <?php
                                        if($content){
                                            foreach ($content as $key=> $item) {
                                                if($item->card_type == 'bank'){
                                                    ?>
                                                    <option value="<?=$item->id?>"> 银行卡 <?=substr($item->account_number,0,3)?>*****<?=substr($item->account_number,'-4')?> <?=$item->account_name ?></option>
                                                    <?php
                                                }elseif($item->card_type == 'alipay'){
                                                    ?>
                                                    <option value="<?=$item->id?>"> 支付宝 <?=hideStar($item->account_number)?> <?=$item->account_name ?></option>
                                                    <?php
                                                }elseif($item->card_type == 'wechat'){
                                                    ?>
                                                    <option value="<?=$item->id?>"> 微信   <?=substr($item->account_number,'-4')?> <?=$item->account_name ?></option>
                                                    <?php
                                                }

                                            }
                                        }?>
                                    </select>
                                </li>
                                <?php
                            }else{
                                ?>
                                <li class="basic_information_a">
                                    <span >没有充值账号信息：<a class="color_red_mddd " href="<?=_get_home_url('account/bankCard#Bank_card_binding1')?>">去添加</a></span>
                                </li>
                                <?php
                            }
                            ?>
                            <li class="basic_information_d czjeyutixin">
                                <label for="" style="width: 111px;">充值金额(￥)：</label>
                                <input type="number" name="pay_money" value="" datatype="n3-11">
                                <span  class="czjetixin">为了尽快确认您的订单，我们会在充值金额后面添加随机小数点。如充值100会有返回的充值金额如100.23。</span>
                            </li>
                            <li class="basic_information_i">
                                <label for=""></label>
                                <button class="modify_sub">确认充值</button>
                            </li>
                            </ul>
                        </form>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</main>
<script>
    window.onload = function() {
        var url_status = $.getUrlParam('Recharge');
        if(url_status){
            $(".rig_main_capital a").removeClass("betting_top-active");
            $('.'+url_status).addClass("betting_top-active");
            $(".table_capital_main").removeClass("table_betting_active");
            $(".brigtinh_main_cen").fadeOut(300);
            $('#Recharge_'+url_status).delay(300).fadeIn();
        }
    };

    $(".cancel_pay").on("click",function(){

        var _this = $(this);
        $.ajax({
            type : 'POST',  //提交方式
            dataType:'json',
            url : '<?=_get_home_url('pay/cancelPay')?>',//路径
            data:{'pay_id':_this.attr('data-id')},//
            success : function(data) {//返回数据根据结果进行相应的处理

                if ( data.status == 'y') {

                    $.alerts(data.info);
                    history.go(0);
                } else {

                    $.alerts(data.info);
                }
            }
        });
        return false;

    });

    $(".artificial_pay").on("submit",function(){

        var _this = $(this);
        $.ajax({
            type : 'POST',  //提交方式
            dataType:'json',
            url : _this.attr('action'),//路径
            data:_this.serializeArray(),//
            success : function(data) {//返回数据根据结果进行相应的处理

                if ( data.status == 'y') {
                    $.alerts(data.info);
                    history.go(0);

                } else {
                    $.alerts(data.info)
                }
            }
        });
        return false;

    });
</script>