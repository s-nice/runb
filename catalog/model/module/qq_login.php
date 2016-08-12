<?php
class ModelModuleQQLogin extends Model {
	const GET_USER_INFO_URL = 'https://graph.qq.com/user/get_user_info';
  const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
  const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

	public function getUserInfo($access_token, $openid) {
    $keysArr = array(
      "access_token" => $access_token,
      "oauth_consumer_key" => $this->config->get("qq_login_client_id"),
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
      "client_id" => $this->config->get("qq_login_client_id"),
      "redirect_uri" => urlencode($this->config->get("qq_login_return_url")),
      "client_secret" => $this->config->get("qq_login_secret"),
      "code" => $code
    );

    //------构造请求access_token的url
    $token_url = $this->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
    $response = $this->get_contents($token_url);

    if(strpos($response, "callback") !== false){

      $lpos = strpos($response, "(");
      $rpos = strrpos($response, ")");
      $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
      $msg = json_decode($response);

      if(isset($msg->error)){
				$this->log('Response msg: ' . $msg->error . ' ' . $msg->error_description);
				echo($msg->error_description . ';  ');
    		return false;
      }
    }

    $params = array();
    parse_str($response, $params);

    return $params["access_token"];

  }

  public function getOpenid($access_token){
    //-------请求参数列表
    $keysArr = array(
    	"access_token" => $access_token
    );

    $graph_url = $this->combineURL(self::GET_OPENID_URL, $keysArr);
    $response = $this->get_contents($graph_url);

    //--------检测错误是否发生
    if(strpos($response, "callback") !== false){
      $lpos = strpos($response, "(");
      $rpos = strrpos($response, ")");
      $response = substr($response, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($response);
    if(isset($user->error)){
			$this->log('Response msg: ' . $user->error);
      return false;
    }

    return $user->openid;
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

	public function getCustomerByOpenid($openid) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE qq_openid = '" . $openid . "'");

		return $query->row;
	}

	public function editCustomerOpenid($customer_id, $openid) {
		$this->event->trigger('pre.customer.qq_openid.edit', $openid);

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET qq_openid = '" . $openid . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$this->event->trigger('post.customer.qq_openid.edit', $openid);
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
		if ($this->config->get('qq_login_debug')) {
			$backtrace = debug_backtrace();
			$this->log->write('Log In with QQ debug (' . $backtrace[1]['class'] . '::' . $backtrace[1]['function'] . ') - ' . $data);
		}
	}
}