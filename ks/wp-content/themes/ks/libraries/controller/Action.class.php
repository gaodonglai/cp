<?php
/**
 * Created by PhpStorm.
 * User: GX
 * Date: 2016/1/17
 * Time: 22:11
 */

namespace libraries\controller;
use libraries\util\VerifyData;

/**
 * Class 视图动作
 * @package libraries\controller
 */
class Action
{

    private $show = false; //是否显示页面路径

    /*private $header;    //头部
    private $footer;    //尾部*/
    private $css;    //样式
    private $js;    //js



    /**
     * 输出页面
     * @param $template
     */
    public function display($template){
        if(empty($template)){
            $path = _TEMP_.'/404.php';
        }else{
            $path = _TEMP_.'/web/'.$template.'.php';          
	 }
        //echo $path;
        if($this->show){

            exit($path);
        }
        if($this){

            //对象属性装换为数组
            foreach($this as $key => $value){
                $arr[$key] = $value;
            }
            extract($arr);//生成变量
        }

            include($path);



    }

    /**
     * 头部加载
     * 加载默认尾部：header
     * @param $header 名称
     * @param string $content 内容
     */
    protected function header($header,$content=''){


        if($header == 'header'){
            get_header();
        }else{
            $path = _TEMP_.'/custom/header/'.$header.'.php';
            if(!is_file($path)){
                exit('温馨提示:加载的头部文件不存在。');
            }

            include_once($path);
        }


    }

    /**
     * 尾部加载
     * 加载默认尾部：footer
     * @param $footer 名称
     * @param string $content 内容
     */
    protected function footer($footer,$content=''){

        if($footer == 'footer'){
            get_footer();
        }else{
            $path = _TEMP_.'/custom/footer/'.$footer.'.php';
            if(!is_file($path)){
                exit('温馨提示:加载的尾部文件不存在。');
            }

            include_once($path);
        }

    }

    /**
     * css加载
     * @param $css
     */
    public  function css($css){
        if(empty($css)){
            echo '温馨提示：css方法已加载但没有添加文件名。';
        }
        $this->css = $css;
        add_action( 'wp_head', array( $this, '__getCss' ) );
    }

    /**js加载
     *
     * @param $js
     */
    public  function js($js){
        if(empty($js)){
            echo '温馨提示：js方法已加载但没有添加文件名。';
        }

        $this->js = $js;
        add_action( 'wp_footer', array( $this, '__getJs' ) );

    }

    public function __getCss(){

        if(empty($this->css)){
            exit('温馨提示：css方法已添加但是没有内容。');
        }

        if(is_array($this->css)){

            foreach($this->css as $key => $value){

                if(is_array($value)){

                    foreach($value as $val){
                        echo '<link rel="stylesheet" href="'.CSS.'/'.$key.'/'.$val.'.css?ver='.CJ_VER.'"/>';

                    }

                }else{

                    echo '<link rel="stylesheet" href="'.CSS.'/'.$value.'.css?ver='.CJ_VER.'"/>';
                }
            }

        }else{
            echo '<link rel="stylesheet" href="'.CSS.'/'.$this->css.'.css?ver='.CJ_VER.'"/>';
        }

    }

    public function __getJs(){
        if(empty($this->js)){
            exit('温馨提示：js方法已添加但是没有内容。');
        }

        if(is_array($this->js)){

            foreach($this->js as $key => $value){

                if(is_array($value)){

                    foreach($value as $val){
                        echo '<script src="'.JS.'/'.$key.'/'.$val.'.js?ver='.CJ_VER.'"></script>';
                    }

                }else{

                    echo '<script src="'.JS.'/'.$value.'.js?ver='.CJ_VER.'"></script>';
                }
            }

        }else{
            echo '<script src="'.JS.'/'.$this->js.'.js?ver='.CJ_VER.'"></script>';
        }
    }

    /**
     * 页面重定向
     * @param $url
     */
    public function redirect($url){

        header("Location: $url");
        exit();
    }


    /**
     * return 页面路径
     */
    protected function showTemplatePath(){

        $this->show = true;
        return $this;
    }


    public function error($con=''){

        $this->redirect(home_url('404'));

    }

    /**
     * 判断提交参数是否为空,如果有空值或错误的值返回true
     * @param $request
     * @param $list
     * @return bool
     */
    public function isRequest($request,$list=''){
        $verify = VerifyData::getInstance();

        if($request){

            if($list){

                if(is_array($list)){

                    foreach ($list as $key=>$item) {

                        if(is_string($key)){

                            if(!$verify->formHandler($request[$key],$item)){
                                return true;
                            }


                        }else{

                            if(empty($request[$item])){
                                return true;
                            }
                        }
                    }

                }else{
                    if(empty($request[$list])){
                        return true;
                    }
                }


            }else{

                foreach($request as $value){
                    if(empty($value)){
                        return true;
                    }
                }
            }


        }else{
            return true;
        }
    }

}