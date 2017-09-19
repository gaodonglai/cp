<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/9/7
 * Time: 13:57
 * 密码找回
 */
?>
<div class="pop_boxb styled-pane">
	<div class="pop_boxbimg retrievePassword">
		<img src="<?=_get_home_url()?>/View/pc/image/logokuai3.png" alt="">
		<img src="<?=_get_home_url()?>/View/pc/image/banner2.png"  alt=""/>
	</div>
    <div class="pop_box_wp">
            <div class="t_boxc" >
                <div class="login_box">
					<h3>
						<a href="javascript:void(0)#" class="login_box_register">密码找回</a>
					</h3>
				</div>

				<div class="login_bd_bg">
					<!--注册-->
					<div class="login_tab register_tab">
                        <?php
                        if($answer){
                            ?>
                            <form method="post" action="<?=_get_home_url('login/getEncrypted')?>" class="postAjax form_register">
                                <input type="hidden" name="user_name" value="<?=$_POST['user_name']?>">
                                <div class="in_box">
                                    <input type="password" value="" autocomplete="off" name="password" placeholder="设置密码"  datatype="*6-18" class="in_txt">
                                </div>
                                <div class="in_box">
                                    <input type="password" value="" autocomplete="off" recheck="password" name="re_password"  placeholder="再次确认"  datatype="*6-18" class="in_txt">
                                </div>

                                <div class="in_box">
                                    <input type="number" value="" name="rand_code" autocomplete="off" placeholder="输入右边的验证码" datatype="n1-4"   class="in_txt" id="al_p" errormsg="请输入验证码"/>
                                    <a href="javascript:void(0)" title="点击重新获取" class="verify_btn" id="ml_gc"><img src="<?=_get_home_url('register/getRandCode')?>" onclick="jQuery(this).attr('src','<?=_get_home_url('register/getRandCode')?>?'+ new Date().getTime())" /></a>
                                    <span class="Validform_checktip"></span>
                                </div>
                                <div class="pay_btn"><a id="al_submit" class="" href="javascript:;"><button>下一步</button></a></div>
                            </form>
                            <?php
                        }else if($question){
                            ?>
                            <form method="post" action="<?=_get_home_url('login/retrievePassword')?>" class="form_register">
                                <input type="hidden" name="user_name" value="<?=$_POST['user_name']?>">
                                <div class="in_box">
                                    <input type="text" value="<?=$question?>" autocomplete="off"  disabled="disabled"  datatype="*" class="in_txt">
                                </div>

                                <div class="in_box">
                                    <input type="text" value="" autocomplete="off" name="user_answer" placeholder="密保答案" datatype="*" class="in_txt">
                                    <span class="Validform_checktip"><?=$content?></span>
                                </div>

                                <div class="in_box">
                                    <input type="number" value="" name="rand_code" autocomplete="off" placeholder="输入右边的验证码" datatype="n1-4"   class="in_txt" id="al_p" errormsg="请输入验证码"/>
                                    <a href="javascript:void(0)" title="点击重新获取" class="verify_btn" id="ml_gc"><img src="<?=_get_home_url('register/getRandCode')?>" onclick="jQuery(this).attr('src','<?=_get_home_url('register/getRandCode')?>?'+ new Date().getTime())" /></a>
                                    <span class="Validform_checktip"></span>
                                </div>
                                <div class="pay_btn"><a id="al_submit" class=""  href="javascript:;"><button>下一步</button></a></div>
                            </form>
                            <?php
                        }else{
                            ?>
                            <form method="post" action="<?=_get_home_url('login/retrievePassword')?>" class="form_register">

                                <div class="in_box">
                                    <input type="text" value="" autocomplete="off" name="user_name" placeholder="常用手机号或邮箱" datatype="*" class="in_txt" id="al_u" errormsg="账号至少6个字符,最多18个字符！">
                                    <span class="Validform_checktip"><?=$content?></span>
                                </div>

                                <div class="in_box">
                                    <input type="number" value="" name="rand_code" autocomplete="off" placeholder="输入右边的验证码" datatype="n1-4"   class="in_txt" id="al_p" errormsg="请输入验证码"/>
                                    <a href="javascript:void(0)" title="点击重新获取" class="verify_btn" id="ml_gc"><img src="<?=_get_home_url('register/getRandCode')?>" onclick="jQuery(this).attr('src','<?=_get_home_url('register/getRandCode')?>?'+ new Date().getTime())" /></a>
                                    <span class="Validform_checktip"><?=$verify_code?></span>
                                </div>
                                <div class="pay_btn"><a id="al_submit" class=""  href="javascript:;"><button>下一步</button></a></div>
                            </form>
                            <?php
                        }
                        ?>

					</div>
					<p class="pay_b_logo pay_b_logob" style=""><a href="<?=_get_home_url('?show=login')?>" title="" class="text_cite_b">账号登录</a></p>
				</div>
			</div>
	</div>
</div>
