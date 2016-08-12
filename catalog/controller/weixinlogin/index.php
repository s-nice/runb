<?php
class ControllerWeixinloginIndex extends Controller {
	public function index() {
		$route = '';

		if (isset($this->request->get['route'])) {
			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && $route != 'weixinlogin' && (!isset($this->request->get['route']) || ($this->request->get['route'] != 'account/bind' && $this->request->get['route'] != 'account/logout'))) {
			if (!$this->customer->isLogged()) {
				if(isset($this->request->get['openid'])) {  //����֤�˺�ͨ��get����Openid
					$this->session->data['weixin_openid'] = $this->request->get['openid'];
				} 
				if (!isset($this->session->data['wxredirect'])) {
					//$http = 'http://';//(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!='off')?'https://':'http://';  
					//$port = $_SERVER["SERVER_PORT"]==80 ? '' : ':' . $_SERVER["SERVER_PORT"];  
					$url = HTTP_SERVER . $_SERVER["REQUEST_URI"];
					$this->session->data['wxredirect'] = $url;
				}
				if (!isset($this->session->data['weixin_openid'])) {
					$this->weixinhome();
				}
				$this->load->model('account/weixin_login');
				//ִ�е����Ѿ����Ա�֤��$this->session->data['weixin_openid']��ֵ��
				if($this->model_account_weixin_login->isOpenidExist($this->session->data['weixin_openid'])) { //��ǰopenid�Ѿ����˺�
					$this->weixinlogin();
					$this->model_account_weixin_login->updateCustomerHeadimgurl($this->session->data['weixin_openid'], $this->session->data['headimgurl']);
					$url = $this->session->data['wxredirect'];
					unset($this->session->data['wxredirect']);
					header('Location: ' . $url);
				} else {
					//����΢�ŵ�½ѡ��ҳ�棬���û�ѡ��PC����ע���˺š����ǡ��״η��ʱ�վ����
					$this->response->redirect($this->url->link('weixinlogin/sel', '', 'SSL'));
				}
			}
		}
	}

	public function weixinhome() {
		include_once("catalog/controller/payment/WxPayPubHelper/WxPayPubHelper.php");
		//���ò���
		if($this->config->get('weipay_appid')){
			WxPayConf_pub::$APPID = $this->config->get('weipay_appid');
		}
		if($this->config->get('weipay_mchid')){
			WxPayConf_pub::$MCHID = $this->config->get('weipay_mchid');
		}
		if($this->config->get('weipay_key')){
			WxPayConf_pub::$KEY = $this->config->get('weipay_key');
		}
		if($this->config->get('weipay_appsecret')){
			WxPayConf_pub::$APPSECRET = $this->config->get('weipay_appsecret');
		}
		//ʹ��jsapi�ӿ�
		$jsApi = new JsApi_pub();
	
		//=========����1����ҳ��Ȩ��ȡ�û�openid============
		//ͨ��code���openid
		if (!isset($_GET['code']))
		{
			//����΢�ŷ���code��
			$url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
			Header("Location: $url"); 
			exit();
		}else
		{
			//��ȡcode�룬�Ի�ȡopenid
		    $code = $_GET['code'];
			$jsApi->setCode($code);
			$openid = $jsApi->getOpenId();
			$userinfo = $jsApi->getUserinfo();
			//preg_replace('~\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]~', '', $userinfo['nickname'])�ĺ���ɾ���ǳ��еı��飬����ᵼ������
			$this->session->data['weixin_nickname'] = preg_replace('~\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]~', '', $userinfo['nickname']);
			$this->session->data['headimgurl'] = $userinfo['headimgurl'];
		}
		$this->session->data['weixin_openid'] = $openid;
	}

	/*
	* ���openid�û��������½�����򲻵�½
	* ����customer���������ֶ�openid
	*/
	public function weixinlogin() {
		//���openid�û��������½�����򲻵�½
		$openid = $this->session->data['weixin_openid'];
		$this->load->model('account/weixin_login');
		if($openid){
			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['wishlist']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['guest']);
			$this->customer->loginWithOpenid($openid);
	  }
  }
}