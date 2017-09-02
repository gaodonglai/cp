<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/22
 * Time: 9:16
 */

namespace app\member\action;

use libraries\controller\Action;
use libraries\helper\YpSms;
use libraries\util\VerifyData;
use libraries\util\StringNew;
use libraries\util\encrypt;
use entity\consumer\Consumer;
use app\member\model\RegisterModel;
use app\member\model\LoginModel;

class RegisterAction extends Action
{   
    private  $consumer;
    private $title;

    public function __construct(){
        
        $this->consumer =  new Consumer();

    }
    
    /*注册页面*/
    function main(){
        /*$this->js(array('public','member/register'));
        $this->css('ch_style');*/
        if(is_mobile()){

            $this->display('member/register-mobile');

        }else{
            //define('TITLE', '用户注册');
            //$this->header('login-header');
            $this->display('member/register');

           // $this->footer('user-footer');
        }

    }

    /*用户注册*/
    function save(){

        if($this->isRequest($_POST)){
            die('信息有误');
        };

        $userphone = $_POST['userphone'];
        $password = $_POST['password'];
        $display_name = $_POST['display_name'];


        $userdata = array(
            'user_login'	=> 	$userphone,
            'user_pass' 	=> 	$password,
            'display_name'=>$display_name,
            'role'         => 'subscriber' //订阅用户
        );

        $user_id = wp_insert_user( $userdata );

        if ( ! is_wp_error( $user_id ) ) {
            //成功
            echo 成功;
            //$this->redirect(home_url('member/register/backPass'));
        }else{
            //失败
            echo '失败';
        }

    }


































    /**********************************************************以前的*******************************************************************/
    public function saveRe($userPhone,$userPass,$userName=''){
        //消费者注册
        $encrypt = new encrypt();
        $this->consumer->c_phone = $userPhone;
        $this->consumer->c_pass = $encrypt->encode($userPass);
        if($userName){
            $this->consumer->c_login = $userName;
        }
        $this->consumer->c_registered = time();
        if(get_option('RegistrationReturnIntegral')){
            $ri = get_option('RegistrationReturnIntegral');
            $this->consumer->c_integral = $ri;
        }
        $register = new RegisterModel();
        $result = $register->register( $this->consumer);
        if($result){
            $consumer = new Consumer();
            $consumerModel = new LoginModel();

            $consumer->c_id = $result;
            $row = $register->selectObject($consumer,'row');
            unset($consumer->c_id);
            $str = StringNew::randString(6);
            $consumer->isonline = $str;

            $consumer->c_login = 'customer'.$row['c_id'];
            $consumerModel->userUpdate($row['c_id'],$consumer);

            /*保存登录信息*/
            $_SESSION['user'] = array(
                'userId'=>$row['c_id'],
                'userPass'=>md5($row['c_pass']),
                'type'=>'C',
                'userNicename'=>$row['c_nicename'],
                'userEmail'=>$row['c_email'],
                'userPhone'=>$row['c_phone'],
                'userAvatar'=>$row['c_avatar'],
                'userIntegral'=>$row['c_integral'],
                'grade'=>$row['c_role'],//用户权限不能随意修改名称
                'isonline'=>md5($str),  //
            );
            $cookieUser = base_encode(json_encode($_SESSION['user']));
            setcookie('user',$cookieUser,time()+259200,'/');
            unset($_SESSION['verificationCode']);
            //if(!is_mobile()){
            //$url = home_url('member/register/success');
            //}else{
            //$url = home_url('/consumer/index');
            //}
            if($ri){
                /*添加记录*/
                global $wpdb;
                $data_array = array(
                    'c_a_content' => '注册赠送',
                    'c_a_status' => 's',
                    'c_a_type' => 'integral',
                    'c_id' => $result,
                    'c_a_amount'=> '+'.$ri,
                    'c_a_surplus' => $ri,
                    'time' => time()
                );
                $wpdb->insert($wpdb->prefix.'consumer_account',$data_array);

            }
            exit(json_encode(array('status'=>'y','info'=>'登录成功','app'=>$_SESSION['user'],'url'=>home_url('consumer/index'))));
        }else{
            return false;
        }
    }

    public function success(){
        if(is_mobile()){
            $this->display('member/success-mobile');

        }else{
            $this->css(array('ch_style','lx_style'));
            define('TITLE', '用户注册成功');
            $this->header('login-header');
            $this->display('member/success');
            $this->footer('user-footer');
        }


    }

