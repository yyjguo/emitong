<?php
session_start();
/**
 * Description: 
 *
 * Author: Yip
 * Date: 14-3-23 下午7:20
 */

$msg = array(
	'tips' => 'none',
	'success' => 0
);
$name = $_POST["name"];
$pwd = $_POST["pwd"];
//$name = "yyp";
//$pwd = "yip";

if ("" != $name && "" != $pwd) {
	$array1 = explode("'", $name);
	$array2 = explode("'", $pwd);
	if( 1 == count($array1) && 1 == count($array2) ) {

		require_once("Util/MySQLUtil.php");
		$admin = MySQLUtil::getAdmin($name);
		//管理员登录验证
		//print_r($admin);

//		$msg['name'] = $name;
//		$msg['pwd'] = $pwd;
		if (null == $admin) {
			//todo
			$msg['tips'] = "error: 用户不存在！";
			$msg['success'] = 0;
		}
		else {
			if(md5($pwd) == $admin->getAdminPwd()) {
				//todo 成功登录处理
				$msg['tips'] = "ok!";
				$msg['success'] = 1;
				$_SESSION["flag"] = 1;
				$_SESSION["username"] = $name;

			}
			else {
				//todo
				$msg['tips'] = "error: 密码错误！";
				//$msg['success'] = 0;
			}
		}

	}
	else {
		$msg['tips'] = "error: 信息错误！";
		//$msg['success'] = 0;
	}
}
else {
	$msg['tips'] = "error: 信息错误！";
	//$msg['success'] = 0;
}

echo json_encode($msg);
