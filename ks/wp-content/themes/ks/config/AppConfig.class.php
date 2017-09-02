<?php
/*
WP配置相关的类
Dong
2015/11/24
*/

class config{
	
	public function __construct() {
		//去除工具条
		show_admin_bar(false);

		self::init(); //初始化配置
		add_action('wp_head',array($this,'FWJL'));
		self::loadMenu();//加载菜单

		require_once _TEMP_.'/config/LoadPath.class.php';//引入自动加载类
		require_once _TEMP_.'/config/DisableEmbeds.class.php';//引入自动加载类

        spl_autoload_register('LoadPath::load'); 	//开启自动化加载类

		session_start();
        if(!$_SESSION['user'] && $_COOKIE['user']){
			$_SESSION['user'] = json_decode(base_decode($_COOKIE['user']),true);
            //$GLOBALS['user'] = json_decode(base_decode($_COOKIE['user']),true);
        }

        /*****判断session用户是否还存在*****/
        if(isset($_SESSION['user'])){

            global $wpdb;
            $row = $wpdb->get_row("SELECT c_id FROM {$wpdb->prefix}consumer WHERE c_id = {$_SESSION['user']['userId']}",ARRAY_A);
		   
            if(!$row){
                
                Header("Location:".home_url()); 
                unset($_SESSION['user']);
                setcookie('user','');
                exit;
            }
        }
        /************end****************/
        
        
            

        /*******end*********/

		$GLOBALS['user'] = $_SESSION['user'];


        //模板载入规则
		add_action("template_redirect", array($this,'traceability_manage_template_redirect'));

	 }
	/*定义常量等默认配置*/
	/**
	 *
     */
	private static function init(){
		/**
		*网络路径
		*/
		/*$indexs = '';
		if($_SERVER['SCRIPT_NAME']!='index.php'){
			$indexs = explode('/index.php',$_SERVER['SCRIPT_NAME']);
			$indexs = $indexs[0];
		}print_r($_SERVER); echo '<br>';*/
		define('TEMP', get_stylesheet_directory_uri());
		define('IMG', TEMP.'/web/img');
		define('JS', TEMP.'/web/js');
		define('CSS', TEMP.'/web/css');

        $upload_dir = wp_upload_dir();   //上传文件主题目录
        define('UPLOAD_DIR',$upload_dir['basedir'].'/');   //上传物理目录
        define('UPLOAD_URL',$upload_dir['baseurl'].'/');   //上传网络目录

        define('CTR_UPLOAD_PATH',  UPLOAD_DIR."customer/");	//消费者上传物理路径
        define('CTR_UPLOAD_URI',  UPLOAD_URL."customer/");	//消费者上传网络路径

		/**
		*服务器绝对路径
		*/
		define('_TEMP_', get_stylesheet_directory());
		
	}

	/**
	 * 模板载入规则
	 * @return bool
     */
	public function traceability_manage_template_redirect(){

		global $wp_query;

		status_header( 200 );

		//查询my_custom_page变量 
		if(!is_404()) return false;

		$reditect_page =  $wp_query->query['pagename'];
		if($reditect_page == 'integral') $reditect_page='integral/integral';
		$reditect_array=explode('/',$reditect_page);

		$get_plateName = $reditect_array[0];
		$plateName = strtolower($reditect_array[0]);//板块名

		$classNmae = ucfirst(strtolower($reditect_array[1]));//类名

		$funcName = $reditect_array[2];	//方法名
		//$funcName = strtolower($reditect_array[2]);	//方法名

        /**
         * 用户访问控制控制器
         */
		//$classNmae = $classNmae ? $classNmae : ucfirst($get_plateName);//如果没有指定就赋予
        $path = _TEMP_.'/app/'.$plateName.'/action/'.$classNmae.'Action.class.php';

        /*global $meun_lists,$sidebar_lists;
        var_dump($meun_lists);
        var_dump($sidebar_lists);*/


		/**
		 * 判断类路径是否存在
		 */
		if(!is_file($path)){

			include _TEMP_.'/404.php';
			exit;
		}

        include_once($path);//加载类

		$class = 'app\\'.$plateName.'\action\\'.$classNmae.'Action';	//命名空间加载

		$query =  new $class();//实例化类

		//echo $class;
		if(empty($funcName)){
			//$class = 'app\\'.$plateName.'\model\\'.$classNmae.'Model';


            if(method_exists($query,'main')){

                $query->main(); //加载默认方法
            }else{
                echo '请添加默认方法';
                exit;
            }
		}else{
			/**
			 * 判断类中是否存在方法
			 */
			if(method_exists($query,$funcName)){
				$query->$funcName();//加载定义方法
			}else{

				include _TEMP_.'/404.php';
				exit;
			}

		}

		exit;
	}

	/**
	 * menu页面自动加载
	 */
	static function loadMenu()
	{
		$arr_submenu = glob(_TEMP_ . "/admin/menu/*.post.php");

		if (!empty($arr_submenu)) {
			foreach ($arr_submenu as $value) {
				include $value;
			}
		}
	}
	/*
     *获取当前的ip地址
     */
	public function getIP() {
		if (@$_SERVER["HTTP_X_FORWARDED_FOR"])
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else if (@$_SERVER["HTTP_CLIENT_IP"])
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		else if (@$_SERVER["REMOTE_ADDR"])
			$ip = $_SERVER["REMOTE_ADDR"];
		else if (@getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (@getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (@getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else
			$ip = "Unknown";
		return $ip;
	}
	/*
     *根据腾讯IP分享计划的地址获取IP所在地，比较精确
     */
	public function getIPLoc_QQ(){
		$queryIP = $this->getIP();
		$url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$queryIP;
		$ch = curl_init($url);
		curl_setopt($ch,CURLOPT_ENCODING ,'gb2312');
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
		$result = curl_exec($ch);
		$result = mb_convert_encoding($result, "utf-8", "gb2312"); // 编码转换，否则乱码
		curl_close($ch);
		preg_match("@<span>(.*)</span></p>@iU",$result,$ipArray);
		$loc = $ipArray[1];
		return $loc;
	}
	public function FWJL(){
		if($_SESSION['look_ip']){
		return false;}
 		/*****记录访问用户******/
            
            $look = new \entity\consumer\LookNotes();
            $reModel =  new \app\member\model\RegisterModel();
            
            $ip = getIP();  //获取IP
            $address = explode(' ', convertip($ip));    //IP转化地址
            
            //$look  = new LookNotes();
            
            if(is_mobile()){

                $result = get_device();    //获取手机设备
            }else{

                $result = get_system();    //获取终端系统
            }

            $look->ip = $ip;
            $look->address = $address[0];
            $look->minute = $address[1];
            $look->device = $result;
            $look->date = date('Y-m-d H:i:s',time());
            if(!isset($_SESSION['look_ip']) || $ip != $_SESSION['look_ip']){

               $id = $reModel->register($look);

               //var_dump($id);
            }else{

                //var_dump($_SESSION['look_ip']);
            }

            $_SESSION['look_ip'] = $ip;
	}

}

new config();