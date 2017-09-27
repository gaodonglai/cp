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
<main>
<div class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--密码修改-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>密码修改</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla rig_main_capital">
                    <a class="modify_binding1 betting_top-active" href="#password_modify_binding1">修改登录密码</a>
                    <a class="modify_binding2" href="#password_modify_binding2">修改交易密码</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active table_capital_main" id="password_modify_binding1">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>为确保您的账户安全，请牢记您的登录密码且不要轻易泄露给他人</p>
                        <form action="<?=_get_home_url('account/updatePassword')?>" class="postAjax basic_information_form  password_modify_form" >
                            <ul>
                                <li class="basic_information_a"> 
                                    <label for="">登录密码：</label>
                                    <input type="password" name="password" value="" datatype="*5-15" nullmsg="请输入登录密码" errormsg="密码范围在5~15位之间！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_b">
                                    <label for="">新登录密码：</label>
                                    <input type="password" value="" name="new_password" nullmsg="请输入新的登录密码"  datatype="*6-18" errormsg="密码至少6个字符,最多18个字符！" />
                                    <span class="Validform_checktip">密码至少6个字符,最多18个字符！</span>
                                </li>
                                <li class="basic_information_c">
                                    <label for="">再次输入新密码：</label>
                                    <input type="password" value="" name="re_new_password"  recheck="new_password" nullmsg="请输入新的登录密码" datatype="*6-18" errormsg="两次输入的密码不一致！" />
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">修 改</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="table_betting_main table_capital_main" id="password_modify_binding2">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>为确保您的账户财产安全，请牢记您的交易密码且不要轻易泄漏给他人</p>
                        <form action="<?=_get_home_url('account/updatePaymentPassword')?>" class="postAjax basic_information_form  password_modify_form registerform" >
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">登录密码：</label>
                                    <input type="password" name="password" value="" datatype="*5-15"  nullmsg="请输入登录密码" errormsg="密码范围在5~15位之间！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_a">
                                    <label for="">交易密码</label>
                                    <input type="password" name="payment_password" value=""  datatype="*5-15" nullmsg="请输入交易密码" errormsg="密码范围在5~15位之间！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_a">
                                    <label for="">新交易密码：</label>
                                    <input type="password" value="" name="new_payment_password" nullmsg="请输入新的交易密码"  datatype="*6-18" errormsg="密码至少6个字符,最多18个字符！" />
                                    <span class="Validform_checktip">交易密码是在进行交易时需要输入的密码，不同于登录密码</span>
                                </li>
                                <li class="basic_information_a">
                                    <label for="">再次输入新交易密码：</label>
                                    <input type="password" value="" name="re_new_payment_password"  recheck="new_payment_password" nullmsg="请输入新的交易密码" datatype="*6-18" errormsg="两次输入的密码不一致！" />
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">修 改</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<script>
    window.onload = function() {
       var url_status = $.getUrlParam('password');
       if(url_status){
           $(".rig_main_capital a").removeClass("betting_top-active");
           $('.'+url_status).addClass("betting_top-active");
           $(".table_capital_main").removeClass("table_betting_active");
           $(".brigtinh_main_cen").fadeOut(300);
           $('#password_'+url_status).delay(300).fadeIn();
       }
   };
</script>