<?php

namespace libraries\util;

use admin\order\action\OrderAction;
use app\consumer\model\MessageModel;
use app\consumer\model\MyorderModel;
use app\store\action\ItemsAction;
use entity\orders\Orders;
use entity\orders\OrdersItems;
class orderexcel{
    public function excelGenerate($data){
        $order_meta = array(
            'use_integral'=>'use_integral',
            'address'=>'address',
            'OrderPostage'=>'OrderPostage',
            'feedback_integral'=>'feedback_integral',
            'orderNotes' => 'orderNotes',
            'remark' => 'remark'
        );
		header("Content-Type: text/html;charset=utf-8");
        $meModel = new MessageModel();
		$orderAc = new OrderAction();
        $px =  $meModel->getPrefix();
        $order = new Orders();
		if(isset($data['ids'])){
			$incomSql = "and a.o_id in({$data['ids']}) ";
			$SqlUser = "SELECT a.*,b.*,d.meta_value as nickName
                FROM {$px}orders as a
                inner join {$px}consumer as b
                on  a.user_id = b.c_id {$incomSql} 
                left join {$px}consumer_meta as d 
                on a.user_id = d.c_id
                and d.meta_key = 'nickName'";
		}else{
        $data['startDate'] = $data['mid'];
        $data['endDate'] = $data['mxd'];
        if($data['cid']){
        $order->user_id = $data['cid'];
        }
        
       
        //$order->o_status = array("o_status <> 'cancel' ");
        if(!empty($_GET['status']) && $_GET['status'] != 'allCount'){
            $status = $_GET['status'];
            $statusSql = "and a.o_status = '{$status}'";
        }
        if(!empty($data['startDate']) && !empty($data['endDate'])){
            $startDate = strtotime($data['startDate']);
            $endDate = strtotime($data['endDate']);

            if($startDate>$endDate){
                $data['startDate'] = $endDate;
                $data['endDate'] = $startDate;
            }
            //$order->o_time = array("o_time >= $startDate and  o_time <= $endDate ");
            $otsql = "and a.o_time >= $startDate and  a.o_time <= $endDate ";
        }else{
            if(!empty($data['startDate'])){
                $startDate = strtotime($data['startDate']);
               // $order->o_time = array("o_time >= $startDate");
                $otsql = "and a.o_time >= $startDate";
            }
            if(!empty($data['endDate'])){
                $endDate = strtotime($data['endDate']);
                //$order->o_time = array("o_time <= $endDate");
                $otsql = "and a.o_time <= $endDate";
            }
        }
		
//        $SqlUser = "SELECT a.*,b.*,c.meta_value as address,d.meta_value as nickName
//                FROM {$px}orders as a
//                inner join {$px}consumer as b
//                on  a.user_id = b.c_id {$otsql}
//                left join {$px}order_meta as c
//                on c.o_id = a.o_id
//                and c.meta_key = 'address'
//                left join {$px}consumer_meta as d
//                on a.user_id = d.c_id
//                and d.meta_key = 'nickName'";


        $SqlUser = "SELECT a.*,b.*,d.meta_value as nickName
                FROM {$px}orders as a
                inner join {$px}consumer as b
                on  a.user_id = b.c_id {$otsql} {$statusSql}
                left join {$px}consumer_meta as d 
                on a.user_id = d.c_id
                and d.meta_key = 'nickName'";
	}


        $getOrder = $meModel->query($SqlUser);
        //$getOrder = $meModel->selectObject($order);
        $items_action = new ItemsAction();//商品外键表
        $order_items = new OrdersItems();
        /**
         * 循环获取订单项中的信息
         */

        foreach($getOrder as $key => $value){

            foreach($order_meta as $k => $meta_v){
                $metaSql = "SELECT meta_value,meta_key FROM {$px}order_meta where meta_key = '{$meta_v} 'and o_id = {$value['o_id']}";

                $res = $meModel->query($metaSql);
                //var_dump($res);
                //if(!empty($res)){
                    $usc[$k] = $res;
               // }
            }
            $flag = '';
            $SQL = "SELECT a.*,b.i_id,c.meta_value as img
                FROM {$px}orders_items as a
                inner join {$px}items_variables as b
                on  a.i_id = b.i_v_id
                and  a.o_id = {$value['o_id']}
                left join {$px}items_meta as c
                on c.i_id = b.i_id
                and meta_key = 'items_thumbnail'";

            $flag = $meModel->query($SQL);

            $SQL = "SELECT * FROM {$px}orders_items where o_id = {$value['o_id']} and i_id='0'";
            $other = $meModel->query($SQL);
            if($other){
                $flag = array_merge($flag,$other);//其他费用
            }

            $getOrder[$key]['order_itmes'] = $flag;
            $getOrder[$key]['order_metas'] = $usc;

        }
        if(!$getOrder){

            exit(json_encode(array('status'=>'n','info'=>'error:The exported data does not exist')));
        }

        /*准备导出*/

        $excelName = 'orderlList';//名称
        header("Content-Type: application/vnd.ms-execl");
        header("Content-Type: application/vnd.ms-excel; charset=utf8");
        header("Content-Disposition: attachment; filename=$excelName.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        header('Content-Length: ');
        ?>
        <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>无标题文档</title>
                <!--[if gte mso 9]><xml>
                    <x:ExcelWorkbook>
                        <x:ExcelWorksheets>
                            <x:ExcelWorksheet>
                                <x:Name>Sheet1</x:Name>
                                <x:WorksheetOptions>
                                    <x:DefaultRowHeight>285</x:DefaultRowHeight>
                                    <x:Selected/>
                                    <x:Panes>
                                        <x:Pane>
                                            <x:Number>3</x:Number>
                                            <x:ActiveRow>3</x:ActiveRow>
                                            <x:ActiveCol>2</x:ActiveCol>
                                        </x:Pane>
                                    </x:Panes>
                                    <x:ProtectContents>False</x:ProtectContents>
                                    <x:ProtectObjects>False</x:ProtectObjects>
                                    <x:ProtectScenarios>False</x:ProtectScenarios>
                                </x:WorksheetOptions>
                            </x:ExcelWorksheet>

                        </x:ExcelWorksheets>
                        <x:WindowHeight>9600</x:WindowHeight>
                        <x:WindowWidth>15075</x:WindowWidth>
                        <x:WindowTopX>480</x:WindowTopX>
                        <x:WindowTopY>90</x:WindowTopY>
                        <x:ProtectStructure>False</x:ProtectStructure>
                        <x:ProtectWindows>False</x:ProtectWindows>
                    </x:ExcelWorkbook>
                </xml><![endif]-->
                <style>
                    .style0{
                        mso-number-format:General;
                        text-align:general;
                        vertical-align:bottom;
                        white-space:nowrap;
                        mso-rotate:0;
                        mso-background-source:auto;
                        mso-pattern:auto;
                        color:windowtext;
                        font-size:12.0pt;
                        font-weight:400;
                        font-style:normal;
                        text-decoration:none;
                        font-family:宋体;
                        mso-generic-font-family:auto;
                        mso-font-charset:134;
                        border:none;
                        mso-protection:locked visible;
                        mso-style-name:常规;
                        mso-style-id:0;
                    }
                    td{
                        text-align:center;
                        mso-style-parent:style0;
                        mso-number-format:"\@";  //设置其数值为默认字符串
                    }
                </style>
            </head>
            <body border="1">
            <table width='800' border="1">
                <tr>
                    <td class='title' style="background-color:darkkhaki;">订单编号</td>
                    <td class='title' style="background-color:darkkhaki;">下单人姓名</td>
                    <td class='title' style="background-color:darkkhaki;">下单人电话</td>
                    <td class='title' style="background-color:darkkhaki;">收货人姓名</td>
                    <td class='title' style="background-color:darkkhaki;">收货人电话</td>
                    <td class='title' style="background-color:darkkhaki;">收货人地址</td>
                    <td class='title' style="background-color:darkkhaki;">订单生成时间</td>
                    <td class='title' style="background-color:darkkhaki;">总价</td>
                    <td class='title' style="background-color:darkkhaki;">邮费</td>
                    <td class='title' style="background-color:darkkhaki;">使用积分</td>
                    <td class='title' style="background-color:darkkhaki;">返现金额</td>
                    <td class='title' style="background-color:darkkhaki;">订单详情</td>
                    <td class='title' style="background-color:darkkhaki;">商品规格</td>
                    <td class='title' style="background-color:darkkhaki;">单项单价</td>
                    <td class='title' style="background-color:darkkhaki;">单项数量</td>
                    <td class='title' style="background-color:darkkhaki;">单项总价</td>
                    <td class='title' style="background-color:darkkhaki;">订单状态</td>
                    <td class='title' style="background-color:darkkhaki;">客服备注</td>
                    <td class='title' style="background-color:darkkhaki;">用户备注</td>
                </tr>
                <?php



                //print_r($rows);
                //var_dump($rows);exit;

                $stipulate_count = 10000;//添加输出数
                //$the_stipulate_count = 10000;//规定输出数
				
				
                //获取总数
                $data_count = count($getOrder);
                //获取总页数
                $pagenum=ceil($data_count/$stipulate_count);
                $i = 0;
                while($i < $pagenum){
                    //获取开始索引
                    $j = $i * $stipulate_count;
                    //获取结束索引
                    $end = $j+$stipulate_count;
                    for($k=$j;$k<$end;++$k){
                        if($getOrder[$k]['o_title'] != '购物车'){
                            ?>
                            <?php
                            if($getOrder[$k]['order_itmes']){
                                $itemsCount = count($getOrder[$k]['order_itmes'])-1;
                                $con = 0;
                                foreach ($getOrder[$k]['order_itmes'] as $ok => $values) {?>
                                        <tr>
                                            <td><?= $getOrder[$k]['order_number'];?></td>
                                            <td>
                                                <?= $getOrder[$k]['nickName'] ? $getOrder[$k]['nickName'] : 'customer'.$getOrder[$k]['user_id'];?><br />
                                            </td>
                                            <td><?= $getOrder[$k]['c_phone'];?><br /></td>
                                            <td>
                                                <?php
                                                if($getOrder[$k]['order_metas']['address']){
                                                    $address = unserialize($getOrder[$k]['order_metas']['address'][0]['meta_value']);
                                                }
                                                ?>
                                                <?= $address['c_ad_name'];?><br />
                                            </td>
                                            <td><?= $address['c_ad_phone'];?><br /></td>
                                            <td> <?= $address['c_ad_province'].$address['c_ad_city'].$address['c_ad_county'].$address['c_ad_details'];?><br /></td>
                                            <td><?= $getOrder[$k]['o_total'] ? date('Y-m-d H:m:s',$getOrder[$k]['o_time']) : '';?></td>
                                            <td style="vnd.ms-excel.numberformat:#,##0.00">
                                                <?php
                                                if($con < 1){
                                                echo $getOrder[$k]['o_total'].'<br />';
                                               }
                                                ?>
                                            </td>
                                            <td style="vnd.ms-excel.numberformat:#,##0.00">
                                                <?php
                                                if($con < 1){
                                                    if($getOrder[$k]['order_metas']['address']){
                                                        $OrderPostage = $getOrder[$k]['order_metas']['OrderPostage'][0]['meta_value'];
                                                        echo  $OrderPostage.'<br />';
                                                    }

                                                }
                                                ?>
                                            </td>
                                            <td style="vnd.ms-excel.numberformat:#,##0.00">
                                                <?php
                                                if($con < 1){
                                                    if($getOrder[$k]['order_metas']['use_integral']){
                                                        $use_integral = $getOrder[$k]['order_metas']['use_integral'][0]['meta_value'];
                                                        echo  $use_integral.'<br />';
                                                    }

                                                }
                                                ?>
                                            </td>
                                            <td style="vnd.ms-excel.numberformat:#,##0.00">
                                                <?php
                                                if($con < 1){
                                                    if($getOrder[$k]['order_metas']['feedback_integral']){
                                                        $feedback_integral = $getOrder[$k]['order_metas']['feedback_integral'][0]['meta_value'];
                                                        echo  $feedback_integral.'<br />';
                                                    }

                                                }
                                                ?>
                                            </td>
                                            <td><?= $values['o_i_title']?></td>
                                            <td><?= $values['o_i_content']?></td>
                                            <td style="vnd.ms-excel.numberformat:#,##0.00"><?= $values['o_i_price']?></td>
                                            <td style="vnd.ms-excel.numberformat:#,##0.00"><?= $values['o_i_count']?></td>
                                            <td style="vnd.ms-excel.numberformat:#,##0.00"><?= $values['o_i_count']*$values['o_i_price'].'.00'?></td>
                                            <td><?= $orderAc->order_status($values['o_i_status']) ? $orderAc->order_status($values['o_i_status']) : '';?></td>
                                            <td><?php
                                                if($con < 1){
                                                    if($getOrder[$k]['order_metas']['orderNotes']){
                                                        $orderNotes = $getOrder[$k]['order_metas']['orderNotes'][0]['meta_value'];
                                                        echo  $orderNotes.'<br />';
                                                    }
                                               }
                                                ?></td>
                                            <td><?php
                                                if($con < 1){
                                                    if($getOrder[$k]['order_metas']['remark']){
                                                        $orderRemark = $getOrder[$k]['order_metas']['remark'][0]['meta_value'];
                                                        echo  $orderRemark.'<br />';
                                                    }
                                                }
                                                ?></td>
                                        </tr>

                                <?php $con++;  }
                            }?>
                        <?php
//                            if($k == $data_count){
//                                break;
//                            }
                        }

                    }
                    $i ++;
                }

                ?>
            </table>
            </body>
        </html>
    <?php
    }
}

