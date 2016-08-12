<?php
class ControllerModuleWeiboLogin extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('module/weibo_login');

		$this->load->model('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('weibo_login', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_button_grey'] = $this->language->get('text_button_grey');
		$data['text_button_blue'] = $this->language->get('text_button_blue');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_client_id'] = $this->language->get('entry_client_id');
		$data['entry_secret'] = $this->language->get('entry_secret');
		$data['entry_sandbox'] = $this->language->get('entry_sandbox');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_button'] = $this->language->get('entry_button');
		$data['entry_seamless'] = $this->language->get('entry_seamless');
		$data['entry_locale'] = $this->language->get('entry_locale');
		$data['entry_return_url'] = $this->language->get('entry_return_url');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_sandbox'] = $this->language->get('help_sandbox');
		$data['help_customer_group'] = $this->language->get('help_customer_group');
		$data['help_seamless'] = $this->language->get('help_seamless');
		$data['help_debug_logging'] = $this->language->get('help_debug_logging');
		$data['help_locale'] = $this->language->get('help_locale');
		$data['help_return_url'] = $this->language->get('help_return_url');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_module_add'] = $this->language->get('button_module_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['client_id'])) {
			$data['error_client_id'] = $this->error['client_id'];
		} else {
			$data['error_client_id'] = '';
		}

		if (isset($this->error['secret'])) {
			$data['error_secret'] = $this->error['secret'];
		} else {
			$data['error_secret'] = '';
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
			'href' => $this->url->link('module/weibo_login', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/weibo_login', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['weibo_login_client_id'])) {
			$data['weibo_login_client_id'] = $this->request->post['weibo_login_client_id'];
		} else {
			$data['weibo_login_client_id'] = $this->config->get('weibo_login_client_id');
		}

		if (isset($this->request->post['weibo_login_secret'])) {
			$data['weibo_login_secret'] = $this->request->post['weibo_login_secret'];
		} else {
			$data['weibo_login_secret'] = $this->config->get('weibo_login_secret');
		}

		if (isset($this->request->post['weibo_login_debug'])) {
			$data['weibo_login_debug'] = $this->request->post['weibo_login_debug'];
		} else {
			$data['weibo_login_debug'] = $this->config->get('weibo_login_debug');
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['weibo_login_customer_group_id'])) {
			$data['weibo_login_customer_group_id'] = $this->request->post['weibo_login_customer_group_id'];
		} else {
			$data['weibo_login_customer_group_id'] = $this->config->get('weibo_login_customer_group_id');
		}

		if (isset($this->request->post['weibo_login_return_url'])) {
			$data['weibo_login_return_url'] = $this->request->post['weibo_login_return_url'];
		} else {
			$data['weibo_login_return_url'] = $this->config->get('weibo_login_return_url');
		}
		//$data['return_url'] = HTTPS_CATALOG . 'index.php?route=module/weibo_login/login';

		if (isset($this->request->post['weibo_login_status'])) {
			$data['weibo_login_status'] = $this->request->post['weibo_login_status'];
		} else {
			$data['weibo_login_status'] = $this->config->get('weibo_login_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/weibo_login.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/weibo_login')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['weibo_login_client_id']) {
			$this->error['client_id'] = $this->language->get('error_client_id');
		}

		if (!$this->request->post['weibo_login_secret']) {
			$this->error['secret'] = $this->language->get('error_secret');
		}

		return !$this->error;
	}

	public function install() {
		$this->load->model('extension/event');

		$this->model_extension_event->addEvent('weibo_login', 'post.customer.logout', 'module/weibo_login/logout');
	}

	public function uninstall() {
		$this->load->model('extension/event');

		$this->model_extension_event->deleteEvent('weibo_login');
	}
}