<?php
// Version By www.opencart.cn
/*
版权所有：www.opencart.cn
*/
require_once("alipay_submit.class.php");
require_once("alipay_notify.class.php");

class ControllerPaymentAlipay extends Controller {
	public function index() {


		// 为 alipay.tpl 准备数据
    $data['button_confirm'] = $this->language->get('button_confirm');
		$data['button_back'] = $this->language->get('button_back');

		// url

		$data['return'] = HTTPS_SERVER . 'index.php?route=checkout/success';

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		$encryption = new Encryption($this->config->get('config_encryption'));

		$data['custom'] = $encryption->encrypt($this->session->data['order_id']);

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		// 获取订单数据
		$this->load->model('checkout/order');
		$this->load->model('payment/alipay');

		$order_id = $this->session->data['order_id'];

		$order_info = $this->model_checkout_order->getOrder($order_id);
	  $order_product_info = $this->model_payment_alipay->getOrderProduct($order_id);
	  //$my = print_r($order_product_info);
	  //logResult($my);


//商户信息
					//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

					//合作身份者id，以2088开头的16位纯数字
		  		$alipay_config['partner']		= trim($this->config->get('alipay_partner'));				//合作伙伴ID

					//安全检验码，以数字和字母组成的32位字符
					$alipay_config['key']			= trim($this->config->get('alipay_security_code'));	//安全检验码key

					//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


					//签名方式 不需修改
					$alipay_config['sign_type']    = strtoupper('MD5');

					//字符编码格式 目前支持 gbk 或 utf-8
					$alipay_config['input_charset']= strtolower('utf-8');

					//ca证书路径地址，用于curl中ssl校验
					//请保证cacert.pem文件在当前文件夹目录中
					$alipay_config['cacert']    = getcwd().'\\cacert.pem';

					//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
					$alipay_config['transport']    = 'http';


		// 计算提交地址
		$seller_email = $this->config->get('alipay_seller_email');		// 商家邮箱
		$security_code = $this->config->get('alipay_security_code');	//安全检验码
		$partner = $this->config->get('alipay_partner');							//合作伙伴ID
		$currency_code = $this->config->get('alipay_currency_code');	//人民币代号（CNY）
		$item_name = $this->config->get('config_store');
		$first_name = $order_info['payment_firstname'];
		$total = $order_info['total'];
		if($currency_code == ''){
			$currency_code = 'CNY';
		}

		$currency_value = $this->currency->getValue($currency_code);
		$amount = $total * $currency_value;
		$amount = number_format($amount,2,'.','');


		$_input_charset = "utf-8";  //字符编码格式  目前支持 GBK 或 utf-8
		$sign_type      = "MD5";    //加密方式  系统默认(不要修改)
		$transport      = "http";  //访问模式,你可以根据自己的服务器是否支持ssl访问而选择http以及https访问模式(系统默认,不要修改)
		$notify_url     = HTTP_SERVER . 'catalog/controller/payment/alipay_notify_url.php';  //异步通知地址
		$return_url		  = HTTPS_SERVER . 'index.php?route=checkout/success';  //同步返回地址
		$show_url       = HTTPS_SERVER . 'index.php'; //你网站商品的展示地址
		$subject = $order_product_info['product_name'] ;
		$body = '商品名称:' . $order_product_info['product_name'] . '-----X商品数量:' . $order_product_info['product_quantity']  ;
		$out_trade_no = $order_id;   //商户订单号
		//$out_trade_no = date("Ymd").$order_id;
		$receive_mobile = $order_product_info['receive_phone'];
		$receive_phone  = $order_product_info['receive_phone'];
		$receive_zip = $order_product_info['receive_zip'];
		$receive_name = $order_product_info['receive_name'];
		$receive_address = $order_product_info['receive_address'];
		$quantity = $order_product_info['product_quantity'];
		
		//var_dump($order_product_info);

		$parameter = array(
		"service" => "create_partner_trade_by_buyer",
		"partner" => trim($alipay_config['partner']),
		"payment_type"	=> "1",
		"notify_url"	=> $notify_url,          //异步返回
		"return_url"	=> $return_url,          //同步返回
		"seller_email"	=> $seller_email,
		"out_trade_no"	=> $out_trade_no,     //支付宝订单号
		"subject"	=> $subject,              //商品名称，必填

		"price"	=> $amount,                  //商品价格，必填
		"quantity"	=> 1,//$quantity,           //商品数量，必填
		"logistics_fee"	=> "0.00",  //物流配送费用
		"logistics_type"	=> "EXPRESS",     //物流配送方式：POST(平邮)、EMS(EMS)、EXPRESS(其他快递)
		//"logistics_payment"	=> $logistics_payment,  //物流付款方式：SELLER_PAY(卖家支付)、BUYER_PAY(买家支付)、BUYER_PAY_AFTER_RECEIVE(货到付款)
		"logistics_payment" => "SELLER_PAY",      //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）

		"body"	=> $body,                 //商品描述，必填
		"show_url"	=> $show_url,      //商品展示地址，需以http://开头的完整路径，如：http://www.商户网站.com/myorder.html
		"receive_name"	=> $receive_name,         //收货人姓名
		"receive_address"	=> $receive_address,   //收货人地址
		"receive_zip"	=> $receive_zip,       //收货人邮编
		"receive_phone"	=> $receive_phone,     //收货人电话号码
		"receive_mobile"	=> $receive_mobile,  //收货人手机号码
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

	//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get");

		$action=$html_text;
		$data['action'] = $action;
		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/alipay.tpl')) {

			return $this->load->view($this->config->get('config_template') . '/template/payment/alipay.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/alipay.tpl', $data);
		}

	}


