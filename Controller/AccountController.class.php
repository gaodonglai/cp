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

    public $bank = array('1'=>'中国工商银行','2'=>'中国建设银行','3'=>'中国农业银行','4'=>'中国邮政储蓄银行'
    ,'5'=>'交通银行','6'=>'招商银行','7'=>'中国银行','8'=>'中国光大银行',
        '9'=>'中信银行','10'=>'浦发银行','11'=>'中国民生银行','12'=>'兴业银行',
        '13'=>'平安银行','14'=>'广发银行','15'=>'华夏银行'
    );

    public $status = array('0'=>'未设置密保和支付码','1'=>'正常','2'=>'暂时没想好','5'=>'账户停用');


    function __construct()
    {
        $this->user_info = get_user_info();
        //如果没有登录跳转到登录页面
        if(!$this->user_info){
            redirect(_get_home_url('?show=login'));
        }

        $this->model = new \Model\Account();

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

        $args = array(
            'back_array' =>$this->bank
        );

        $user_id = $this->user_info->user_id;
        $content  = $this->model->getBankCardAll($user_id);

        $args = array(
            'bank'=>$this->bank,
            'content'=>$content
        );


        define("FUNFCTIO_NAME",__FUNCTION__);

        get_header_front();

        display_show('accountBankCard',$args);

        get_footer_front();
    }

    /**
     *提现申请
     */
    function extractMoney(){


        $user_id = $this->user_info->user_id;
        $content  = $this->model->getBankCardAll($user_id);
        $money = $this->user_info->reward_money - $this->user_info->frozen_money;//可用金额

        $Conbankmy = new BankMg();
        $bankmy = new \Model\BankMg();
        $withdraw_log = $bankmy->getUserWithdrawRecord($user_id);

        $args = array(
            'quota'=>get_option('withdraw_quota_setting'),//提现限额,
            'bank'=>$this->bank,
            'content'=>$content,
            'money'=>$money,
            'withdraw_log'=>$withdraw_log,
            'dispose_stauts'=>$Conbankmy->status,
            'dispose_type'=>$Conbankmy->type
        );

        define("FUNFCTIO_NAME",__FUNCTION__);
        get_header_front();
        display_show('accountExtractMoney',$args);
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

        $user_id = $this->user_info->user_id;
        //$recharge_type bank：银行卡，wechat:微信支付，alipay：支付宝;qq:qq钱包
        //获取充值记录
        $get_log = $this->model->getPayLog($user_id);
        $get_cash = $this->model->getCashRecord($user_id);
        $args = array(

            'recharge_type'=>array('bank'=>'银行卡','wechat'=>'微信支付','alipay'=>'支付宝','qq'=>'qq钱包','artificial'=>'人工充值','direct'=>'其他充值'),
            'cost_type'=>array('cash'=>'现金','grow'=>'积分'),
            'pay_log'=>$get_log,
            'cash_log'=>$get_cash,

        );

        define("FUNFCTIO_NAME",__FUNCTION__);
        get_header_front();
        display_show('accountMy',$args);
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

        $user_id = $this->user_info->user_id;
        $content  = $this->model->getBankCardAll($user_id);

        $artificial_pay = $this->model->getArtificialPay($user_id);

        $args = array(
            'artificial_pay'=>$artificial_pay,
            'content'=>$content,
            'recharge_type'=>array('bank'=>'银行卡','wechat'=>'微信','alipay'=>'支付宝'),
        );

       // $js = array('pc/js/publics.js');

        define("FUNFCTIO_NAME",__FUNCTION__);
        get_header_front();
        display_show('accountPay',$args);
        get_footer_front('');
    }



    /**
     *分销商管理
     */
    function  distribution(){

        //获取分享信息
        $this->getMyShare();
        //获取用户分享链接
        $user_id = $this->user_info->user_id;
        $get_link_info = $this->model->getAccountLinkShare($user_id);
        $residue_time = $get_link_info->end_time - time();
        $distri_url = _get_home_url('register?code='.$get_link_info->reg_code);


        $drp = new \Model\Distribution();
        $drp_one = $drp->getMyMember($user_id,1);//1级分销用户
        $drp_two = $drp->getMyMember($user_id,2);//2级分销用户
        $sum_up_money = $drp->getMyCommission($user_id);//获取总佣金
        $today_money = $drp->getMyTodayCommission($user_id);//获取今日佣金
        $CommissionDetail = $drp->getMyCommissionDetail($user_id);//佣金

        $args = array(
            'distri_url'=>$distri_url,
            'residue_time'=>$residue_time,
            'drp_one'=>$drp_one,
            'drp_two'=>$drp_two,
            'sum_up_money'=>$sum_up_money,
            'today_money'=>$today_money,
            'CommissionDetail'=>$CommissionDetail
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

    /**
     * 完善信息
     */
    public function perfectInfo(){

        if($this->user_info->status != 0){
            exit();
        }
        get_header_front();
        display_show('accountPerfectInfo');
        get_footer_front();
    }

    /*********************************************************开始：用户功能方法***************************************************************/
    /**
     *设置密保与支付密码
     */
    public function setPerfectInfo(){

        if(in_array("",$_POST)){
            exit(json_encode(array('status'=>'n','info'=>'请完善填写内容')));
        }
        $question         = $_POST['question'];
        $answer           = $_POST['answer'];
        $payment_password = $_POST['payment_password'];
        $re_payment_password = $_POST['re_payment_password'];

        if(strlen($question) > 36 || strlen($answer) > 24){//一个汉字3个字符位
            exit(json_encode(array('status'=>'n','info'=>'请正确输入信息')));
        }

        if(!is_numeric($payment_password) || strlen($payment_password) != 6 || $payment_password != $re_payment_password){//一个汉字3个字符位
            exit(json_encode(array('status'=>'n','info'=>'支付密码有误.请重新输入')));
        }

        if(wpDecode($payment_password,$this->user_info->password)){//一个汉字3个字符位
            exit(json_encode(array('status'=>'n','info'=>'支付密码不能与登录密码一致')));
        }

        $this->model->wpdb->query("BEGIN");
        $set_account = array(
            'question'=>$question,
            'answer'=>$answer,
            'status'=>1
        );
        $result1 = $this->model->updateAccountInfo('account',$set_account,array('user_id'=>$this->user_info->user_id));

        $set_payment = array(
            'user_id'=>$this->user_info->user_id,
            'payment_password'=>wpEncrypt($payment_password),
            'last_time'=>date('Y-m-d H:i:s'),
            'payment_state'=>'y'
        );
        $result2 = $this->model->insertAccountInfo('account_payment',$set_payment);

        if($result1 && $result2){
            $this->model->wpdb->query("COMMIT");

            exit(json_encode(array('status'=>'y','info'=>'添加成功','url'=>_get_home_url('account'))));
        }else{
            $this->model->wpdb->query("ROLLBACK");
            exit(json_encode(array('status'=>'n','info'=>'添加失败，请重试')));
        }

    }

    /**
     * 获取我的分享
     */
    private function getMyShare(){

        $user_id = $this->user_info->user_id;

        $get_link_info = $this->model->getAccountLinkShare($user_id);

        $valid_time = 10;//有效分钟数

        //如果用户分享链接信息为空，创建一条
        if(empty($get_link_info)){

            $set_link_info = $this->model->setAccountLinkShare($user_id,$valid_time);

            if($set_link_info){

                return true;
                //exit(json_encode(array('status'=>'r','info'=>'创建成功')));
            }else{

            }

        }else{

            $end_time = $get_link_info->end_time;
            //如果有效时间小于当前时间重新创建
            if($end_time < time()){
                $up_link_info = $this->model->updateAccountLinkShare($user_id,$valid_time);
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

        $result = $this->model->updateAccountInfo('account',$_POST,array('user_id'=>$user_id));
        if($result){
            exit(json_encode(array('status'=>'y','info'=>'更新成功')));
        }
    }

    /**
     * 更新密码信息
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

            $result = $this->model->updateAccountInfo('account',array('password'=>wpEncrypt($new_password)),array('user_id'=>$user_id));
            if($result){
                $login = new Login();
                $login->logout();   //注销用户
                exit(json_encode(array('status'=>'r','info'=>'密码修改成功','url'=>_get_home_url())));
            }
        }else{
            exit(json_encode(array('status'=>'n','info'=>'原密码不正确')));
        }



    }

    /**
     * 更新交易密码
     */
    public function updatePaymentPassword(){
        if(in_array("",$_POST)){
            exit(json_encode(array('status'=>'n','info'=>'请完善填写内容')));
        }

        $password = $_POST['password'];
        $payment_password = $_POST['payment_password'];
        $new_payment_password = $_POST['new_payment_password'];
        $re_new_payment_password = $_POST['re_new_payment_password'];

        if($payment_password == $new_payment_password){
            exit(json_encode(array('status'=>'n','info'=>'新支付密码不能跟原密码一样')));
        }

        if(!preg_match("/^[\w-\.]{6,16}$/",$password) ||  strlen($payment_password) != 6 ||  strlen($new_payment_password) != 6){
            exit(json_encode(array('status'=>'n','info'=>'密码位数不正确')));
        }

        if($re_new_payment_password != $new_payment_password){
            exit(json_encode(array('status'=>'n','info'=>'两次输入的新密码不正确')));
        }

        $user_id = $this->user_info->user_id;

        $account_payment = $this->model->getAccountPayment($user_id);
        if(empty($account_payment)){
            exit(json_encode(array('status'=>'n','info'=>'无交易密码')));
        }
        //echo wpDecode($password,$this->user_info->password);

        if(wpDecode($password,$this->user_info->password) && wpDecode($payment_password,$account_payment->payment_password)){

            $result = $this->model->updateAccountInfo('account_payment',array('payment_password'=>wpEncrypt($new_payment_password)),array('user_id'=>$user_id));
            if($result){

                exit(json_encode(array('status'=>'r','info'=>'支付密码修改成功')));
            }
        }else{
            exit(json_encode(array('status'=>'n','info'=>'支付密码修改失败')));
        }

    }

    /**
     * 绑定银行卡
     */
    public function setBankCard(){

        if(in_array("",$_POST)){
            exit(json_encode(array('status'=>'n','info'=>'请完善填写内容')));
        }

        $type = $_POST['type'];
        $user_id = $this->user_info->user_id;

        $get_content = $this->model->getBankCardCount($user_id,$type);//查询数量

        if($type == 'bank'){


            $bank_account = $_POST['bank_account'];
            $bank_card = $_POST['bank_card'];
            $bank_name = $_POST['bank_name'];

            if(!bankVerify($bank_account)){
                exit(json_encode(array('status'=>'n','info'=>'银行卡号不正确')));
            }

            if($get_content == 2){
                exit(json_encode(array('status'=>'n','info'=>'不能再添加了')));
            }

            $args = array('user_id'=>$user_id,'account_number'=>$bank_account,'opening_bank'=>$bank_card,'card_state'=>'y','time'=>date('Y-m-d H:i:s'),'account_name'=>$bank_name,'card_type'=>$type);

        }else if($type == 'alipay'){
            if($get_content == 1){
                exit(json_encode(array('status'=>'n','info'=>'不能再添加了')));
            }

            $alipay_account = $_POST['alipay_account'];
            $alipay_name = $_POST['alipay_name'];
            $args = array('user_id'=>$user_id,'account_number'=>$alipay_account,'account_name'=>$alipay_name,'card_type'=>$type,'card_state'=>'y','time'=>date('Y-m-d H:i:s'));

        }else if($type == 'wechat'){
            if($get_content == 1){
                exit(json_encode(array('status'=>'n','info'=>'不能再添加了')));
            }
            $wechat_account = $_POST['wechat_account'];
            $wechat_name = $_POST['wechat_name'];
            $args = array('user_id'=>$user_id,'account_number'=>$wechat_account,'account_name'=>$wechat_name,'card_type'=>$type,'card_state'=>'y','time'=>date('Y-m-d H:i:s'));
        }

        if($args){

            $result = $this->model->insertAccountInfo('card_binding',$args);

            if($result){
                exit(json_encode(array('status'=>'s','info'=>'添加成功')));
            }
        }



    }

    /**
     * 删除银行卡
     */
    function deleteBankCard(){

        $bank = $_POST['bank'];
        if(!is_numeric($bank)){
            exit();
        }

        $user_id = $this->user_info->user_id;
        $table = $this->model->table.'card_binding';

        $result = $this->model->wpdb->query("UPDATE $table SET  `card_state`='n' WHERE id = {$bank} and`user_id`= {$user_id}");

        if($result){
            exit(json_encode(array('status'=>'y','info'=>'删除成功')));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'删除失败')));
        }
    }

    /*********************************************************结束：用户功能方法***************************************************************/


}