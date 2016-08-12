<?php
class ControllerModuleFlashSale extends Controller {
	private $error = array();

	public function install(){
		$this->load->model('module/flash_sale');
		$this->model_module_flash_sale->createTables();
	}

	public function index() {
		$this->load->language('module/flash_sale');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('flash_sale', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['text_notes'] = $this->language->get('text_notes');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_product_name'] = $this->language->get('column_product_name');
		$data['column_product_quantity'] = $this->language->get('column_product_quantity');
		$data['column_product_display_quantity'] = $this->language->get('column_product_display_quantity');
		$data['column_product_used_quantity'] = $this->language->get('column_product_used_quantity');
		$data['column_product_price'] = $this->language->get('column_product_price');
		$data['column_start_time'] = $this->language->get('column_start_time');
		$data['column_end_time'] = $this->language->get('column_end_time');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['help_delete'] = $this->language->get('help_delete');

		$data['add'] = $this->url->link('module/flash_sale/add', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/flash_sale', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['action'] = $this->url->link('module/flash_sale', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['flash_sale_status'])) {
			$data['flash_sale_status'] = $this->request->post['flash_sale_status'];
		} else {
			$data['flash_sale_status'] = $this->config->get('flash_sale_status');
		}

		$data['flash_sales'] = array();
		$this->load->model('module/flash_sale');
		$results = $this->model_module_flash_sale->getAllFlashSales();
		foreach ($results as $result) {
			$data['flash_sales'][] = array(
				'flash_sale_id' => $result['flash_sale_id'],
				'product_name'         => $result['product_name'],
				'quantity'         => $result['quantity'],
				'display_quantity'         => $result['display_quantity'],
				'used_quantity'         => $this->model_module_flash_sale->countUsedQuantity($result['flash_sale_id']),
				'flash_sale_price'         => $result['flash_sale_price'],
				'start_time'         => $result['start_time'],
				'end_time'         => $result['end_time'],
				'status'				=> $result['status'],
				'href'					=> '../index.php?route=product/flash_sale&'. 'id=' . $result['flash_sale_id'],
				'edit'          => $this->url->link('module/flash_sale/edit', 'token=' . $this->session->data['token'] . '&flash_sale_id=' . $result['flash_sale_id'] . $url, 'SSL'),
				'delete'          => $this->url->link('module/flash_sale/delete', 'token=' . $this->session->data['token'] . '&flash_sale_id=' . $result['flash_sale_id'] . $url, 'SSL')
			);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/flash_sale_list.tpl', $data));
	}

	public function add() {
		$this->load->language('module/flash_sale');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('module/flash_sale');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_module_flash_sale->addFlashSale($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('module/flash_sale', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getForm();
	}

	public function edit() {
		$this->load->language('module/flash_sale');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('module/flash_sale');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_module_flash_sale->editFlashSale($this->request->get['flash_sale_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('module/flash_sale', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('module/flash_sale');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('module/flash_sale');

		if (isset($this->request->get['flash_sale_id']) && $this->validateDelete()) {
			$this->model_module_flash_sale->deleteFlashSale($this->request->get['flash_sale_id']);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('module/flash_sale', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = !isset($this->request->get['flash_sale_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_product_id'] = $this->language->get('entry_product_id');
		$data['entry_product_name'] = $this->language->get('entry_product_name');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_display_quantity'] = $this->language->get('entry_display_quantity');
		$data['entry_start_time'] = $this->language->get('entry_start_time');
		$data['entry_end_time'] = $this->language->get('entry_end_time');

		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_status'] = $this->language->get('help_status');
		$data['help_auto_complete'] = $this->language->get('help_auto_complete');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['product_id'])) {
			$data['error_product_id'] = $this->error['product_id'];
		} else {
			$data['error_product_id'] = array();
		}

		if (isset($this->error['price'])) {
			$data['error_price'] = $this->error['price'];
		} else {
			$data['error_price'] = array();
		}

		if (isset($this->error['quantity'])) {
			$data['error_quantity'] = $this->error['quantity'];
		} else {
			$data['error_quantity'] = array();
		}

		if (isset($this->error['display_quantity'])) {
			$data['error_display_quantity'] = $this->error['display_quantity'];
		} else {
			$data['error_display_quantity'] = array();
		}

		if (isset($this->error['start_time'])) {
			$data['error_start_time'] = $this->error['start_time'];
		} else {
			$data['error_start_time'] = array();
		}

		if (isset($this->error['end_time'])) {
			$data['error_end_time'] = $this->error['end_time'];
		} else {
			$data['error_end_time'] = array();
		}

		if (isset($this->error['product_name'])) {
			$data['error_product_name'] = $this->error['product_name'];
		} else {
			$data['error_product_name'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/flash_sale', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['flash_sale_id'])) {
			$data['action'] = $this->url->link('module/flash_sale/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('module/flash_sale/edit', 'token=' . $this->session->data['token'] . '&flash_sale_id=' . $this->request->get['flash_sale_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('module/flash_sale', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['flash_sale_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$flash_sale_info = $this->model_module_flash_sale->getFlashSale($this->request->get['flash_sale_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($flash_sale_info)) {
			$data['product_id'] = $flash_sale_info['product_id'];
		} else {
			$data['product_id'] = '';
		}

		if (isset($this->request->post['product_name'])) {
			$data['product_name'] = $this->request->post['product_name'];
		} elseif (!empty($flash_sale_info)) {
			 $product_info = $this->model_module_flash_sale->getProductInfo($flash_sale_info['product_id']);
			 $data['product_name'] = $product_info['name'];
		} else {
			$data['product_name'] = '';
		}

		if (isset($this->request->post['flash_sale_price'])) {
			$data['flash_sale_price'] = $this->request->post['flash_sale_price'];
		} elseif (!empty($flash_sale_info)) {
			$data['flash_sale_price'] = $flash_sale_info['flash_sale_price'];
		} else {
			$data['flash_sale_price'] = '1.00';
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($flash_sale_info)) {
			$data['quantity'] = $flash_sale_info['quantity'];
		} else {
			$data['quantity'] = '1';
		}

		if (isset($this->request->post['display_quantity'])) {
			$data['display_quantity'] = $this->request->post['display_quantity'];
		} elseif (!empty($flash_sale_info)) {
			$data['display_quantity'] = $flash_sale_info['display_quantity'];
		} else {
			$data['display_quantity'] = '1';
		}

		if (isset($this->request->post['start_time'])) {
			$data['start_time'] = $this->request->post['start_time'];
		} elseif (!empty($flash_sale_info)) {
			$data['start_time'] = $flash_sale_info['start_time'];
		} else {
			$data['start_time'] = date('Y-m-d H:i:s',strtotime("+1 day"));
		}

		if (isset($this->request->post['end_time'])) {
			$data['end_time'] = $this->request->post['end_time'];
		} elseif (!empty($flash_sale_info)) {
			$data['end_time'] = $flash_sale_info['end_time'];
		} else {
			$data['end_time'] = date('Y-m-d H:i:s',strtotime("+2 day"));
		}

		if (isset($this->request->post['flash_sale_description'])) {
			$data['flash_sale_description'] = $this->request->post['flash_sale_description'];
		} elseif (isset($this->request->get['flash_sale_id'])) {
			$data['flash_sale_description'] = $this->model_module_flash_sale->getFlashSaleDescriptions($this->request->get['flash_sale_id']);
		} else {
			$data['flash_sale_description'] = array();
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($flash_sale_info)) {
			$data['status'] = $flash_sale_info['status'];
		} else {
			$data['status'] = false;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/flash_sale_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/flash_sale')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['product_id']) {
			$this->error['product_id'] = $this->language->get('error_product_id');
		}

		if (utf8_strlen($this->request->post['flash_sale_price']) < 1 || $this->request->post['flash_sale_price'] < 0) {
			$this->error['price'] = $this->language->get('error_price');
		}

		if (utf8_strlen($this->request->post['quantity']) < 1 || !(int)$this->request->post['quantity']) {
			$this->error['quantity'] = $this->language->get('error_quantity');
		}

		if (utf8_strlen($this->request->post['display_quantity']) < 1 || !(int)$this->request->post['display_quantity']) {
			$this->error['display_quantity'] = $this->language->get('error_display_quantity');
		}

		if (utf8_strlen($this->request->post['start_time']) < 1) {
			$this->error['start_time'] = $this->language->get('error_start_time_empty');
		}

		if (utf8_strlen($this->request->post['end_time']) < 1) {
			$this->error['end_time'] = $this->language->get('error_end_time_empty');
		}

		foreach ($this->request->post['flash_sale_description'] as $language_id => $value) {
			if ((utf8_strlen($value['product_name']) < 3) || (utf8_strlen($value['product_name']) > 64)) {
				$this->error['product_name'][$language_id] = $this->language->get('error_product_name');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/flash_sale')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/flash_sale')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

 //pull product info when use auto complete
	public function ajaxGetProductInfo($product_id) {
		$json = array();
		$this->load->model('module/flash_sale');
		$product_info = $this->model_module_flash_sale->getProductInfo($this->request->get['product_id']);

		if ($product_info) {
			$json['product_info'] = $product_info;
		} else {
			$json['product_info'] = array();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
