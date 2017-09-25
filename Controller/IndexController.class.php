<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 18:05
 */

namespace Controller;


class Index extends \Model\Index
{
    function main(){
        // $this->getIndexInfo();
        /*$mIdex = new \Model\Index();
        $mIdex->getIndexInfo();*/
        if(is_mobile()){
            display_show('index');

        }else{

            $args = array();
        $FastThreemodel = new \Model\FastThree();
        $args['FastThree'] = $FastThreemodel->get_FastThrees(1,9);
        get_header_front();
        display_show('index',$args);
        get_footer_front();

        }


    }


    public function activity(){
        get_header_front();
        display_show('activity');
        get_footer_front();
    }

    public function help(){
 
        get_header_front();
        display_show('help');
        get_footer_front();
    }

}