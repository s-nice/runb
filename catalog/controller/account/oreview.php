<?php
class ControllerAccountOreview extends Controller {
	private $error = array();

	/*
	* 获取评论订单商品列表
	*/
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/oreview', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/oreview');

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

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/oreview', $url, 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_rating'] = $this->language->get('column_rating');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_review_text'] = $this->language->get('column_review_text');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_review'] = $this->language->get('button_review');
		$data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['oreview_products'] = array();

		$this->load->model('account/oreview');

		$filter_data = array(
			'filter_customer_id' => $this->customer->getId(),
			'start'              => ($page - 1) * 10,
			'limit'              => 10
		);
		
		// 根据是否已评论来筛选，true表示已评论，false表示未评论，不定义表示所有
		if (isset($this->request->get['reviewed'])) {
			$filter_data['filter_reviewed'] = $this->request->get['reviewed'];
		}
		
		$oreview_total = $this->model_account_oreview->getTotalOreviews($filter_data);
		$results = $this->model_account_oreview->getOreviews($filter_data);

		$data['oreviews'] = array();
		foreach ($results as $result) {
			$data['oreviews'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['name'],
				'text'       => $result['text'],
				'rating'     => $result['rating'],
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
				'reviewed'   => $result['reviewed'],
				'href'       => $result['reviewed'] ?  '' : $this->url->link('account/oreview/add', 'order_id=' . $result['order_id'] . '&order_product_id=' . $result['order_product_id'], 'SSL'),
			);
		}

		$pagination = new Pagination();
		$pagination->total = $oreview_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/oreview', 'page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($oreview_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($oreview_total - 10)) ? $oreview_total : ((($page - 1) * 10) + 10), $oreview_total, ceil($oreview_total / 10));

		$data['continue'] = $this->url->link('account/account', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/oreview_product_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/oreview_product_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/oreview_product_list.tpl', $data));
		}
	}

	/*
	* 添加评论的表单。
	*/
	public function add() {
		$this->load->language('account/oreview');

		$this->load->model('account/oreview');
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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/oreview/add', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_description'] = $this->language->get('text_description');
		$data['text_write'] = $this->language->get('text_write');
		$data['text_note'] = $this->language->get('text_note');
		$data['entry_oreview'] = $this->language->get('entry_oreview');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['entry_bad'] = $this->language->get('entry_bad');

		$data['button_submit'] = $this->language->get('button_submit');
		$data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['text'])) {
			$data['error_text'] = $this->error['text'];
		} else {
			$data['error_text'] = '';
		}

		if (isset($this->error['rating'])) {
			$data['error_rating'] = $this->error['rating'];
		} else {
			$data['error_rating'] = '';
		}

		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}

		if (isset($this->request->post['text'])) {
			$data['text'] = $this->request->post['text'];
		} else {
			$data['text'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} else {
			$data['rating'] = '';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('return', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		if (isset($this->request->get['order_product_id'])) {
			$data['order_product_id'] = $this->request->get['order_product_id'];
		} else {
			$data['order_product_id'] = '';
		}

		$data['action'] = $this->url->link('account/oreview/add', '', 'SSL');

		$data['back'] = $this->url->link('account/account', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/oreview_form.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/oreview_form.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/oreview_form.tpl', $data));
		}
	}

	public function write() {
		$this->load->language('account/oreview');
		$this->load->language('product/product');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['text']) < 10) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}
			
			$this->load->model('account/oreview');

			if ($this->model_account_oreview->isReviewed($this->request->get['order_product_id'])) {
				$json['error'] = $this->language->get('error_alredy_reviewed');
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->model_account_oreview->addOreview($this->request->get['order_product_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function review() {
		$this->load->language('product/product');

		$this->load->model('account/oreview');

		$data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['reviews'] = array();

		$review_total = $this->model_account_oreview->getTotalOreviewsByProductId($this->request->get['product_id']);

		$results = $this->model_account_oreview->getOreviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['reviews'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('account/oreview/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/oreview.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/oreview.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/oreview.tpl', $data));
		}
	}

	public function validate() {
		if ((utf8_strlen($this->request->post['text']) < 10) || (utf8_strlen($this->request->post['text']) > 1000)) {
			$this->error['text'] = $this->language->get('error_text');
		}

		if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
			$this->error['rating'] = $this->language->get('error_rating');
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}
	}
}