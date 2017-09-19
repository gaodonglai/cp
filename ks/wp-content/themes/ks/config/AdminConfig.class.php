<?php
/**
 * Created by PhpStorm.
 * User: GX
 * Date: 2016/1/17
 * Time: 17:26
 */
class AdminConfig
{

    /**
     * AdminConfig constructor.
     */
    function __construct()
    {
        /*******************************start*请不要认为不好看而改变加载顺序******************************************/


        add_filter('admin_title',array($this,'admin_title'),10,2);
        add_action('admin_head', array($this, 'loadMenuStyle'));  //加载菜单默认css与js
        //add_action( 'admin_init', array($this, 'baw_no_admin_access'), 1 );//禁止订阅用户进入后台
        self::init();       //加载默认配置
        require_once _TEMP_ . '/config/LoadPath.class.php';   //引入自动加载类
        spl_autoload_register('LoadPath::load');    //开启自动化加载类


        //add_action('load-themes.php',array($this,'operation_wp_roles'));//加载主题时
        add_action('admin_footer',array($this,'add_wp_menu_role_list'));//加载主题后保存默认菜

        self::loadMenu();   //加载菜单

        self::loadAjax();   //加载ajax配置


        $upload_dir = wp_upload_dir();   //上传文件主题目录
        define('UPLOAD_DIR',$upload_dir['basedir'].'/');   //上传物理目录
        define('UPLOAD_URL',$upload_dir['baseurl'].'/');   //上传网络目录

        define('CTR_UPLOAD_PATH',  UPLOAD_DIR."customer/"); //消费者上传物理路径
        define('CTR_UPLOAD_URI',  UPLOAD_URL."customer/");  //消费者上传网络路径

        /*******************************end*******************************************/

        add_filter('get_avatar', array($this, 'get_avatar'), 1, 5);
        /*其他程序加载*/
        add_filter('pre_site_transient_update_core', create_function('$a', "return null;")); // 关闭核心提示

        add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示

        add_filter('pre_site_transient_update_themes', create_function('$a', "return null;")); // 关闭主题提示

        remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新

        remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件

        remove_action('admin_init', '_maybe_update_themes');  // 禁止 WordPress 更新主题
		//移除 WordPress 仪表盘欢迎面板
		remove_action('welcome_panel', 'wp_welcome_panel');

        register_nav_menus(array('pc-menu' => __('PC端菜单'),));//添加菜单页面
        register_nav_menus(array('mobile-menu' => __('手机端菜单'),));//添加菜单页面

        // 禁用修订版本
        remove_action('pre_post_update', 'wp_save_post_revision');
        //modify the background image
        //add_filter('admin_footer_text', array($this,'change_footer_admin'), 9999);//去除页脚
        //add_filter( 'update_footer', array($this,'change_footer_version'), 9999);//去除版本
        add_action('admin_bar_menu', array($this, 'my_edit_toolbar'), 999);


        // 禁用自动保存，所以编辑长文章前请注意手动保存。
        add_action('admin_print_scripts', create_function('$a', "wp_deregister_script('autosave');"));
        wp_deregister_script('l10n');
        add_action('widgets_init', array($this, 'my_remove_recent_comments_style'));

        add_filter('contextual_help', array($this, 'wpse50723_remove_help'), 999, 3);//去除帮助
		
		add_action('wp_dashboard_setup',  array($this, 'Yusi_remove_dashboard_widgets'),11 );

		/*自带特色图片*/
		add_theme_support('post-thumbnails');

        //支持小工具
        if (function_exists('register_sidebar')) {
            register_sidebar(array(
                'before_widget' => '<li>', // widget 的开始标签
                'after_widget' => '</div></li>', // widget 的结束标签
                'before_title' => '<div class="hyNewListLeftTitle"><span><b>', // 标题的开始标签
                'after_title' => '</b></span></div><div class="hyNewListInquire">' // 标题的结束标签
            ));
        }

        add_filter('tiny_mce_before_init', array($this, 'custum_fontfamily'));//添加字体
        add_filter('tiny_mce_before_init', array($this, 'enable_more_buttons'));//添加字体


        /* 自定义 WordPress 后台底部的版权和版本信息*/
        add_filter('admin_footer_text', array($this,'left_admin_footer_text'));

        add_filter('update_footer', array($this,'right_admin_footer_text'), 11);
        if($_GET['page']=='products' && $_GET['action']=='edit'){
            add_action( 'wp_before_admin_bar_render', array($this,'OXP_admin_bar_edit') );
        }
    }

    function enable_more_buttons($buttons) {
        $buttons[] = 'styleselect';
        $buttons[] = 'fontselect';
        return $buttons;
    }


    function custum_fontfamily($initArray){
        $initArray['font_formats'] = "微软雅黑='微软雅黑';宋体='宋体';黑体='黑体';仿宋='仿宋';楷体='楷体';隶书='隶书';幼圆='幼圆';";
        return $initArray;
    }

