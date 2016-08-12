<?php
class Ihuyi {
	private $URL='http://106.ihuyi.cn/webservice/sms.php?method=Submit';
	private $params;

	public function __construct($controller) {
		$this->params = array(
			'account'  => $controller->config->get('config_c123_ac'),					                         //�û��˺�
			'password' => $controller->config->get('config_c123_authkey'),	                             //��֤��Կ
			'mobile'   => '',		                                     //����,��������ö��Ÿ���
			'content'  => '',  //iconv('gbk','utf-8',$c),		                 //���ҳ����gbk���룬��ת��utf-8���룬�����ҳ����utf-8���룬����Ҫת��
		);
	}
	
	/*
	* ������Ϣ���ݺ�Ҫ���͵����ֻ����룬�ֻ������ԷֺŸ�������Ϣ����Ϊutf8��ʽ���粻����ת����utf8��ʽ
	*/
	public function setParams($msg, $mobile) {
		$this->params["mobile"] = trim($mobile);
		$this->params["content"] = trim($msg);
	}


	/*
	* ����״̬˵����
	* 1 �����ɹ�
	* 0 �ʻ���ʽ����ȷ(��ȷ�ĸ�ʽΪ:Ա�����@��ҵ���)
	* -1 �������ܾ�(�ٶȹ��졢��ʱ���IP���Ե�)�����ٶȹ������ʱ�ٷ�
	* -2 ��Կ����ȷ
	* -3 ��Կ������
	* -4 ��������ȷ(���ݺͺ��벻��Ϊ�գ��ֻ����������࣬����ʱ������)
	* -5 �޴��ʻ�
	* -6 �ʻ����������ѹ���
	* -7 �ʻ�δ�����ӿڷ���
	* -8 ����ʹ�ø�ͨ����
	* -9 �ʻ�����
	* -10 �ڲ�����
	* -11 �۷�ʧ��
	*/
	public function send() {
		$this->log_result($this->params["content"]);
		$this->log_result($this->params["mobile"]);
		$re= $this->postSMS();			//POST��ʽ�ύ
		$this->log_result("������Ϣ��".iconv('utf-8','gbk//IGNORE',$this->params["content"]));
		
	  $res = $this->xml_to_array($re);
	  $res = $res['SubmitResult'];

		$this->log_result("���ͽ����".iconv('utf-8','gbk//IGNORE',$res['msg']));   //���ͳɹ����ص�ֵ
		if($res['code'] == 2){
	  	return true;
		}else{
	  	return false;
	  }
	}

	/*
	* ����xml��ʽΪ����
	*/
	function xml_to_array($xml){
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches)){
			$count = count($matches[0]);
			for($i = 0; $i < $count; $i++){
			$subxml= $matches[2][$i];
			$key = $matches[1][$i];
				if(preg_match( $reg, $subxml )){
					$arr[$key] = $this->xml_to_array( $subxml );
				}else{
					$arr[$key] = $subxml;
				}
			}
		}
		return $arr;
	}

	/*
	 * ��������$params��$URL��ֵ
	 */
	function postSMS(){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $this->URL);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $this->params);
			$return_str = curl_exec($curl);
			curl_close($curl);
			return $return_str;
	}

	function  log_result($word) {
		
		$fp = fopen(DIR_LOGS ."log_sms.txt","a");	
		flock($fp, LOCK_EX) ;
		fwrite($fp,$word."::Date��".strftime("%Y-%m-%d %H:%I:%S",time())."\t\n");
		flock($fp, LOCK_UN); 
		fclose($fp);
		
	}
}
?>