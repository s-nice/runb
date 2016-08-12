<?php

class ControllerPaymentupop extends Controller {
	private $error = array(); 
	
	public function index() {
		
		
		//添加产品字段
		$sql = $this->db->query("Describe `".DB_PREFIX."order` order_number;")->row;
		if(!count($sql)){
			//echo '1111';	
			$this->db->query("ALTER TABLE `".DB_PREFIX."order` ADD `order_number` INT NOT NULL COMMENT '商户订单号' AFTER `order_id`;");

		}else{
			//echo 'opencart-111';	
		}
		
		
		$this->language->load('payment/upop');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('upop', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_successful'] = $this->language->get('text_successful');
		$data['text_declined'] = $this->language->get('text_declined');
		$data['text_off'] = $this->language->get('text_off');
		
		//entry_merId
		$data['entry_merId'] = $this->language->get('entry_merId');
	
		$data['text_pay_name'] = $this->language->get('text_pay_name');
		$data['text_pay_desc'] = $this->language->get('text_pay_desc');
	
		$data['text_business_name'] = $this->language->get('text_business_name');
		
		
		$data['text_environment_type'] = $this->language->get('text_environment_type');

		$data['entry_order_status'] = $this->language->get('entry_order_status');		
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		
	
 		if (isset($this->error['upop_merId'])) {
			$data['error_upop_merId'] = $this->error['upop_merId'];
		} else {
			$data['error_upop_merId'] = '';
		}
		
	

 		if (isset($this->error['upop_business_name'])) {
			$data['error_upop_business_name'] = $this->error['upop_business_name'];
		} else {
			$data['error_upop_business_name'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/upop', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => ' :: '
   		);
				
		$data['action'] = $this->url->link('payment/upop', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		
	
		if (isset($this->request->post['upop_merId'])) {
			$data['upop_merId'] = $this->request->post['upop_merId'];
		} else {
			$data['upop_merId'] = $this->config->get('upop_merId');
		}
		
	
		if (isset($this->request->post['upop_order_status_id'])) {
			$data['upop_order_status_id'] = $this->request->post['upop_order_status_id'];
		} else {
			$data['upop_order_status_id'] = $this->config->get('upop_order_status_id');
		}
		
		if (isset($this->request->post['upop_status'])) {
			$data['upop_status'] = $this->request->post['upop_status'];
		} else {
			$data['upop_status'] = $this->config->get('upop_status');
		}
		
		
	
		$data['array_upop_environment_type'][] = array(
			'title'  => '开发联调环境',
			'value' => '0'
		);
		$data['array_upop_environment_type'][] = array(
			'title'  => 'PM环境(预上线)',
			'value' => '1'
		);
		$data['array_upop_environment_type'][] = array(
			'title'  => '生产环境',
			'value' => '2'
		);
		if (isset($this->request->post['upop_environment_type'])) {
			$data['upop_environment_type'] = $this->request->post['upop_environment_type'];
		} else {
			$data['upop_environment_type'] = $this->config->get('upop_environment_type');
		}

		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		

		if (isset($this->request->post['upop_sort_order'])) {
			$data['upop_sort_order'] = $this->request->post['upop_sort_order'];
		} else {
			$data['upop_sort_order'] = $this->config->get('upop_sort_order');
		}

		$this->template = 'payment/upop.tpl';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');		
		$this->response->setOutput($this->load->view('payment/upop.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/upop')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['upop_merId']) {
			$this->error['upop_merId'] = $this->language->get('error_upop_merId');
		}
		
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>