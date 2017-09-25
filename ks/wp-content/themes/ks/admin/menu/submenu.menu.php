<?php
/**
 * 添加子菜单页面
 */
class submenu_menu_calss{
    public function __construct()
    {
        add_action('admin_menu',array($this,'add_submenu_menu'));
        add_action('load-themes.php',array($this,'add_submenu_menu_role'));//模板加载时
    }


    public function add_submenu_menu_role(){
        global $pagenow,$wp_roles;
        //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            $role = 'site_switch';//权限名
            $wp_roles->add_cap('administrator', $role);//
            $GLOBALS['role_list'][$role] = '网站开关';

           /* $role = 'test1';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试1';

            $role = 'test2';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试2';*/

        }
    }


    public function add_submenu_menu() {


        add_submenu_page( 'options-general.php','网站开关','网站开关','site_switch','site_switch',array($this,'menu_func'));
        //add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_func1'));

    }

    public function menu_func(){
        $checked_switch = get_option('website_checked_switch');//网站开关
        $off_switch = get_option('website_off_switch_content');//网站关闭后显示的内容
        ?>
        <div class="wrap">
            <h1>网站开关</h1>

            <form class="change-switch-form">
                <input type="hidden" name="action" value="checked_switch">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">网站是否，显示 </th>
                        <td><fieldset><legend class="screen-reader-text"><span>对于feed中的每篇文章，显示 </span></legend>
                                <p><label><input name="checked_switch" type="radio" value="yes" <?=$checked_switch == 'yes' ? 'checked="checked"' : ""?>> 开启</label><br>
                                    <label><input name="checked_switch" type="radio" value="no" <?=$checked_switch == 'no' ? 'checked="checked"' : ""?>> 关闭</label></p>
                            </fieldset></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="blogname">关闭后提示内容</label></th>
                        <td><input name="off_switch" type="text"  placeholder="网站维护" value="<?=$off_switch?>" class="regular-text"></td>
                    </tr>
                    </tbody>
                </table>

                <p class="submit"><input type="submit" name="submit" class="button button-primary" value="保存更改"></p></form>
        </div>
        <script src="<?= JS;?>/jquery2.1.1.min.js"></script>
        <script>
            $(".change-switch-form").on("submit",function(){

                var _this = $(this);
                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=admin_url( 'admin-ajax.php' );?>",//路径
                    data:_this.serializeArray(),//
                    success : function(data) {//返回数据根据结果进行相应的处理
                        if ( data.status == 'y') {
                            alert(data.info);
                            history.go(0);
                        } else {
                            alert(data.info);
                        }
                    }
                });
                return false;

            });

        </script>
        <?php

    }
    public function menu_func1(){



    }

}
new submenu_menu_calss();
?>