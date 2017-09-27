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
    	<div class="footer_main_left">
		  	<a href="javascript:void(0)">
			  	<p class="top_tooteraa">技术支持 <i>Technical support</i></p>
			  	<div class="technicalSupport">
					<img src="<?=_get_home_url()?>/View/pc/image/dafayun.png" alt="">
					<p><span>宇泰云系统</span><i>专业的彩票系统平台</i></p>
			  	</div>
		  	</a>
        </div>
        <div class="footer_main_center">
       		<div class="footer_main_cccc">
				<p class="top_tooteraa">服务体验 <i>Service experience</i></p>
				<ul class="serviceExperience">
					  <li>平台充值到账平均时间
		              	<p class="footBar"><span  style="width: 22.7778%;"></span></p> <em>0'41</em><i>秒</i></li> 
		              <li>平台提现到账平均时间
		              	<p class="footBar"><span  style="width: 79.4444%;"></span></p> <em>2'23</em><i>秒</i>
		              </li>
	              </ul>
              </div>
        </div>
        <div class="footer_main_right">
	        <div class="footer_main_cccc">
				<p class="top_tooteraa">充值方式<i>Recharge method</i></p>
				<div class="rechargeMethod"><i class="wechat"></i><i  class="alipay"></i><i  class="cup"></i></div>
	        </div>
        </div>
    </div>
    <div class="container_about aboutText">
	    <p class="fix_about">
		    <a href="javascript:void(0)">关于我们</a>|
		    <a href="javascript:void(0)">联系我们</a>|
		    <a href="javascript:void(0)">代理加盟</a>|
	    	<a href="javascript:void(0)">存款帮助</a>|<a>隐私声明</a>|
	    </p> 
	    <p class="copyright">Copyright © <span class="siteName">福彩快三网</span> Reserved | 18+</p>
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
								<a href="<?=_get_home_url('login/retrievePassword')?>" title="忘记密码？" target="_blank" class="text_cite">忘记密码？</a>
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
<script>
	var home = "<?=_get_home_url()?>";
</script>
<!-- Swiper JS -->
<script src="<?=_get_home_url()?>View/pc/js/swiper.jquery.min.js?v=<?=J_C_V?>"></script>
<!--表单验证插件-->
<script src="<?=_get_home_url()?>View/pc/js/Validform_v5.3.2_min.js?v=<?=J_C_V?>"></script>
<!--城市三级联动-->
<!--<script src="<?/*=_get_home_url()*/?>View/pc/js/distpicker.data.js"></script>
<script src="<?/*=_get_home_url()*/?>View/pc/js/distpicker.js"></script>-->
<!--复制文本插件-->
<script src="<?=_get_home_url()?>View/pc/js/clipboard.min.js?v=<?=J_C_V?>"></script>
<script src="<?=_get_home_url()?>View/pc/js/cookie.url.config.js?v=<?=J_C_V?>"></script>
<script src="<?=_get_home_url()?>View/pc/js/template.js?v=<?=J_C_V?>"></script>
<script src="<?=_get_home_url()?>View/pc/js/public.js?v=<?=J_C_V?>"></script>
<?php
if($js){
	foreach ($js as $v){ ?>
		<script src="<?=_get_home_url()?>View/<?=$v?>?v=<?=J_C_V?>"></script>
	<?php }
 }
?>
</html>