    /*密码找回页面*/
    function backPass(){
        if($_POST){

            /*$_POST参数中无手机号*/
            if(empty($_POST['userPhone']) || !isset($_POST['userPhone'])){
                $_POST['userPhone'] = $this->phoneExistence();
            }

            $verify = VerifyData::getInstance();
            //验证用户名
            if(!$verify->formHandler($_POST['userPhone'],'m')){
                exit(json_encode(array('status'=>'n','info'=>'手机格式有误')));
            }

            //验证码验证
            if(isset($_SESSION['verificationCode'])){

                $this->judgePhoneCode($_POST['userPhone'],$_POST['registerCode']);
            }else{
                exit(json_encode(array('status'=>'n','info'=>'请先获取验证码')));
            }

             
            $model = new RegisterModel();
            $row = $model->selectOne( $this->consumer,"c_phone = '{$_POST['userPhone']}' ");
            if($row){

                exit(json_encode(array('status'=>'y','info'=>'下一步','url'=>home_url('/member/register/backPass?type=next'))));

            }

            exit(json_encode(array('status'=>'n','info'=>'用户信息有误')));

        }else{

            if(isset($_GET['type'])){

                if(!isset($_SESSION['verificationCode'])){

                    $this->redirect(home_url('member/register/backPass'));
                }
            }

           
            $this->js(array('public','cookie.url.config'));
            $this->css('ch_style');




            if(is_mobile()){
                $this->display('member/backPass-mobile');
            }else{
                $this->header('login-header');
                $this->display('member/backPass');
                $this->footer('user-footer');
            }

        }
    }

    /*密码修改*/
    public function updatePass(){
        $model = new RegisterModel();
        $loginModel = new LoginModel();
        $encrypt = new encrypt();

        $verify = VerifyData::getInstance();

        if(!isset($_SESSION['verificationCode'])){  //不存在手机验证码就判断是否为老密码修改

            if(isset($_POST['userCode'])){
                if($_POST['userCode'] != $_SESSION['code']){
                    exit(json_encode(array('status'=>'n','info'=>'验证码有误,请重新输入')));
                }
            }else{
                exit(json_encode(array('status'=>'n','info'=>'数据信息有误','url'=>'')));
            }

        }else{
            if(isset($_POST['userCode'])){
                if($_POST['userCode'] != $_SESSION['code']){
                    exit(json_encode(array('status'=>'n','info'=>'验证码有误,请重新输入')));
                }
            }
        }

        /*密码验证*/
        if($_POST['userPass'] != $_POST['userRePass']){
            exit(json_encode(array('status'=>'n','info'=>'两次密码输入不一致')));
        }
        if(!$verify->formHandler($_POST['userRePass'],'pass')){
            exit(json_encode(array('status'=>'n','info'=>'密码格式有误')));
        }



        if(isset($_POST['oldPass'])){
            $row = $model->selectOne( $this->consumer,"c_id = '{$_SESSION['user']['userId']}' ");
        }else{
            $row = $model->selectOne( $this->consumer,"c_phone = '{$_SESSION['verificationCode']['phone']}' ");
        }


        if($row){

            if(isset($_POST['oldPass'])){
               // var_dump($row['c_pass']);
                if($encrypt->encode($_POST['oldPass']) != $row['c_pass']){
                    exit(json_encode(array('status'=>'n','info'=>'旧密码不正确,请重新输入')));
                }
            }

            if($row['c_pass'] == $encrypt->encode($_POST['userRePass'])){
                exit(json_encode(array('status'=>'n','info'=>'新密码不能与旧密码一致')));
            }

             $this->consumer->c_pass = $encrypt->encode($_POST['userRePass']);

            $result = $loginModel->userUpdate($row['c_id'], $this->consumer);
            if($result){
                unset($_SESSION['verificationCode']);
                unset($_SESSION['passSet']);
                unset($_SESSION['user']);
                unset($_COOKIE['user']);

                exit(json_encode(array('status'=>'y','info'=>'设置成功','url'=>home_url('member/login'))));
            }else{
                exit(json_encode(array('status'=>'n','info'=>'设置失败')));
            }
        }

        exit(json_encode(array('status'=>'n','info'=>'用户不存在')));

    }

    /*判断信息唯一性---->查找为空时使用*/
    public function judgeOnly($data=''){

        if(!empty($data)) $_POST = $data;

        $result = $this->getInformation($_POST);

        if($result){
            exit(json_encode(array('status'=>'n','info'=>$this->title.'已被注册')));
        }else{
            exit(json_encode(array('status'=>'y','info'=>'')));
        }
        exit;
    }

