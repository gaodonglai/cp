<?php
/**
 * _code()是函数
 * @access public
 * @param int $_width 表示的长度
 * @param int $_height 表示的高度
 * @param int $_rnd_code 表示的位数
 * @param bool $_flag 表示是否需要边框
 * @return void 这个函数执行后产生一个
 */
function _code($_width = 100,$_height = 25,$_rnd_code = 5,$_flag = false) {
    session_start();
    //创建随机码
    $_nmsg = "";
    for ($i=0;$i<$_rnd_code;$i++) {
        $_nmsg .= dechex(mt_rand(0,15));
    }

    //保存在session
    $_SESSION['code'] = $_nmsg;
    $_SESSION['verifycode_time'] = time();

    //创建一张图像
    $_img = imagecreatetruecolor($_width,$_height);

    //白色
    $_white = imagecolorallocate($_img,255,255,255);

    //填充
    imagefill($_img,0,0,$_white);

    if ($_flag) {
        //黑色,边框
        $_black = imagecolorallocate($_img,0,0,0);
        imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
    }

    //随即画出6个线条
    for ($i=0;$i<6;$i++) {
        $_rnd_color = imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
    }

    //随即雪花
    for ($i=0;$i<100;$i++) {
        $_rnd_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
        imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_rnd_color);
    }

    //输出
    for ($i=0;$i<strlen($_SESSION['code']);$i++) {
        $_rnd_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
        imagestring($_img,5,$i*$_width/$_rnd_code+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
    }

    //输出图像
    header('Content-Type: image/png');
    imagepng($_img);

    //销毁
    imagedestroy($_img);
}
_code();
?>