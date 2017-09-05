<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 23:58
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> <!-- 优先使用 IE 最新版本和 Chrome -->
    <meta name="zk" content="name, 526399773@qq.com" /> <!-- 网页作者 -->
    <meta name="format-detection" content="telephone=no"/>
    <meta name="format-detection" content="email=no"/>
    <link rel="stylesheet" href="<?=_get_home_url()?>View/pc/css/swiper.css">
    <link rel="stylesheet" href="<?=_get_home_url()?>View/pc/css/style.min.css">
    <link rel="stylesheet" href="<?=_get_home_url()?>View/pc/css/style.css">
    <script src="<?=_get_home_url()?>View/pc/js/jquery2.1.1.min.js"></script>
</head>
<body>
<!--导航-->
<header>
    <nav class="lottery_nav">
        <div class="lottery_logo"><a href="javascript:void(0)"></a></div>
        <div class="lottery_nav_center">
            <ul>
                <li class="loactive"><a href="<?=_get_home_url()?>"><i class="iconfont">&#xe61d;</i><span>首页</span></a></li>
                <li><a href=""><i class="iconfont">&#xe76d;</i><span>游戏规则</span></a></li>
                <li><a href=""><i class="iconfont">&#xe700;</i><span>优惠活动</span></a></li>
                <li><a href=""><i class="iconfont">&#xe661;</i><span>走势图</span></a></li>
                <li><a href=""><i class="iconfont">&#xe631;</i><span>合作代理</span></a></li>
                <li><a href=""><i class="iconfont">&#xe66d;</i><span>交易记录</span></a></li>
                <li><a href=""><i class="iconfont">&#xe64c;</i><span>消费送彩金</span></a></li>
                <li><a href="<?=_get_home_url('account/pay')?>"><i class="iconfont">&#xe68f;</i><span>充值</span></a></li>
                <li><a href="<?=_get_home_url('account/extractMoney')?>"><i class="iconfont">&#xe71c;</i><span>取款</span></a></li>
				<?php
                            if(get_user_info()){
                                ?>
                                <li class="lottery_balance"><a href=""> 余额：<span><?=get_user_info()->user_money?></span>元<i class="iconfont">&#xe600;</i></a></li>
                            <?php
                            }




                            ?>
            </ul>
        </div>
        <div class="lottery_Personal">
            <div class="Login-registration">
                <?php
                if(get_user_info()){
                    ?>
                    <a class="" href="<?=_get_home_url('login/logout')?>">登出</a>
                    <?php
                }else{
                    ?>
                    <a class="box_formlo login-ina" href="javascript:void(0)">登录</a>
                    <a class="box_formlo registr_ina" href="javascript:void(0)">注册</a>
                <?php
                }
                ?>

            </div>
            <div class="login-in">
                <span>zk你好</span>
                <span><i class="iconfont">&#xe621;</i></span>
            </div>
        </div>
    </nav>
</header>
