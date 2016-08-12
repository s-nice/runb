<?php
class Sms {
	private $plant;
	private $params;
	private $controller;

	public function __construct() {
		//������ʷԭ��Ϊ�˼������������ĵ��ã�ʵ����������������ʱ��֮�����������
		$args = func_get_args();   
		if(count($args) == 1) {   
			$controller = $args[0];   
		} else if(count($args) == 3) {   
			$controller =  $args[2];   
		}
		
		$this->controller = $controller;
		if ($this->controller->config->get('config_c123_plant') == 'yunpian') {
			require_once(DIR_SYSTEM . 'library/sms/yunpian/SmsOperator.php');
			
			$this->plant = new SmsOperator($controller->config->get('config_c123_ac'), $controller->config->get('config_c123_authkey'));
		} else {
			$class = 'sms\\' . $controller->config->get('config_c123_plant');
			if (class_exists($class)) {
				$this->plant = new $class($controller);
			} else {
				exit('Error: Could not load sms library ' . $class . '!');
			}
		}
	}
	
	/*
	* ������Ϣ���ݺ�Ҫ���͵����ֻ����룬�ֻ������ԷֺŸ�������Ϣ����Ϊutf8��ʽ���粻����ת����utf8��ʽ
	*/
	public function setParams($msg, $mobile) {
		$this->log_result("set params");
		if ($this->controller->config->get('config_c123_plant') == 'yunpian') {
			$this->params = array(
				'text'    => $msg,
				'mobile'    => $mobile
			);
		} else {
			$this->plant->setParams($msg, $mobile);
		}
	}

	/*
	* ���Ͷ���
	*/
	public function send() {
		$this->log_result("send message");
		if ($this->controller->config->get('config_c123_plant') == 'yunpian') {
			$result = $this->plant->single_send($this->params);
			if ($result->responseData['code'] > 0) {
				return $result->responseData['code'] . ': ' . $result->responseData['detail'];
			} else {
				return true;
			}
		} else {
			return $this->plant->send();
		}
	}

	function  log_result($word) {
		
		$fp = fopen(DIR_LOGS ."sms_log.txt","a");	
		flock($fp, LOCK_EX) ;
		fwrite($fp,$word."::Date��".strftime("%Y-%m-%d %H:%I:%S",time())."\t\n");
		flock($fp, LOCK_UN); 
		fclose($fp);
		
	}
}
