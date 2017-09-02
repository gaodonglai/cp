<?php
    require '../../../../wp-load.php';

    //use libraries\util\publicFunction;
    require_once './publicFunction.class.php';
    require_once './StringNew.class.php';
    $publicClass = new \libraries\util\publicFunction();
    /*
     * 现金券生成
     * */
    $parValue = $_POST['parValue']; //面值
    $number = $_POST['number']; //数量
	$login = $_POST['bId']; //企业ID
 
	$time = date('ym');//表后缀时间

	$company_code = $publicClass->dispRepair($login,4,0).'_'.$time;
	
	//创建企业用户对应的现金券表
	global $wpdb;
	$table_name = $wpdb->prefix . "integral_"."$company_code";  //获取表前缀，并设置新表的名称

	if($wpdb->get_var("show tables like '{$table_name}'") != $table_name) {  //判断表是否已存在

		//创建表
		$sql = "CREATE TABLE " . $table_name . " (
		  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '主键',
		  `bId` int(20) NOT NULL COMMENT '企业ID',
		  `parValue` int(20) NOT NULL COMMENT '面值',
		  `randCode` varchar(10) NOT NULL COMMENT '随机码',
		  `randIncode` varchar(6) NOT NULL COMMENT '验证码',
		  `timeCode` bigint(5) NOT NULL COMMENT '生成月份',
		  `verify` bigint(2) NOT NULL DEFAULT 2 COMMENT '是否验证',
		  `lastTime` int(20) NOT NULL  COMMENT '最后验证时间',
		  `storageTime` int(20) NOT NULL COMMENT '生成时间',
		  UNIQUE KEY id (id)
		  )ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
		require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
		$db_result = dbDelta($sql);
	
		if(empty($db_result[$table_name])){
			exit(json_encode(array('status'=>'n')));
		} 
 
	}



	function set_sym($count,$table_name,$time,$parValue,$login){
		global $wpdb;
        $StringClass = new \libraries\util\StringNew();
        $create_time = time();//字段生成时间
		for($j=0; $j < $count; $j++) {
			 
			 //得到随机码
			 $randNum = $StringClass->randString(4,1);
			 //$randNum = dispRepair($randNum,4,0);

			 //得到内码随机码
			 $in_randNum = $StringClass->randString(6,1);
			 //$in_randNum = dispRepair($in_randNum,6,0);

			 //插入数据
			if($j==0){
	 
				$sql = "INSERT INTO $table_name ( `bId`,`parValue`,`randCode`, `randIncode`,`timeCode`,`storageTime`) VALUES ( $login,$parValue,'{$randNum}','{$in_randNum}',$time,$create_time)";

			}else{
				$sql .= ",($login,$parValue,'{$randNum}','{$in_randNum}',$time,$create_time)";
			}
 
			
		}
        //var_dump($sql);exit;
		return $wpdb->query($sql);
		
	}
	
	

	$wpdb->query('START TRANSACTION'); //开启事务
 

	$setting_count = 100000;//设置条数
	$get_count = ceil($number/$setting_count);//得到的条数
 
	//如果get_count大于0代表插入数量大一十万
	$surplus_count = $number % $setting_count;
	
	for($i=$get_count; $i > 0; $i--) 
	{
		if($i == 1 && $surplus_count>0) $setting_count = $surplus_count;
		
		$result = set_sym($setting_count,$table_name,$time,$parValue,$login);
		if(!$result){
			$result = false;
			break;
		}
	}

	//print_r($result.'----'.$number);exit;
	if($result && $result == $number){
		
		$wpdb->query("COMMIT");//提交事务

		/*保存申请记录*/

		$re = $wpdb->insert($wpdb->prefix.'integral_apply_record',array('bid'=>$login,'timeCode'=>$time,'parValue'=>$parValue,'num'=>$number,'time'=>time()));
		if($re)	{
			echo json_encode(array('status'=>'y','url'=>admin_url('?page=business&type=integralList&bId=').$_POST['bId']));
		}else{
			echo json_encode(array('status'=>'n','info'=>'生成失败'));
		}


	}else{
		$wpdb->query("ROLLBACK");//回滚事务

        echo json_encode(array('status'=>'n','info'=>'请尝试将数量调整到2W5以下提交'));

	}
	
	$wpdb->query('END');//结束事务


	exit;
?>

