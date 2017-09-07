<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:07
 */

namespace Controller;


class Account
{
    function __construct()
    {
        $this->user_info = get_user_info();
        //如果没有登录跳转到登录页面
        if(!$this->user_info){
            redirect(_get_home_url());
        }

    }

    function main(){

        $this->my();
    }


    /**
     *投注
     */
    function bet(){

        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountBet');

        get_footer_front();
    }

    /**
     *银行卡管理
     */
    function bankCard(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountBankCard');

        get_footer_front();
    }

    /**
     *提现申请
     */
    function extractMoney(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountExtractMoney');

        get_footer_front();
    }

    /**
     *资金明细
     */
    function fcDetails(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountFcDetails');

        get_footer_front();
    }

    /**
     *我的账户
     */
    function my(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountMy');

        get_footer_front();
    }

    /**
     *密码修改
     */
    function passwordUp(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountPasswordUp');

        get_footer_front();
    }

    /**
     *支付
     */
    function pay(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountPay');

        get_footer_front();
    }

    /**
     *充值返现活动
     */
    function payActivity(){
        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountPayActivity');

        get_footer_front();
    }


    /**
     *分销商管理
     */
    function  distribution(){

        //获取分享信息
        $this->getMyShare();
        //获取用户分享链接
        $user_id = $this->user_info->user_id;
        $model = new \Model\Account();
        $get_link_info = $model->getAccountLinkShare($user_id);

        $residue_time = $get_link_info->end_time - time();

        $distri_url = _get_home_url('register?code='.$get_link_info->reg_code);


        $args = array(
            'distri_url'=>$distri_url,
            'residue_time'=>$residue_time
        );

        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountDistribution',$args);

        get_footer_front();
    }

    /**
     * 用户二维码
     */
    public function myQrCode(){
        $url = $_GET['code'];
        phpqrcode($url);
    }

    /*********************************************************开始：用户功能方法***************************************************************/
    /**
     * 获取我的分享
     */
    private function getMyShare(){

        $user_id = $this->user_info->user_id;
        $model = new \Model\Account();
        $get_link_info = $model->getAccountLinkShare($user_id);

        $valid_time = 1;//有效分钟数

        //如果用户分享链接信息为空，创建一条
        if(empty($get_link_info)){

            $set_link_info = $model->setAccountLinkShare($user_id,$valid_time);

            if($set_link_info){

                return true;
                //exit(json_encode(array('status'=>'r','info'=>'创建成功')));
            }else{

            }

        }else{

            $end_time = $get_link_info->end_time;
            //如果有效时间小于当前时间重新创建
            if($end_time < time()){
                $up_link_info = $model->updateAccountLinkShare($user_id,$valid_time);
                if($up_link_info){
                    return true;
                    //exit(json_encode(array('status'=>'r','info'=>'更新成功')));
                }
            }


        }

    }

    /**
     * 更新用户信息
     */
    public function updateAccount(){
        $email = $_POST['email'];
        $mobile_phone = $_POST['mobile_phone'];
        if($email){
            if(!preg_match( "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email )){
                exit(json_encode(array('status'=>'n','info'=>'邮箱格式不正确')));
            }
        }
        if($mobile_phone){
            if( !preg_match("/^1[34578]\d{9}$/", $mobile_phone) ){
                exit(json_encode(array('status'=>'n','info'=>'手机号不正确')));
            }
        }


        unset($_POST['user_name']);
        $user_id = $this->user_info->user_id;
        $model = new \Model\Account();
        $result = $model->updateAccountInfo('account',$_POST,array('user_id'=>$user_id));
        if($result){
            exit(json_encode(array('status'=>'y','info'=>'更新成功')));
        }
    }

    /**
     * 更新用户信息
     */
    public function updatePassword(){
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
        $re_new_password = $_POST['re_new_password'];

        if(empty($password) || empty($new_password) || empty($re_new_password)){
            exit(json_encode(array('status'=>'n','info'=>'密码为空')));
        }

        if(!preg_match("/^[\w-\.]{6,16}$/",$password) || !preg_match("/^[\w-\.]{6,16}$/",$new_password)){
            exit(json_encode(array('status'=>'n','info'=>'用户密码位数不正确')));
        }

        if($new_password !== $re_new_password){
            exit(json_encode(array('status'=>'n','info'=>'两次输入密码不一致')));
        }


        if(wpDecode($password,$this->user_info->password)){

            $user_id = $this->user_info->user_id;
            $model = new \Model\Account();
            $result = $model->updateAccountInfo('account',array('password'=>wpEncrypt($new_password)),array('user_id'=>$user_id));
            if($result){
                $login = new Login();
                $login->logout();   //注销用户
                exit(json_encode(array('status'=>'r','info'=>'密码修改成功','url'=>_get_home_url())));
            }
        }else{
            exit(json_encode(array('status'=>'n','info'=>'原密码不正确')));
        }



    }

    /*********************************************************结束：用户功能方法***************************************************************/


}