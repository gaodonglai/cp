<?php
/**
 * Created by PhpStorm.
 * User: GX
 * Date: 2016/5/23
 * Time: 23:20
 */

namespace app\member\action;


use libraries\controller\Action;
use libraries\db\Sql;

class LiveAction extends Action
{
    public function main(){
        $sql = new Sql();
        $px = $sql->getPrefix();
        $l = "SELECT * FROM `{$px}warehouse_live` order by id desc";
        $getLive = $sql->query($l);
        if($getLive){

            foreach ($getLive as $key => $value) {
                # code...
                $getLive[$key]['live_picture'] = wp_get_attachment_image_url($value['live_picture']);

            }

            exit(json_encode(array('status'=>'y','info'=>$getLive)));
        }else{
            exit(json_encode(array('status'=>'n','info'=>'内容获取失败')));
        }


    }



}