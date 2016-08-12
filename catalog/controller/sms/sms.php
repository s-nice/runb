<?php 
require_once(DIR_SYSTEM . 'library/sms.php');
class ControllerSmsSms extends Controller { 
	public function index() {
		$json = array();
		
		//$this->load->model('sms/sms');
		$tel = $this->request->post['tel'];

		if (!$json) {					
			if ((utf8_strlen($tel) != 11) || !preg_match('/^\d{10,13}$/', $tel)) {
				$json = array(
					'error'            => $this->language->get('error_tel')		
				);
			}
    	$this->load->language('sms/sms');
			$this->load->model('account/customer');
			if ($this->model_account_customer->getTotalCustomersByTelephone($tel)) {
				$json = array(
					'error'            => $this->language->get('error_tel_exists')		
				);
			}
		}
		
		$code = mt_rand(100000,999999); //生成校验码
		setcookie('smscode', $code, time() + 600, '/');
		setcookie('tel', $tel, time() + 600, '/');
		//$this->session->data['smscode'] = $code;
		//$this->session->data['tel'] = $tel;
		
		$this->load->language('sms/sms');
		//$msg = sprintf($this->language->get('entry_smsmsg'), $this->config->get('config_name'), $code);
		$msg = sprintf($this->language->get('entry_smsmsg'), $code);
		$this->log_result("发送消息：".$msg);
		
		if (!$json) {
			require_once(DIR_SYSTEM . 'library/sms.php');
			$sms = new Sms($this->config->get('config_c123_ac'), $this->config->get('config_c123_authkey'), $this);
			$sms->setParams($msg, $tel);
			$ret = $sms->send();
			if($ret === true){
				$this->log_result("发送成功");
				$json = array(
					'status'            => 'success'		
				);
			}else{
				$this->log_result("发送失败,".$ret);
				$json = array(
					'status'            => 'fail',
					'msg'               => 'Fail: ' . $ret
				);
			}
		}
			
		$this->response->setOutput(json_encode($json));
	}	

	/*  日志消息,把反馈的参数记录下来*/	
	function  log_result($word) {
		
		$fp = fopen(DIR_LOGS . "log_sms_" . strftime("%Y%m%d",time()) . ".txt","a");	
		flock($fp, LOCK_EX) ;
		fwrite($fp,$word."::Date：".strftime("%Y-%m-%d %H:%I:%S",time())."\t\n");
		flock($fp, LOCK_UN); 
		fclose($fp);
		
	}

}
?>