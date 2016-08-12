<?php
/*
	获取数据库信息
*/
require_once('../config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Settings
$query = $db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE code = 'upop' ");
foreach($query->rows as $result){
	$config->set($result['key'], $result['value']);
}


//upop订单状态
$order_status_id = $config->get('upop_order_status_id');


include_once 'func/common.php';
include_once 'func/secureUtil.php';
?>
<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>响应页面</title>

<style type="text/css">
body table tr td {
	font-size: 14px;
	word-wrap: break-word;
	word-break: break-all;
	empty-cells: show;
}
</style>
</head>
<body>
	<table width="800px" border="1" align="center">
		<tr>
			<th colspan="2" align="center">响应结果</th>
		</tr>
	
			<?php
			
			// 初始化日志
			$log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
			$log->LogInfo ( "============BackReceive.php处理ajax开始===============" );
			
			
			foreach ( $_POST as $key => $val ) {
				
				$log->LogInfo ( $key . '-' .$val );
				
				?>
			<tr>
			<td width='30%'><?php echo isset($mpi_arr[$key]) ?$mpi_arr[$key] : $key ;?></td>
			<td><?php echo $val ;?></td>
		</tr>
			<?php }?>
			<tr>
			<td width='30%'>验证签名</td>
			<td><?php			
			if (isset ( $_POST ['signature'] )) {
				
				echo verify ( $_POST ) ? '验签成功' : '验签失败';
				
				$log->LogInfo (verify ( $_POST ));
				
				$orderId = $_POST ['reqReserved']; //其他字段也可用类似方式获取
				
				//更新订单的状态
				$db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '".$order_status_id."' WHERE order_id = '".$orderId."' ");
				
				
			} else {
				//echo '签名为空';
				$log->LogInfo ('签名为空');
			}
			
			
			$log->LogInfo ( "============BackReceive.php处理ajax结束===============" );
			
			?></td>
		</tr>
	</table>
</body>
</html>
