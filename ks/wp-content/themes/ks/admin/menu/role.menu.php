<?php
/**
 * 用户角色添加于删除
 * User: 95
 * Date: 2016/2/1
 * Time: 16:37
 */
add_action('admin_menu', 'add_role_menu');
add_action('load-themes.php', 'add_role_menu_role');
// 模板加载时
function add_role_menu_role()
{
    global $pagenow, $wp_roles;
    // 判断是否为激活主题页面
    if ('themes.php' == $pagenow && isset($_GET['activated'])) {

        $role = 'role'; // 权限名
        $wp_roles->add_cap('administrator', $role); // 为管理员添加编辑商品权限
        $GLOBALS['role_list'][$role] = '角色管理';
    }
}

function add_role_menu()
{
    global $init_role;
    $init_role = array(
        'read' => '个人中心',
        'switch_themes' => '外观[外观，主题]',
        'edit_themes' => '外观[主题编辑器编辑主题文件。]',
        'edit_theme_options' => '外观[小部件，菜单，定制，背景，头]',
        'install_themes' => '外观[添加新主题]',
        'activate_plugins' => '插件',
        'edit_plugins' => '插件[插件编辑器]',
        'install_plugins' => '插件[添加新]',
        'edit_users' => '用户',
        'manage_options' => '设置[常规，撰写，阅读，讨论，固定链接]',
        'moderate_comments' => '允许用户访问和评论的评论子面板',
        'manage_categories' => '文章[分类]，友情链接[分类]',
        'manage_links' => '友情链接[新添加]',
        'upload_files' => '媒体[添加新]',
        'import' => '工具[导入，导出]',
        'unfiltered_html' => '允许用户发布HTML标记甚至JavaScript代码在页面、文章、评论和小部件。',
        'edit_posts' => '文章[添加，编辑],评论[等待审核]',
        'publish_posts' => '发布文章',
        'edit_others_posts' => '管理[评论]',
        'edit_published_posts' => '用户可以编辑他们的文章发表。这个功能默认是关闭的。',
        'edit_pages' => '页面[新添加]'
    );
    
    add_menu_page(__('角色权限管理'), __('角色权限管理'), 'role', 'role', 'menu_role','',13);
    
    add_submenu_page('role', '新增角色', '新增角色', 'role', 'role_add', 'menu_role_add');
}

/**
 * 角色列表
 */
function menu_role()
{
    echo '<h1>已有角色</h1>';
    
    global $wp_roles, $init_role;

    $get_role_list = get_option('wp_role_list');
    
    if ($get_role_list) {
        $wp_role_list = array_merge_recursive($get_role_list, $init_role);
    } else {
        $wp_role_list = $init_role;
    }

    $role = $wp_roles->get_names();
    unset($role['administrator']);
    
    ?>
    <style>
        #accordion {
            background: #fff;
        }
        .ui-accordion-header {
            padding: 10px;margin: 0; border-bottom: 1px solid #ccc;
        }
        .ui-accordion-content p {
            margin: 0;padding: 10px;color: #302B2B;
        }
        .ui-accordion-content p span {
            width: 500px; display: inline-block;position: relative; padding: 5px 0;
        }
        .ui-accordion-content p b {
            font-weight: normal; margin-left: 30px;
        }
        .ui-accordion-content p input {
            position: absolute;left: 0;
        }
        .delect-role{
            float: right;font-size: 22px;cursor: pointer;padding-left: 5px;width: 20px;
        }
    </style>

    <script src="<?=get_stylesheet_directory_uri()?>/admin/web/js/jquery.min.js"></script>
    <script src="<?=get_stylesheet_directory_uri()?>/admin/web/js/jquery-ui/jquery-ui.min.js"></script>

    <div id="accordion">
        <?php
        if (empty($role)) {
            exit('<h1>当前没有可用的角色</h1>');
        }
        foreach ($role as $key => $value) {
        ?>
        <h3><?=$value;?><span data-role="<?=$key;?>" class="delect-role">×</span></h3>
        <div>
            <p>
            <?php
            foreach ($wp_role_list as $k => $v) {

                ?>
                <span> <b><?=$v;?></b>
                    <input type="checkbox"  <?=$k=='read'?'disabled="disabled"':''?> data-role="<?=$key;?>" name="check_role" <?=$wp_roles->roles[$key]['capabilities'][$k] ? 'checked="checked"' : '';?> value="<?=$k;?>" /></span>
                <?php
            }
            ?>
            </p>
        </div>
        <?php
        }
        ?>
    </div>

    <script>
        $(function() {
            //手风琴
            $( "#accordion" ).accordion();

            //点击添加权限
            $('input[name=check_role]').click(function(){
                var _this = $(this);
                var flag = _this.is(':checked');
                if(flag){
                    var check = 'y';

                }else{
                    var check = 'n';

                }
                var role = _this.attr('data-role');
                var check_role = $(this).val();
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data:{'action':'role_jurisdiction_settings','role':role,'check_role':check_role,'check':check},
                    dataType: "json",
                    success: function(data){
                        if(data.flag == 'y'){
                            $.alerts(data.info);

                        }else if(data.flag == 'n'){
                            $.alerts(data.info);
                            _this.attr("checked",false);

                        }
                    }
                });
            });

            //点击删除角色
            $('.delect-role').click(function(){

                if(!confirm("确认要删除这个角色吗？")){
                    return false;
                }
                var _this = $(this);
                var role_name = _this.attr('data-role');
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data:{'action':'role_delete','role_name':role_name},
                    dataType: "json",
                    success: function(data){
                        if(data.flag == 'y'){
                            $.alerts(data.info);

                            history.go(0);
                        }else if(data.flag == 'n'){
                            $.alerts(data.info);

                        }
                    }
                });
            });
        });
    </script>

