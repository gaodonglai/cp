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
<div class="pop_box styled-pane">
    <div class="pop_box_wp">
        <div class="p_b_bd">
            <div class="img_logo_wp">
                <img src="image/logokuai3.png" alt="">
            </div>
            <div class="t_boxc">
                <div class="login_box">
                    <h3>
                        <a href="#login-1" class="tab_form_a login_box_ona login_box_on">账号登录</a>
                        <a class="tab_form_a login_box_onb" href="#login-2">短信登录</a>

                    </h3>
                    <h3 class="login_box_registera">
                        <a href="javascript:void(0)#" class="login_box_register">手机注册</a>
                    </h3>
                </div>
                <div class="login_bd_bg">
                    <!--登录-->
                    <div class="login_tab login_taba login_tab_active" id="login-1">
                        <form action="" class="form_logoin">
                            <div class="in_box">
                                <input type="text" value="" placeholder="请输您的帐号" class="in_txt" id="al_u">
                            </div>
                            <div class="in_box">
                                <input type="password" value="" placeholder="密码" class="in_txt" id="al_p">
                            </div>
                            <div class="in_box in_boxa">
                                <label  for="al_remember" class="cbox">
                                    <input type="checkbox"  name="" class="chk" checked="checked">下次自动登录
                                </label>
                                <a href="javascript:void(0)" title="忘记密码？" target="_blank" class="text_cite">忘记密码？</a>
                            </div>
                            <div class="pay_btn"><a id="al_submit" class="" title="登录" href="javascript:void(0)">登录</a></div>
                        </form>
                    </div>
                    <!--手机登录-->
                    <div class="login_tab login_taba login_tabac" id="login-2">
                        <form action="" class="form_logoin_phone">
                            <div class="in_box">
                                <input type="number" value="" autocomplete="off" placeholder="常用手机号" class="in_txt" id="al_u">
                            </div>
                            <div class="in_box">
                                <input type="number" value="" autocomplete="off" placeholder="短信验证码" class="in_txt" id="al_p">
                                <a href="javascript:void(0)" title="获取验证码" class="verify_btn" id="ml_gc">获取验证码</a>
                            </div>
                            <div class="in_box in_boxa">
                                <label  for="al_remember" class="cbox">
                                    <input type="checkbox"  name="" class="chk" checked="checked">下次自动登录
                                </label>
                                <a href="javascript:void(0)" title="忘记密码？" target="_blank" class="text_cite">忘记密码？</a>
                            </div>
                            <div class="pay_btn"><a id="al_submit" class="" title="登录" href="javascript:void(0)">登录</a></div>
                        </form>
                    </div>
                    <!--注册-->
                    <div class="login_tab register_tab">
                        <form action="" class="form_register">
                            <div class="in_box">
                                <input type="number" value="" autocomplete="off" placeholder="常用手机号" class="in_txt" id="al_u">
                            </div>
                            <div class="in_box">
                                <input type="number" value="" autocomplete="off" placeholder="短信验证码" class="in_txt" id="al_p">
                                <a href="javascript:void(0)" title="获取验证码" class="verify_btn" id="ml_gc">获取验证码</a>
                            </div>
                            <div class="pay_btn"><a id="al_submit" class="" title="登录" href="javascript:void(0)">注册</a></div>
                        </form>
                    </div>
                    <p class="pay_b_logo pay_b_logoa" style=""><a href="javascript:void(0)" title="" class="text_cite">注册帐号</a></p>
                    <p class="pay_b_logo pay_b_logob" style=""><a href="javascript:void(0)" title="" class="text_cite_b">账号短信登录</a></p>
                    <!--第三方帐号登录-->
                    <div class="other_login_wp" id="tl_div" style="">
                        <span class="tit">其他登录</span>
                        <div class="other_login" id="tl_icons">
                            <a id="icon_qq" title="QQ" class="login_img" target="_blank" href="javascript:void(0)"><img id="img_qq" alt="QQ" src="image/qq.png"></a>
                            <a id="icon_weixin" title="微信" class="login_img" target="_blank" href="javascript:void(0)"><img id="img_weixin" alt="微信" src="image/weixin.png"></a>
                            <a id="icon_sina" title="新浪微博" class="login_img" target="_blank" href="javascript:void(0)"><img id="img_sina" alt="新浪微博" src="image/sina.png"></a>
                            <a id="icon_alipay" title="支付宝" class="login_img" target="_blank" href="javascript:void(0)"><img id="img_alipay" alt="支付宝" src="image/alipay.png"></a>
                        </div>
                        <div class="other_login2" id="tl_icons2_" style="display: none;">
                            <a id="icon_xiaomi" title="小米" class="login_link" target="_blank" href="javascript:void(0)">小米</a>
                            <span class="d_line">|</span>
                            <a id="icon_aq360" title="360" class="login_link" target="_blank" href="javascript:void(0)">360</a>
                            <span class="d_line">|</span>
                            <a id="icon_renren" title="人人网" class="login_link" target="_blank" href="javascript:void(0)">人人网</a>
                            <span class="d_line">|</span>
                            <a id="icon_tianyi" title="天翼" class="login_link" target="_blank" href="javascript:void(0)">天翼</a>
                        </div>
                        <a href="javascript:;" class="link_more tab_form_a" id="tl_arrow___">更多<i class="ico_more"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a  class="p_b_close" href="javascript:void(0)" title="关闭"></a>
    </div>
</div>
<!--遮罩层-->
<div class="mask-re"></div>
</body>
<script src="<?=_get_home_url()?>View/pc/js/jquery2.1.1.min.js"></script>
<!-- Swiper JS -->
<script src="<?=_get_home_url()?>View/pc/js/swiper.jquery.min.js"></script>
<script src="<?=_get_home_url()?>View/pc/js/public.js"></script>
</html>
