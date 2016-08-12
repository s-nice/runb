<?php
class ControllerModuleWeiboLogin extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$data['client_id'] = $this->config->get('weibo_login_client_id');
			$data['return_url'] = $this->config->get('weibo_login_return_url');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/weibo_login.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/weibo_login.tpl', $data);
			} else {
				return $this->load->view('default/template/module/weibo_login.tpl', $data);
			}
		}
	}

	public function login() {
		$this->load->model('module/weibo_login');
		$this->load->model('account/customer');
		$this->load->model('account/customer_group');

		if ($this->customer->isLogged()) {
			echo '<script type="text/javascript">window.opener.location = "' . $this->url->link('account/account', '', 'SSL') . '"; window.close();</script>';
		}

		if (!isset($this->request->get['code'])) {
			if (isset($this->request->get['error']) && isset($this->request->get['error_description'])) {
				$this->model_module_weibo_login->log('No code returned. Error: ' . $this->request->get['error'] . ', Error Description: ' . $this->request->get['error_description']);
			}

			echo '<script type="text/javascript">window.opener.location = "' . $this->url->link('account/login', '', 'SSL') . '"; window.close();</script>';
		} else {
			$response = $this->model_module_weibo_login->getTokens($this->request->get['code']);
		}

		if (isset($response)) {
			$access_token = $response->access_token;
			$uid = $response->uid;
		}

		if (isset($access_token) && isset($uid)) {
			$user = $this->model_module_weibo_login->getUserInfo($access_token, $uid);
		}

		if (isset($user)) {
			$customer_info = $this->model_module_weibo_login->getCustomerByUid($uid);

			if ($customer_info) {
				if ($this->validate($customer_info['customer_id'])) {
					$this->completeLogin($customer_info['customer_id'], $customer_info['email'], $access_token);
				} else {
					$this->model_module_weibo_login->log('Could not login to - ID: ' . $customer_info['customer_id'] . ', Email: ' . $customer_info['email']);
					echo '<script type="text/javascript">window.opener.location = "' . $this->url->link('account/login', '', 'SSL') . '"; window.close();</script>';
				}
			} else {
				if ($this->config->get('weibo_login_customer_group_id')) {
					$customer_group_id = $this->config->get('weibo_login_customer_group_id');
				} else {
					$customer_group_id = $this->config->get('config_customer_group_id');
				}

				$data = array(
					'customer_group_id' => (int)$customer_group_id,
					'firstname'         => $user->name,
					'email'             => md5($uid),
					'telephone'         => '',
					'fax'               => '',
					'password'          => uniqid(rand(), true),
					'company'           => ''
				);

				$customer_id = $this->model_account_customer->addCustomer($data);
				$this->model_module_weibo_login->editCustomerUid($customer_id, $uid);

				$this->model_module_weibo_login->log('Customer ID date_added: ' . $customer_id);

				$customer_info = $this->model_module_weibo_login->getCustomerByUid($uid);
				if ($this->validate($customer_info['customer_id'])) {
					$this->completeLogin($customer_id, $customer_info['email'], $access_token);
				} else {
					$this->model_module_weibo_login->log('Could not login to - ID: ' . $customer_id . ', Email: ' . $user->name);
					echo '<script type="text/javascript">window.opener.location = "' . $this->url->link('account/login', '', 'SSL') . '"; window.close();</script>';
				}
			}
		} else {
			echo $user->msg;
		}
	}

	public function logout() {
		if (isset($this->session->data['weibo_login'])) {
			unset($this->session->data['weibo_login']);
		}
	}

	protected function completeLogin($customer_id, $email, $access_token) {
		unset($this->session->data['guest']);

		// Add to activity log
		$this->load->model('account/activity');

		$activity_data = array(
			'customer_id' => $this->customer->getId(),
			'name'        => $this->customer->getFirstName()
		);

		$this->model_account_activity->addActivity('login', $activity_data);

		if (isset($this->session->data['weibo_login']['seamless'])) {
			unset($this->session->data['weibo_login']['seamless']);
		}

		$this->model_module_weibo_login->log('Customer logged in - ID: ' . $customer_id . ', Email: ' . $email);
		echo '<script type="text/javascript">window.opener.location = "' . $this->url->link('account/account', '', 'SSL') . '"; window.close();</script>';
	}

	protected function validate($customer_id) {
		// Check how many login attempts have been made.
		$login_info = $this->model_account_customer->getLoginAttempts($customer_id);

		if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['warning'] = $this->language->get('error_attempts');
		}

		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomer($customer_id);

		if ($customer_info && !$customer_info['approved']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		if (!$this->error) {
			if (!$this->customer->login($customer_id, '', true)) {
				$this->error['warning'] = $this->language->get('error_login');

				$this->model_account_customer->addLoginAttempt($customer_id);
			} else {
				$this->model_account_customer->deleteLoginAttempts($customer_id);
			}
		}

		return !$this->error;
	}
}