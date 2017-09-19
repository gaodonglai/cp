<?php
/**
 * Created by PhpStorm.
 * User: GX
 * Date: 2016/1/17
 * Time: 22:11
 */

namespace libraries\controller;

/**
 * Class 后台视图动作
 * @package libraries\controller
 */
class AdminAction
{

    private $show = false; //是否显示页面路径


    /**
     * 输出页面
     * @param $template
     */
    protected function display($template){
        if(empty($template)){
            $path = _TEMP_.'/404.php';
        }else{
            $path = _TEMP_.'/admin/web/'.$template.'.php';
        }

        if($this->show){

            exit($path);
        }

        if(!is_file($path)){
            exit('温馨提示：页面路径指向错误');
        }

        if($this){

            //对象属性装换为数组
            foreach($this as $key => $value){
                $arr[$key] = $value;
            }
            extract($arr);//生成变量


            include($path);
        }


        /**
         * 默认添加admin_url
         */
        $admin_url = TEMP.'/admin/ajax.php';

        include_once($path);

    }

    /**
     * 页面重定向
     * @param $url
     */
    protected function redirect($url){

        header("Location: $url");

    }
    /**
     * JS页面重定向
     * @param $url
     */
    public  function jsRedirect($url){

        ?>
        <script>location="<?=$url?>"</script>
        <?php

    }

    /**
     * return 页面路径
     */
    protected function showTemplatePath(){

        $this->show = true;
        return $this;
    }


    public function error($content){ 
        echo "
            <style>
            table {
                *border-collapse: collapse; /* IE7 and lower */
                border-spacing: 0;
                width: 100%;    
            }

            .bordered {
                border: solid #ccc 1px;
                -moz-border-radius: 6px;
                -webkit-border-radius: 6px;
                border-radius: 6px;
                -webkit-box-shadow: 0 1px 1px #ccc; 
                -moz-box-shadow: 0 1px 1px #ccc; 
                box-shadow: 0 1px 1px #ccc;         
            }

            .bordered tr:hover {
                background: #fbf8e9;
                -o-transition: all 0.1s ease-in-out;
                -webkit-transition: all 0.1s ease-in-out;
                -moz-transition: all 0.1s ease-in-out;
                -ms-transition: all 0.1s ease-in-out;
                transition: all 0.1s ease-in-out;     
            }    
                
            .bordered td, .bordered th {
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;
                padding: 10px;
                text-align: left;    
            }

            .bordered th {
                background-color: #dce9f9;
                background-image: -webkit-gradient(linear, left top, left bottom, from(#ebf3fc), to(#dce9f9));
                background-image: -webkit-linear-gradient(top, #ebf3fc, #dce9f9);
                background-image:    -moz-linear-gradient(top, #ebf3fc, #dce9f9);
                background-image:     -ms-linear-gradient(top, #ebf3fc, #dce9f9);
                background-image:      -o-linear-gradient(top, #ebf3fc, #dce9f9);
                background-image:         linear-gradient(top, #ebf3fc, #dce9f9);
                -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; 
                -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
                box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
                border-top: none;
                text-shadow: 0 1px 0 rgba(255,255,255,.5); 
            }

            .bordered td:first-child, .bordered th:first-child {
                border-left: none;
            }

            .bordered th:first-child {
                -moz-border-radius: 6px 0 0 0;
                -webkit-border-radius: 6px 0 0 0;
                border-radius: 6px 0 0 0;
            }

            .bordered th:last-child {
                -moz-border-radius: 0 6px 0 0;
                -webkit-border-radius: 0 6px 0 0;
                border-radius: 0 6px 0 0;
            }

            .bordered th:only-child{
                -moz-border-radius: 6px 6px 0 0;
                -webkit-border-radius: 6px 6px 0 0;
                border-radius: 6px 6px 0 0;
            }

            .bordered tr:last-child td:first-child {
                -moz-border-radius: 0 0 0 6px;
                -webkit-border-radius: 0 0 0 6px;
                border-radius: 0 0 0 6px;
            }

            .bordered tr:last-child td:last-child {
                -moz-border-radius: 0 0 6px 0;
                -webkit-border-radius: 0 0 6px 0;
                border-radius: 0 0 6px 0;
            }
              
            </style>
            <table class='bordered'>
                  <thead>

                  <tr>       
                      <th colspan='2'><h3>提示消息</h3></th>
                  </tr>
                  </thead>
                  <tr>
                      <td><h4>错误内容:</h4></td>        
                      <td><h4>$content</h4></td>
                  </tr>
                  <tr>
                      <td colspan='2'><a href='javascript:void(0)' onClick='history.go(0);'>返回</a></td>        
                  </tr>          
            </table>";

     }

}