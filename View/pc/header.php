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
    <script src="<?=_get_home_url()?>View/pc/js/publics.js"></script>
    <script>
        $(document).ready(function() {
            <?php
            if($_GET['show'] == 'login'){
                ?>
                    $(".pop_boxa").addClass("pop_login");
                    $(".mask-re").addClass("mask-reb");
            <?php
            }
            ?>
        });
    </script>
</head>
<body>
<!--导航-->
<header>
    <nav class="lottery_nav">
        <div class="lottery_logo"><a href="javascript:void(0)"></a></div>
        <div class="lottery_nav_center">
            <ul>
                <li class="loactive"><a href="<?=_get_home_url()?>"><i class="iconfont">&#xe61d;</i><span>首页</span></a></li>
                <li><a href=""><i class="iconfont">&#xe651;</i><span>购彩大厅</span></a></li>
                <li><a href="<?=_get_home_url('index/activity')?>"><i class="iconfont">&#xe700;</i><span>优惠活动</span></a></li>
                <li><a href="<?=_get_home_url('index/Trendchart')?>"><i class="iconfont">&#xe661;</i><span>走势图</span></a></li>
                <li><a href="<?=_get_home_url('account/distribution')?>"><i class="iconfont">&#xe631;</i><span>分销中心</span></a></li>
                <li><a href="<?=_get_home_url('account/fcDetails')?>"><i class="iconfont">&#xe64c;</i><span>交易记录</span></a></li>
                <li><a href="<?=_get_home_url('index/help')?>"><i class="iconfont">&#xe60e;</i><span>帮助中心</span></a></li>
                <li><a href="<?=_get_home_url('account/my')?>"><i class="iconfont">&#xe607;</i><span>个人中心</span></a></li>
				<?php
                if(get_user_info()){
                    ?>
                    <li class="lottery_balance"><a href="">余额：<span><?=get_user_info()->user_money?></span>元<i class="iconfont">&#xe600;</i></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="lottery_Personal">
           
                <?php
                if(get_user_info()){
                    ?>
                    
                      <div class="login-in">
                        <span><a href="<?=_get_home_url('account/my')?>"><?php echo get_user_info()->user_name?></a></span>
                        <span><a class="" href="<?=_get_home_url('login/logout')?>"><i class="iconfont">&#xe621;</i></a></span>
                    </div>
                    <?php
                }else{
                    ?>
                     <div class="Login-registration">
                    <a class="box_formlo login-ina" href="javascript:void(0)">登录</a>
                    <a class="registr_ina" href="<?=_get_home_url('register')?>">注册</a>
                      </div>
                <?php
                }
                ?>

          
          
        </div>
    </nav>
</header>
