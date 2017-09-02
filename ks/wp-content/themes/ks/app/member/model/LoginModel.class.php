<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/25
 * Time: 15:38
 */

namespace app\member\model;


use entity\consumer\Consumer;
use libraries\db\Sql;

class LoginModel extends Sql
{
    
    /*查询用户*/
    public function userLogin($data){

        $consumer = new Consumer();
        return $this->table($this->getPrefix().$consumer->table)->where("c_login ='{$data['userName']}' or c_email = '{$data['userName']}'  or c_phone = '{$data['userName']}' ")->getRow()->select();

    }
    
    /*更新用户*/
    public function userUpdate($id,$object){
        return $this->where("c_id = $id")->update($object);
    }

    /*地址获取 rows*/
    public function getAddress($where){

        return $this->table($this->getPrefix().'address_list')->where($where)->select();

    }

}