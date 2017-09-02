<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:03
 */

namespace admin\activity\model;

use libraries\db\Sql;
use libraries\util\SkipPaging;

class ActivityModel extends Sql
{
    /*获取单条*/
    public function getOne($table,$where,$field='*'){
        return $this->field($field)->table($this->getPrefix().$table)->where($where)->getRow()->select();
    }

    /*添加数据*/
     function register($object){

        return $this->save($object,true);

    }

    /*更新数据*/
    public function businessUpdate($where,$object){
        return $this->where($where)->update($object);
    }
    
     /*删除*/
    public function remove($table,$where){
        return $this->table($this->getPrefix().$table)->where($where)->delete();
    }

    /*获取现金券申请记录*/
    public function getApplyRecord($sql){
        
        return $this->query($sql);
    }

    /*分页操作*/
    public function limitPage($table,$count,$where,$pagenum,$sort='id desc',$size='10'){

        //分页
        $paging = new SkipPaging();
        $paging->pagenum = $pagenum;
        $paging->sum = $count;
        $paging->limit = $size;

        $start = ( $paging->pagenum - 1 ) * $paging->limit;
        $content = $this->getList($table,$where,$sort,$start,$paging->limit);
        $link = $paging->linkClick();
       
        return array('content'=>$content,'link'=>$link);

    }

    /*分页查询*/
    public function getList($table,$where,$sort='id desc',$start=0,$size=10){
        return $this->table($this->getPrefix().$table)->where($where)->limit($start,$size)->order($sort)->select();
    }
}