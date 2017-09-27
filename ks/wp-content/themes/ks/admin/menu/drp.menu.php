<?php
/**
 * 分销管理
 */
class order_drp_calss{
    public function __construct()
    {
        add_action('admin_menu',array($this,'add_drp_menu'));
        add_action('load-themes.php',array($this,'add_drp_menu_role'));//模板加载时
    }


    public function add_drp_menu_role(){
        global $pagenow,$wp_roles;
         //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            $role = 'drp';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '分销管理';

            /*$role = 'test1';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试1';

            $role = 'test2';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试2';*/

        }
    }


    public function add_drp_menu() {

        add_menu_page('分销管理','分销管理','drp','drp',array($this,'fun_menu'),'',206);
        add_submenu_page('drp','设置','设置','drp_setting','drp_setting',array($this,'menu_test1'));
        /*
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));*/

    }

    public function fun_menu(){

        echo "<h1>分销排行</h1>";
        $orderMenu = new \admin\test\action\TestAction();
        $orderMenu->index();

    }
    public function fun_menu1(){

        echo "<h1>设置</h1>";
        $orderMenu = new \admin\test\action\TestAction();
        $orderMenu->index();

    }

}
new order_drp_calss();
?>