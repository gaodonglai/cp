<?php
$cat = get_the_category()[0];		//获取当前分类信息
get_header();
?>

<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
<!-- 文章详情 begin -->
<div class="container">
    <div class="articlescrap_details">
        <div class="articlescrap_details_top">
            <i class="iconfont">&#xe61e;</i>
            <span class=""><a href="<?=home_url('archives/category/defaultcategory')?>">返回文章列表</a> </span>
        <span class="fr">
            <?php previous_post_link() ?>
            <i class="iconfont" style="position: relative;top: 1px;">&#xe621;</i>
            <?php next_post_link() ?>
        </span>
        </div>
        <div class="articlescrap_text_main">

        <h1 class="articlescrap_details_h1 text_right">
            <span class="fl"><?php the_title(); ?></span>
            <span>2016-6-09 12:40</span>
        </h1>
        <?php the_content();?>
        <div class="articlescrap_details_fen text_center">
            <img src="<?=IMG?>/articlescrap_details_img01.png" alt="">
            <img src="<?=IMG?>/articlescrap_details_img02.png" alt="">
            <img src="<?=IMG?>/articlescrap_details_img03.png" alt="">
            <img src="<?=IMG?>/articlescrap_details_img04.png" alt="">
        </div>
        </div>
        <!--<div class="articlescrap_details_line text_right">
        <span class="fl">
            <i class="iconfont">&#xe61d;</i>
            <span class=""> 22条评论</span>
        </span>
            <div></div>
            <i class="iconfont">&#xe624;</i>
            <a class="my_click_say" href="javascript: void(0);">我来说两句</a>
        </div>-->
        <!--<ul class="articlescrap_details_lists">
            <li class="">
                <img src="<?/*=IMG*/?>/articlescrap_details_img01.png" alt="">
                <span>咕噜噜来噜啦</span>
                <span class="articlescrap_details_lists_data1 fr">2016-6-12  23:12</span>
                <p>酒很香，非常不错，哈哈哈，存点酒,给自己以感
                    动，给时间以期许。</p>
                <i class="iconfont">&#xe622;</i>
                <span class="">赞22</span>
            <span class="fr">
                <i class="iconfont">&#xe625;</i>
                <a href="" class="">回复</a>
            </span>
            </li>
            <li class="">
                <img src="<?/*=IMG*/?>/articlescrap_details_img01.png" alt="">
                <span>咕噜噜来噜啦</span>
                <span class="articlescrap_details_lists_data1 fr">2016-6-12  23:12</span>
                <p>酒很香，非常不错，哈哈哈，存点酒,给自己以感
                    动，给时间以期许。</p>
                <i class="iconfont">&#xe603;</i>
                <span class=""> 赞22</span>
            <span class="fr">
                <i class="iconfont">&#xe625;</i>
                <a href="" class="">回复</a>
            </span>
            </li>
        </ul>-->
    </div>
</div>
<?php endif; ?>
<!-- 文章详情 end -->


    <div class="container">

        <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
            <div class="articlescrap_lists">
                <ul class="articlescrap_lists_data">
                    <li>
                        <span><?php the_time('n月') ?></span>
                    </li>
                    <li>
                        <span><?php the_time('j') ?></span>
                    </li>
                    <li>
                        <span><?php the_time('Y') ?></span>
                    </li>
                </ul>
                <?php
                if ( get_post_thumbnail_id($post->ID) )
                {
                    $thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
                    $newPic = $thumbnail_image_url[0];
                }else{
                    $newPic = IMG.'/default.png';
                }?>
                <!-- <img src="<?=IMG?>/articlescrap_lists_data.png" alt=""> -->
                <img class="articlescrap_lists_img" src="<?=$newPic?>" alt="">
                <div>
                    <h1 class="articlescrap_container"><?php the_title(); ?></h1>
                    <p class="articlescrap_container"><?php the_content();?></p>

                </div>
            </div>
        <?php endif; ?>

    </div>

    <div class="articlescrap_details_fixed">
        <div class="my_account_header">
            <div class="container_100_center">
                <!--头部 begin-->
                <div class="my_account_header">
                    <a href="javascript: history.go(-1)" class="fl margin_both_font articlescrap_details_cancel">
                        取消
                    </a>
                    <span>发表评论</span>
                    <a href="#" class="fr margin_both_font">保存</a>
                </div>
                <!--头部 end-->
            </div>
        </div>
        <textarea placeholder="输入内容" class="articlescrap_details_textarea font_28" name="" id=""></textarea>
    </div>

    <script>
        jQuery(function($){
            $(".my_click_say").click(function(){
                $('.articlescrap_details_fixed').show();
            });
            $(".articlescrap_details_cancel").click(function(){
                $('.articlescrap_details_fixed').hide();
            });
        });

    </script>

<?php get_footer(); ?>