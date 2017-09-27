<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:21
 * Created people: gaodonglai
 * pageName:用户界面侧边栏
 */

?>
<div class="personal_main_left">
    <div class="sonal_main_lef_header">
        <p class="lef_header_a"><a href="<?=_get_home_url('account/my')?>"><span><img src="<?=_get_home_url()?>/View/pc/image/headerk3.png" alt=""></span><b><?php echo get_user_info()->user_name?></b></a></p>
        <p class="lef_header_d">
            <span>当前余额</span>
            <b><?=get_user_info()->user_money?></b>
        </p>
    </div>
    <div class="sonal_main_lef_nav">
        <ul>
            <li><a href="<?=_get_home_url('account/my')?>" <?=FUNFCTIO_NAME == 'my' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe607;</i>我的账户</a></li>
            <li><a href="<?=_get_home_url('account/bet')?>" <?=FUNFCTIO_NAME == 'bet' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe601;</i>我的投注</a></li>
            <li><a href="<?=_get_home_url('account/fcDetails')?>" <?=FUNFCTIO_NAME == 'fcDetails' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe605;</i>资金明细</a></li>
            <li><a href="<?=_get_home_url('account/pay')?>" <?=FUNFCTIO_NAME == 'pay' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe60d;</i>立即充值</a></li>

            <li><a href="<?=_get_home_url('account/extractMoney')?>" <?=FUNFCTIO_NAME == 'extractMoney' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe627;</i>提现申请</a></li>
            <li><a href="<?=_get_home_url('account/passwordUp')?>" <?=FUNFCTIO_NAME == 'passwordUp' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe653;</i>密码修改</a></li>
            <li><a href="<?=_get_home_url('account/bankCard')?>" <?=FUNFCTIO_NAME == 'bankCard' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe65e;</i>绑银行卡</a></li>
            <li><a href="<?=_get_home_url('account/distribution')?>" <?=FUNFCTIO_NAME == 'distribution' ? 'class="left-nav-active"' : ''?>><i class="iconfont">&#xe631;</i>分销管理</a></li>
        </ul>
    </div>
</div>