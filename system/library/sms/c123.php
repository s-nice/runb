<?php
class C123 {
	private $URL='http://smsapi.c123.cn/OpenPlatform/OpenApi';
	private $params;

	public function __construct($controller) {
		$this->params = array(
			'action'=>'sendOnce',                                //�������� ��������sendOnce���ŷ��ͣ�sendBatchһ��һ���ͣ�sendParam	��̬�������Žӿ�
			'ac'=>$controller->config->get('config_c123_ac'),					                         //�û��˺�
			'authkey'=>$controller->config->get('config_c123_authkey'),	                             //��֤��Կ
			'cgid'=>$controller->config->get('config_c123_cgid'),    //ͨ������
			'm'=>'',		                                     //����,��������ö��Ÿ���
			'c'=>'',  //iconv('gbk','utf-8',$c),		                 //���ҳ����gbk���룬��ת��utf-8���룬�����ҳ����utf-8���룬����Ҫת��
			'csid'=>trim($controller->config->get('config_c123_csid')),     //ǩ����� ������Ϊ�գ�Ϊ��ʱʹ��ϵͳĬ�ϵ�ǩ�����
			't'=>'', //$t                                              //��ʱ���ͣ�Ϊ��ʱ��ʾ��������
		);
	}
	
	/*
	* ������Ϣ���ݺ�Ҫ���͵����ֻ����룬�ֻ������ԷֺŸ�������Ϣ����Ϊutf8��ʽ���粻����ת����utf8��ʽ
	*/
	public function setParams($msg, $mobile) {
		$this->params["m"] = str_replace(";",",",$mobile);
		/*
		if(false !== strpos($mobile,";")) {
			$this->params["action"] = 'sendBatch';
		}
		*/
		$this->params["c"] = $msg;
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
		$this->log_result(iconv('utf-8','gbk//IGNORE',var_export($this->params["c"], true)));
		$this->log_result($this->params["m"]);
		$this->log_result($this->params["action"]);
		$re= $this->postSMS();			//POST��ʽ�ύ
		$this->log_result("������Ϣ��".iconv('utf-8','gbk//IGNORE',var_export($this->params, true)));
	  preg_match_all('/result="(.*?)"/',$re,$res);
		if(trim($res[1][0]) == '1' ) {  //���ͳɹ� ��������ҵ��ţ�Ա����ţ����ͱ�ţ��������������ۣ����
		
		  preg_match_all('/\<Item\s+(.*?)\s+\/\>/',$re,$item);
			for($i=0;$i<count($item[1]);$i++){
		    preg_match_all('/cid="(.*?)"/',$item[1][$i],$cid);
		    preg_match_all('/sid="(.*?)"/',$item[1][$i],$sid);
				preg_match_all('/msgid="(.*?)"/',$item[1][$i],$msgid);
				preg_match_all('/total="(.*?)"/',$item[1][$i],$total);
				preg_match_all('/price="(.*?)"/',$item[1][$i],$price);
				preg_match_all('/remain="(.*?)"/',$item[1][$i],$remain);
				
				$send['cid']=$cid[1][0];             //��ҵ���
			  $send['sid']=$sid[1][0];             //Ա�����
				$send['msgid']=$msgid[1][0];         //���ͱ��
				$send['total']=$total[1][0];         //�Ʒ�����
				$send['price']=$price[1][0];         //���ŵ���
				$send['remain']=$remain[1][0];       //���
				$send_arr[]=$send;                   //����send_arr �洢�˷��ͷ��غ�������Ϣ
			}
			$this->log_result("���ͳɹ�,״̬Ϊ".$res[1][0]);   //���ͳɹ����ص�ֵ
			return true;
			
		}	else {  //����ʧ�ܵķ���ֵ
		  switch(trim($res[1][0])){
				case  0: $ret = "�ʻ���ʽ����ȷ(��ȷ�ĸ�ʽΪ:Ա�����@��ҵ���)";break; 
				case  -1: $ret = "�������ܾ�(�ٶȹ��졢��ʱ���IP���Ե�)�����ٶȹ������ʱ�ٷ�";break;
				case  -2: $ret = " ��Կ����ȷ";break;
				case  -3: $ret = "��Կ������";break;
				case  -4: $ret = "��������ȷ(���ݺͺ��벻��Ϊ�գ��ֻ����������࣬����ʱ������)";break;
				case  -5: $ret = "�޴��ʻ�";break;
				case  -6: $ret = "�ʻ����������ѹ���";break;
				case  -7: $ret = "�ʻ�δ�����ӿڷ���";break;
				case  -8: $ret = "����ʹ�ø�ͨ����";break;
				case  -9: $ret = "�ʻ�����";break;
				case  -10: $ret = "�ڲ�����";break;
				case  -11: $ret = "�۷�ʧ��";break;
				default:$ret = "δ֪����"; break;
			}
			$this->log_result("����ʧ�ܣ�".$ret);   //���ͳɹ����ص�ֵ
			return $ret;
		}
	}


	/*
	 * ��������$params��$URL��ֵ
	 */
	function postSMS()
	{
		$row = parse_url($this->URL);
		$host = $row['host'];
		$port = isset($row['port'])&&$row['port'] ? $row['port']:80;
		$file = $row['path'];
		$post = '';
		while (list($k,$v) = each($this->params)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.0\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;		
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}

	function  log_result($word) {
		
		$fp = fopen(DIR_LOGS ."sms_c123.txt","a");	
		flock($fp, LOCK_EX) ;
		fwrite($fp,$word."::Date��".strftime("%Y-%m-%d %H:%I:%S",time())."\t\n");
		flock($fp, LOCK_UN); 
		fclose($fp);
		
	}
}
?>