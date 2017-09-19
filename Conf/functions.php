<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 22:50
 */

date_default_timezone_set('PRC');   //设置时区(中国标准时间)

session_start();

/**
 * 获取用户信息
 * @return mixed
 */
function get_user_info(){
    global $wpdb,$user_info;
    if($user_info){
        return $user_info;
    }else{
        $user_id = $_SESSION['user_id'];
        if($user_id){
            $user_info = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}account` WHERE user_id = {$user_id}");
            return $user_info;
        }else{
            return false;
        }
    }

}

/**
 * 用户id
 * @return mixed
 */
function get_user_id(){
    return $_SESSION['user_id'];
}

/**
 * 页面重定向
 * @param $url 页面链接
 */
function redirect($url){

    header("Location: $url");
    exit();
}


//个性化函数
function individu_ation_functions(){
    $arr_submenu = glob(MAIN_PATH . "/functions/*.function.php");

    if (!empty($arr_submenu)) {
        foreach ($arr_submenu as $value) {
            include $value;
        }
    }
}
individu_ation_functions();

/**
 * 显示页面
 * @param $pageName 页面名称
 */
function display_show($pageName,$args=array()){
    $equipment = is_mobile() ? VIEW_MOBILE : VIEW_PC;
    $file = $equipment . $pageName .EXT;

    if(is_file($file)){
        if(is_array($args)){
            if(!empty($args)){
                //对象属性装换为数组
                foreach($args as $key => $value){
                    $arr[$key] = $value;
                }
                extract($arr);//生成变量
            }
        }


        include $file;
    }


}



function get_header_front( $name = null ) {

    $terminal = is_mobile() ? 'mobile' : 'pc';


    $templates = array();
    $name = (string) $name;
    if ( '' !== $name ) {
        $templates = 'View'.DS.$terminal.DS."header-{$name}.php";
    }else{
        $templates = 'View'.DS.$terminal.DS.'header.php';
    }

    include MAIN_PATH . DS . $templates;

}

function get_footer_front( $name = null ) {

    $terminal = is_mobile() ? 'mobile' : 'pc';

    $name = (string) $name;
    if ( '' !== $name ) {
        $templates = 'View'.DS.$terminal.DS."footer-{$name}.php";
    }else{
        $templates    = 'View'.DS.$terminal.DS.'footer.php';
    }

    include MAIN_PATH . DS . $templates;
}

//获取主页
/**
 * @param string $page
 * @return string
 */
function _get_home_url($page=''){

    $baseUrl = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
    $baseUrl = empty($baseUrl) ? '/' : '/'.trim($baseUrl,'/').'/';


    return "http://".$_SERVER['HTTP_HOST'].$baseUrl.$page;

}



/*判断手持设备*/
function is_mobile( $a=false ) {
    global $is_mobile;
    if($is_mobile){
        return $is_mobile;
    }
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            if($a==true){

                $is_mobile = $device;
            }else{

                $is_mobile = true;
            }
            break;
        }
    }
    return $is_mobile;
}

/**
 *识别安卓APP
 */
if(is_mobile() && ($_GET['isapp'] == MD5('sxshappyes') || $_COOKIE['isapp'] == MD5('sxshappyes'))){
    $isapp = $_GET['isapp'] ? $_GET['isapp'] : $_COOKIE['isapp'];
    setcookie('isapp',$isapp,time()+'315360000','/','.sixiangcangku.com');
}
/**
 *识别IPSAPP
 */
if(is_mobile() && ($_GET['isapp'] == MD5('sxshiosyes') || $_COOKIE['isapp'] == MD5('sxshiosyes'))){
    $isapp = $_GET['isapp'] ? $_GET['isapp'] : $_COOKIE['isapp'];
    setcookie('isapp',$isapp,time()+'315360000','/','.sixiangcangku.com');
}

/*获取用户ip地址*/
function ip() {
    $unknown = 'unknown';
    if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    /*
    处理多层代理的情况
    或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
    */
    if (false !== strpos($ip, ','))
        $ip = reset(explode(',', $ip));
    return $ip;
}

/**
 * 用户名、邮箱、手机账号中间字符串以*隐藏
 * @param $str
 * @return mixed
 */
function hideStar($str) { //
    if (strpos($str, '@')) {
        $email_array = explode("@", $str);
        $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀
        $count = 0;
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
        $rs = $prevfix . $str;
    } else {
        $pattern = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i';
        if (preg_match($pattern, $str)) {
            $rs = preg_replace($pattern, '$1****$2', $str); // substr_replace($name,'****',3,4);
        } else {
            $rs = substr($str, 0, 3) . "***" . substr($str, -4);
        }
    }
    return $rs;
}

/*
  16-19 位卡号校验位采用 Luhm 校验方法计算：
    1，将未带校验位的 15 位卡号从右依次编号 1 到 15，位于奇数位号上的数字乘以 2
    2，将奇位乘积的个十位全部相加，再加上所有偶数位上的数字
    3，将加法和加上校验位能被 10 整除。
*/
function bankVerify($s) {
    $n = 0;
    for ($i = strlen($s); $i >= 1; $i--) {
        $index=$i-1;
        //偶数位
        if ($i % 2==0) {
            $n += $s{$index};
        } else {//奇数位
            $t = $s{$index} * 2;
            if ($t > 9) {
                $t = (int)($t/10)+ $t%10;
            }
            $n += $t;
        }
    }
    return ($n % 10) == 0;
}
