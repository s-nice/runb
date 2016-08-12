<?php
class ControllerModuleOnline extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/online');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('online', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_qq'] = $this->language->get('entry_qq');
		$data['entry_qq2'] = $this->language->get('entry_qq2');
		$data['entry_qq3'] = $this->language->get('entry_qq3');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('module/online', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/online', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['online_telephone'])) {
			$data['online_telephone'] = $this->request->post['online_telephone'];
		} else {
			$data['online_telephone'] = $this->config->get('online_telephone');
		}

		if (isset($this->request->post['online_qq'])) {
			$data['online_qq'] = $this->request->post['online_qq'];
		} else {
			$data['online_qq'] = $this->config->get('online_qq');
		}

		if (isset($this->request->post['online_qq2'])) {
			$data['online_qq2'] = $this->request->post['online_qq2'];
		} else {
			$data['online_qq2'] = $this->config->get('online_qq2');
		}

		if (isset($this->request->post['online_qq3'])) {
			$data['online_qq3'] = $this->request->post['online_qq3'];
		} else {
			$data['online_qq3'] = $this->config->get('online_qq3');
		}

		if (isset($this->request->post['online_status'])) {
			$data['online_status'] = $this->request->post['online_status'];
		} else {
			$data['online_status'] = $this->config->get('online_status');
		}

		if (isset($this->request->post['image'])) {
			$data['online_image'] = $this->request->post['online_image'];
		} else {
			$data['online_image'] = $this->config->get('online_image');
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['online_image']) && is_file(DIR_IMAGE . $this->request->post['online_image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['online_image'], 100, 100);
		} elseif ($this->config->get('online_image')) {
			$data['thumb'] = $this->model_tool_image->resize($this->config->get('online_image'), 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/online.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/online')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}