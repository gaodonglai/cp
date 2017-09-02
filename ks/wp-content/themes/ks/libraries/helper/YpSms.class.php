<?php
namespace libraries\helper {

    /***
     * Class 移动终端短信发送
     */
    class YpSms{

        private $show = false;


        /**\
         * 短信发送
         * @param 内容标示
         * @param 手机号
         * @param 变量/可以为空
         */
        public function send_mobile($mark,$mobile,$variable=null){
            /**
             * 防止ajax跨域攻击恶意送短信
             */
            if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')){
                // $file  = '/var/www/html/sxck/ajaxlog.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
                // $content = $_SERVER['HTTP_REFERER'].' '.$_SERVER["REMOTE_ADDR"].' '. date('Y-m-d H:i:s',time())." \n";
                // $f  = file_put_contents($file, $content,FILE_APPEND);
                //禁止继续访问
                /*if($_SERVER["REMOTE_ADDR"]){
                    $htaccess  = '/var/www/html/sxck/.htaccess';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
                    $htaccesscontent = ' '.$_SERVER["REMOTE_ADDR"];
                    $htaccessf  = file_put_contents($htaccess, $htaccesscontent,FILE_APPEND);
                }*/
                
                header("Location: 404.php");
                exit();
            }
            $apikey = "8e3eec7f5c525cb1c0a15ff6bbff6c68"; //修改为您的apikey(https://www.yunpian.com)登陆官网后获取

            $note = get_option('short_message_settings');
            $apikey = $note['user_pwd'];
            if($variable){
                if(is_array($variable)){
                    $text = vsprintf($note['content'][$mark]['content'],$variable);//短信内容
                }else{
                    $text = sprintf($note['content'][$mark]['content'],$variable);//短信内容
                }

            }else{
                $text = $note['content'][$mark]['content'];
            }

            $text = "【{$note['content'][$mark]['sign']}】".$text;
            //exit($text);

            $ch = curl_init();

            /* 设置验证方式 */

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));

            /* 设置返回结果为流 */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            /* 设置超时时间*/
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            /* 设置通信方式 */
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // 发送短信
            $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
            $json_data = $this->send($ch,$data);
            $array = json_decode($json_data,true);

            curl_close($ch);

            if($array['msg'] == 'OK'){
                return true;
            }else{
                return false;
            }

        }



        private function get_user($ch,$apikey){
            curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/user/get.json');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
            return curl_exec($ch);
        }

        private function send($ch,$data){
            curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/sms/send.json');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            return curl_exec($ch);
        }

        private function tpl_send($ch,$data){
            curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/sms/tpl_send.json');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            return curl_exec($ch);
        }

        private function voice_send($ch,$data){
            curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v1/voice/send.json');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            return curl_exec($ch);
        }


    }
}
