<?php
/**
 * 默认配置文件
 *
 * 
 */
session_start();
date_default_timezone_set('PRC');   //设置时区(中国标准时间)

/**
 * 订单处理end
*/
/**
 * 判断管理员
 * @return int
 */
function ludou_is_administrator() {
    // wp_get_current_user函数仅限在主题的functions.php中使用
    $currentUser = wp_get_current_user();

    if(!empty($currentUser->roles) && in_array('administrator', $currentUser->roles))
        return 1;  // 是管理员
    else
        return 0;  // 非管理员
}

/**
 * 点单号生成规则
 * @return string
 */
function build_order_no($orderid,$user){
   return date('ymd').($orderid*3).substr($user,-1);
    //return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/*转译html*/
function htmlSChars($v){
    return array_map('_htmlSChars',$v);
}

function _htmlSChars($v)
{
    if(is_array($v)){
        return array_map('_htmlSChars',$v);
    }else{
        return htmlspecialchars($v);
    }
}

/*判断系统-leo*/  
function get_system(){  
    $user_OSagent = $_SERVER['HTTP_USER_AGENT'];  
    if(strpos($user_OSagent,"NT")){  
        $visitor_os ="Windows";   
    }elseif(strpos($user_OSagent,"Mac")) {  
        $visitor_os ="Mac";  
    } elseif(strpos($user_OSagent,"Linux")) {   
        $visitor_os ="Linux";  
    } elseif(strpos($user_OSagent,"Unix")) {  
        $visitor_os ="Unix";  
    } elseif(strpos($user_OSagent,"FreeBSD")) {  
        $visitor_os ="FreeBSD";  
    } elseif(strpos($user_OSagent,"SunOS")) {  
        $visitor_os ="SunOS";   
    } elseif(strpos($user_OSagent,"BeOS")) {  
        $visitor_os ="BeOS";   
    } elseif(strpos($user_OSagent,"OS/2")) {  
        $visitor_os ="OS/2";  
    } elseif(strpos($user_OSagent,"PC")) {  
        $visitor_os ="Macintosh";  
    } elseif(strpos($user_OSagent,"AIX")) {  
        $visitor_os ="AIX";  
    } elseif(strpos($user_OSagent,"IBM OS/2")) {  
        $visitor_os ="IBM OS/2";  
    } elseif(strpos($user_OSagent,"BSD")) {  
        $visitor_os ="BSD";  
   } elseif(strpos($user_OSagent,"NetBSD")) {  
        $visitor_os ="NetBSD";  
    } else {  
       $visitor_os ="其它操作系统";  
    }  
    return $visitor_os;   
}

/*获取设备名称-leo*/
function get_device(){

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (stripos($user_agent, "iPhone")!==false) {
        $brand = 'iPhone';
    }else if (stripos($user_agent, "iPad")!==false) {
        $brand = 'iPad';
    }else if (stripos($user_agent, "SAMSUNG")!==false || stripos($user_agent, "Galaxy")!==false || strpos($user_agent, "GT-")!==false || strpos($user_agent, "SCH-")!==false || strpos($user_agent, "SM-")!==false) {
        $brand = '三星';
    } else if (stripos($user_agent, "Huawei")!==false || stripos($user_agent, "Honor")!==false || stripos($user_agent, "H60-")!==false || stripos($user_agent, "H30-")!==false) {
        $brand = '华为';
    } else if (stripos($user_agent, "Lenovo")!==false) {
        $brand = '联想';
    } else if (strpos($user_agent, "MI-ONE")!==false || strpos($user_agent, "MI 1S")!==false || strpos($user_agent, "MI 2")!==false || strpos($user_agent, "MI 3")!==false || strpos($user_agent, "MI 4")!==false || strpos($user_agent, "MI-4")!==false) {
        $brand = '小米';
    } else if (strpos($user_agent, "HM NOTE")!==false || strpos($user_agent, "HM201")!==false) {
        $brand = '红米';
    } else if (stripos($user_agent, "Coolpad")!==false || strpos($user_agent, "8190Q")!==false || strpos($user_agent, "5910")!==false) {
        $brand = '酷派';
    } else if (stripos($user_agent, "ZTE")!==false || stripos($user_agent, "X9180")!==false || stripos($user_agent, "N9180")!==false || stripos($user_agent, "U9180")!==false) {
        $brand = '中兴';
    } else if (stripos($user_agent, "OPPO")!==false || strpos($user_agent, "X9007")!==false || strpos($user_agent, "X907")!==false || strpos($user_agent, "X909")!==false || strpos($user_agent, "R831S")!==false || strpos($user_agent, "R827T")!==false || strpos($user_agent, "R821T")!==false || strpos($user_agent, "R811")!==false || strpos($user_agent, "R2017")!==false) {
        $brand = 'OPPO';
    }else if (strpos($user_agent, "LG")!==false || stripos($user_agent, "Desire")!==false) {
        $brand = 'LG';
    }else if (strpos($user_agent, "HTC")!==false || stripos($user_agent, "Desire")!==false) {
        $brand = 'HTC';
    } else if (stripos($user_agent, "vivo")!==false) {
        $brand = 'vivo';
    } else if (stripos($user_agent, "K-Touch")!==false) {
        $brand = '天语';
    } else if (stripos($user_agent, "Nubia")!==false || stripos($user_agent, "NX50")!==false || stripos($user_agent, "NX40")!==false) {
        $brand = '努比亚';
    } else if (strpos($user_agent, "M045")!==false || strpos($user_agent, "M032")!==false || strpos($user_agent, "M355")!==false) {
        $brand = '魅族';
    } else if (stripos($user_agent, "DOOV")!==false) {
        $brand = '朵唯';
    } else if (stripos($user_agent, "GFIVE")!==false) {
        $brand = '基伍';
    } else if (stripos($user_agent, "Gionee")!==false || strpos($user_agent, "GN")!==false) {
        $brand = '金立';
    } else if (stripos($user_agent, "HS-U")!==false || stripos($user_agent, "HS-E")!==false) {
        $brand = '海信';
    } else if (stripos($user_agent, "Nokia")!==false) {
        $brand = '诺基亚';
    } else {
        $brand = '其他手机';
    }

    return $brand;
}

/*获取IP-leo*/
function getIP() { 
    if (getenv('HTTP_CLIENT_IP')) { 
        $ip = getenv('HTTP_CLIENT_IP'); 
    } 
    elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
        $ip = getenv('HTTP_X_FORWARDED_FOR'); 
    } 
    elseif (getenv('HTTP_X_FORWARDED')) { 
        $ip = getenv('HTTP_X_FORWARDED'); 
    } 
    elseif (getenv('HTTP_FORWARDED_FOR')) { 
        $ip = getenv('HTTP_FORWARDED_FOR'); 

    } 
    elseif (getenv('HTTP_FORWARDED')) { 
        $ip = getenv('HTTP_FORWARDED'); 
    } 
    else { 
        $ip = $_SERVER['REMOTE_ADDR']; 
    } 
    return $ip; 
} 

