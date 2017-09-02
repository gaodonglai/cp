<?php

namespace libraries\util {


    class publicFunction{

        /*获取IP*/
        public function getIP() { 
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

        /*IP转换地址*/
        public function convertip($ip) {
            $dat_path = TEMPLATEPATH.'/qqwry.dat'; 
            
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



        /**
         * 自动补0
         */
        function dispRepair($str,$len,$msg,$type='1') {
            $length = $len - strlen($str);
            if($length<1)return $str;
            if ($type == 1) {
                $str = str_repeat($msg,$length).$str;
            } else {
                $str .= str_repeat($msg,$length);
            }
            return $str;
        }

        /*隐藏号码*/
        function hidtel($phone){
            $IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i',$phone); //固定电话
            if($IsWhat == 1){
                return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i','$1****$2',$phone);
            }else{
                return  preg_replace('/(1[3-9]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
            }
        }

        /*隐藏部分*/
        function hideStar($str) { //用户名、邮箱、手机账号中间字符串以*隐藏
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
                    $rs = substr($str, 0, 3) . "***" . substr($str, -1);
                }
            }
            return $rs;
        }


        /*
         * 正则匹配
         * @ str type   匹配类型
         * @ str value  匹配参数
         * */
        function pregMatch($type,$value){
            if($type == 'mobile'){
                $match = '/^1[3-9][0-9]{9}$/';  //手机
            }elseif($type == 'pass'){
                $match = '/^[A-Za-z0-9_\,\.\;\\\'\?]{6,20}$/';  //密码由字母、数字和标点符号组成
            }elseif($type == 'user'){
                $match = '/^[a-zA-Z_][\w_]{3,16}$/';  //用户名以字母或下划线开头 4-16位
            }elseif($type == 'email'){
                $match = '/^([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i';    //邮箱
            }elseif($type == 'nick'){
                $match = "/[\x{4e00}-\x{9fa5}\w]{1,20}$/u";
            }
            return preg_match($match,$value);
        }

        //数字格式化
        public function num_format($num){
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
        public function time2Units ($time)
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

        /*
        * 中文截取，支持gb2312,gbk,utf-8,big5
        *
        * @param string $str 要截取的字串
        * @param int $start 截取起始位置
        * @param int $length 截取长度
        * @param string $charset utf-8|gb2312|gbk|big5 编码
        * @param $suffix 是否加尾缀
        */

        public function csubstr($str, $start=0, $length, $suffix=false,$charset="utf-8")
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
    }
}
