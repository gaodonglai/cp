<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/9/7
 * Time: 13:57
 * 用户注册
 */
?>
<div class="pop_boxb styled-pane">
	<div class="pop_boxbimg">
		<img src="<?=_get_home_url()?>/View/pc/image/logokuai3.png" alt="">
		<img src="<?=_get_home_url()?>/View/pc/image/banner2.png"  alt=""/>
	</div>
    <div class="pop_box_wp">
            <div class="t_boxc">
                <div class="login_box">
					<h3>
						<a href="javascript:void(0)#" class="login_box_register">账号注册</a>
					</h3>
				</div>
                <div class="clock qrcode_clock"></div>
                <span class="color_red_mddd card_status">请在有效的时间内完成注册，如果无法完成请向来源者重新索取注册页面方式。</span>

				<div class="login_bd_bg">
					<!--注册-->
					<div class="login_tab register_tab">
						<form action="<?=_get_home_url('register/entering')?>" class="postAjax form_register">
                            <input type="hidden" value="<?=$_GET['code']?>" name="code" />
							<div class="in_box">
								<input type="text" value="" autocomplete="off" name="user_name" placeholder="常用手机号或邮箱" datatype="*" class="in_txt" id="al_u" errormsg="账号至少6个字符,最多18个字符！">
								<span class="Validform_checktip"></span>
							</div>
							<div class="in_box">
									<input type="password" value="" name="user_pass" class="in_txt" placeholder="设置密码"  datatype="*6-18" errormsg="密码至少6个字符,最多18个字符！" />
									<span class="Validform_checktip"></span>
							</div>
							<div class="in_box">
								<input type="password" value="" name="user_rePass" class="in_txt"  recheck="user_pass" placeholder="再次确认" datatype="*6-18" errormsg="两次输入的密码不一致！" />
								<span class="Validform_checktip"></span>
							</div>
							<div class="in_box">
								<input type="number" value="" name="rand_code" autocomplete="off" placeholder="输入右边的验证码" datatype="n1-4"   class="in_txt" id="al_p" errormsg="请输入验证码"/>
								<a href="javascript:void(0)" title="点击重新获取" class="verify_btn" id="ml_gc"><img src="<?=_get_home_url('register/getRandCode')?>" onclick="jQuery(this).attr('src','<?=_get_home_url('register/getRandCode')?>?'+ new Date().getTime())" /></a>
								<span class="Validform_checktip"></span>
							</div>
							<div class="pay_btn"><a id="al_submit" class="" title="登录" href="javascript:;"><button>注册</button></a></div>
						</form>
					</div>
					<p class="pay_b_logo pay_b_logob" style=""><a href="javascript:void(0)" title="" class="text_cite_b">账号登录</a></p>
				</div>
			</div>
	</div>
</div>
<!--倒计时-->
<script src="<?=_get_home_url()?>View/pc/js/flipclock.min.js"></script>
<script>
    /*倒计时*/
    var clock = $('.clock').FlipClock({
        clockFace: 'HoilyCounter',
        autoStart: false,
        callbacks: {
            stop: function() {
                $('#al_submit').find('button').html('已失效').attr('disabled','disabled').css('background','#cccccc');
            }
        },
    });
    clock.setCountdown(true);
    clock.setTime(<?=$residue_time?>-2);
    clock.start();


</script>