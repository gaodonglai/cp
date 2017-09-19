<?php
/*
WP配置相关的类
Dong
2015/11/24
*/
class config{
	
	public function __construct() {
		 
		$this->init();
		
		require_once _TEMP_.'/config/sqlsafe.class.php';//加载sql注入,已实例化对象
		require_once _TEMP_.'/config/loadpath.class.php';//自动加载类
		
		add_filter('get_avatar', array($this, 'get_avatar'), 1, 5);
		/*其他程序加载*/
		add_filter('pre_site_transient_update_core',    create_function('$a', "return null;")); // 关闭核心提示

		add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示

		add_filter('pre_site_transient_update_themes',  create_function('$a', "return null;")); // 关闭主题提示

		remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新

		remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件

		remove_action('admin_init', '_maybe_update_themes');  // 禁止 WordPress 更新主题
		
		//改后台lgoo
		add_filter('login_headerurl', create_function(false,'return home_url();'));
		add_filter('login_headertitle', create_function(false,'return get_bloginfo("description");'));
				
		// 禁用修订版本
		remove_action( 'pre_post_update' , 'wp_save_post_revision' );

		//精简头部信息
		//remove_action( 'wp_head', 'wp_enqueue_scripts', 1 ); //Javascript的调用
		remove_action( 'wp_head', 'feed_links', 2 ); //移除feed
		remove_action( 'wp_head', 'feed_links_extra', 3 ); //移除feed
		remove_action( 'wp_head', 'rsd_link' ); //移除离线编辑器开放接口
		remove_action( 'wp_head', 'wlwmanifest_link' );  //移除离线编辑器开放接口
		remove_action( 'wp_head', 'index_rel_link' );//去除本页唯一链接信息
		remove_action('wp_head', 'parent_post_rel_link', 10, 0 );//清除前后文信息
		remove_action('wp_head', 'start_post_rel_link', 10, 0 );//清除前后文信息
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'locale_stylesheet' );
		remove_action('publish_future_post','check_and_publish_future_post',10, 1 );
		remove_action( 'wp_head', 'noindex', 1 );
		//remove_action( 'wp_head', 'wp_print_styles', 8 );//载入css
		remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
		remove_action( 'wp_head', 'wp_generator' ); //移除WordPress版本
		remove_action( 'wp_head', 'rel_canonical' );
		remove_action( 'wp_footer', 'wp_print_footer_scripts' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
		
		add_action('login_head', array($this,'nowspark_login_head'));
		//modify the background image
		add_filter('admin_footer_text', array($this,'change_footer_admin'), 9999);//去除页脚
		add_filter( 'update_footer', array($this,'change_footer_version'), 9999);//去除版本
		add_action('admin_bar_menu', array($this,'my_edit_toolbar'), 999); 
		//去除工具条
		show_admin_bar(false);
		// 禁用自动保存，所以编辑长文章前请注意手动保存。
		add_action( 'admin_print_scripts', create_function( '$a', "wp_deregister_script('autosave');" ) );
		wp_deregister_script( 'l10n' );
		add_action('widgets_init', array($this,'my_remove_recent_comments_style'));
		
		//模板载入规则   
		add_action("template_redirect", array($this,'traceability_manage_template_redirect'));  
		//非管理员只能查看自己的文章列表
		add_filter('parse_query', array($this,'mypo_parse_query_useronly' ));
		//在文章编辑页面的[添加媒体]只显示用户自己上传的文件
		add_action('pre_get_posts',array($this,'my_upload_media'));
		//在[媒体库]只显示用户上传的文件
		add_filter('parse_query', array($this,'my_media_library' ));
		
		add_filter( 'contextual_help', array($this,'wpse50723_remove_help'), 999, 3 );//去除帮助

		if(is_admin()){
			include _TEMP_ .'/wp/menu/short.message.interface.php';
			include _TEMP_ .'/wp/ajax/ajax.php';
		}

	 }
	/*定义常量等默认配置*/
	public function init(){
		/**
		*网络路径
		*/
		define('TEMP', get_stylesheet_directory_uri());
		define('IMG', TEMP.'/web/img');
		define('JS', TEMP.'/web/js');
		define('CSS', TEMP.'/web/css');
		/**
		*服务器绝对路径
		*/
		define('_TEMP_', get_stylesheet_directory());
	}

	public function get_avatar($avatar, $id_or_email, $size, $default, $alt) {

		return '<img alt="'.$alt.'" src="'.IMG.'/avatar/wpua.png" class="avatar avatar-'.$size.' photo" height="'.$size.'" width="'.$size.'">';
	}
	
