<?php
//短信账户内容设置
add_action( 'wp_ajax_short_message_settings', 'default_short_message_settings' );
function default_short_message_settings(){
    $message = get_option('short_message_settings');
	if($_POST['type']=='del'){
		unset($message['content'][$_POST['flag']]);
		}else{
			
		if($_POST['user_name']){
			$message['user_name'] = $_POST['user_name'];
		}
		if($_POST['user_pwd']){
			$message['user_pwd'] = $_POST['user_pwd'];
		}
		if($_POST['flag']){
			$message['content'][$_POST['flag']] = array(
			'content'=>$_POST['content'],
			'sign'=>$_POST['sign']
			);
		}
	}
  
	$flag = update_option('short_message_settings',$message);
	if($flag){
		echo json_encode(array('flag'=>success,'content'=>'操作成功'));
	}else{
		echo json_encode(array('flag'=>error,'content'=>'此操作失败'));
	}
	exit;
}

//邮件账户内容设置
add_action( 'wp_ajax_smtp_send_settings', 'default_smtp_send_settings' );
function default_smtp_send_settings(){

    if($_POST){
        unset($_POST['action']);

        foreach($_POST as $value){
            if(empty($value)){
                exit(array('status'=>n,'info'=>'有空的内容'));
            }
        }

        $flag = update_option('smtp_send_settings',$_POST);

        if($flag){
            echo json_encode(array('flag'=>y,'info'=>'更新成功'));
        }else{
            echo json_encode(array('flag'=>n,'info'=>'更新失败'));
        }
    }
    exit;
}

//角色与默认权限添加
add_action( 'wp_ajax_role_add', 'default_role_add' );
function default_role_add(){

    foreach($_POST as $value){
        if(empty($value)){
            exit(json_encode(array('flag'=>n,'info'=>'有空值。')));
        }
    }

    if( current_user_can( 'role' ) ) {

        global $wp_roles;

        $role = $_POST['role'];
        $display_name = $_POST['display_name'];
        $role_s = $_POST['role_s'];

        $role_s_arr = array();

        foreach($role_s as $value){
            $role_s_arr[$value] = true;
        }

        $result = add_role( $role,$display_name , $role_s_arr);

        if( $result ){
            echo json_encode(array('flag'=>y,'info'=>'用户角色创建成功'));

        }else {
            echo json_encode(array('flag'=>n,'info'=>'因为用户角色已经存在或者其它原因导致创建失败'));

        }

    }

    exit;
}

//角色权限添加与删除
add_action( 'wp_ajax_role_jurisdiction_settings', 'default_role_jurisdiction_settings' );
function default_role_jurisdiction_settings(){

    $role = $_POST['role'];
    $check_role = $_POST['check_role'];
    $check = $_POST['check'];
    if($check_role && current_user_can( 'role' ) && $role && $check){
        global $wp_roles;

        if($check == 'y'){
            //添加角色权限
            $flag = '添加';
            $wp_roles->add_cap( $role, $check_role);
        }else{
            $flag = '取消';
            $wp_roles->remove_cap( $role, $check_role);
        }


        echo json_encode(array('flag'=>y,'info'=>'权限'.$flag.'成功'));

    }
    exit;
}

//角色删除
add_action( 'wp_ajax_role_delete', 'default_role_delete' );
function default_role_delete(){

    $role_name = $_POST['role_name'];
    if(current_user_can( 'role' ) && ($role_name != 'administrator')){
        global $wp_roles;

        $wp_roles->remove_role( $role_name );

        echo json_encode(array('flag'=>y,'info'=>'操作成功'));

    }
    exit;
}

//合作品牌信息设置
add_action('wp_ajax_short_partner_settings', 'short_partner_settings');
function short_partner_settings(){
    if($_POST){
        //$data = array('partner_name'=>$_POST['user_name'],'partner_url'=>$_POST['user_pwd'],'partner_img'=>$_POST['items_thumbnail']);
        if($_POST['flag']){
        foreach($_POST['flag'] as $key => $value){
            $data[$key]['partner_name'] = $value;
            if($_POST['sign']){
            foreach($_POST['sign'] as $key2 => $value2){
                $data[$key2]['partner_url'] = $value2;
                if($_POST['items_thumbnail']){
                foreach($_POST['items_thumbnail'] as $key3 => $value3){
                    $data[$key3]['items_thumbnail'] = $value3;
                }
                }
            }
            }

        }
        }
        $flag = update_option('short_partner_settings',$data);
        if($flag){
            echo json_encode(array('flag'=>y,'info'=>'更新成功'));
        }else{
            echo json_encode(array('flag'=>n,'info'=>'更新失败'));
        }
    }
   exit;
}

//支付设置
add_action( 'wp_ajax_pay_update', 'default_pay_update' );
function default_pay_update(){

    foreach ($_POST as $item) {
        if(empty($item)){
            exit(json_encode(array('flag'=>n,'info'=>'有空值')));
        }
    }
    $gsb = get_option('pay_Settings');

    if($gsb){
        $usb = update_option('pay_Settings',array_merge($gsb,array($_POST['subtab']=>$_POST)));
    }else{
        $usb = update_option('pay_Settings',array($_POST['subtab']=>$_POST));
    }
    if($usb){
        echo json_encode(array('flag'=>y,'info'=>'设置成功'));
    }else{
        echo json_encode(array('flag'=>n,'info'=>'设置失败'));
    }
    exit;
}