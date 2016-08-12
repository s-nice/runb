<?php
class ControllerSaleWithdraw extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/withdraw');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/withdraw');

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_withdraw_id'])) {
			$filter_withdraw_id = $this->request->get['filter_withdraw_id'];
		} else {
			$filter_withdraw_id = NULL;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = NULL;
		}

		if (isset($this->request->get['filter_refused'])) {
			$filter_refused = $this->request->get['filter_refused'];
		} else {
			$filter_refused = NULL;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = NULL;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'withdraw_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_withdraw_id'])) {
			$url .= '&filter_withdraw_id=' . $this->request->get['filter_withdraw_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_refused'])) {
			$url .= '&filter_refused=' . $this->request->get['filter_refused'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		//$data['add'] = $this->url->link('sale/withdraw/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		//$data['delete'] = $this->url->link('sale/withdraw/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['withdraws'] = array();

		$filter_data = array(
			'filter_withdraw_id'      => $filter_withdraw_id,
			'filter_status'           => $filter_status,
			'filter_refused'          => $filter_refused,
			'filter_date_added'       => $filter_date_added,
			'sort'                    => $sort,
			'order'                   => $order,
			'start'                   => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                   => $this->config->get('config_limit_admin')
		);

		$withdraw_total = $this->model_sale_withdraw->getTotalWithdraws($filter_data);

		$results = $this->model_sale_withdraw->getWithdraws($filter_data);

		$this->load->model('customer/customer');
		foreach ($results as $result) {
			$customer = $this->model_customer_customer->getCustomer($result['customer_id']);
			if($customer){
				$customer_name = $customer['firstname'] ? $customer['firstname'] : ($customer['email'] ? $customer['email'] : ($customer['telephone'] ? $customer['telephone'] :$customer['customer_id']));
			}else{
				$customer_name = $result['customer_id'];
			}
			$data['withdraws'][] = array(
				'withdraw_id'   => $result['withdraw_id'],
				'customer'      => $customer_name,
				'bank_account'  => $result['bank_account'],
				'amount'        => $result['amount'],
				'status'        => $result['status'],
				'refused'       => $result['refused'],
				'message'       => $result['message'],
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'          => $this->url->link('sale/withdraw/edit', 'token=' . $this->session->data['token'] . '&withdraw_id=' . $result['withdraw_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_withdraw_status_0'] = $this->language->get('text_withdraw_status_0');
		$data['text_withdraw_status_1'] = $this->language->get('text_withdraw_status_1');
		$data['text_withdraw_refused_0'] = $this->language->get('text_withdraw_refused_0');
		$data['text_withdraw_refused_1'] = $this->language->get('text_withdraw_refused_1');

		$data['column_withdraw_id'] = $this->language->get('column_withdraw_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_bank_account'] = $this->language->get('column_bank_account');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_refused'] = $this->language->get('column_refused');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_message'] = $this->language->get('column_message');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_withdraw_id'] = $this->language->get('entry_withdraw_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_bank_account'] = $this->language->get('entry_bank_account');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_refused'] = $this->language->get('entry_refused');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_message'] = $this->language->get('entry_message');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_withdraw_id'])) {
			$url .= '&filter_withdraw_id=' . $this->request->get['filter_withdraw_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_refused'])) {
			$url .= '&filter_refused=' . $this->request->get['filter_refused'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_withdraw_id'] = $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . '&sort=withdraw_id' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_refused'] = $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . '&sort=refused' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_withdraw_id'])) {
			$url .= '&filter_withdraw_id=' . $this->request->get['filter_withdraw_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_refused'])) {
			$url .= '&filter_refused=' . $this->request->get['filter_refused'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $withdraw_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($withdraw_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($withdraw_total - $this->config->get('config_limit_admin'))) ? $withdraw_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $withdraw_total, ceil($withdraw_total / $this->config->get('config_limit_admin')));

		$data['filter_withdraw_id'] = $filter_withdraw_id;
		$data['filter_status'] = $filter_status;
		$data['filter_refused'] = $filter_refused;
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/withdraw_list.tpl', $data));
	}

	public function edit() {
		$this->load->language('sale/withdraw');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/withdraw');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_withdraw->editWithdraw($this->request->get['withdraw_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_withdraw_id'])) {
				$url .= '&filter_withdraw_id=' . $this->request->get['filter_withdraw_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_refused'])) {
				$url .= '&filter_refused=' . $this->request->get['filter_refused'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = $this->language->get('text_edit');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_withdraw_status_0'] = $this->language->get('text_withdraw_status_0');
		$data['text_withdraw_status_1'] = $this->language->get('text_withdraw_status_1');
		$data['text_withdraw_refused_0'] = $this->language->get('text_withdraw_refused_0');
		$data['text_withdraw_refused_1'] = $this->language->get('text_withdraw_refused_1');

		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_bank_account'] = $this->language->get('entry_bank_account');
		$data['entry_date_ordered'] = $this->language->get('entry_date_ordered');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_refused'] = $this->language->get('entry_refused');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_comment'] = $this->language->get('entry_comment');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['bank_account'])) {
			$data['error_bank_account'] = $this->error['bank_account'];
		} else {
			$data['error_bank_account'] = '';
		}

		if (isset($this->error['status'])) {
			$data['error_status'] = $this->error['status'];
		} else {
			$data['error_status'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_withdraw_id'])) {
			$url .= '&filter_withdraw_id=' . $this->request->get['filter_withdraw_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_refused'])) {
			$url .= '&filter_refused=' . $this->request->get['filter_refused'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		//if (!isset($this->request->get['withdraw_id'])) {
		//	$data['action'] = $this->url->link('sale/withdraw/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		//} else {
			$data['action'] = $this->url->link('sale/withdraw/edit', 'token=' . $this->session->data['token'] . '&withdraw_id=' . $this->request->get['withdraw_id'] . $url, 'SSL');
		//}

		$data['cancel'] = $this->url->link('sale/withdraw', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['withdraw_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$withdraw_info = $this->model_sale_withdraw->getWithdraw($this->request->get['withdraw_id']);
		}

		if (isset($this->request->post['bank_account'])) {
			$data['bank_account'] = $this->request->post['bank_account'];
		} elseif (!empty($withdraw_info)) {
			$data['bank_account'] = $withdraw_info['bank_account'];
		} else {
			$data['bank_account'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($withdraw_info)) {
			$data['status'] = $withdraw_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['refused'])) {
			$data['refused'] = $this->request->post['refused'];
		} elseif (!empty($withdraw_info)) {
			$data['refused'] = $withdraw_info['refused'];
		} else {
			$data['refused'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/withdraw_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/withdraw')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!isset($this->request->post['bank_account']) || !$this->request->post['bank_account']) {
			$this->error['bank_account'] = $this->language->get('error_bank_account');
		}

		if ($this->request->post['status'] && $this->request->post['refused']) {
			$this->error['status'] = $this->language->get('error_status');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
}