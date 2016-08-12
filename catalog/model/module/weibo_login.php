<?php
class ModelModuleWeiboLogin extends Model {
	const GET_USER_INFO_URL = 'https://api.weibo.com/2/users/show.json';
  const GET_ACCESS_TOKEN_URL = "https://api.weibo.com/oauth2/access_token";

	public function getUserInfo($access_token, $uid) {
    $keysArr = array(
      "access_token" => $access_token,
      "uid" => $uid
    );

    $token_url = $this->combineURL(self::GET_USER_INFO_URL, $keysArr);
    $response = $this->get_contents($token_url);

		return json_decode($response);
	}

  public function getTokens($code){
    //-------��������б�
    $keysArr = array(
      "grant_type" => "authorization_code",
      "client_id" => $this->config->get("weibo_login_client_id"),
      "redirect_uri" => urlencode($this->config->get("weibo_login_return_url")),
      "client_secret" => $this->config->get("weibo_login_secret"),
      "code" => $code
    );

    //------��������access_token��url
    $token_url = $this->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
    
    $response = $this->post($token_url, $keysArr);

    $response = json_decode($response);

    if(isset($response->error)){
			$this->log('Response msg: ' . $response->error);
			echo($response->error . ';  ');
  		return false;
    }

    return $response;

  }

  private function combineURL($baseURL,$keysArr){
    $combined = $baseURL."?";
    $valueArr = array();

    foreach($keysArr as $key => $val){
        $valueArr[] = "$key=$val";
    }

    $keyStr = implode("&",$valueArr);
    $combined .= ($keyStr);
    
    return $combined;
  }

  /**
   * get_contents
   * ������ͨ��get����������
   * @param string $url       �����url,ƴ�Ӻ��
   * @return string           ���󷵻ص�����
   */
  private function get_contents($url){
    if (0) {//(ini_get("allow_url_fopen") == "1") {
      $response = file_get_contents($url);
    }else{
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_URL, $url);
      $response =  curl_exec($ch);
      curl_close($ch);
    }
    //-------����Ϊ��
    if(empty($response)){
      $this->error->showError("50001");
    }

    return $response;
  }

	public function getCustomerByUid($uid) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE weibo_uid = '" . $uid . "'");

		return $query->row;
	}

	public function editCustomerUid($customer_id, $uid) {
		$this->event->trigger('pre.customer.weibo_uid.edit', $uid);

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET weibo_uid = '" . $uid . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$this->event->trigger('post.customer.weibo_uid.edit', $uid);
	}

  //��ʵ��json��php����ת������
  private function simple_json_parser($json){
    $json = str_replace("{","",str_replace("}","", $json));
    $jsonValue = explode(",", $json);
    $arr = array();
    foreach($jsonValue as $v){
      $jValue = explode(":", $v);
      $arr[str_replace('"',"", $jValue[0])] = (str_replace('"', "", $jValue[1]));
    }
    return $arr;
  }

  /**
   * post
   * post��ʽ������Դ
   * @param string $url       ���ڵ�baseUrl
   * @param array $keysArr    ����Ĳ����б�
   * @param int $flag         ��־λ
   * @return string           ���ص���Դ����
   */
  private function post($url, $keysArr, $flag = 0){

    $ch = curl_init();
    if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
  }

	public function log($data) {
		if ($this->config->get('weibo_login_debug')) {
			$backtrace = debug_backtrace();
			$this->log->write('Log In with QQ debug (' . $backtrace[1]['class'] . '::' . $backtrace[1]['function'] . ') - ' . $data);
		}
	}
}