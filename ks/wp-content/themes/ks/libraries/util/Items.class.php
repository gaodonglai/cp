<?php

/**
 * items
 * User: ijita
 * Date: 2016/3/10
 * Time: 10:10
 */
namespace libraries\util;
class Items
{
    /**
     * 单个产品
     */
    public function __construct()
    {
        $this->action = new \libraries\controller\Action();
    }

    public function ItemsLi($v,$collection){

        $this->action->collection = $collection;

        $this->action->v = $v;
        $this->action->display('store/items/itemsLi');
    }
    public function homeItemsList($v){

        $this->action->v = $v;
        $this->action->display('store/items/homeItemsList');
    }
}