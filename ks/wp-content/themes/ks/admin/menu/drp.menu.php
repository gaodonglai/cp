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

            $role = 'drp_setting';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '分销设置';

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
        add_submenu_page('drp','分销设置','分销设置','drp_setting','drp_setting',array($this,'menu_test1'));
        /*
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));*/

    }

    public function fun_menu(){

        if($_GET['type'] == 'detailed'){
            //佣金详情
            $this->drp_detailed();
            exit();
        }elseif ($_GET['type'] == 'distributor'){
            //分销商列表
            $this->drp_distributor();
            exit();
        }

        global $wpdb;
        $like = $_GET['like'];
        if($like){
            $g_like = "WHERE a.user_name LIKE '%{$like}%' or a.nick_name LIKE '%{$like}%'";
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT a.user_id,a.nick_name,a.mobile_phone,a.user_name,sum(b.increase_money) as totel_increase_money FROM {$wpdb->prefix}account as a inner JOIN {$wpdb->prefix}drp_log as b on a.user_id = b.rank_user_id  $g_like group by a.user_id ORDER BY a.user_id DESC   LIMIT $offset, $limit " );
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">分销用户列表</h1>

            <hr class="wp-header-end">

            <h2 class="screen-reader-text">过滤用户列表</h2>
            <form action="<?=add_query_arg()?>" method="get">
                <input type="hidden" id="user-search-input" name="page" value="account">
                <p class="search-box">
                    <label class="screen-reader-text" for="user-search-input">搜索用户:</label>
                    <input type="search" id="user-search-input" name="like" value="">
                    <input type="submit" id="search-submit" class="button" value="搜索用户"></p>

                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label><select name="action" id="bulk-action-selector-top">
                        <option value="-1">批量操作</option>
                        <option value="delete">删除</option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="应用">
                </div>

                <h2 class="screen-reader-text">用户列表</h2><table class="wp-list-table widefat fixed striped users">
                    <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">姓名</th>
                        <th scope="col" id="email" class="manage-column column-email sortable desc"><a href="javascript:;"><span>手机号</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="role" class="manage-column column-role">佣金(总)</th>
                        <th scope="col" id="role" class="manage-column column-role">操作</th>
                    </tr>
                    </thead>

                    <tbody id="the-list" data-wp-lists="list:user">
                    <?php if( $entries ) { ?>
                        <?php
                        foreach( $entries as $entry ) {
                            ?>
                            <tr id="user-1"><th scope="row" class="check-column">
                                    <label class="screen-reader-text" for="user_1">选择</label><input type="checkbox" name="users[]" id="user_1" class="administrator" value="<?=$entry->user_id?>">
                                <td class="username column-username has-row-actions column-primary" data-colname="用户名"><strong>
                                        <a href="javascript:;"><?=$entry->user_name?></a>
                                    </strong><br>
                                    <div class="row-actions"><span class="edit">
                                            <a href="?page=drp&type=distributor&user_id=<?=$entry->user_id?>">分销商列表</a> </span>
                                        |
                                            <a href="?page=drp&type=detailed&user_id=<?=$entry->user_id?>">佣金明细</a> </span>
                                    </div>
                                    <button type="button" class="toggle-row"><span class="screen-reader-text">显示详情</span></button>
                                </td>
                                <td class="name column-name" data-colname="姓名"><?=$entry->nick_name?></a></td>
                                <td class="email column-email" data-colname="手机号"><a href="javascript:;"><?=$entry->mobile_phone?></a></td>
                                <td class="user_id column-user_id" data-colname="余额"><?=$entry->totel_increase_money?></td>
                                <td class="user_id column-user_id" data-colname="操作"> </td>
                            </tr>
                            <?php

                        }
                        ?>

                    <?php } else { ?>
                        <tr>
                            <td colspan="2">No posts yet</td>
                        </tr>
                    <?php } ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">姓名</th>
                        <th scope="col" id="email" class="manage-column column-email sortable desc"><a href="javascript:;"><span>手机号</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="role" class="manage-column column-role">佣金(总)</th>
                        <th scope="col" id="role" class="manage-column column-role">操作</th>

                    </tr>
                    </tfoot>

                </table>
                <div class="tablenav bottom">

                    <div class="alignleft actions bulkactions">
                        <label for="bulk-action-selector-bottom" class="screen-reader-text">选择批量操作</label><select name="action2" id="bulk-action-selector-bottom">
                            <option value="-1">批量操作</option>
                            <option value="delete">删除</option>
                        </select>
                        <input type="submit" id="doaction2" class="button action" value="应用">
                    </div>

            </form>
            <?php

            $total = $wpdb->get_var( "SELECT COUNT(a.user_id) FROM {$wpdb->prefix}account as a inner JOIN {$wpdb->prefix}drp_log as b on a.user_id = b.rank_user_id  $g_like group by a.user_id" );

            $num_of_pages = ceil( $total / $limit );
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '上一页', 'aag' ),
                'next_text' => __( '下一页', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
            }

            echo '</div>';
            ?>
            <br class="clear">

        </div>
        <?php

    }



    function drp_detailed(){
        global $wpdb;
        $like = $_GET['like'];
        $user_id = $_GET['user_id'];
        if($like){
            $g_like = "and b.user_name LIKE '%{$like}%' or b.nick_name LIKE '%{$like}%'";
        }
        $get_user_name =  $wpdb->get_var("select user_name from {$wpdb->prefix}account where user_id = {$user_id}");

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT b.user_name,a.money,a.increase_money,a.rank,a.time FROM {$wpdb->prefix}drp_log as a inner join {$wpdb->prefix}account as b on a.user_id = b.user_id WHERE a.rank_user_id = {$user_id} $g_like  LIMIT $offset, $limit " );

        ?>

        <div class="wrap">
            <h1 class="wp-heading-inline"><?=$get_user_name?>的佣金详情</h1>

            <hr class="wp-header-end">

            <h2 class="screen-reader-text">过滤用户列表</h2>
            <form action="<?=add_query_arg()?>" method="get">
                <input type="hidden" id="user-search-input" name="page" value="drp">
                <input type="hidden" id="user-search-input" name="type" value="detailed">
                <input type="hidden" id="user-search-input" name="user_id" value="<?=$user_id?>">
                <p class="search-box">
                    <label class="screen-reader-text" for="user-search-input">搜索用户:</label>
                    <input type="search" id="user-search-input" name="like" value="">
                    <input type="submit" id="search-submit" class="button" value="搜索用户"></p>
            </form>
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label><select name="action" id="bulk-action-selector-top">
                        <option value="-1">批量操作</option>
                        <option value="delete">删除</option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="应用">
                </div>

                <h2 class="screen-reader-text">用户列表</h2><table class="wp-list-table widefat fixed striped users">
                    <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>分销用户</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">充值金额</th>
                        <th scope="col" id="name" class="manage-column column-name">贡献金额</th>
                        <th scope="col" id="name" class="manage-column column-name">等级</th>
                        <th scope="col" id="role" class="manage-column column-role">时间</th>

                    </tr>
                    </thead>

                    <tbody id="the-list" data-wp-lists="list:user">
                    <?php if( $entries ) { ?>
                        <?php
                        foreach( $entries as $entry ) {
                            ?>
                            <tr id="user-1"><th scope="row" class="check-column">
                                    <label class="screen-reader-text" for="user_1">选择</label><input type="checkbox" name="users[]" id="user_1" class="administrator" value="<?=$entry->user_id?>">
                                <td class="username column-username has-row-actions column-primary" data-colname="用户名"><strong>
                                         <a href="javascript:;"><?=$entry->user_name?></a>
                                    </strong><br /><br />

                                </td>
                                <td class="name column-name" data-colname="充值金额"><?=$entry->money?></a></td>
                                <td class="email column-email" data-colname="贡献金额"><a href="javascript:;"><?=$entry->increase_money?></a></td>
                                <td class="user_id column-user_id" data-colname="等级"><?=$entry->rank?></td>
                                <td class="user_id column-user_id" data-colname="时间"><?=$entry->time?></td>

                            </tr>
                            <?php

                        }
                        ?>

                    <?php } else { ?>
                        <tr>
                            <td colspan="2">No posts yet</td>
                        </tr>
                    <?php } ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>分销用户</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">充值金额</th>
                        <th scope="col" id="name" class="manage-column column-name">贡献金额</th>
                        <th scope="col" id="name" class="manage-column column-name">等级</th>
                        <th scope="col" id="role" class="manage-column column-role">时间</th>

                    </tr>
                    </tfoot>

                </table>
                <div class="tablenav bottom">

                    <div class="alignleft actions bulkactions">
                        <label for="bulk-action-selector-bottom" class="screen-reader-text">选择批量操作</label><select name="action2" id="bulk-action-selector-bottom">
                            <option value="-1">批量操作</option>
                            <option value="delete">删除</option>
                        </select>
                        <input type="submit" id="doaction2" class="button action" value="应用">
                    </div>


            <?php

            $total = $wpdb->get_var( "SELECT COUNT(a.id) FROM {$wpdb->prefix}drp_log as a inner join {$wpdb->prefix}account as b on a.user_id = b.user_id WHERE a.rank_user_id = {$user_id} $g_like" );
            $num_of_pages = ceil( $total / $limit );
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '上一页', 'aag' ),
                'next_text' => __( '下一页', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
            }

            echo '</div>';
            ?>
            <br class="clear">

        </div>
        <?php
    }



    //当前用户的分销商列表
    function drp_distributor(){
        global $wpdb;
        $like = $_GET['like'];
        $user_id = $_GET['user_id'];
        $grade = $_GET['grade'];

        if(empty($grade)){
            $grade = 1;
        }

        if($like){
            $g_like = "and b.user_name LIKE '%{$like}%' or b.nick_name LIKE '%{$like}%'";
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT b.user_name,a.money,a.increase_money,a.rank,a.time FROM {$wpdb->prefix}drp_log as a inner join {$wpdb->prefix}account as b on a.user_id = b.user_id WHERE a.rank_user_id = {$user_id} and a.rank={$grade} $g_like  LIMIT $offset, $limit " );

        $get_user_name =  $wpdb->get_var("select user_name from {$wpdb->prefix}account where user_id = {$user_id}");

        ?>

        <div class="wrap">
        <h1 class="wp-heading-inline"><?=$get_user_name?>的分销用户列表</h1>

        <hr class="wp-header-end">


        <h2 class="nav-tab-wrapper" style="margin-bottom:10px;">
            <a href="?page=drp&type=distributor&user_id=<?=$user_id?>&grade=1" title="一级分销用户" class="nav-tab <?=$grade == '1' || empty($grade) ? 'nav-tab-active' : ""?>">一级分销用户</a>
            <a href="?page=drp&type=distributor&user_id=<?=$user_id?>&grade=2" title="二级分销用户" class="nav-tab <?=$grade == '2' ? 'nav-tab-active' : ""?>">二级分销用户</a>
        </h2>

        <h2 class="screen-reader-text">过滤用户列表</h2>
        <form action="<?=add_query_arg()?>" method="get">
            <input type="hidden" id="user-search-input" name="page" value="drp">
            <input type="hidden" id="user-search-input" name="type" value="detailed">
            <input type="hidden" id="user-search-input" name="user_id" value="<?=$user_id?>">
            <p class="search-box">
                <label class="screen-reader-text" for="user-search-input">搜索用户:</label>
                <input type="search" id="user-search-input" name="like" value="">
                <input type="submit" id="search-submit" class="button" value="搜索用户"></p>
        </form>
        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label><select name="action" id="bulk-action-selector-top">
                <option value="-1">批量操作</option>
                <option value="delete">删除</option>
            </select>
            <input type="submit" id="doaction" class="button action" value="应用">
        </div>

        <h2 class="screen-reader-text">用户列表</h2><table class="wp-list-table widefat fixed striped users">
            <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>分销用户</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="name" class="manage-column column-name">充值金额</th>
                <th scope="col" id="name" class="manage-column column-name">贡献金额</th>
                <th scope="col" id="name" class="manage-column column-name">等级</th>
                <th scope="col" id="role" class="manage-column column-role">时间</th>

            </tr>
            </thead>

            <tbody id="the-list" data-wp-lists="list:user">
            <?php if( $entries ) { ?>
                <?php
                foreach( $entries as $entry ) {
                    ?>
                    <tr id="user-1"><th scope="row" class="check-column">
                            <label class="screen-reader-text" for="user_1">选择</label><input type="checkbox" name="users[]" id="user_1" class="administrator" value="<?=$entry->user_id?>">
                        <td class="username column-username has-row-actions column-primary" data-colname="用户名"><strong>
                                <a href="javascript:;"><?=$entry->user_name?></a>
                            </strong><br /><br />

                        </td>
                        <td class="name column-name" data-colname="充值金额"><?=$entry->money?></a></td>
                        <td class="email column-email" data-colname="贡献金额"><a href="javascript:;"><?=$entry->increase_money?></a></td>
                        <td class="user_id column-user_id" data-colname="等级"><?=$entry->rank?></td>
                        <td class="user_id column-user_id" data-colname="时间"><?=$entry->time?></td>

                    </tr>
                    <?php

                }
                ?>

            <?php } else { ?>
                <tr>
                    <td colspan="2">No posts yet</td>
                </tr>
            <?php } ?>

            </tbody>

            <tfoot>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>分销用户</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="name" class="manage-column column-name">充值金额</th>
                <th scope="col" id="name" class="manage-column column-name">贡献金额</th>
                <th scope="col" id="name" class="manage-column column-name">等级</th>
                <th scope="col" id="role" class="manage-column column-role">时间</th>

            </tr>
            </tfoot>

        </table>
        <div class="tablenav bottom">

            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-bottom" class="screen-reader-text">选择批量操作</label><select name="action2" id="bulk-action-selector-bottom">
                    <option value="-1">批量操作</option>
                    <option value="delete">删除</option>
                </select>
                <input type="submit" id="doaction2" class="button action" value="应用">
            </div>


            <?php

            $total = $wpdb->get_var( "SELECT COUNT(a.id) FROM {$wpdb->prefix}drp_log as a inner join {$wpdb->prefix}account as b on a.user_id = b.user_id WHERE a.rank_user_id = {$user_id} $g_like" );
            $num_of_pages = ceil( $total / $limit );
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '上一页', 'aag' ),
                'next_text' => __( '下一页', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
            }

            echo '</div>';
            ?>
            <br class="clear">

        </div>
        <?php
    }

    //分销设置
    function menu_test1(){
        $type = $_GET['type'];

        $proportion = get_option('drp_proportion_content');//分销比例
        ?>
            <div class="wrap">
            <h1>分销设置</h1>
            <h2 class="nav-tab-wrapper" style="margin-bottom:10px;">
            <a href="?page=drp_setting&type=default" title="分销比例" class="nav-tab <?=$type == 'default' || empty($type) ? 'nav-tab-active' : ""?>">默认分销比例</a>
            <a href="?page=drp_setting&type=individuation" title="个性化分销比例" class="nav-tab <?=$type == 'individuation' ? 'nav-tab-active' : ""?>">个性化分销比例</a>
            </h2>
            <?php
            if($type == 'default' || empty($type)){
                ?>
                <form class="add-drp-form" novalidate="novalidate">
                    <input name="action" type="hidden" value="account/drp/drpConfirm">
                    <table class="form-table">
                       <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                                 <tr>
                                    <th scope="row"><label for="blogname">直接分销用户</label></th>
                                   <td><input name="distribution_one" type="text" value="<?=$proportion['distribution_one']?>" class="regluar-text ltr">
                                    <p class="description" id="tagline-description">以百分比计算，如填1那么就是赠送充值金额的1%。</p></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label>间接分销用户</label></th>
                                    <td><input name="distribution_two" type="text" value="<?=$proportion['distribution_two']?>" class="regluar-text ltr">
                                     <p class="description" id="tagline-description">一般情况下间接用户所占百分比小于直接分销用户。</p></td>
                                </tr>
                       </tbody>

                      </table>

                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"></p>
                </form>

                <?php
            }else{

            }

            ?>
        <script src="<?= JS;?>/jquery2.1.1.min.js"></script>
        <script>

            $(".add-drp-form").on("submit",function(){

                var _this = $(this);
                if(!confirm("请确认是否按照当前比例，确认立即生效")){
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:_this.serializeArray(),//
                    success : function(data) {//返回数据根据结果进行相应的处理

                        if ( data.status == 'y') {
                            alert(data.info);
                            window.history.go(0);
                        } else {
                            alert(data.info);
                        }
                    }
                });
                return false;

            });


        </script>




        </div>
            <?php
    }

}
new order_drp_calss();
?>