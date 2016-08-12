<?php 
class ControllerModuleSms extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('module/sms');

		$this->document->settitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('config_c123', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect( HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
		}
				
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_c123_plant'] = $this->language->get('entry_c123_plant');
		$data['entry_c123_ac'] = $this->language->get('entry_c123_ac');
		$data['entry_c123_authkey'] = $this->language->get('entry_c123_authkey');
		$data['entry_c123_cgid'] = $this->language->get('entry_c123_cgid');
		$data['entry_c123_csid'] = $this->language->get('entry_c123_csid');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
			
		}

		if (isset($this->error['config_c123_cgid'])) {
			$data['error_c123_cgid'] = $this->error['config_c123_cgid'];
		} else {
			$data['error_c123_cgid'] = '';
		}
		if (isset($this->error['config_c123_authkey'])) {
			$data['error_c123_authkey'] = $this->error['config_c123_authkey'];
		} else {
			$data['error_c123_authkey'] = '';
		}
		if (isset($this->error['config_c123_ac'])) {
			$data['error_c123_ac'] = $this->error['config_c123_ac'];
		} else {
			$data['error_c123_ac'] = '';
		}

		if (isset($this->error['config_c123_plant'])) {
			$data['error_c123_plant'] = $this->error['config_c123_plant'];
		} else {
			$data['error_c123_plant'] = '';
		}

		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
					'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
					'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
					'href'      => $this->url->link('module/sms', 'token=' . $this->session->data['token'], 'SSL')
   		);


		$data['action'] = $this->url->link('module/sms', 'token=' . $this->session->data['token'], 'SSL');		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['modules'] = array();
		
		if (isset($this->request->post['config_c123_cgid']))
		{
			$data['config_c123_cgid'] = $this->request->post['config_c123_cgid'];
		}else{
			$data['config_c123_cgid'] =  $this->config->get('config_c123_cgid');
		}
		if (isset($this->request->post['config_c123_csid']))
		{
			$data['config_c123_csid'] = $this->request->post['config_c123_csid'];
		}else{
			$data['config_c123_csid'] =  $this->config->get('config_c123_csid');
		}
		if (isset($this->request->post['config_c123_authkey']))
		{
			$data['config_c123_authkey'] = $this->request->post['config_c123_authkey'];
		}else{
			$data['config_c123_authkey'] =  $this->config->get('config_c123_authkey');
		}
		
		if (isset($this->request->post['config_c123_ac']))
		{
			$data['config_c123_ac'] = $this->request->post['config_c123_ac'];
		}else{
			$data['config_c123_ac'] =  $this->config->get('config_c123_ac');
		}

		if (isset($this->request->post['config_c123_plant']))
		{
			$data['config_c123_plant'] = $this->request->post['config_c123_plant'];
		}else{
			$data['config_c123_plant'] =  $this->config->get('config_c123_plant');
		}

		if (isset($this->request->post['c123sms_status']))
		{
			$data['config_c123_status'] = $this->request->post['config_c123_status'];
		}else{
			$data['config_c123_status'] =  $this->config->get('config_c123_status');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/sms.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/sms')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['config_c123_plant']) {
			$this->error['config_c123_plant'] = $this->language->get('error_c123_plant');
		}

		if (!$this->request->post['config_c123_ac']) {
			$this->error['config_c123_ac'] = $this->language->get('error_c123_ac');
		}

		if (!$this->request->post['config_c123_authkey']) {
			if ($this->request->post['config_c123_plant'] == 'c123' || $this->request->post['config_c123_plant'] == 'ihuyi') {
				$this->error['config_c123_authkey'] = $this->language->get('error_c123_authkey');
			}
		}
		
		if (!$this->request->post['config_c123_cgid']) {
			if ($this->request->post['config_c123_plant'] == 'c123') {
				$this->error['config_c123_cgid'] = $this->language->get('error_c123_cgid');
			}
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	public function install()
	{
		$this->load->language('module/sms');
		$this->session->data['success'] = $this->language->get('text_success_install');
	}
}
?>