/*IP地址转化-leo*/
function convertip($ip) {
    $dat_path = WP_CONTENT_DIR.'/uploads/qqwry/qqwry.dat';
    
    if(!$fd = @fopen($dat_path, 'rb')){
        return 'IP date file not exists or access denied';
    }
    $ip = explode('.', $ip);
    $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];
    $DataBegin = fread($fd, 4);
    $DataEnd = fread($fd, 4);
    $ipbegin = implode('', unpack('L', $DataBegin));
    if($ipbegin < 0) $ipbegin += pow(2, 32);
    $ipend = implode('', unpack('L', $DataEnd));
    if($ipend < 0) $ipend += pow(2, 32);
    $ipAllNum = ($ipend - $ipbegin) / 7 + 1;
    $BeginNum = 0;
    $EndNum = $ipAllNum;
    while($ip1num>$ipNum || $ip2num<$ipNum) {
        $Middle= intval(($EndNum + $BeginNum) / 2);
        fseek($fd, $ipbegin + 7 * $Middle);
        $ipData1 = fread($fd, 4);
        if(strlen($ipData1) < 4) {
            fclose($fd);
            return 'System Error';
        }
        $ip1num = implode('', unpack('L', $ipData1));
        if($ip1num < 0) $ip1num += pow(2, 32);
        if($ip1num > $ipNum) {
            $EndNum = $Middle;
            continue;
        }
        $DataSeek = fread($fd, 3);
        if(strlen($DataSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
        fseek($fd, $DataSeek);
        $ipData2 = fread($fd, 4);
        if(strlen($ipData2) < 4) {
            fclose($fd);
            return 'System Error';
        }
        $ip2num = implode('', unpack('L', $ipData2));
        if($ip2num < 0) $ip2num += pow(2, 32);
        if($ip2num < $ipNum) {
            if($Middle == $BeginNum) {
                fclose($fd);
                return 'Unknown';
            }
            $BeginNum = $Middle;
        }
    }
    $ipFlag = fread($fd, 1);
    if($ipFlag == chr(1)) {
        $ipSeek = fread($fd, 3);
        if(strlen($ipSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
        fseek($fd, $ipSeek);
        $ipFlag = fread($fd, 1);
    }
    if($ipFlag == chr(2)) {
        $AddrSeek = fread($fd, 3);
        if(strlen($AddrSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $ipFlag = fread($fd, 1);
        if($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if(strlen($AddrSeek2) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }
        while(($char = fread($fd, 1)) != chr(0))
        $ipAddr2 .= $char;
        $AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
        fseek($fd, $AddrSeek);
        while(($char = fread($fd, 1)) != chr(0))
        $ipAddr1 .= $char;
    } else {
        fseek($fd, -1, SEEK_CUR);
        while(($char = fread($fd, 1)) != chr(0))
        $ipAddr1 .= $char;

        $ipFlag = fread($fd, 1);
        if($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if(strlen($AddrSeek2) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }
        while(($char = fread($fd, 1)) != chr(0)){
            $ipAddr2 .= $char;
        }
    }
    fclose($fd);
    if(preg_match('/http/i', $ipAddr2)) {
        $ipAddr2 = '';
    }
    $ipaddr = "$ipAddr1 $ipAddr2";
    $ipaddr = preg_replace('/CZ88.Net/is', '', $ipaddr);
    $ipaddr = preg_replace('/^s*/is', '', $ipaddr);
    $ipaddr = preg_replace('/s*$/is', '', $ipaddr);
    if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
        $ipaddr = 'Unknown';
    }
    $ipaddr = iconv('gbk', 'utf-8//IGNORE', $ipaddr); 
    if( $ipaddr != '  ' )
        return $ipaddr;
    else
        $ipaddr = '地址未知！火星来客？';
        return $ipaddr;
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

function is_weixin(){
    return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger');
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
//分页功能
function theme_echo_pagenavi($flag=false){
    global $request, $posts_per_page, $wpdb, $paged;

    $maxButtonCount = 3; //显示的最多链接数目
    if (!is_single()) {
        if(!is_category()) {
            preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);
        } else {
            preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);
        }

        $fromwhere = $matches[1];
        //var_dump(get_the_category());
        $numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
        //var_dump(get_the_category());

        $max_page = ceil($numposts /$posts_per_page);
        if(empty($paged)) {
            $paged = 1;
        }

        $start = max(1, $paged - intval($maxButtonCount/2));
        $end = min($start + $maxButtonCount - 1, $max_page);
        $start = max(1, $end - $maxButtonCount + 1);

        if($flag){
            ?>
            <div id="navigation">
                <a href="<?=get_pagenum_link($paged+1)?>">下一页</a>
            </div>
            <?php
        }else{
            if($paged == 1){
                if($end == 1){
                    echo ' ';
                }else{

                    echo '<a href="#"><li>首页</li></a>';
                }
            }else{
                echo '<a href="'.get_pagenum_link().'"><li>首页</li></a>';
                echo '<a href="'.get_pagenum_link($paged-1).'"><li class="hyNewListLeftPageLast">上一页</li></a>';
            }

            if($paged > 3){
                echo '<a href="'.get_pagenum_link(1).'"><li class="page_num">1</li></a>';
                echo '<li>...</li>';
            }
            if($paged == 3){
                echo '<a href="'.get_pagenum_link(1).'"><li class="page_num">1</li></a>';
            }
            if($end == 1){
                echo '';
            }else{

                for($i=$start; $i<=$end; $i++){
                    if($i == $paged) {
                        echo '<a href="'.get_pagenum_link($i).'"><li class="page_num on">'.$i.'</li></a>';
                    } else {
                        echo '<a href="'.get_pagenum_link($i).'"><li class="page_num">'.$i.'</li></a>';
                    }
                }
            }

            if($paged == $max_page){
                if($end == 1){
                    echo '';
                }else{

                    echo "<li>末页</li> ";
                }
            }else{
                echo '<a href="'.get_pagenum_link($paged+1).'"><li class="hyNewListLeftPageNext">下一页</li></a>';
                echo '<a href="'.get_pagenum_link($max_page).'"><li>尾页</li></a>';
            }
        }
        
        //echo " <li>共{$numposts}条记录</li>";
    }
}

//判断二维数组中时候有某个值
function deep_in_array($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }

        if(in_array($value, $item)) {
            return true;
        } else if(deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
}

/// 函数名称：post_views
/// 函数作用：取得文章的阅读次数
 function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    if ($echo) echo $before, number_format($views), $after;
    else return $views;
}

/*
* 中文截取，支持gb2312,gbk,utf-8,big5
*
* @param string $str 要截取的字串
* @param int $start 截取起始位置
* @param int $length 截取长度
* @param string $charset utf-8|gb2312|gbk|big5 编码
* @param $suffix 是否加尾缀
*/

 function csubstr($str, $start=0, $length, $suffix=false,$charset="utf-8")
{

    if(function_exists("mb_substr"))

    {

        if(mb_strlen($str, $charset) <= $length) return $str;

        $slice = mb_substr($str, $start, $length, $charset);

    }
    else
    {

        $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";

        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";

        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";

        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";

        preg_match_all($re[$charset], $str, $match);

        if(count($match[0]) <= $length) return $str;

        $slice = join("",array_slice($match[0], $start, $length));
    }

    if($suffix) return $slice."…";

    return $slice;

}
//数字格式化
 function num_format($num){
    if(!is_numeric($num)){
        return false;
    }
    $rvalue='';
    $num = explode('.',$num);//把整数和小数分开
    $rl = !isset($num['1']) ? '' : $num['1'];//小数部分的值
    $j = strlen($num[0]) % 3;//整数有多少位
    $sl = substr($num[0], 0, $j);//前面不满三位的数取出来
    $sr = substr($num[0], $j);//后面的满三位的数取出来
    $i = 0;
    while($i <= strlen($sr)){
        $rvalue = $rvalue.','.substr($sr, $i, 3);//三位三位取出再合并，按逗号隔开
        $i = $i + 3;
    }
    $rvalue = $sl.$rvalue;
    $rvalue = substr($rvalue,0,strlen($rvalue)-1);//去掉最后一个逗号
    $rvalue = explode(',',$rvalue);//分解成数组
    if($rvalue[0]==0){
        array_shift($rvalue);//如果第一个元素为0，删除第一个元素
    }
    $rv = $rvalue[0];//前面不满三位的数
    for($i = 1; $i < count($rvalue); $i++){
        $rv = $rv.','.$rvalue[$i];
    }
    if(!empty($rl)){
        $rvalue = $rv.'.'.$rl;//小数不为空，整数和小数合并
    }else{
        $rvalue = $rv;//小数为空，只有整数
    }
    return $rvalue;
}
//计算评论发表时间
 function time2Units ($time)
{
    $year   = floor($time / 60 / 60 / 24 / 365);
    $time  -= $year * 60 * 60 * 24 * 365;
    $month  = floor($time / 60 / 60 / 24 / 30);
    $time  -= $month * 60 * 60 * 24 * 30;
    $week   = floor($time / 60 / 60 / 24 / 7);
    $time  -= $week * 60 * 60 * 24 * 7;
    $day    = floor($time / 60 / 60 / 24);
    $time  -= $day * 60 * 60 * 24;
    $hour   = floor($time / 60 / 60);
    $time  -= $hour * 60 * 60;
    $minute = floor($time / 60);
    $time  -= $minute * 60;
    $second = $time;
    $elapse = '';

    $unitArr = array('年'  =>'year', '个月'=>'month',  '周'=>'week', '天'=>'day','小时'=>'hour', '分钟'=>'minute', '秒'=>'second');

    foreach ( $unitArr as $cn => $u )
    {
        if ( $$u > 0 )
        {
            $elapse = $$u . $cn;
            break;
        }
    }
    return $elapse;
}


function base_encode($str) {

    $src  = array("/","+","=");
    $dist = array("_","-","!");
    $old  = base64_encode($str);
    $new  = str_replace($src,$dist,$old);

    return $new;
}

function base_decode($str) {

    $dist = array("_","-","!");
    $dist  = array("/","+","=");
    $old  = str_replace($src,$dist,$str);
    $new = base64_decode($old);

    return $new;
}
/*组装数组 ijitao*/
function CombinationArray($arr){
    if(count($arr) >= 2){
        $tmparr = array();
        $arr1 = array_shift($arr);
        $arr2 = array_shift($arr);
        foreach($arr1 as $k1 => $v1){
            foreach($arr2 as $k2 => $v2){
                $c = $v1;
                if(!is_array($c)){
                    $c = array($c);
                }
                $c[]=$v2;
                $tmparr[] = $c;
            }
        }
        array_unshift($arr, $tmparr);
        $arr = CombinationArray($arr);
    }else{
        return $arr;
    }
    return $arr;
}
function CombinationArrays($allSe){
    $allSe = CombinationArray($allSe);
    if($allSe){
        $s=array();
        foreach($allSe as $v){
            foreach($v as $vv){
                $s[]=array($vv);
            }
        }
        $allSe = $s;
    }else{
        $allSe = $allSe[0];
    }
    return $allSe;
}

if($_REQUEST){
    require_once get_stylesheet_directory().'/config/SqlSafe.class.php';//加载sql注入,已实例化对象
}

/**
 * 程序加载
 */
if(is_admin()){
    require_once 'config/AdminConfig.class.php';//加载admin默认设置
    add_filter('sanitize_file_name', 'wpyou_rename_upload_file', 10);
}else{

    require_once 'config/AppConfig.class.php';//加载默认设置
}
/*公用*/
add_action( 'init', 'coolwp_remove_open_sans_from_wp_core');
function coolwp_remove_open_sans_from_wp_core() {
        wp_deregister_style( 'open-sans' );
        wp_register_style( 'open-sans', false );
        wp_enqueue_style('open-sans','');
    }
//改后台lgoo
add_filter('login_headerurl', create_function(false, 'return home_url();'));
add_filter('login_headertitle', create_function(false, 'return get_bloginfo("description");'));
add_action('login_head', 'nowspark_login_head');
function nowspark_login_head(){
    echo '<style type="text/css">
            body.login #login h1 a {
                background:url("' . IMG . '/topBottom/share-logo-red.png") no-repeat center transparent;
                height: 100px;
                width: 155px;
                padding:0;
                margin:0 auto 1em;
                background-size: contain;}
                </style>';
}
function wpyou_rename_upload_file($filename) {

    $info = pathinfo($filename);
    $ext = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($filename, $ext);
    return substr(md5($name), 0, 15) . $ext; // 15 为要截取的文件名长度

}
function priceHtml($price){
    return "<b class='priceY'>&yen;</b>".sprintf('%.2f',$price);
}

require_once 'libraries/util/EtNavigation.class.php';
function wpautops($content){
    $content = wpautop($content);
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
}
/**
 * 新浪获取地址
 */
function getIpAddress(){
    $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=".getIP();
    $ipContent   = file_get_contents($url);
    $jsonData = explode("=",$ipContent);
    $jsonAddress = substr($jsonData[1], 0, -1);
    return $jsonAddress;
}
/**
*获取到的地址进行转换
 */
 function getIpAddressList($num=1){
     global $user;
     $return = array();
     $AccountModel = new \app\consumer\model\AccountModel();
     if($user){
         if($_SESSION['address']){
             $where = "and a.c_ad_id = {$_SESSION['address']}";
             $getUserAddressfirst = $AccountModel->getAddressAll("c_id={$user['userId']} {$where}",'1');
         }else{
             $getUserAddressfirst = $AccountModel->getAddressAll("c_id={$user['userId']}",'1');
         }
        if($getUserAddressfirst) {
            if ($getUserAddressfirst[0]['c_ad_province']) {
                $return['province'] = array(
                    'code' => $getUserAddressfirst[0]['c_ad_province'],
                    'name' => $getUserAddressfirst[0]['c_ad_provinceN'],
                );
            }
            if ($getUserAddressfirst[0]['c_ad_city']) {
                $return['city'] = array(
                    'code' => $getUserAddressfirst[0]['c_ad_city'],
                    'name' => $getUserAddressfirst[0]['c_ad_cityN'],
                );
            }
            if ($getUserAddressfirst[0]['c_ad_county']) {
                $return['district'] = array(
                    'code' => $getUserAddressfirst[0]['c_ad_county'],
                    'name' => $getUserAddressfirst[0]['c_ad_countyN'],
                );
            }
            return $return;
        }
     }
     $ip_info=json_decode(getIpAddress());
     if($ip_info->province){
         /**
          * 第一级
          */
         $province = $AccountModel->getAddress("name like '{$ip_info->province}%' and parentId =0");
         $return['province'] = $province =$province[0];
         if($ip_info->city && $province && $num>1){
             /**
              * 第二级
              */
             $city = $AccountModel->getAddress("name like '{$ip_info->city}%' and parentId ={$province['code']} ");
             $return['city'] = $city = $city[0];
             if($ip_info->district && $city && $num>2){
                 /**
                  * 第三级
                  */
                 $district = $AccountModel->getAddress("name like '{$ip_info->city}%' and parentId ={$city['code']}");
                 $return[district] = $district[0];
             }
         }
     }
     return $return;
 }

function inStockS($i_id,$p_id){
    $IpAddress = getIpAddressList(2);
    $r = false;
    //第一级判断
    $inStock = inStock($i_id,$p_id,$IpAddress['province']['code']);
    if($inStock){
        $r = $inStock;
    }
    /**
     * 判断第二级
     */
    if(!$inStock || $inStock->status!='all'){
        $inStock = inStock($i_id,$p_id,$IpAddress['city']['code']);
        if($inStock){
            $r = $inStock;
        }else{
            $r = false;
        }
    }
    return $r;
}
