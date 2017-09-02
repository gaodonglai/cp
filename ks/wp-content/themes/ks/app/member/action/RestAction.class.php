<?php
/**
 * Created by PhpStorm.
 * User: GX
 * Date: 2016/5/23
 * Time: 23:20
 */

namespace app\member\action;


use libraries\controller\Action;

class RestAction extends Action
{
    public function main(){
        echo '请不要乱点';
    }

    public function url(){


        //当前是否是微信
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {

            if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                $this->display('order/pay/phoneSkip/openIphone');
            }else{
                $this->display('order/pay/phoneSkip/openAndroid');
            }
            exit();
        }else{
			if($_GET['type'] == 'html'){
				?>
			<head> 
				<meta http-equiv="refresh" content="0;url=<?=base64_decode(str_replace(" ","+",$_GET['url']))?>"> 
			</head> 
			<?php
			}else{
                $this->redirect(base64_decode(str_replace(" ","+",$_GET['url']))) ;
			}
			
            

        }
    }
}