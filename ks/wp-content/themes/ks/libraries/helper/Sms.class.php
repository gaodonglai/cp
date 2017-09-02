<?php
namespace libraries\helper {

    /***
     * Class 移动终端短信发送
     */
    class Sms{

        private $show = false;


        /**\
         * 短信发送
         * @param 内容标示
         * @param 手机号
         * @param 变量/可以为空
         */
        public function send_mobile($mark,$mobile,$variable=null){

           $note = get_option('short_message_settings');

            if($variable){
                $content = sprintf($note['content'][$mark]['content'],$variable);//短信内容
            }else{
                $content = $note['content'][$mark]['content'];
            }

            $argv = array(
                'name'=>$note['user_name'],     //必填参数。用户账号
                'pwd'=>$note['user_pwd'],     //必填参数。（web平台：基本资料中的接口密码）
                'content'=>$content,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
                'mobile'=>$mobile,   //必填参数。手机号码。多个以英文逗号隔开
                'stime'=>date("Y-m-d H:i:s"),   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
                'sign'=>$note['content'][$mark]['sign'],    //必填参数。用户签名。
                'type'=>'pt',  //必填参数。固定值 pt
                'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
            );

            if($this->show){
                var_dump($argv);
                exit();
            }

            $this->send_sms($argv);
        }



        /**
         *
         */
        private function send_sms($argv)
        {
            $flag = 0;
            $params='';//要post的数据

            //构造要post的字符串
            //echo $argv['content'];
            foreach ($argv as $key=>$value){
                if ($flag!=0) {
                    $params .= "&";
                    $flag = 1;
                }
                $params.= $key."="; $params.= urlencode($value);// urlencode($value);
                $flag = 1;
            }

            $url = "http://web.duanxinwang.cc/asmx/smsservice.aspx?".$params; //提交的url地址

            $curl = curl_init();// 初始化一个 cURL 对象

            curl_setopt($curl, CURLOPT_URL, $url);// 设置需要抓取的URL

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。

            $data = curl_exec($curl);// 运行cURL，请求网页

            curl_close($curl);// 关闭URL请求

            $con= substr( $data, 0, 1 );  //获取信息发送后的状态
            //$con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
            if($con==0){
                return true;
            }else{
                return false;
            }


        }

        /**
         * @return 短信内容
         */
         function showContent(){
            $this->show = true;
            return $this;
        }

    }
}
