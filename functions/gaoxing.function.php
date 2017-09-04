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
function wpEncrypt($parameter){

    global $wp_hasher;

    if ( empty($wp_hasher) ) {
        require_once( MAIN_PATH.'/ks/wp-includes/class-phpass.php');

        $wp_hasher = new PasswordHash(8, TRUE);
    }


    return $wp_hasher->HashPassword($parameter);

}


/**
 * 解密
 * @param $parameter 需要验证的参数
 * @param $sigParameter 已加密的参数
 * @return bool
 */
function wpDecode($parameter, $sigParameter){

    global $wp_hasher;

    if ( empty($wp_hasher) ) {
        require_once( MAIN_PATH.'/ks/wp-includes/class-phpass.php');

        $wp_hasher = new PasswordHash(8, TRUE);
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
 * 获取随机验证码
 */
function get_rand_code(){
    require_once( MAIN_PATH.'/Conf/libraries/CkCode.class.php');
    $code = new CkCode();
    return $code->code();
}