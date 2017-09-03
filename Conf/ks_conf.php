<?php
/**
*配置文件
*author:i
*date:2017/08/23 17:04
**/
define('CP_VERSION', '0.8');
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);  //为\斜杠
define('VIEW', MAIN_PATH .DS . 'View');  //视图
define('Model', MAIN_PATH .DS . 'Model');  //模型
define('VIEW_MOBILE', MAIN_PATH .DS . 'View' . DS . 'mobile' . DS);  //mobile
define('VIEW_PC', MAIN_PATH .DS . 'View' . DS . 'pc' . DS);  //pc


/*调用wp的配置文件*/
include_once MAIN_PATH . DS .'ks/wp-load'.EXT;
/*根据自己页面做相应的功能概述*/

/*公共函数*/
include_once MAIN_PATH .DS .'Conf'. DS .'functions'.EXT;

//包含目录
$include_dir = [
    'Controller',
    'Model',
    'View'
];

//设置包含目录
set_include_path(get_include_path() . PATH_SEPARATOR .implode(PATH_SEPARATOR, $include_dir));

/**
 * 自动加载类库
 * @param string $class 类名
 */
function auto_load_class($class = '')
{

    $namespace =  explode('\\', $class);   //分解为数组

    $str_class = str_replace('\\',DS,$class);
    //可扩展方向：文件夹_类名
    $path = MAIN_PATH.DS.$str_class .$namespace[0].'.class'.EXT;

    //其他加载模式（正常加载）
    //$pathRest = MAIN_PATH.DS.$str_class;

    /**
     * 判断类路径是否存在
     */
    if(is_file($path)){
        include_once($path);
    }


}

spl_autoload_register('auto_load_class'); //spl注册自动加载


if(isset( $_SERVER['PATH_INFO'] ) ){

    $pathinfo =  explode('/', $_SERVER['PATH_INFO']);   //分解为数组
    $pathinfo=array_filter($pathinfo);  //去空

    $classNmae = ucfirst(strtolower($pathinfo[1]));//类名
    $funcName = $pathinfo[2]; //方法名

    $class = '\Controller\\'.$classNmae;	//命名空间加载

    $query =  new $class();//实例化类

    if(empty($funcName)){

        if(method_exists($query,'main')){
            $query->main(); //加载默认方法
        }else{

            exit;
        }

    }else{
        /**
         * 判断类中是否存在方法
         */
        if(method_exists($query,$funcName)){
            $query->$funcName();//加载定义方法
        }else{

            exit;
        }

    }

}else{


    $obj = new \Controller\Index();//实例化
    $obj->main();
}

