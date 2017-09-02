<?php

class sqlsafe {
    //private  $getfilter    ="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    //private  $postfilter   ="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    private  $filter ="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE|USER_NAME|USER_PASS)";
    /**
     * 构造函数
     */
    public function __construct() {

        //foreach($_REQUEST as $key=>$value){$this->stopattack($key,$value,$this->getfilter);}
        //foreach($_POST as $key=>$value){$this->stopattack($key,$value,$this->postfilter);}
        //foreach($_COOKIE as $key=>$value){$this->stopattack($key,$value,$this->cookiefilter);}
        $_REQUEST = $this->stopattack($_REQUEST);
        $_COOKIE = $this->stopattack($_COOKIE);
    }
    /**
     * 参数检查并写日志
     */
    public function stopattack($str){
        if(is_array($str)) {
            $array=array();
            foreach ($str as $key => $value) {
                /**
                 * 防止SQL注入
                 */
                $values= $value;
                if(is_array($values)) $values = implode($values);
                $ArrFiltReq = $this->filter;
                if (preg_match("/".$ArrFiltReq."/is",$values) == 1){
                    header("Location: 404.php");
                    exit;
                }

                $keys = $this->xss_clean($key);
                $array[$keys] = $this->stopattack($value);
            }
            return $array;
        }else{
            return $this->xss_clean($str);
        }
    }
    public function xss_clean($data){

        // Fix &entity\n;
        $data=str_replace(array('&','<','>'),array('&','<','>'),$data);
        $data=preg_replace('/(&#*\w+)[\x00-\x20]+;/u','$1;',$data);
        $data=preg_replace('/(&#x*[0-9A-F]+);*/iu','$1;',$data);
        $data=html_entity_decode($data,ENT_COMPAT,'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $data=preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu','$1>',$data);
        // Remove javascript: and vbscript: protocols
        $data=preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu','$1=$2nojavascript...',$data);
        $data=preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu','$1=$2novbscript...',$data);
        $data=preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u','$1=$2nomozbinding...',$data);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data=preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i','$1>',$data);
        $data=preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i','$1>',$data);
        $data=preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu','$1>',$data);
        // Remove namespaced elements (we do not need them)
        $data=preg_replace('#</*\w+:\w[^>]*+>#i','',$data);

        // http://www.phpernote.com/
        do{// Remove really unwanted tags
            $old_data=$data;
            $data=preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i','',$data);
        }while($old_data!==$data);
        // we are done...
        if(is_admin()){
            return $data;
        }else{
            return htmlspecialchars($data);
        }

    }
    /**
     * SQL注入日志
     */
    public function writeslog($log){

        $log_path = CACHE_PATH.'logs'.DIRECTORY_SEPARATOR.'sql_log.txt';
        $ts = fopen($log_path,"a+");
        fputs($ts,$log."\\r\\n");
        fclose($ts);
    }
}
new sqlsafe();

?>
