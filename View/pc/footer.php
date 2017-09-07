<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/24
 * Time: 0:03
 */

?>

<footer>
    <div class="lottery_footer">
        <p><a href="javascript:void(0)">帮助中心</a></p>
        <p>CopyRight ©版权所有 菲律宾政府合法博彩牌照认证</p>
        <p>资金安全建议：为了你您的资金安全，建议定期更换您的安全密码</p>
        <p>郑重提示：彩票有风险，投注需谨慎，不向未满18周岁青少年出售彩票</p>
    </div>
</footer>
<!--返回顶部-->
<div class="scroll" id="scroll"><i class="iconfont">&#xe8da;</i></div>
<!--登录弹出窗-->
<div class="pop_boxa pop_box styled-pane ">
    <div class="pop_box_wp">
        <div class="p_b_bd">
            <div class="img_logo_wp">
                <img src="<?=_get_home_url()?>/View/pc/image/logokuai3.png" alt="">
            </div>
            <div class="t_boxc">
                <div class="login_box">
                    <h3>
						<a href="javascript:void(0)" class="tab_form_a login_box_ona login_box_on">账号登录</a>
					</h3>
				</div>
				<div class="login_bd_bg">
					<!--登录-->
					<div class="login_tab login_taba login_tab_active" id="login-1">
						<form action="<?=_get_home_url('login/login')?>" class="postAjax form_logoin">
							<div class="in_box">
								<input type="text" value="" name="user_name" placeholder="请输您的帐号" class="in_txt" datatype="*6-18" errormsg="账号至少6个字符,最多18个字符！" />
								<span class="Validform_checktip"></span>
							</div>
							<div class="in_box">
								<input type="password" value="" name="user_pass" placeholder="密码" class="in_txt" id="al_p" datatype="*6-18" errormsg="密码至少6个字符,最多18个字符" />
								<span class="Validform_checktip"></span>
							</div>
							<div class="in_box in_boxa">
								<label  for="al_remember" class="cbox">
									<input type="checkbox"  name="" class="chk" checked="checked">下次自动登录
								</label>
								<a href="javascript:void(0)" title="忘记密码？" target="_blank" class="text_cite">忘记密码？</a>
							</div>
							<div class="pay_btn"><button id="al_submit" class="" title="登录">登录</button></div>
						</form>
					</div>
					<p class="pay_b_logo pay_b_logoa" style=""><a href="<?=_get_home_url('register')?>" title="" class="text_cite_a">注册帐号</a></p>
				</div>
			</div>
		</div>
		<a  class="p_b_close" href="javascript:void(0)" title="关闭"></a>
	</div>
</div>
<!--遮罩层-->
<div class="mask-re"></div>
</body>

<!-- Swiper JS -->
<script src="<?=_get_home_url()?>View/pc/js/swiper.jquery.min.js"></script>
<!--表单验证插件-->
<script src="<?=_get_home_url()?>View/pc/js/Validform_v5.3.2_min.js"></script>
<!--城市三级联动-->
<script src="<?=_get_home_url()?>View/pc/js/distpicker.data.js"></script>
<script src="<?=_get_home_url()?>View/pc/js/distpicker.js"></script>
<!--复制文本插件-->
<script src="<?=_get_home_url()?>View/pc/js/clipboard.min.js"></script>
<script src="<?=_get_home_url()?>View/pc/js/cookie.url.config.js"></script>
<script src="<?=_get_home_url()?>View/pc/js/public.js"></script>
</html>

