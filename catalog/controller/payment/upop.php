<?php

include_once 'upop/func/common.php';
include_once 'upop/func/SDKConfig.php';
include_once 'upop/func/secureUtil.php';
include_once 'upop/func/log.class.php';

class ControllerPaymentupop extends Controller {
	public function index() {
		
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		
		/**
		 * 消费交易-前台 
		 */
		 
		 //获取商户号
		 $merId = $this->config->get('upop_merId');
		 
		 //前台通知地址
		 $frontUrl = HTTP_SERVER . 'index.php?route=checkout/success';
		 
		 
		 //后台通知地址	
		 $backUrl = HTTP_SERVER . "upop/BackReceive.php";
		 
		 //商户订单号
		 $orderId = $order_info['order_id'];
		 
		 //交易金额，单位分
		 $total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
		 
		/**
		 *	以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考
		 */
		// 初始化日志
		$log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
		$log->LogInfo ( "============处理前台请求开始===============" );
		// 初始化日志
		$params = array(
			'version' => '5.0.0',				//版本号
			'encoding' => 'utf-8',				//编码方式
			'certId' => getSignCertId (),			//证书ID
			'txnType' => '01',				//交易类型	
			'txnSubType' => '01',				//交易子类
			'bizType' => '000201',				//业务类型
			'frontUrl' =>  $frontUrl,  		//前台通知地址
			'backUrl' => $backUrl,		//后台通知地址	
			'signMethod' => '01',		//签名方法
			'channelType' => '08',		//渠道类型，07-PC，08-手机
			'accessType' => '0',		//接入类型
			'merId' => $merId,		        //商户代码，请改自己的测试商户号
			'orderId' => date('YmdHis'),	//商户订单号
			'txnTime' => date('YmdHis'),	//订单发送时间
			'txnAmt' => $total * 100,		//交易金额，单位分
			'currencyCode' => '156',	//交易币种
			'defaultPayType' => '0001',	//默认支付方式	
			//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
			'reqReserved' => $orderId, //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		);

		// 签名
		sign ( $params );
		
		
		// 前台请求地址
		$front_uri = SDK_FRONT_TRANS_URL;
		$log->LogInfo ( "前台请求地址为>" . $front_uri );
		
		$button_confirm = $this->language->get('button_confirm');
		
		// 构造 自动提交的表单
		$html_form = create_html ( $params, $front_uri , $button_confirm );
		
		$log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
		$log->LogInfo ( $html_form );
		$log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
		$log->LogInfo ( "============处理前台请求 结束===========" );

		$data['html'] =  $html_form;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/upop.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/upop.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/upop.tpl', $data);
		}
		
	
	}
	
	public function callback() {
		$this->load->model('checkout/order');
		$pending = 1;
		$failed = 10;
		require_once('upop_quickpay_service.php');

		try {
			$response = new quickpay_service($_POST, quickpay_conf::RESPONSE);
			$arr_ret = $response->get_args();
			$order_id = str_replace("0000000","",$response->get('orderNumber'));
			if ($response->get('respCode') != quickpay_service::RESP_SUCCESS) {
				$err = sprintf("Error: %d => %s", $response->get('respCode'), $response->get('respMsg'));
				$this->model_checkout_order->addOrderHistory($order_id, $failed);
				$this->response->redirect($this->url->link('checkout/failure'));
				throw new Exception($err);
			}else {
				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('upop_order_status_id'));
				$this->response->redirect($this->url->link('checkout/success'));
				
			}
		
			$arr_ret = $response->get_args();
		
			file_put_contents('notify.txt', var_export($arr_ret, true));
		
		}
		catch(Exception $exp) {

			file_put_contents('notify.txt', var_export($exp, true));
			$this->model_checkout_order->addOrderHistory($order_id, $failed);
			$this->response->redirect($this->url->link('checkout/failure'));
		}

		
	}
}
?>