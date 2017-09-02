<?php
namespace libraries\helper {
	/**
	 * 快递一百接口
	 * Class Logistics
	 * @package libraries\helper
	 */

    class Logistics {
        /**
         * @param 收件人
         * @param 邮件标题
         * @param 邮件内容
         * @return bool
         */

        public function connectLogisticsAPI($typeCom,$typeNu){

            /*$typeCom = $_GET["com"];//快递公司
            $typeNu = $_GET["nu"];  //快递单号*/

            //echo $typeCom.'<br/>' ;
            //echo $typeNu ;

            $AppKey='a86d77ce1e7ad2b3';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
            //$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=2&muti=1&order=asc';
            $url = 'http://www.kuaidi100.com/applyurl?key='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu;

            //请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
            //$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';


            //优先使用curl模式发送数据
             
			$curl = curl_init();
			curl_setopt ($curl, CURLOPT_URL, $url);
			curl_setopt ($curl, CURLOPT_HEADER,0);
			curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
			curl_setopt ($curl, CURLOPT_TIMEOUT,5);
			$get_content = curl_exec($curl);
			curl_close ($curl);
             
            return $get_content;

        }

    }

}
?>