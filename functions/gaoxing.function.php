<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2017/9/1
 * Time: 下午4:51
 * Created people: gaodonglai
 * pageName:
 */

/**
 * 加密
 * @param $parameter 需要加密的参数
 * @return bool|string
 */
function wpEncrypt($password) {
    global $wp_hasher;

    if ( empty($wp_hasher) ) {
        require_once( MAIN_PATH.'/ks/wp-includes/class-phpass.php');
        // By default, use the portable hash from phpass
        $wp_hasher = new PasswordHash(8, true);
    }

    return $wp_hasher->HashPassword( trim( $password ) );
}


/**
 * 解密
 * @param $parameter 需要验证的参数
 * @param $sigParameter 已加密的参数
 * @return bool
 */
function wpDecode($parameter,$sigParameter){

    global $wp_hasher;

    if ( empty($wp_hasher) ) {
        require_once( MAIN_PATH.'/ks/wp-includes/class-phpass.php');

        $wp_hasher = new PasswordHash(8, true);
    }

    //验证密码
    $data = $wp_hasher->CheckPassword($parameter,$sigParameter);
    if($data){
        return true;
    }else{
        return false;
    }



}

/**
 * 获取用户二维码
 * @param $url
 */
function phpqrcode($url){
    include MAIN_PATH . DS . 'Conf' . DS .'libraries'.DS .'phpqrcode'.DS .'phpqrcode.php';
    QRcode::png($url);
}


/**
 * 获取随机验证码
 */
function get_rand_code(){
    require_once( MAIN_PATH.'/Conf/libraries/CkCode.class.php');
    $code = new CkCode();
    return $code->code();
}