	public function nowspark_login_head() {
		  echo '<style type="text/css">
				body.login #login h1 a {
					background:url("'.IMG.'/logo-280x280.png") no-repeat center transparent;
					height: 100px;
					width: 155px;
					padding:0;
					margin:0 auto 1em;
					background-size: auto 100%;}
					</style>';
	}
	
	public function my_edit_toolbar($wp_toolbar) {
		$wp_toolbar->remove_node('wp-logo'); //去掉Wordpress LOGO 
		//$wp_toolbar->remove_node('site-name'); //去掉网站名称 
		$wp_toolbar->remove_node('updates'); //去掉更新提醒 
		//$wp_toolbar->remove_node('comments'); //去掉评论提醒 
		//$wp_toolbar->remove_node('new-content'); //去掉新建文件 
		//$wp_toolbar->remove_node('top-secondary'); //用户信息 
	}
	
	// 禁用自动保存，所以编辑长文章前请注意手动保存。
	public function my_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ,'recent_comments_style'));
	}
	
	public function wpse50723_remove_help($old_help, $screen_id, $screen){
		$screen->remove_help_tabs();
		return $old_help;
	}


	public function iplookup(){
		$ch_ip = curl_init();
		curl_setopt($ch_ip, CURLOPT_URL, 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$_SERVER["REMOTE_ADDR"]);
		curl_setopt($ch_ip, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch_ip, CURLOPT_HEADER, 0);
		//执行并获取HTML文档内容
		$output_ip = curl_exec($ch_ip);
		curl_close($ch_ip);
		if($output_ip){
			$return=json_decode($output_ip,true);
			$output=$return['country'].$return['province'].$return['city'];
		}else{
			$output='匿名';
			}
		
		//释放curl句柄
		
		return $output;
		
	 }
	 
	//模板载入规则   
	/**
	 * @return bool
     */
	public function traceability_manage_template_redirect(){
 
		global $wp_query;
		
		status_header( 200 );
 
		//查询my_custom_page变量 
		if(!is_404()) return false;

		$reditect_page =  $wp_query->query['pagename'];
		//print_r($wp_query);

		/*if ($reditect_page=='login')
		{
			header("Location:".home_url('member/login.php'));
			exit;
		}*/
		


		 
		/*不包含html 404*/
		/*if(!preg_match("/(h|H)(t|T)(m|M)(l|L)$/",$reditect_page, $matches)){
			include TEMP.'/404.php';
			exit;
		}*/
		$reditect_array=explode('/',$reditect_page);



		$plateName = $reditect_array[0];//板块名

		$classNmae = ucfirst($reditect_array[1]);//类名

		$funcName = $reditect_array[2];	//方法名

		$path = _TEMP_.'/src/'.$plateName.'/action/'.$classNmae.'Action.class.php';
		//echo $path;

		/**
		 * 判断类路径是否存在
		 */
		if(!is_file($path)){
			include _TEMP_.'/404.php';
			exit;
		}

		include_once($path);//加载类

		$class = 'src\\'.$plateName.'\action\\'.$classNmae;	//命名空间加载

		$query =  new $class();//实例化类

		spl_autoload_register('loadpath::load'); 	//自动化加载类

		if(empty($funcName)){

			$query->main(); //加载默认方法
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



		/*获取目录*/

		/*switch (count($reditect_page_array)) {
			case '1':
				$path = explode('.',$reditect_page_array[0]);
				$path_s = _TEMP_.'/index/'.$path[0].'.php';
				
				break;
			case '2':
				$path = $reditect_page_array[0];
				$name_s = explode('.',$reditect_page_array[1]);
				
				$load_url = _TEMP_.'/src/'.$path;//设置上一级目录为
				
				$path_s = $load_url.'/action/'.$name_s[0].'.php';
				
				break;
			default:
					return false;
				break;
		}*/
		 //echo $path_s;
		/*unset($path);
		unset($name_s);*/
		
		/*if(is_file($path))
		{
			status_header( 200 );
			include($path);
			die();
		}*/

	}
	//费非管理员只能查看自己的文章列表
	public function mypo_parse_query_useronly( $wp_query ) {
		if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
			if ( !current_user_can( 'manage_options' ) ) {
				global $current_user;
				$wp_query->set( 'author', $current_user->id );
			}
		}
	}
	//在文章编辑页面的[添加媒体]只显示用户自己上传的文件
	public function my_upload_media( $wp_query_obj ) {
	  global $current_user, $pagenow;
	  if( !is_a( $current_user, 'WP_User') )
		return;
	  if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
		return;
	  if( !current_user_can( 'manage_options' ) && !current_user_can('manage_media_library') )
		$wp_query_obj->set('author', $current_user->ID );
	  return;
	}
	//在[媒体库]只显示用户上传的文件
	public function my_media_library( $wp_query ) {
		if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false ) {
			if ( !current_user_can( 'manage_options' ) && !current_user_can( 'manage_media_library' ) ) {
				global $current_user;
				$wp_query->set( 'author', $current_user->id );
			}
		}
	}
	
	   

	public function change_footer_admin () {return '';}//去除页脚
	public function change_footer_version() {return '';}//去除版本

	/*判断手持设备*/
	public function is_mobile() {
	  $user_agent = $_SERVER['HTTP_USER_AGENT'];
	  $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
	  $is_mobile = false;
	  foreach ($mobile_agents as $device) {
		if (stristr($user_agent, $device)) {
		  $is_mobile = true;
		  break;
		}
	  }
	  return $is_mobile;
	}
	
	public function load_html(){
		
	}

}
$config = new config();