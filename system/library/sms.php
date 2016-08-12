<?php
class Sms {
	private $plant;
	private $params;
	private $controller;

	public function __construct() {
		//由于历史原因，为了兼容三个参数的调用，实际上三个参数调用时，之后第三个有用
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
	* 设置消息内容和要发送到的手机号码，手机号码以分号隔开，消息内容为utf8格式，如不是需转换成utf8格式
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
	* 发送短信
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
		fwrite($fp,$word."::Date：".strftime("%Y-%m-%d %H:%I:%S",time())."\t\n");
		flock($fp, LOCK_UN); 
		fclose($fp);
		
	}
}
