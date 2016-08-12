<?php
class ControllerAccountWithdraw extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('account/withdraw');

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/withdraw', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('account/withdraw');
			$this->model_account_withdraw->addWithdraw($this->request->post);

			$this->response->redirect($this->url->link('account/withdraw/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_withdraw'),
			'href' => $this->url->link('account/withdraw', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_description'] = $this->language->get('text_description');
		$data['text_agree'] = $this->language->get('text_agree');

		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_bank_account'] = $this->language->get('entry_bank_account');

		$data['help_message'] = $this->language->get('help_message');
		$data['help_amount'] = sprintf($this->language->get('help_amount'), $this->currency->format($this->config->get('config_withdraw_min')), $this->currency->format($this->config->get('config_withdraw_max')));
		$data['help_bank_account'] = $this->language->get('help_bank_account');

		$data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['amount'])) {
			$data['error_amount'] = $this->error['amount'];
		} else {
			$data['error_amount'] = '';
		}

		if (isset($this->error['bank_account'])) {
			$data['error_bank_account'] = $this->error['bank_account'];
		} else {
			$data['error_bank_account'] = '';
		}

		$data['action'] = $this->url->link('account/withdraw', '', 'SSL');

		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} else {
			$data['message'] = '';
		}

		$data['customer_id'] = $this->customer->getId();

		if (isset($this->request->post['amount'])) {
			$data['amount'] = $this->request->post['amount'];
		} else {
			$data['amount'] = $this->currency->format($this->config->get('config_withdraw_min'), $this->config->get('config_currency'), false, false);
		}

		if (isset($this->request->post['bank_account'])) {
			$data['bank_account'] = $this->request->post['bank_account'];
		} else {
			$data['bank_account'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/withdraw.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/withdraw.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/withdraw.tpl', $data));
		}
	}

	public function success() {
		$this->load->language('account/withdraw');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/withdraw')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_message');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('checkout/transaction');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}

	protected function validate() {
		if ($this->request->post['amount'] > $this->customer->getBalance()) {
			$this->error['amount'] = sprintf($this->language->get('error_amount'), $this->customer->getBalance());
		}

		if ($this->request->post['bank_account'] == '') {
			$this->error['bank_account'] = $this->language->get('error_bank_account');
		}

		if (!isset($this->request->post['agree'])) {
			$this->error['warning'] = $this->language->get('error_agree');
		}

		return !$this->error;
	}
}
