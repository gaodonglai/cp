<?php
/**
 * 后台ajax提交操作
 * 当前提交只能是post提交
 */

require_once  dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' ;
header("Content-Type: text/html; charset=utf-8");
if (is_user_logged_in() && $_POST) {

    require_once get_stylesheet_directory() . '/config/LoadPath.class.php'; // 引入自动加载类

    spl_autoload_register('loadpath::load'); // 开启自动化加载类
    
    $action = $_POST['action']; // 类路径
    
    if (empty($action)) {
        exit('温馨提示：action没有了。');
    }

    $action_array = explode('/', $action);

    $plateName = strtolower($action_array[0]); // 板块名
    
    $classNmae = ucfirst(strtolower($action_array[1])); // 类名

    $funcName = $action_array[2]; // 方法名
    
   /* if (! current_user_can($plateName)) {
        exit('温馨提示：当前用户不具备这样的权限');
    }*/
    
    /**
     * 角色控制待添加
     */
    
    $class_pact = 'admin\\' . $plateName . '\\action\\' . $classNmae . 'Action';
    $object = new $class_pact(); // 实例化需要访问的类

    if ($funcName) {

        if (method_exists($object, $funcName)) {
            $object->$funcName();
        } else {
            exit('温馨提示：当前访问的方法不存在。');
        }
    }
} else {
    
    // do_action( 'ddbz_ajax_nopriv_' . $_REQUEST['action'] );
}
exit();