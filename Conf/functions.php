<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 22:50
 */

date_default_timezone_set('PRC');   //设置时区(中国标准时间)

//个性化函数
function individuationFunctions(){
    $arr_submenu = glob(MAIN_PATH . "/functions/*.function.php");

    if (!empty($arr_submenu)) {
        foreach ($arr_submenu as $value) {
            include $value;
        }
    }
}
individuationFunctions();



/**
 * 显示页面
 * @param $pageName 页面名称
 */
function display_show($pageName){
    $equipment = is_mobile() ? VIEW_MOBILE : VIEW_PC;
    $file = $equipment . $pageName .EXT;
    if(is_file($file))
        include $file;

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