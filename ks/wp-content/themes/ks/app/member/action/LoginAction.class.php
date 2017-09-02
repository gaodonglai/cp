<?php
namespace app\member\action;
use libraries\controller\Action;
use app\member\model\LoginModel;
use app\member\model\RegisterModel;
use entity\consumer\Consumer;
use libraries\util\encrypt;
use libraries\util\StringNew;

/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/19
 * Time: 16:11
 */
class LoginAction extends Action
{
    private $consumer;
    private $reModel;
    private $encrypt;
    private $model;

    public function __construct(){
        $this->consumer =  new Consumer();
        $this->reModel =  new RegisterModel();
        $this->encrypt = new encrypt();
        $this->model = new LoginModel();
    }


    /*登录页面*/
    public function main(){

        //global $user;


        /*判断登录信息是否存在*/
        if(isset($_COOKIE['user'])){

            $user = json_decode(base_decode($_COOKIE['user']),true);
            
        }elseif(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
           
        }

        if($user){
            $row = $this->reModel->selectOne($this->consumer," c_id = {$user['userId']}");

            if(md5($row['c_pass']) == $user['userPass']){
                $this->redirect(home_url('consumer/index'));
            }
        }

        if(is_mobile()){
            $this->display('member/login-mobile');
        }else{
            //$this->css('ch_style');
            //$this->js(array('cookie.url.config','public','posfixed'));
            //$this->header('login-header');
            $this->display('member/login');
            //$this->footer('user-footer');
        }
    }


    /**
     * 用户登录
     */
    public  function login(){

        if (!is_user_logged_in()) {
            //未登录
            $creds = array();
            $creds['user_login'] = $_POST['user_login']; // 用户名
            $creds['user_password'] = $_POST['user_pass']; // 密码
            $creds['remember'] = true;
            $user = wp_signon( $creds, false );
            if ( !is_wp_error($user) ){
                //成功
                echo '登录成功';


                /**
                 * 如果是手机
                 */
                if(is_mobile()){
                    exit(json_encode(array('status'=>'y','info'=>'登录成功','app'=>$_SESSION['user'],'url'=>home_url('consumer/index'))));
                }
                exit(json_encode(array('status'=>'y','info'=>'登录成功','url'=>home_url('consumer/myorder'))));

            }else{
                //失败
                echo '登录失败';
            }

        }else{
            //已登录

        }








    }
    public function validateLogin(){
        global $wpdb;
        $cid = $_POST['userName'];
        $pass = $_POST['userPass']; 
        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}consumer WHERE c_id = {$cid}",ARRAY_A);
        if($row){
            if(md5($row['c_pass']) == $pass ){ 

                /*更新登录码*/
                $str = StringNew::randString(6);
                $this->consumer->isonline = $str;
                $results = $this->model->userUpdate($row['c_id'],$this->consumer);
                if(!$results){
                    exit(json_encode(array('status'=>'400','info'=>'账户异常，请重新登录')));
                }
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
                exit(json_encode(array('status'=>'y','app'=>$_SESSION['user'])));
            }
           
        }
         exit(json_encode(array('status'=>'n','info'=>'账户异常，请重新登录')));
    }
    /*登出*/
    public function logout(){
        session_destroy();
        session_unset();
        unset($_SESSION['user']);
        setcookie('user','',time()-1,'/');

        $this->redirect(home_url('member/login'));
    }

    /*获取联动位置*/
    public function getArea(){
        $type = substr($_POST['thisName'],0,4);

        $name = substr($_POST['thisName'],4);
        if($name == 'Province'){
            $next = $type.'City';
        }else if($name == 'City'){
            $next = $type.'Area';
        }else{
            $next = $type.'Road';
        }


        $where = "parentId ={$_POST['parentId']}";
        $area = $this->model->getAddress($where);
        if($area){

            exit(json_encode(array('status'=>'y','info'=>$area,'nextType'=>$next)));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'已无子级菜单')));
        }

    }

}