    /*判断信息唯一性---->查找有值时使用*/
    public function judgeIsNull($data=''){

        if(!empty($data)) $_POST = $data;

        $result = $this->getInformation($_POST);
        if($result){
            exit(json_encode(array('status'=>'y','info'=>'')));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'用户信息不存在')));
        }
        exit;
    }

    /*判断唯一信息获取*/
    public function getInformation($data){
        $model = new RegisterModel();

        /*用户名/手机/邮箱验证*/
        $verify = VerifyData::getInstance();

        if($data['name'] == 'userName'){

            $this->title = '用户名';
            $rule = 'u';
            $key = 'c_login';

        }elseif($data['name'] == 'userPhone'){
            $this->title = '手机号';
            $rule = 'm';
            $key = 'c_phone';

        }elseif($data['name'] == 'userEmail'){
            $this->title = '邮箱号';
            $rule = 'e';
            $key = 'c_email';
        }
        $result = $verify->formHandler($data['param'],$rule);
        if(!$result){
            exit(json_encode(array('status'=>'n','info'=>$this->title.'格式有误')));
        }

        /*判断是否唯一*/
        $row = $model->selectOne( $this->consumer,"$key = '{$data['param']}' ");
        return $row;
    }


    /*发送手机验证码*/
    public function getPhoneCode(){

        require_once _TEMP_.'/libraries/helper/gt3/web/VerifyLoginServlet.php';

        $getGeeResult = validate();

        if(!$getGeeResult){
            exit(json_encode(array('status'=>'n','info'=>'验证码错误')));
        }

       /* if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')){
            $file  = '/var/www/html/sxck/ajaxlog.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
            $content = $_SERVER['HTTP_REFERER'].' '.$_SERVER["REMOTE_ADDR"].' '. date('Y-m-d H:i:s',time())." \n";
            $f  = file_put_contents($file, $content,FILE_APPEND);
            header("Location: 404.php");
            exit();
        }*/
        if(in_array($_POST['type'], array('register','backPass'))){
            /*$_POST参数中无手机号*/
            if($_POST['type']=='register' && empty($_POST['phone'])){

                $_POST['phone'] = $this->phoneExistence();
            }
           // unset($_SESSION['verificationCode'] );exit;

            /*验证用户*/
            if(empty($_POST['phone'])){
                exit(json_encode(array('status'=>'n','info'=>'请输入一个有效的手机')));
            }
            $data['name'] = 'userPhone';
            $data['param'] = $_POST['phone'];
            $result = $this->getInformation($data);
            switch($_POST['type']){
                case 'register':
                    if($result) exit(json_encode(array('status'=>'n','info'=>'此手机号已被注册')));
                    break;
                case 'backPass':
                    if(empty($result)) exit(json_encode(array('status'=>'n','info'=>'用户信息不存在')));
                    break;
            }
            
        }else{
             if(empty($_POST['phone'])){
                exit(json_encode(array('status'=>'n','info'=>'请输入一个有效的手机')));
            }
        }
        

        //$this->judgePhoneCode($_POST['phone']);

        /*短信发送相关操作*/
        $string = new StringNew();
        $str = $string->randString(6,1);

        //云片网
        $yp_sms = new YpSms();
        $is_sms = $yp_sms->send_mobile('standard',$_POST['phone'], $str);

        if($is_sms){

            $_SESSION['verificationCode'] = array(
                'time'=>time()+300,
                'phone'=>$_POST['phone'],
                'code'=>md5($str)
            );

            exit(json_encode(array('status'=>'y','info'=>'有效期5分钟，请注意查收')));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'发送失败，请稍后重试')));
        }
        //短信网
        /*$send_sms = new Sms();
        $send_sms->send_mobile('standard', $_POST['phone'], $str);*/

        //exit(json_encode(array('status'=>'y','info'=>$str,'phone'=>$_POST['phone'])));
    }
     /*找回密码邮箱验证码*/
    public function getEmailCode(){

        /*$_POST参数中无手机号*/
        if(empty($_POST['email'])){
            exit(json_encode(array('status'=>'n','info'=>'邮箱地址不能为空')));
        }

        /*验证用户*/
        $data['name'] = 'userEmail';
        $data['param'] = $_POST['email'];
        $result = $this->getInformation($data);
        if(!$result){
            exit(json_encode(array('status'=>'n','info'=>'邮箱不存在，请核实后重试')));
        }

        /*短信发送相关操作*/
        $string = new StringNew();
        $str = $string->randString(6,1);

        //云片网
       // $yp_sms = new YpSms();
        //$is_sms = $yp_sms->send_mobile('standard',$_POST['phone'], $str);
        $message ="验证码：".$str.",有效期为5分钟，请注意查收，勿向他人泄露此验证码。";
        $is_mail = wp_mail($_POST['email'], '邮箱验证码', $message);
        if($is_mail){

            $_SESSION['verificationCode'] = array(
                'time'=>time()+300,
                'email'=>$_POST['email'],
                'code'=>md5($str)
            );

            exit(json_encode(array('status'=>'y','info'=>'发送成功，有效期5分钟')));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'发送失败，请稍后重试')));
        }
     
    }
    /**
    *验证并修改用户密码
    */
    public function AppRetrievePassword(){

        $phone = $_POST['phone'];
        $Code = md5($_POST['Code']);
        $newPass = $_POST['newPass'];

        if(strlen($newPass)<6){
           exit(json_encode(array('status'=>'n','info'=>'新密码至少为6个字符')));
        }

        $verificationCode = $_SESSION['verificationCode'];

        if($verificationCode['time'] < time()){
                unset($_SESSION['verificationCode']);
                exit(json_encode(array('status'=>'n','info'=>'验证码过期,请重新获取')));
            }
        if($verificationCode['code'] != $Code){
                exit(json_encode(array('status'=>'n','info'=>'验证码错误,请重新输入')));
            }

        
        /*验证用户*/
        
        if($verificationCode['email']){
             $emailphone = $verificationCode['email'];
            $data['name'] = 'userEmail';
            
        }else if($verificationCode['phone']){
             $emailphone = $verificationCode['phone'];
            $data['name'] = 'userPhone';
           
        }
        $data['param'] = $emailphone;
       
        if($emailphone != $phone){
            exit(json_encode(array('status'=>'n','info'=>'手机或邮箱与验证码不匹配')));
        }
        $result = $this->getInformation($data);
        if(!$result){
            exit(json_encode(array('status'=>'n','info'=>'手机或邮箱不存在，请核对后重试')));
        } 
        $encrypt = new encrypt();
        $newPass = $encrypt->encode($newPass);
        if( $newPass == $result['c_pass']){
           exit(json_encode(array('status'=>'n','info'=>'新密码不能与旧密码相同')));
        }
        /**
        *修改密码
        */
        $this->consumer->c_pass = $newPass;
        $loginModel = new LoginModel();
        $result = $loginModel->userUpdate($result['c_id'], $this->consumer);
        if(!$result){
            exit(json_encode(array('status'=>'n','info'=>'找回密码失败，请重试')));
        }
        unset($_SESSION['verificationCode']);
        unset($_SESSION['user']);
        unset($_COOKIE['user']);

        exit(json_encode(array('status'=>'y','info'=>'成功找回密码，请重新登录')));

    }
    /*参数中无手机号情况*/
    private function phoneExistence(){
        global $user;
        if(!empty($user)){

            $model = new RegisterModel();
            $row =  $model->selectOne( $this->consumer,"c_id = {$user['userId']}");
            return $row['c_phone'];
        }
    }

    /*判断手机验证码*/
    public function judgePhoneCode($phone,$code=''){

        /*用户名/手机/邮箱验证*/
        $verify = VerifyData::getInstance();
        $result = $verify->formHandler($phone,'m');
        if(!$result){
            exit(json_encode(array('status'=>'n','info'=>'手机格式有误,请重新输入')));
        }

        if(isset($_SESSION['verificationCode'])){

            if($phone !=$_SESSION['verificationCode']['phone'] ){
                if(empty($code)){
                    unset($_SESSION['verificationCode']);
                    $info = ',请重新获取';
                }
                exit(json_encode(array('status'=>'n','info'=>'当前手机号与已获取验证码手机号不一致'.$info)));
            }

            if(empty($code)){
                if($_SESSION['verificationCode']['time'] > time()){
                    exit(json_encode(array('status'=>'n','info'=>'验证码未过期')));
                }
            }else{

                if(!isset($_SESSION['verificationCode'])){
                    exit(json_encode(array('status'=>'n','info'=>'请先获取验证码')));
                }

                if($_SESSION['verificationCode']['time'] < time()){
                    unset($_SESSION['verificationCode']);
                    exit(json_encode(array('status'=>'n','info'=>'验证码过期,请重新获取')));
                }

                if( md5($code) != $_SESSION['verificationCode']['code']){
                    exit(json_encode(array('status'=>'n','info'=>'验证码错误,请重新输入')));
                }
            }
        }else{
            exit(json_encode(array('status'=>'n','info'=>'验证码不存在,请重新获取')));
        }

    }

}