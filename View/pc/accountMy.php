<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:45
 * Created people: gaodonglai
 * pageName:我的账户
 */



?>
<!--个人中心内容-->
<main class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">

        <!--我的账户-->
        <div class="personal_main_macen personal_main_active" id="personal-a">
            <div class="per_main_rig_top">
                <h4>我的账户</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla">基本信息</p>
                <div class="basic_information">
                    <form action="" class="basic_information_form Withdrawals_bind_form">
                        <ul>
                            <li class="basic_information_a">
                                <label for="">用户名：</label>
                                <input type="text" readonly="readonly" name="name" value="lenghanweizz"><span class="Prompt_header">不能修改</span>
                                <span class="color_red_mdcc">可以用于登陆，请牢记！</span>
                            </li>
                            <li class="basic_information_b">
                                <label for="">姓名：</label>
                                <input type="text" name="realName" value=""  required="required" class="inputxt" >
                            </li>
                            <li class="basic_information_c">
                                <label for="">性别：</label>
                                <label class="basic_radio_label">
                                    <input class="mui-checkbox checkbox-s checkbox-orange"  id="sex" type="radio" name="sex" value = "男" checked />
                                    <i class="iconfont checkbox-i">&#xe628;</i>男
                                </label>
                                <label class="basic_radio_label">
                                    <input class="mui-checkbox checkbox-s checkbox-orange" id="sex" type="radio" name="sex" value = "女" />女
                                    <i class="iconfont checkbox-i">&#xe628;</i>
                                </label>
                            </li>
                            <li class="basic_information_d">
                                <label for="">手机：</label>
                                <input type="number" name="phone" value="" id="phone">
                            </li>
                            <li class="basic_information_e">
                                <label for="">QQ：</label>
                                <input type="number" name="qq" value=""  required="required">
                            </li>
                            <li class="basic_information_f">
                                <label for="">Email：</label>
                                <input type="number" name="email" value=""  id="">
                            </li>
                            <li class="basic_information_g">
                                <label for=""></label>
                                <button class="modify_sub">修改</button>
                                <span class="color_red_mdcc">为了你的财产安全，请填写真实信息</span>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>


    </div>
</main>
