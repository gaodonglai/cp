<?php

namespace libraries\util;

use app\consumer\model\MessageModel;
use app\consumer\model\MyorderModel;
class excel{

    public function excelGenerate($data){ 
        $meModel = new MessageModel();
        $orModel = new MyorderModel();
        $publicClass = new publicFunction();

        $bId = $publicClass->dispRepair($data['bId'],4,0);
        $business = $orModel->getOne('business',"id = {$data['bId']}");
        $table = 'integral_'.$bId.'_'.$data['timeCode'];
        
        header("Content-Type: text/html;charset=utf-8");

        $sql = "bId = $bId and timeCode = {$data['timeCode']}";

        if(!empty($data['startDate']) && !empty($data['endDate'])){
            $startDate = strtotime($data['startDate']);
            $endDate = strtotime($data['endDate']);

            if($startDate>$endDate){
                $data['startDate'] = $endDate;
                $data['endDate'] = $startDate;
            }

            $sql .= " and storageTime >= $startDate and  storageTime <= $endDate ";
        }else{

            if(!empty($data['startDate'])){

                $startDate = strtotime($data['startDate']);

                $sql .= " and storageTime = $startDate";
            }
               
            if(!empty($data['endDate'])){

                $endDate = strtotime($data['endDate']);

                $sql .= " and storageTime = $endDate";
            }


        }
        

        if(isset($data['parValue']) && $data['parValue'] != 'all'){
            $sql .= " and parValue = {$data['parValue']} ";
            $parValue = $data['parValue'].'CNY';
        }

        
        $total = $meModel->countVar($table,$sql,"COUNT(id) AS num");

        /*var_dump('代码优化中,暂停使用');
        var_dump($total);exit;
        $rows = $meModel->getAll($table,$sql);*/

        if($total==0){
            
            exit('数据为空,请换个时间点尝试...');
        }

        /*准备导出*/

        $excelName = integralList.'-'.$data['timeCode'].'-'.$parValue;//名称

        header("Content-Type: application/vnd.ms-execl");
        header("Content-Type: application/vnd.ms-excel; charset=utf8");
        header("Content-Disposition: attachment; filename=$excelName.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        //header('Content-Length: ');
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
                    <td class='title' style="background-color:darkkhaki;">面值</td>
                    <td class='title' style="background-color:darkkhaki;">兑换码</td>
                    <td class='title' style="background-color:darkkhaki;">防伪码</td>
                    <td class='title' style="background-color:darkkhaki;">二维码链接</td>
                </tr>
                <?php



                //print_r($rows);
                //var_dump($rows);exit;

                $stipulate_count = 10000;//添加输出数
                //$the_stipulate_count = 10000;//规定输出数

                //获取总数
               // $data_count = count($rows);
                //获取总页数
                $pagenum=ceil($total/$stipulate_count);

                $i = 0;
                //var_dump($data_count);
                //var_dump($rows);
                $fix = $meModel->getPrefix();
                while($i < $pagenum){

                    //获取开始索引
                    $j = $i * $stipulate_count;
                    $newSql = "select id,parValue,timeCode,randCode,randIncode from {$fix}$table where $sql limit $j,$stipulate_count";
                    
                    $rows = $meModel->query($newSql,ARRAY_A);
                    if($rows){
                        foreach ($rows as $key => $row) {

                            $integralCode = $row['timeCode'].$bId.$row['randCode'].$publicClass->dispRepair($row['id'],8,0);
                            $param = base_encode($integralCode);
                            ?>
                            <tr>
                                <td><?=$row['parValue'];?></td>
                                <td><?=$integralCode;?></td>
                                <td><?=$row['randIncode']?></td>
                                <td><?='http://'.$_SERVER['HTTP_HOST'].'/integral/integral?param='.$param?></td>
                            </tr>
                        <?php
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

