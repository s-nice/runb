<?php
/**
 * ���÷�ʽ����controller��
 * $kuaidi = new Kuaidi('1256879', 'd0cb36e1-7016-45b1-861a-d50d5cfc2dba');
 * $tracking = $kuaidi->getOrderTraces('YD', '1901280494608');
 */
 
class Kuaidi {
	private $ReqURL = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
	private $TestReqURL = 'http://api.kdniao.cc:8081/Ebusiness/EbusinessOrderHandle.aspx';
	private $ID = '1237100';  //����ID
	private $Key = '518a73d8-1f7f-441a-b644-33e77b49d846';  //����key

	public function __construct($id = '1237100', $key = '1237100') {  //Ĭ�ϲ���Ϊ����id�Ͳ���key��
		$this->ID = $id;
		$this->Key = $key;
		if ($id == '1237100') {
			$this->ReqURL = $this->TestReqURL;
		}
	}
	
	function getOrderTraces($shipperCode, $logisticCode){
		$json =  $this->getOrderTracesByJson($shipperCode, $logisticCode);
		
		$arr = json_decode($json, true);
		
		$traces = array();
		
		if (!(isset($arr['Traces']) && $arr['Traces'])) {
			$result = array(
					'company_code'  => $shipperCode,
					'express_no'    => $logisticCode,
					'message'       => $arr['Reason']
				);
		} else {
			foreach($arr['Traces'] as $trace){
				$traces[] = array(
						'time'    => $trace['AcceptTime'],
						'station' => $trace['AcceptStation']
					);
			}
			
			$result = array(
					'company_code'  => $arr['ShipperCode'],
					'express_no'    => $arr['LogisticCode'],
					'traces'        => $traces,
				);
		}
			
		return $result;
	}
	/**
	 * Json��ʽ ��ѯ���������켣
	 */
	function getOrderTracesByJson($shipperCode, $logisticCode){
		$requestData= "{\"OrderCode\":\"\",\"ShipperCode\":\"".$shipperCode."\",\"LogisticCode\":\"".$logisticCode."\"}";
		$datas = array(
				'EBusinessID' => $this->ID,
				'RequestType' => '1002',
				'RequestData' => urlencode($requestData) ,
				'DataType' => '2', //1������xml��ʽ��2������json��ʽ
			);
		$datas['DataSign'] = $this->encrypt($requestData, $this->Key);
		$result = $this->sendPost($this->ReqURL, $datas);	
		
		//���ݹ�˾ҵ�����ص���Ϣ......
		
		return $result;
	}
	
	/**
	 * XML��ʽ ��ѯ���������켣
	 */
	function getOrderTracesByXml($shipperCode, $logisticCode){
		$requestData= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>".
							"<Content>".
							"<OrderCode></OrderCode>".
							"<ShipperCode>" . $shipperCode . "</ShipperCode>".
							"<LogisticCode>" . $logisticCode . "</LogisticCode>".
							"</Content>";
		
		$datas = array(
				'EBusinessID' => $this->ID,
				'RequestType' => '1002',
				'RequestData' => urlencode($requestData) ,
				'DataType' => '1', //1������xml��ʽ��2������json��ʽ
			);
		$datas['DataSign'] = $this->encrypt($requestData, $this->Key);
		$result = $this->sendPost($this->ReqURL, $datas);	
		
		//���ݹ�˾ҵ�����ص���Ϣ......
		
		return $result;
	}
	 
	/**
	 *  post�ύ���� 
	 * @param  string $url ����Url
	 * @param  array $datas �ύ������ 
	 * @return url��Ӧ���ص�html
	 */
	function sendPost($url, $datas) {
		$temps = array();	
		foreach ($datas as $key => $value) {
			$temps[] = sprintf('%s=%s', $key, $value);		
		}	
		$post_data = implode('&', $temps);
		$url_info = parse_url($url);
		$httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
		$httpheader.= "Host:" . $url_info['host'] . "\r\n";
		$httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
		$httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
		$httpheader.= "Connection:close\r\n\r\n";
		$httpheader.= $post_data;
		$fd = fsockopen($url_info['host'], 80);
		fwrite($fd, $httpheader);
		$gets = "";
		$headerFlag = true;
		while (!feof($fd)) {
			if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
				break;
			}
		}
		while (!feof($fd)) {
			$gets.= fread($fd, 128);
		}
		fclose($fd);    
		
		return $gets;
	}
	
	/**
	 * ����Signǩ������
	 * @param data ����   
	 * @param appkey Appkey
	 * @return DataSignǩ��
	 */
	function encrypt($data, $appkey) {
		return urlencode(base64_encode(md5($data.$appkey)));
	}

	function log_result($word) {
		
		$fp = fopen(DIR_LOGS ."log_kuaidi.txt","a");	
		flock($fp, LOCK_EX) ;
		fwrite($fp,$word."::Date��".strftime("%Y-%m-%d %H:%I:%S",time())."\t\n");
		flock($fp, LOCK_UN); 
		fclose($fp);
		
	}
}
?>