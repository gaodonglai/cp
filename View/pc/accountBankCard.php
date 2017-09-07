<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:14
 * pageName:银行卡管理
 */

?>

<!--个人中心内容-->
<main class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--银行卡管理-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>银行卡管理</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla rig_main_capital">
                    <a class="betting_top-active" href="#Bank_card_binding1">绑定新的银行卡</a>
                    <a href="#Bank_card_binding2">绑定支付宝账号</a>
                    <a href="#Bank_card_binding3">绑定微信账号</a>
                    <a href="#Bank_card_binding4">已绑定的账号</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active table_capital_main" id="Bank_card_binding1">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>暂不支持信用卡，请填写实名认证的银行卡账户信息。</p>
                        <form action="" class="basic_information_form registerform">
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">选择银行：</label>
                                    <select name="bankother" class="loginValue" nullmsg="请选择银行" datatype="*"">
                                        <option value="">请选择银行</option>
                                        <option value="中国工商银行">中国工商银行</option>
                                        <option value="中国建设银行">中国建设银行</option>
                                        <option value="中国农业银行">中国农业银行</option>
                                        <option value="中国邮政储蓄银行">中国邮政储蓄银行</option>
                                        <option value="交通银行">交通银行</option>
                                        <option value="招商银行">招商银行</option>
                                        <option value="中国银行">中国银行</option>
                                        <option value="中国光大银行">中国光大银行</option>
                                        <option value="中信银行">中信银行</option>
                                        <option value="浦发银行">浦发银行</option>
                                        <option value="中国民生银行">中国民生银行</option>
                                        <option value="兴业银行">兴业银行</option>
                                        <option value="平安银行">平安银行</option>
                                        <option value="广发银行">广发银行</option>
                                        <option value="华夏银行">华夏银行</option>
                                        <option value="1">其他</option>
                                    </select>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_b">
                                    <label for="">银行名称：</label>
                                    <input type="text" name="bank" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_c">
                                    <label for="">开户城市：</label>
                                    <div id="distpicker4" data-toggle="distpicker" class="province-city" >
                                      <select name="province"></select>
                                      <select name="city"></select>
                                    </div>
                                </li>
                                <li class="basic_information_d">
                                    <label for="">开户支行：</label>
                                    <input type="text" name="subbank" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip">请填写详细的支行名称</span>
                                </li>
                                <li class="basic_information_e">
                                    <label for="">银行卡户名：</label>
                                    <input type="text" name="Name" value="" datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/ >
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_f">
                                    <label for="">银行卡号：</label>
                                    <input type="number" name="account" value="" datatype="n1-19"  errormsg="银行卡格式不正确！"/  >
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_g">
                                    <label for="">确认卡号：</label>
                                    <input type="number" name="account" value="" datatype="n1-19"  errormsg="银行卡格式不正确！"/  >
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_h codeverify_btn">
                                    <label for="">手机验证：</label>
                                    <input type="number" name="code" id="code" class="text">
                                    <a href="javascript:void(0)" title="获取验证码" >获取验证码</a>
                                </li>
                                <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">绑定银行卡</button>
                                    <span class="color_red_mdcc">您最多可以保存2个银行卡账号</span>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Bank_card_binding2">
                         <form action="" class="basic_information_form registerform">
                            <ul>
                               
                                <li class="basic_information_b">
                                    <label for="">支付宝账号：</label>
                                    <input type="text" name="bank" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_b">
                                    <label for="">真实姓名：</label>
                                    <input type="text" name="bank" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                 <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">绑定支付宝</button>
                                    <span class="color_red_mdcc">您最多可以保存1个支付宝账号</span>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Bank_card_binding3">
                        <form action="" class="basic_information_form registerform">
                            <ul>
                               
                                <li class="basic_information_b">
                                    <label for="">微信账号：</label>
                                    <input type="text" name="bank" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                 <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">绑定微信</button>
                                    <span class="color_red_mdcc">您最多可以保存1个微信账号</span>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="table_betting_main table_capital_main  Bank_card_bind_mainbb" id="Bank_card_binding4">
                        <div class="bank_manage bank_manage_active">
                            <div class="item">
                                <div class="head">
                                    <span>中国建设银行<i class="iconfont">&#xe622;</i></span>
                                    <a class="delete"  href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                </div>
                                <div class="body">
                                    <dl>
                                        <dd>
                                            <span>卡号：</span>6217 *********** 7564</dd>
                                        <dd><span>户名：</span>张奎</dd>
                                        <dd><span>城市：</span>四川 成都</dd>
                                        <dd><span>支行：</span>云南省曲靖市</dd>
                                    </dl>
                                    <a href="javascript:void(0)" class="take take_bank_manage">默认帐户</a>
                                </div>
                            </div>
                        </div>
                        <div class="bank_manage">
                            <div class="item">
                                <div class="head">
                                    <span>中国农业银行<i class="iconfont">&#xe622;</i></span>
                                    <a class="delete"  href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                </div>
                                <div class="body">
                                    <dl>
                                        <dd>
                                            <span>卡号：</span>6217 *********** 7564</dd>
                                        <dd><span>户名：</span>张奎</dd>
                                        <dd><span>城市：</span>四川 成都</dd>
                                        <dd><span>支行：</span>云南省曲靖市</dd>
                                    </dl>
                                    <a href="javascript:void(0)" class="take take_bank_manage">设为默认帐户</a>
                                </div>
                            </div>
                        </div>
                        <div class="bank_manage">
                            <div class="item">
                                <div class="head">
                                    <span class="zhifubao">支付宝账号<i class="iconfont">&#xe62b;</i></span>
                                    <a class="delete"  href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                </div>
                                <div class="body">
                                    <dl>
                                        <dd>
                                            <span>账号：</span>132191079952</dd>
                                        <dd><span>名字：</span>张奎</dd>
                                    </dl>
                                    <a href="javascript:void(0)" class="take take_bank_manage">设为默认帐户</a>
                                </div>
                            </div>
                        </div>
                        <div class="bank_manage">
                            <div class="item">
                                <div class="head">
                                    <span class="weixina">微信账号<i class="iconfont">&#xe603;</i></span>
                                    <a class="delete"  href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                </div>
                                <div class="body">
                                    <dl>
                                        <dd>
                                            <span>账号：</span>132191079952</dd>
                                        <dd><span>名字：</span>张奎</dd>
                                    </dl>
                                    <a href="javascript:void(0)" class="take take_bank_manage">设为默认帐户</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>