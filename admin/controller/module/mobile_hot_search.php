<?php
class ControllerModuleMobileHotSearch extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/mobile_hot_search');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('mobile_hot_search', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_hot_searches'] = $this->language->get('entry_hot_searches');		
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_url'] = $this->language->get('entry_url');
		$data['entry_style'] = $this->language->get('entry_style');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['mobile_hot_search_title'])) {
			$data['error_mobile_hot_search_title'] = $this->error['mobile_hot_search_title'];
		} else {
			$data['error_mobile_hot_search_title'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/mobile_hot_search', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/mobile_hot_search', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];


		$data['modules'] = array();

		if (isset($this->request->post['mobile_hot_search'])) {
			$data['modules'] = $this->request->post['mobile_hot_search'];
		} elseif ($this->config->get('mobile_hot_search')) {
			$data['modules'] = $this->config->get('mobile_hot_search');
		}else{
			$data['modules'] = array();
		}
		if (isset($this->request->post['mobile_hot_search_status'])) {
			$data['mobile_hot_search_status'] = $this->request->post['mobile_hot_search_status'];
		} elseif ($this->config->get('mobile_hot_search_status')) {
			$data['mobile_hot_search_status'] = $this->config->get('mobile_hot_search_status');
		}else{
			$data['mobile_hot_search_status'] = '';
		}
		if (isset($this->request->post['mobile_hot_search_title'])) {
			$data['mobile_hot_search_title'] = $this->request->post['mobile_hot_search_title'];
		} elseif ($this->config->get('mobile_hot_search_title')) {
			$data['mobile_hot_search_title'] = $this->config->get('mobile_hot_search_title');
		}else{
			$data['mobile_hot_search_title'] = $data['entry_hot_searches'];
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/mobile_hot_search.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/mobile_hot_search')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>