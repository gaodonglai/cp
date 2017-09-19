<?php
/**
 * 取现管理
 */
class withdraw_calss{
    public function __construct()
    {
        add_action('admin_menu',array($this,'add_withdraw_menu'));
        add_action('load-themes.php',array($this,'add_withdraw_menu_role'));//模板加载时
    }


    public function add_withdraw_menu_role(){
        global $pagenow,$wp_roles;
         //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            $role = 'withdraw';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '取现管理';

            /*$role = 'test1';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试1';

            $role = 'test2';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试2';*/

        }
    }


    public function add_withdraw_menu() {

        add_menu_page('取现管理','取现管理','withdraw','withdraw',array($this,'fun_menu'),'',208);
       /* add_submenu_page('test','测试1','测试1','test1','test1',array($this,'menu_test1'));
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));*/

    }

    public function fun_menu(){

        echo "<h1>取现管理</h1>";
        $orderMenu = new \admin\test\action\TestAction();
        $orderMenu->index();

    }


}
new withdraw_calss();
?>