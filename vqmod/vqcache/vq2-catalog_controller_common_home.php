<?php
class ControllerCommonHome extends Controller {

	public function weixinhome() {
		include_once("catalog/controller/payment/WxPayPubHelper/WxPayPubHelper.php");
		//设置参数
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
		//使用jsapi接口
		$jsApi = new JsApi_pub();
	
		//=========步骤1：网页授权获取用户openid============
		//通过code获得openid
		if (!isset($_GET['code']))
		{
			//触发微信返回code码
			$url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
			Header("Location: $url"); 
			exit();
		}else
		{
			//获取code码，以获取openid
		    $code = $_GET['code'];
			$jsApi->setCode($code);
			$openid = $jsApi->getOpenId();
		}
		$this->session->data['weixin_openid'] = $openid;
	}
			
	public function index() {

		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !isset($this->request->get['openid']) && !isset($this->session->data['weixin_openid'])) {
			if(!isset($this->session->data['weixin_openid'])){
				$this->weixinhome();
			}
		} else if(isset($this->request->get['openid'])) {
			$this->session->data['weixin_openid'] = $this->request->get['openid'];
		}
			
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

				if (is_mobile()) {
					$this->load->language('mobile/mobile');
					$data['text_search'] = $this->language->get('text_search');
				}
      
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}