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
<main class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">

        <div class="personal_main_macen personal_main_active" id="persona6-f">
            <div class="per_main_rig_top">
                <h4>提现申请</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla Withdrawals_bind">
                    <a class="betting_top-active" href="#Withdrawals_binding1">银行卡提现</a>
                    <a href="#Withdrawals_binding2">支付宝提现</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active Withdrawals_bind_main" id="Withdrawals_binding1">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>暂不支持信用卡和微信提现，目前仅支持储蓄卡和支付宝提现。</p>
                        <form action="" class="basic_information_form Withdrawals_bind_form">
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">银行卡号：</label>
                                    <select name="bankother" class="loginValue" onchange="selectInput(this);">
                                        <option data-msg="6217003890002717564" value="274014">中国建设银行尾号：7564</option>
                                        <option data-msg="6217003890002717564" value="274014">中国农业银行尾号：7564</option>
                                        <option data-msg="6217003890002717564" value="274014">中国招商银行尾号：7564</option>
                                    </select>
                                </li>
                                <li class="basic_information_b">
                                    <label for="">可用人民币：</label>
                                    <span class="color_red_mddd leftdd">5000.00</span>
                                </li>
                                <li class="basic_information_d">
                                    <label for="">提现金额(￥)：</label>
                                    <input type="text" name="money" value=""  required="required">
                                    <span class="color_red_mdcc">最少提现金额为￥100</span>
                                </li>
                                <li class="basic_information_e">
                                    <label for="">交易密码：</label>
                                    <input type="password" name="pwdtrade" value=""  required="required">
                                </li>
                                <li class="basic_information_c">
                                    <label for="">到账时间：</label>
                                    <div class="basic_information_c_main">
                                        <label class="basic_radio_label">
                                            <input class="mui-checkbox checkbox-s checkbox-orange"  id="type-1" type="radio" name="paymentype" value = "2" />
                                            <i class="iconfont checkbox-i">&#xe628;</i> 极速提现（9:00——18:00时间段 1时内到账，其他时间段 12小时内到账）
                                        </label>
                                        <label class="basic_radio_label">
                                            <input class="mui-checkbox checkbox-s checkbox-orange" id="type-2" type="radio" name="paymentype" value = "1" checked="1"/>
                                            快速提现	（正常24小时内到账，具体到账时间因收款银行略有不同，节假日会略有延迟）
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
                                <th><span>操作</span></th>
                            </tr>
                            </thead>
                            <tbody class="tbody_referenceb tbody_referencebc">
                            <tr class="screen_nowin_a">
                                <td><span>2017-08-23 16:46:29</span></td>
                                <td><span>300.00</span></td>
                                <td><span>2.00</span></td>
                                <td><span>298.00</span></td>
                                <td><span>建设银行</span></td>
                                <td><span>7564</span></td>
                                <td><span class="tdbetting-active-aa">通过</span></td>
                                <td><span></span></td>
                                <td><span><a href=""><i class="iconfont">&#xe629;</i></a></span></td>
                            </tr>
                            <tr class="screen_nowin_a">
                                <td><span>2017-08-23 16:46:29</span></td>
                                <td><span>300.00</span></td>
                                <td><span>2.00</span></td>
                                <td><span>298.00</span></td>
                                <td><span>建设银行</span></td>
                                <td><span>7564</span></td>
                                <td><span class="tdbetting-active-b">未通过</span></td>
                                <td><span>银行卡异常</span></td>
                                <td><span><a href=""><i class="iconfont">&#xe629;</i></a></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr class="style12">
                    </div>
                    <div class="table_betting_main  Withdrawals_bind_main" id="Withdrawals_binding2">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>暂不支持信用卡和微信提现，目前仅支持储蓄卡和支付宝提现。</p>
                        <form action="" class="basic_information_form Withdrawals_bind_form">
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">支付宝账号：</label>
                                    <input type="text" name="money" value=""  required="required">
                                </li>
                                <li class="basic_information_b">
                                    <label for="">可用人民币：</label>
                                    <span class="color_red_mddd leftdd">5000.00</span>
                                </li>
                                <li class="basic_information_d">
                                    <label for="">提现金额(￥)：</label>
                                    <input type="text" name="money" value=""  required="required">
                                    <span class="color_red_mdcc">最少提现金额为￥100</span>
                                </li>
                                <li class="basic_information_e">
                                    <label for="">交易密码：</label>
                                    <input type="password" name="pwdtrade" value=""  required="required">
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
                                <th><span>操作</span></th>
                            </tr>
                            </thead>
                            <tbody class="tbody_referenceb tbody_referencebc">
                            <tr class="screen_nowin_a">
                                <td><span>2017-08-23 16:46:29</span></td>
                                <td><span>300.00</span></td>
                                <td><span>2.00</span></td>
                                <td><span>298.00</span></td>
                                <td><span>13219079952</span></td>
                                <td><span class="tdbetting-active-aa">通过</span></td>
                                <td><span></span></td>
                                <td><span><a href=""><i class="iconfont">&#xe629;</i></a></span></td>
                            </tr>
                            <tr class="screen_nowin_a">
                                <td><span>2017-08-23 16:46:29</span></td>
                                <td><span>300.00</span></td>
                                <td><span>2.00</span></td>
                                <td><span>298.00</span></td>
                                <td><span>526399773</span></td>
                                <td><span class="tdbetting-active-b">未通过</span></td>
                                <td><span>账号异常</span></td>
                                <td><span><a href=""><i class="iconfont">&#xe629;</i></a></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr class="style12">
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>