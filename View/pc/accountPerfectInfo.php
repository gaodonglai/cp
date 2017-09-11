<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/9/11
 * Time: 10:07
 * 完善密保和支付密码信息
 */
?>

<!--完善密保和支付密码信息-->
<main class="personal_main">
    <div class="personal_main_right">
        <!--密码修改-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>完善信息</h4>
            </div>
            <div class="per_main_rig_main">
                <div class="basic_information">
                    <div>
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>为确保您的账户财产安全，请牢记您的交易密码且不要轻易泄漏给他人。设置密保问题是方便您找回自已遗失的密码。</p>
                        <form action="<?=_get_home_url('account/setPerfectInfo')?>" class="postAjax basic_information_form  password_modify_form registerform" >
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">密保问题：</label>
                                    <input type="text" name="question" value="" maxlength="12" datatype="n12" placeholder="我的家乡"  nullmsg="请输入密保问题" errormsg="字数范围在5~15位之间！"/>
                                    <span class="Validform_checktip">请用12字阐述密保问题。</span>
                                </li>
                                <li class="basic_information_a">
                                    <label for="">密保答案：</label>
                                    <input type="text" name="answer" value="" maxlength="8" datatype="n8" placeholder="上海"  nullmsg="请输入密保答案" errormsg="密码范围在5~15位之间！"/>
                                    <span class="Validform_checktip">请用8字阐述密保答案。</span>
                                </li>
                                <li class="basic_information_a">
                                    <label for="">交易密码</label>
                                    <input type="password" name="payment_password" value=""  datatype="*5-15" nullmsg="请输入交易密码" errormsg="密码范围在5~15位之间！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_a">
                                    <label for="">再次输入交易密码：</label>
                                    <input type="password" value="" name="re_payment_password" nullmsg="请输入新的交易密码"  datatype="*6-18" errormsg="密码至少6个字符,最多18个字符！" />
                                    <span class="Validform_checktip">交易密码是在进行交易时需要输入的密码，不同于登录密码</span>
                                </li>
                                <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">保存</button>
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
    var url_status = $.getUrlParam('password');
    if(url_status){
        $(".rig_main_capital a").removeClass("betting_top-active");
        $('.'+url_status).addClass("betting_top-active");
        $(".table_capital_main").removeClass("table_betting_active");
        $(".brigtinh_main_cen").fadeOut(300);
        $('#password_'+url_status).delay(300).fadeIn();
    }
</script>