    public function admin_title($admin_title,$title){
        $title = apply_filters('admin_title_title',$title);
        if ( is_network_admin() )
            $admin_title = sprintf( __( 'Network Admin: %s' ), esc_html( get_current_site()->site_name ) );
        elseif ( is_user_admin() )
            $admin_title = sprintf( __( 'Global Dashboard: %s' ), esc_html( get_current_site()->site_name ) );
        else
            $admin_title = get_bloginfo( 'name' );

        if ( $admin_title == $title )
            $admin_title = $title;
        else
            $admin_title = sprintf( __( '%1$s &lsaquo; %2$s' ), $title, $admin_title );

        return $admin_title;
    }
    function OXP_admin_bar_edit() {
        global $wp_admin_bar;
        $wp_admin_bar->add_menu( array(
            'id' => 'my-items',
            'title' => '查看商品',
            'href' =>home_url('store/items/'.$_GET['id']),
            'meta' =>array(
                'target'=>'_blank'
            )
        )
        );
    }

	function Yusi_remove_dashboard_widgets() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}
    
    function right_admin_footer_text($text)
    {
        // 右边信息
        $text = '1.0版本';
        return $text;
    }

    function left_admin_footer_text($text)
    {
        // 左边信息
        $text = 'caipiao';
        return $text;
    }

 


    /**
     * menu页面自动加载
     */
    static function loadMenu()
    {

        $arr_menu = glob(_TEMP_ . "/admin/menu/*.menu.php");

        if (!empty($arr_menu)) {
            foreach ($arr_menu as $value) {
                include $value;
            }
        }

        $arr_submenu = glob(_TEMP_ . "/admin/menu/*.submenu.php");

        if (!empty($arr_submenu)) {
            foreach ($arr_submenu as $value) {
                include $value;
            }
        }

        $arr_submenu = glob(_TEMP_ . "/admin/menu/*.post.php");

        if (!empty($arr_submenu)) {
            foreach ($arr_submenu as $value) {
                include $value;
            }
        }
    }



    /**
     * menu页面自动加载
     */
    static function loadAjax()
    {

        $arr_menu = glob(_TEMP_ . "/admin/ajax/*.ajax.php");

        if (!empty($arr_menu)) {
            foreach ($arr_menu as $value) {

                include $value;
            }
        }

    }





    /*定义常量等默认配置
    *
    */
    private static function init(){
        /**
         *网络路径
         */
        define('TEMP', get_stylesheet_directory_uri());
        define('IMG', TEMP . '/admin/web/img');
        define('JS', TEMP . '/admin/web/js');
        define('CSS', TEMP . '/admin/web/css');

        $upload_dir = wp_upload_dir();   //上传文件主题目录
        define('ADMIN_UPLOAD_DIR',$upload_dir['basedir'].'/');   //上传物理目录
        define('ADMIN_UPLOAD_URL',$upload_dir['baseurl'].'/');   //上传网络目录
        
        /**
         *服务器绝对路径
         */
        define('_TEMP_', get_stylesheet_directory());
    }


    /**
     * 加载页面默认样式
     */
     function loadMenuStyle(){
         /**
          * 后台数据统一提交页面
          */
         $admin_url = get_stylesheet_directory_uri() . '/admin/ajax.php';
         echo '
         <script> admin_url = "'.$admin_url.'";
          home_url = "'.home_url().'";
         </script>';

         do_action('admin_JsStyle_action');
    }


    public function get_avatar($avatar, $id_or_email, $size, $default, $alt){

        return '<img alt="' . $alt . '" src="' . IMG . '/avatar/wpua.jpg" class="avatar avatar-' . $size . ' photo" height="' . $size . '" width="' . $size . '">';
    }

    public function my_edit_toolbar($wp_toolbar){
        $wp_toolbar->remove_node('wp-logo'); //去掉Wordpress LOGO
        //$wp_toolbar->remove_node('site-name'); //去掉网站名称
        $wp_toolbar->remove_node('updates'); //去掉更新提醒
        //$wp_toolbar->remove_node('comments'); //去掉评论提醒
        //$wp_toolbar->remove_node('new-content'); //去掉新建文件
        //$wp_toolbar->remove_node('top-secondary'); //用户信息
    }

    // 禁用自动保存，所以编辑长文章前请注意手动保存。
    public function my_remove_recent_comments_style(){
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }

    public function wpse50723_remove_help($old_help, $screen_id, $screen){
        $screen->remove_help_tabs();
        return $old_help;
    }






    public function iplookup(){
        $ch_ip = curl_init();
        curl_setopt($ch_ip, CURLOPT_URL, 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $_SERVER["REMOTE_ADDR"]);
        curl_setopt($ch_ip, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_ip, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output_ip = curl_exec($ch_ip);
        curl_close($ch_ip);
        if ($output_ip) {
            $return = json_decode($output_ip, true);
            $output = $return['country'] . $return['province'] . $return['city'];
        } else {
            $output = '匿名';
        }

        //释放curl句柄

        return $output;

    }


    /**
     * 加载wp主题模板时，删除自带角色
     */
    public function operation_wp_roles() {

        global $wp_roles;

        /*$wp_roles->remove_role('contributor');
        $wp_roles->remove_role('editor');
        $wp_roles->remove_role('author');
        $wp_roles->remove_role('subscriber');*/

    }


    /**
     * 加载wp主题模板时，添加自定义主题菜单模块到potion表中
     */
    function add_wp_menu_role_list(){
        global $pagenow;
        //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            update_option('wp_role_list', $GLOBALS['role_list']);

            echo '<script>history.go(0);</script>';
        }
    }

    function baw_no_admin_access() {
        if( current_user_can( 'subscriber' ) ) {
            wp_redirect( home_url() );
            die();
        }
    }

}

new AdminConfig();