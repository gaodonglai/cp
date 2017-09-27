<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:14
 * pageName:提现申请
 */

?>

<!--个人中心内容-->
<main>
<div class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--提现申请-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>提现申请</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla rig_main_capital">
                    <a class="betting_top-active binding1" href="#Withdrawals_binding1">银行卡提现</a>
                   <!-- <a class="binding2" href="#Withdrawals_binding2">支付宝提现</a>-->
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active table_capital_main" id="Withdrawals_binding1">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>暂不支持信用卡和微信提现，目前仅支持储蓄卡和支付宝提现。</p>
                        <form action="<?=_get_home_url('bankMg/withdrawalApp')?>" class="postAjax basic_information_form Withdrawals_bind_form registerform">
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">银行卡号：</label>

                                    <select name="bank" class="loginValue">
                                        <option value="">请选择</option>
                                        <?php
                                        $flag = true;
                                        if($content){
                                            print_r($content);
                                            foreach ($content as $item) {
                                                if ($item->card_type == 'bank') {

                                                    $flag = false;
                                                    ?>
                                                    <option value="<?=$item->opening_bank?>"><?=$bank[$item->opening_bank]?>尾号：<?=substr($item->account_number, -4)?></option>
                                                    <?php
                                                }
                                               /* if($item->card_type == 'alipay'){
                                                    $alipay_id = $item->id;
                                                    $alipay_name = $item->account_number;

                                                }*/
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if($flag){
                                        ?>
                                        <span >没有银行卡<a class="color_red_mddd " href="<?=_get_home_url('account/bankCard')?>">去添加</a></span>
                                    <?php
                                    }
                                    ?>
                                </li>
                                <li class="basic_information_b">
                                    <label for="">可用人民币：</label>
                                    <span class="color_red_mddd leftdd"><?=$money ? sprintf("%.2f",$money) : '0.00'?></span>
                                </li>
                                <li class="basic_information_d">
                                    <label for="">提现金额(￥)：</label>
                                    <input type="number" name="money" value="" datatype="n3-11" nullmsg="请输入提现金额" errormsg="最少提现金额为￥<?=$quota?>"//>
                                    <span class="Validform_checktip">最少提现金额为￥<?=$quota?></span>
                                </li>
                                <li class="basic_information_e">
                                    <label for="">交易密码：</label>
                                    <input type="password" name="deal_password" value=""  datatype="*5-15" nullmsg="请填写密码！" errormsg="密码范围在5~15位之间！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_c">
                                    <label for="">到账时间：</label>
                                    <div class="basic_information_c_main">
                                    <label class="basic_radio_label">
                                        <input class="mui-checkbox checkbox-s checkbox-orange"  id="type-1" type="radio" name="paymen_type" value = "2" />
                                        <i class="iconfont checkbox-i">&#xe628;</i> 极速提现（9:00——18:00时间段 1时内到账，其他时间段 12小时内到账） 
                                    </label>
                                    <label class="basic_radio_label">
                                        <input class="mui-checkbox checkbox-s checkbox-orange" id="type-2" type="radio" name="payment_ype" value = "1" checked="1"/>
                                         快速提现   （正常24小时内到账，具体到账时间因收款银行略有不同，节假日会略有延迟）
                                        <i class="iconfont checkbox-i">&#xe628;</i>
                                    </label>
                                    </div>
                                </li>
                                <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">确认提现</button>
                                </li>
                            </ul>
                        </form>
                        <h3>提现记录</h3>
                        <table class="table_reference">
                            <thead class="tbody_referencea">
                            <tr>
                                <th><span>操作时间</span></th>
                                <th><span>提现金额</span></th>
                                <th><span>手续费</span></th>
                                <th><span>实收金额</span></th>
                                <th><span>银行名称</span></th>
                                <th><span>银行卡后四位</span></th>
                                <th><span>状态</span></th>
                                <th><span>拒绝理由</span></th>

                            </tr>
                            </thead>
                            <tbody class="tbody_referenceb tbody_referencebc">
                            <?php
                            if($withdraw_log['content']){
                                foreach ($withdraw_log['content'] as $item) {

                                        ?>
                                        <tr class="screen_nowin_a">
                                            <td><span><?=$item->time?></span></td>
                                            <td><span><?=$item->money?></span></td>
                                            <td><span><?=$item->service_charge?></span></td>
                                            <td><span><?=sprintf("%.2f",$item->money - $item->service_charge)?></span></td>

                                            <?php
                                            if($item->card_type == 'bank'){
                                                ?>
                                                <td><span><?=$bank[$item->opening_bank]?></span></td>
                                                <td><span><?=substr($item->account_number,'-4')?></span></td>
                                                <?php
                                            }else{
                                            ?>
                                            <td><span><?=$dispose_type[$item->card_type]?></span></td>
                                                <td><span><?=hideStar($item->account_number)?></span></td>
                                            <?php

                                            }

                                            ?>

                                            <td><span class="tdbetting-active-aa"><?=$dispose_stauts[$item->status]?></span></td>
                                            <td><span><?=$item->refuse_reason?></span></td>

                                        </tr>
                                        <?php

                                }
                            }else{
                                ?>
                                <tr class="screen_nowin_a">
                                    <td><span></span></td>
                                    <td><span></span></td>
                                    <td><span></span></td>
                                    <td><span></span></td>
                                    <td><span></span>没有记录</td>
                                    <td><span></span></td>
                                    <td><span class="tdbetting-active-aa"></span></td>
                                    <td><span></span></td>

                                </tr>
                            <?php
                            }

                            ?>

                            </tbody>
                        </table>
                        <hr class="style12">
                        <?php
                        $page_links = paginate_links( array(
                            'base' => add_query_arg( 'page', '%#%'.'#Withdrawals_binding1' ),
                            'format' => '',
                            'prev_text' => __( '上一页', 'aag' ),
                            'next_text' => __( '下一页', 'aag' ),
                            'total' => ceil( $withdraw_log['count']),
                            'current' => $withdraw_log['pagenum']
                        ) );

                        if ( $page_links ) {
                            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
                        }
                        ?>
                    </div>
                   <!-- <div class="table_betting_main  table_capital_main Withdrawals_bind_main" id="Withdrawals_binding2">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>暂不支持信用卡和微信提现，目前仅支持储蓄卡和支付宝提现。</p>
                        <form action="<?/*=_get_home_url('bankMg/withdrawalApp')*/?>" class="postAjax basic_information_form Withdrawals_bind_form registerform">
                            <input type="hidden" name="bank" value="<?/*=$alipay_id*/?>" >
                            <input type="hidden" name="payment_ype" value="1" >
                            <ul>
                                <?php
/*                                if(empty($alipay_name)){
                                    */?>
                                    <li class="basic_information_a">
                                        <span >没有支付宝账号：<a class="color_red_mddd " href="<?/*=_get_home_url('account/bankCard#Bank_card_binding2')*/?>">去添加</a></span>
                                    </li>

                                    <?php
/*                                }else{
                                    */?>
                                    <li class="basic_information_a">
                                        <label for="">支付宝账号：</label>
                                        <input type="text" disabled="disabled" name="money" value="<?/*=hideStar($alipay_name)*/?>"  nullmsg="请输入支付宝账号" datatype="*4-18" errormsg="至少6个字符,最多18个字符！">
                                        <span class="Validform_checktip"></span>
                                    </li>
                                <?php
/*                                }
                                */?>

                                <li class="basic_information_b">
                                    <label for="">可用人民币：</label>
                                    <span class="color_red_mddd leftdd"><?/*=$money ? sprintf("%.2f",$money) : '0.00'*/?></span>
                                </li>
                                <li class="basic_information_d">
                                    <label for="">提现金额(￥)：</label>
                                    <input type="number" name="money" value="" datatype="n3-11" nullmsg="请输入提现金额" errormsg="最少提现金额为￥<?/*=$quota*/?>"/>
                                    <span class="Validform_checktip">最少提现金额为￥<?/*=$quota*/?></span>
                                </li>
                                <li class="basic_information_e">
                                    <label for="">交易密码：</label>
                                    <input type="password" name="deal_password" value=""  datatype="*5-15" nullmsg="请输入交易密码" errormsg="密码范围在5~15位之间！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_c">
                                    <label for="">到账时间：</label>
                                    <span class="leftdd">24小时内到账</span>
                                </li>
                                <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">确认提现</button>
                                </li>
                            </ul>
                        </form>
                        <h3>提现记录</h3>
                        <table class="table_reference">
                            <thead class="tbody_referencea">
                            <tr>
                                <th><span>操作时间</span></th>
                                <th><span>提现金额</span></th>
                                <th><span>手续费</span></th>
                                <th><span>实收金额</span></th>
                                <th><span>支付宝账号</span></th>
                                <th><span>状态</span></th>
                                <th><span>拒绝理由</span></th>

                            </tr>
                            </thead>
                            <tbody class="tbody_referenceb tbody_referencebc">
                            <?php
/*                            if($withdraw_log){
                                foreach ($withdraw_log as $item) {
                                    if($item->card_type == 'alipay'){
                                        */?>
                                        <tr class="screen_nowin_a">
                                            <td><span><?/*=$item->time*/?></span></td>
                                            <td><span><?/*=$item->money*/?></span></td>
                                            <td><span><?/*=$item->service_charge*/?></span></td>
                                            <td><span><?/*=sprintf("%.2f",$item->money - $item->service_charge)*/?></span></td>
                                            <td><span><?/*=substr($item->account_number,'-4')*/?></span></td>
                                            <td><span class="tdbetting-active-aa"><?/*=$dispose_stauts[$item->status]*/?></span></td>
                                            <td><span><?/*=$item->refuse_reason*/?></span></td>

                                        </tr>
                                        <?php
/*                                    }
                                }
                            }else{
                                */?>
                                <tr class="screen_nowin_a">
                                    <td><span></span></td>
                                    <td><span></span></td>
                                    <td><span></span></td>

                                    <td><span></span>没有记录</td>
                                    <td><span></span></td>
                                    <td><span class="tdbetting-active-aa"></span></td>
                                    <td><span></span></td>

                                </tr>
                                <?php
/*                            }

                            */?>
                            </tbody>
                        </table>
                        <hr class="style12">

                    </div>-->
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
