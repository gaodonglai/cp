<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/22
 * Time: 17:35
 */

echo '主页';

?>

<?php //用户登出
if (is_user_logged_in()) {
    $current_user = get_currentuserinfo();
    //print_r($current_user);
    echo $current_user->user_login;
   // echo $current_user->roles[0];


    echo '我的积分'.cp_getPoints($current_user->ID);
    cp_show_logs($current_user->ID, 15 , false);

    ?><a href="<?php echo wp_logout_url(home_url('member/login')); ?>" title="登出">登出</a><?php
}else{
    ?><a href="<?php echo home_url('member/login'); ?>" title="登录">登录</a><?php
}
?>


