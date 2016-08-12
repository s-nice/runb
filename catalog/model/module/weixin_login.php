<?php
class ModelModuleWeixinLogin extends Model {
	const GET_USER_INFO_URL = 'https://api.weixin.qq.com/sns/userinfo';
  const GET_ACCESS_TOKEN_URL = "https://api.weixin.qq.com/sns/oauth2/access_token";

	public function getUserInfo($access_token, $openid) {
    $keysArr = array(
      "access_token" => $access_token,
      "openid" => $openid
    );

    $token_url = $this->combineURL(self::GET_USER_INFO_URL, $keysArr);
    $response = $this->get_contents($token_url);

		return json_decode($response);
	}

  public function getTokens($code){
    //-------请求参数列表
    $keysArr = array(
      "grant_type" => "authorization_code",
      "appid" => $this->config->get("weixin_login_client_id"),
      "secret" => $this->config->get("weixin_login_secret"),
      "code" => $code
    );

    //------构造请求access_token的url
    $token_url = $this->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
    $response = $this->get_contents($token_url);

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
   * 服务器通过get请求获得内容
   * @param string $url       请求的url,拼接后的
   * @return string           请求返回的内容
   */
  private function get_contents($url){
    if (ini_get("allow_url_fopen") == "1") {
      $response = file_get_contents($url);
    }else{
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_URL, $url);
      $response =  curl_exec($ch);
      curl_close($ch);
    }
    //-------请求为空
    if(empty($response)){
      $this->error->showError("50001");
    }

    return $response;
  }

	public function getCustomerByUid($uid) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE weixin_uid = '" . $uid . "'");

		return $query->row;
	}

	public function editCustomerUid($customer_id, $uid) {
		$this->event->trigger('pre.customer.weixin_uid.edit', $uid);

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET weixin_uid = '" . $uid . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$this->event->trigger('post.customer.weixin_uid.edit', $uid);
	}

  //简单实现json到php数组转换功能
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

	public function log($data) {
		if ($this->config->get('weixin_login_debug')) {
			$backtrace = debug_backtrace();
			$this->log->write('Log In with QQ debug (' . $backtrace[1]['class'] . '::' . $backtrace[1]['function'] . ') - ' . $data);
		}
	}
}