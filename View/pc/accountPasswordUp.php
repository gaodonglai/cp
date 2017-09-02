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

        <div class="personal_main_macen personal_main_active" id="persona7-g">
            <div class="per_main_rig_top">
                <h4>密码修改</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla">登录密码和交易密码</p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active password_modify">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>为确保您的账户安全，请牢记您的登录密码和交易密码且不要轻易泄露给他人</p>
                        <form action="" class="basic_information_form password_modify_form">
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">登录密码：</label>
                                    <input type="password" name="oldpwd" value=""  required="required">
                                </li>
                                <li class="basic_information_a">
                                    <label for="">新登录密码：</label>
                                    <input type="password" name="pwd" value=""  required="required">
                                </li>
                                <li class="basic_information_a">
                                    <label for="">再次输入新密码：</label>
                                    <input type="password" name="repwd" value=""  required="required">
                                </li>
                                <li class="basic_information_a">
                                    <label for="">交易密码</label>
                                    <input type="password" name="repwdtrade" value=""  required="required">
                                </li>
                                <li class="basic_information_a">
                                    <label for="">新交易密码：</label>
                                    <input type="password" name="repwdtrade" value=""  required="required">
                                    <span class="color_red_mdcc">交易密码是在进行交易时需要输入的密码，不同于登录密码</span>
                                </li>
                                <li class="basic_information_a">
                                    <label for="">再次输入新交易密码：</label>
                                    <input type="password" name="repwdtrade" value=""  required="required">
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