	// 支付返回后的处理
	public function callback() {
		logResult("callback start.");

		// 获取商家信息
		//商户信息
					//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
		  			$alipay_config['partner']		= trim($this->config->get('alipay_partner'));				//合作伙伴ID

					  $alipay_config['key']			= trim($this->config->get('alipay_security_code'));	//安全检验码key
					
						$alipay_config['sign_type']    = strtoupper('MD5'); 	//签名方式 不需修改
										
						$alipay_config['input_charset']= strtolower('utf-8'); //字符编码格式 目前支持 gbk 或 utf-8
					 //ca证书路径地址，用于curl中ssl校验
					//请保证cacert.pem文件在当前文件夹目录中
					 $alipay_config['cacert']    = getcwd().'\\cacert.pem';					
					//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
					 $alipay_config['transport']    = 'http';


		// 获取支付宝返回的数据
    
    //logResult($_POST);

		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		logResult('verify_result=' . $verify_result);

		if($verify_result) {   //认证合格
			logResult('验证成功');

			//获取支付宝的反馈参数
			$order_id   = $_POST['out_trade_no'];   //获取支付宝传递过来的订单号

			logResult('out_trade_no=' . $order_id);

			$this->load->model('checkout/order');

			// 获取订单ID
			$order_info = $this->model_checkout_order->getOrder($order_id);

			// 存储订单至系统数据库
			if ($order_info) {
				$order_status_id = $order_info["order_status_id"];

				$alipay_order_status_id = $this->config->get('alipay_order_status_id');
				$alipay_wait_buyer_pay = $this->config->get('alipay_wait_buyer_pay');
				$alipay_wait_buyer_confirm = $this->config->get('alipay_wait_buyer_confirm');
				$alipay_trade_finished = $this->config->get('alipay_trade_finished');
				$alipay_wait_seller_send = $this->config->get('alipay_wait_seller_send');


				// 避免处理已完成的订单
				logResult('order_id=' . $order_id . ' order_status_id=' . $order_status_id);

				if ($order_status_id != $alipay_trade_finished) {
					logResult("No finished.");
					// 获取原始订单的总额
					$currency_code = $this->config->get('alipay_currency_code');				//人民币代号（CNY）
					$total = $order_info['total'];
					logResult('total=' . $total);
					if($currency_code == ''){
						$currency_code = 'CNY';
					}
					$currency_value = $this->currency->getValue($currency_code);
					logResult('currency_value=' . $currency_value);
					$amount = $total * $currency_value;
					$amount = number_format($amount,2,'.','');
					logResult('amount=' . $amount);

					// 支付宝付款金额
					$total     = $_POST['total_fee'];      // 获取支付宝传递过来的总价格
					logResult('total_fee=' . $total);
					/*
					$receive_name    =$_POST['receive_name'];    //获取收货人姓名
					$receive_address =$_POST['receive_address']; //获取收货人地址
					$receive_zip     =$_POST['receive_zip'];     //获取收货人邮编
					$receive_phone   =$_POST['receive_phone'];   //获取收货人电话
					$receive_mobile  =$_POST['receive_mobile'];  //获取收货人手机
					*/

					/*
						获取支付宝反馈过来的状态,根据不同的状态来更新数据库
						WAIT_BUYER_PAY(表示等待买家付款);
						WAIT_SELLER_SEND_GOODS(表示买家付款成功,等待卖家发货);
						WAIT_BUYER_CONFIRM_GOODS(表示卖家已经发货等待买家确认);
						TRADE_FINISHED(表示交易已经成功结束);
					*/
					if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {                   //等待买家付款
						//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
						if($order_status_id != $alipay_trade_finished && $order_status_id != $alipay_wait_buyer_confirm && $order_status_id != $alipay_wait_seller_send){
							$this->model_checkout_order->addOrderHistory($order_id, $alipay_wait_buyer_pay);

							echo "success";		//请不要修改或删除

							//调试用，写文本函数记录程序运行情况是否正常
							logResult('success - alipay_wait_buyer_pay');
						}
					}
					else if($total < $amount){	// 付款不足
							//$this->model_checkout_order->update($order_id, 10);
							logResult('order_id=' . $order_id . "Total Error:total=" . $total . "<amount" .$amount);
					}
					else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS' && $order_status_id != $alipay_dual_wait_seller_send) { //买家付款成功,等待卖家发货
						//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
						 $this->model_checkout_order->addOrderHistory($order_id, $alipay_wait_seller_send);
							echo "success";		//请不要修改或删除

							//调试用，写文本函数记录程序运行情况是否正常
							logResult('success - alipay_wait_seller_send');
						//}
					}
					else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS'&& $order_status_id != $alipay_dual_wait_buyer_confirm ) { //卖家已经发货等待买家确认
						
						//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
						if($order_status_id != $alipay_trade_finished){
							$this->model_checkout_order->addOrderHistory($order_id, $alipay_wait_buyer_confirm);

							echo "success";		//请不要修改或删除

							//调试用，写文本函数记录程序运行情况是否正常
							logResult('success - alipay_wait_buyer_confirm');
						}
					}
					else if(($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS') && ($order_status_id != $alipay_dual_trade_finished)) {		//交易成功结束

						//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
						$this->model_checkout_order->addOrderHistory($order_id, $alipay_trade_finished);

						echo "success";		//请不要修改或删除

						//调试用，写文本函数记录程序运行情况是否正常
						logResult('success - alipay_trade_finished');
					}
					else {
						echo "fail";
						logResult ("verify_failed");
					}
				}
			}
		}
	}
}
?>