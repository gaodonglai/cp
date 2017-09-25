<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 23:06
 */

?>
<!--轮播-->
<div class="home-swiper">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" data-swiper-autoplay="7000">
                <div class="text-swiper">
                    <div class="details_main_center">
                        <div class="details_top">
                            <?php
                                if(get_user_info()){
                            ?>
                                <p><span><i class="iconfont">&#xe607;</i>账号：</span><?php echo get_user_info()->user_name?></p></span>
                                <p><i class="iconfont">&#xe605;</i>余额：<span><?=get_user_info()->user_money?></span> 元</p>  
                            <?php
                                }else{
                            ?>
                                <p><span><i class="iconfont">&#xe607;</i>账号：尚未登录</span></p>
                                <p><i class="iconfont">&#xe605;</i>余额：<span>00.00</span> 元</p>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="details_botton">
                            <a href="<?=_get_home_url('account/pay')?>"><i class="iconfont">&#xe64c;</i>充值</a>
                            <a href="<?=_get_home_url('account/extractMoney')?>"><i class="iconfont">&#xe71c;</i>取款</a>
                        </div>
                        <div class="details_main">
                            <p class="details_main_p"><a href="#item-1" class="details_main_pa details_active">客户端下载</a><a href="#item-2" class="details_main_pb">常见问题</a></p>
                            <div class="tab_download tab_downloadaa" id="item-1">
                                <div class="tab_download_img"><img src="View/pc/image/QR_code.png" alt=""></div>
                                <div class="tab_download_text">
                                    <p>
                                        <a href="javascript:void(0)">暂未开通</a>
                                        <span>请通过手机浏览器打开网站</span>
                                    </p>
                                </div>
                            </div>
                            <div class="tab_download tab_downloadbb" id="item-2">
                                <p><a href="<?=_get_home_url('index/help')?>">提现后需要多久到账？</a></p>
                                <p><a href="<?=_get_home_url('index/help')?>">平台充值方式有哪些？</a></p>
                                <p><a href="<?=_get_home_url('index/help')?>">提现后需要多久到账？</a></p>
                                <p><a href="<?=_get_home_url('index/help')?>">平台充值方式有哪些？</a></p>
                            </div>
                            <div class="tab_problem"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
            </div>
            <div class="swiper-slide">
            </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-arrow">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</div>
<!--首页内容-->
<main class="lottery_main">
    <div class="lottery_main_conent">
        <div class="lottery_main_left">
            <?php
            foreach ($FastThree as $v){
                /*单双*/
                $p_odd_even = '--';
                /*大小*/
                $p_size = '--';
                /*和*/
                $sumvalue = 0;
                /*期号*/
                $lottery_period = '--';
                $p_number = array(6,6,6);
                if($v->p_id){
                    $p_number = explode(',',$v->p_number);
                    $p_odd_even = $v->p_odd_even=='y'?'单':'双';
                    $p_size = $v->p_size=='y'?'大':'小';
                    $sumvalue = $v->sumvalue;
                    $lottery_period = $v->lottery_period;
                }
                /*获取图片*/
                $src = 'View/pc/image/BJK3.png';
                if($v->img) {
                    $image_attributes = wp_get_attachment_image_src($v->img);
                    if($image_attributes) $src = $image_attributes[0];
                }
                ?>
                <div class="lottery_main_dice">
                    <div class="lottery_madice_top">
                        <img src="<?=$src?>" alt="">
                        <span><?=$v->name?></span>
                    </div>
                    <div class="lottery_madice_main">
                        <p>期号：第<span>
                                <?=$lottery_period?>
                            </span>期</p>
                        <p class="lottery_madice_mshuang">
                            和值:<span><?=$sumvalue?></span>
                            形态:<span><?=$p_size?></span>|<span><?=$p_odd_even?></span></p>
                        <p class="lottery_madice_lottery">
                            <span>开奖号码：</span>
                            <span class="code0 dice_k3_<?=$p_number[0]?>_roll"></span>
                            <span class="code0 dice_k3_<?=$p_number[1]?>_roll"></span>
                            <span class="code0 dice_k3_<?=$p_number[2]?>_roll"></span>
                        </p>
                        <p><a href="<?=_get_home_url('fastthree/view/?ks='.$v->id)?>">立即投注</a>
                            <a href="<?=_get_home_url('fastthree/trendchart/?ks='.$v->id)?>">走势详情</a></p>
                    </div>
                </div>
            <?php }
            ?>

        </div>
        <div class="lottery_main_right">
            <div class="winners_list">
                <h1><i class="iconfont">&#xe626;</i><span>中奖名单</span></h1>
                <div class="winners_list_main">
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>1</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>2</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>3</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>4</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>5</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>6</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>7</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>8</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>9</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span>10</span></div>
                        <div class="winners_list_mpright"><p>第<span>2016121612</span>期</p><p>王宝强<span>15,000,00</span>元</p></div>
                    </div>
                </div>
            </div>
            <div class="winners_list Announcement">
                <h1><i class="iconfont">&#xe606;</i><span>平台公告</span></h1>
                <div class="winners_list_main">
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span></span></div>
                        <div class="winners_list_mpright"><p>时时彩本期撒单公告,请及时查看</p><p>2017/8/23 3:48</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span></span></div>
                        <div class="winners_list_mpright"><p>平台最高奖金设置</p><p>2017/8/23 3:48</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span></span></div>
                        <div class="winners_list_mpright"><p>时时彩本期撒单公告,请及时查看</p><p>2017/8/23 3:48</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span></span></div>
                        <div class="winners_list_mpright"><p>时时彩本期撒单公告,请及时查看</p><p>2017/8/23 3:48</p></div>
                    </div>
                    <div class="winners_list_main_p">
                        <div class="winners_list_mpleft"><span></span></div>
                        <div class="winners_list_mpright"><p>时时彩本期撒单公告,请及时查看</p><p>2017/8/23 3:48</p></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
