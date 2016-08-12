<?php
/**
 * 调用方式，在controller中
 * $kuaidi = new Kuaidi100('', 'd0cb36e1-7016-45b1-861a-d50d5cfc2dba');
 * $tracking = $kuaidi->getOrderTraces('yunda', '1901280494608'); 
 */
 
class Kuaidi100 {
	private $ReqURL = 'http://api.kuaidi100.com/api';
	private $Key = '';

	public function __construct($id = '', $key = '') {  //对于快递100，没有id只有key，此处只是为了跟快递鸟的接口统一，所以id传空即可。
		$this->Key = $key;
	}
	
	/**
	 * 查询订单物流轨迹
	 * $type: 0返回json, 1返回xml, 2返回html, 3返回text
	 */
	function getOrderTraces($shipperCode, $logisticCode, $type = 0){
		$url = $this->ReqURL . '?id=' . $this-> Key . '&com=' . $shipperCode.'&nu=' . $logisticCode . '&show=' . $type . '&muti=1&order=asc';
		
		//优先使用curl模式发送数据
		if (function_exists('curl_init') == 1){
		  $curl = curl_init();
		  curl_setopt ($curl, CURLOPT_URL, $url);
		  curl_setopt ($curl, CURLOPT_HEADER,0);
		  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
		  $json = curl_exec($curl);
		  curl_close ($curl);
		}else{
		  include("snoopy.php");
		  $snoopy = new snoopy();
		  $snoopy->referer = 'http://www.google.com/';//伪装来源
		  $snoopy->fetch($url);
		  $json = $snoopy->results;
		}
		
		$arr = json_decode($json, true);

		$traces = array();
		
		if (!isset($arr['data'])) {
			$result = array(
					'company_code'  => $shipperCode,
					'express_no'    => $logisticCode,
					'message'       => $arr['message']
				);
		} else {
			foreach($arr['data'] as $trace){
				$traces[] = array(
						'time'    => $trace['time'],
						'station' => $trace['context']
					);
			}
			
			$result = array(
					'company_code'  => $arr['com'],
					'express_no'    => $arr['nu'],
					'traces'        => $traces,
				);
		}
		
		return $result;
	}
	
	function log_result($word) {
		
		$fp = fopen(DIR_LOGS ."log_kuaidi.txt","a");	
		flock($fp, LOCK_EX) ;
		fwrite($fp,$word."::Date：".strftime("%Y-%m-%d %H:%I:%S",time())."\t\n");
		flock($fp, LOCK_UN); 
		fclose($fp);
		
	}
}
?>