<?php
}

function menu_role_add()
{
    echo '<h1>新增角色</h1>';

    global $init_role;

    $wp_role_list = get_option('wp_role_list');
    
    if ($wp_role_list) {
        $role = array_merge_recursive($wp_role_list, $init_role);
    } else {
        $role = $init_role;
    }

    ?>
    <style>
        #role_form {
            background: #fff;
            padding: 10px;
        }

        #role_form p {
            margin: 0;
        }
        .role_add {
            border-bottom: 1px solid #ccc;
        }
        .role_add span {
            display: inline-block;width: 100%;padding: 5px 0;
        }
        .role_adda_qx {
            width: 70px;min-height: 100px;display: inline-block;float: left;font-weight: bold;padding-top: 5px;
        }
        .ckssa {
            width: 100%;display: inline-block;margin-top: 50px;text-align: center;
        }
        .role_adda_right {
            display: inline-block;width: 90%;float: left;
        }
        .role_adda {
            padding-top: 30px;border: normal;
        }
        .role_adda_right b {
            width: 500px;display: inline-block;font-weight: normal;position: relative;text-indent: 30px;padding: 5px 0;
        }
        .role_adda_right b input {
            position: absolute;left: 0;
        }
        #ckss {
            width: 100px;height: 40px;background: #0073AA;border: none;color: #Fff;border-radius: 5px;cursor: pointer;
        }
    </style>
    <form id="role_form">
        <input type="hidden" name="action" value="role_add" />
        <p class="role_add">
            <span> <b>角色名称：</b> <input type="text" name="role"
                placeholder="角色名，如：admin" />
            </span> <span><b>角色昵称：</b> <input type="text" name="display_name"
                placeholder="角色昵称，如：管理员" /> </span>
        </p>
        <p class="role_adda">
            <span class="role_adda_qx">应用权限：</span> <span class="role_adda_right">
        <?php
            foreach ($role as $key => $value) {
                $flag = '';
                if($key=='read'){
                    $flag = 'checked="checked" onclick="return false;"';
                }

                echo '<b>' . $value . '<input type="checkbox" '. $flag . '  name="role_s[]" value="' . $key . '"/></b>';
            }
        ?>
            </span> <span class="ckssa"><input type="button"  checked="checked" id="ckss" value="提交" /></span>
        </p>
    </form>
    <script src="<?=get_stylesheet_directory_uri()?>/admin/web/js/jquery.min.js"></script>
    <script src="<?=get_stylesheet_directory_uri()?>/admin/web/js/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $('#ckss').click(function(){
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: $('#role_form').serialize(),
                dataType: "json",
                success: function(data){
                    if(data.flag == 'y'){
                        $.alerts(data.info);
                        history.go(0);
                    }else if(data.flag == 'n'){
                        $.alerts(data.info);

                    }
                }
            });

        });

    </script>
<?php
}

