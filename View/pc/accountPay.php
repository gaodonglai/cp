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

        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>立即充值</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla Recharge_header">
                    <a class="betting_top-active" href="#Recharge_tab1">支付宝微信扫码充值</a>
                    <a href="#Recharge_tab2">QQ钱包充值</a>
                    <a href="#Recharge_tab3">银行卡充值</a>
                    <a href="#Recharge_tab4">大额人工服务充值</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active tab_Recharge" id="Recharge_tab1">
                        <p>支付宝微信扫码充值</p>
                    </div>
                    <div class="table_betting_main tab_Recharge" id="Recharge_tab2">
                        <p>QQ钱包充值</p>
                    </div>
                    <div class="table_betting_main tab_Recharge" id="Recharge_tab3">
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
                    <div class="table_betting_main tab_Recharge" id="Recharge_tab4">
                        <p>大额人工服务充值</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>