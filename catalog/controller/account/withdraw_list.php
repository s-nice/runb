<?php
class ControllerAccountWithdrawList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/withdraw_list', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/withdraw');

		$this->document->setTitle($this->language->get('heading_title'));

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

		$this->load->model('account/withdraw');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_message'] = $this->language->get('column_message');
		$data['column_amount'] = sprintf($this->language->get('column_amount'), $this->config->get('config_currency'));
		$data['column_bank_account'] = $this->language->get('column_bank_account');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_refused'] = $this->language->get('column_refused');

		$data['text_withdraw_status_0'] = $this->language->get('text_withdraw_status_0');
		$data['text_withdraw_status_1'] = $this->language->get('text_withdraw_status_1');
		$data['text_withdraw_refused_0'] = $this->language->get('text_withdraw_refused_0');
		$data['text_withdraw_refused_1'] = $this->language->get('text_withdraw_refused_1');
		$data['text_total'] = $this->language->get('text_total');
		$data['text_empty'] = $this->language->get('text_empty');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_withdraw'] = $this->language->get('button_withdraw');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['withdraws'] = array();

		$filter_data = array(
			'sort'  => 'date_added',
			'order' => 'DESC',
			'start' => ($page - 1) * 10,
			'limit' => 10
		);

		$withdraw_total = $this->model_account_withdraw->getTotalWithdraws();

		$results = $this->model_account_withdraw->getWithdraws($filter_data);

		foreach ($results as $result) {
			$data['withdraws'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'message'     => $result['message'],
				'bank_account'=> $result['bank_account'],
				'status'      => $result['status'],
				'refused'     => $result['refused'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $withdraw_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/withdraw', 'page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($withdraw_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($withdraw_total - 10)) ? $withdraw_total : ((($page - 1) * 10) + 10), $withdraw_total, ceil($withdraw_total / 10));

		$data['total'] = $this->currency->format($this->customer->getBalance());

		$data['continue'] = $this->url->link('account/account', '', 'SSL');
		$data['recharge'] = $this->url->link('account/withdraw', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/withdraw_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/withdraw_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/withdraw_list.tpl', $data));
		}
	}
}