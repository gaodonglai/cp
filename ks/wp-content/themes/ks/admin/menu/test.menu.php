<?php
/**
 * test
 */
class order_menu_calss{
    public function __construct()
    {
        add_action('admin_menu',array($this,'add_test_menu'));
        add_action('load-themes.php',array($this,'add_test_menu_role'));//模板加载时
    }


    public function add_test_menu_role(){
        global $pagenow,$wp_roles;
        //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            $role = 'test';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试';

            $role = 'test1';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试1';

            $role = 'test2';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试2';

        }
    }


    public function add_test_menu() {

        add_menu_page('测试','测试','test','test',array($this,'menu_test'),'',203);
        add_submenu_page('test','测试1','测试1','test1','test1',array($this,'menu_test1'));
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));

    }

    public function menu_test(){

        echo "<h1>测试</h1>";
        $orderMenu = new \admin\test\action\TestAction();
        $orderMenu->index();

    }
    public function menu_test1(){

        echo "<h1>测试</h1>";
        $orderMenu = new \admin\test\action\TestAction();
        $orderMenu->index();

    }

}
new order_menu_calss();
?>