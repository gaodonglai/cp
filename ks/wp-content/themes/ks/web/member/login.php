<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/22
 * Time: 18:53
 */
?>
<form action="<?=home_url('/member/login/login')?>" class="postAjax" method="post">

                <input id="username" class='login_center_info_text' name="user_login" type="text" placeholder="手机" >

            </li>
            <li>
                <label for="password">用户密码*</label>
                <input id="password" class='login_center_info_text' name="user_pass" type="password" placeholder="密码">
                <a href="####" class="weui_icon_clear" id="search_clear" style="display: none;">
                    <i class="fa fa-close"></i>
                </a>
            </li>
            <?php /*<li class="login_center_info_li3">
						<label for="">验证码</label>
						<input placeholder="输入验证码" type="text"  name="code" maxlength="5" class="login_center_info_text" />

						<a href="javascript:void (0)">
							<img class="login_ma" src="<?=get_stylesheet_directory_uri(); ?>/libraries/util/ckCode.class.php" width="80" height="43" alt="验证码" id="img1" title="点击更换验证码" onclick="jQuery(this).attr('src','<?= get_stylesheet_directory_uri();?>/libraries/util/ckCode.class.php?'+ new Date().getTime())"/>

						</a>
					</li>*/?>
            <li>
                <input type="submit" class="login_center_info_login" value="登 录"/>

            </li>
            <li>
                <div class="login_center_info_bottom login_center_info_bottom1 fl">
                    <input id="login_remember_pwd" type="checkbox" name="recall" value="on"/>
                    <label for="login_remember_pwd" style="font-weight: inherit;">不自动登录</label>
                </div>
                <div class="login_center_info_bottom login_center_info_bottom2 fl">
                    <a href="<?=home_url('/member/register/')?>">用户注册</a>/
                    <a href="<?=home_url('/member/register/backPass')?>">忘记密码</a>
                </div>

            </li>
        </ul>
        <div class="login_center_info_two_code">

        </div>
    </div>
</form>
