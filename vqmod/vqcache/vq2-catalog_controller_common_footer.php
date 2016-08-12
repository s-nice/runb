<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

				$this->load->language('information/contact');
				$data['text_contact'] = $this->language->get('heading_title');
				$data['address'] = nl2br($this->config->get('config_address'));
				$data['telephone'] = $this->config->get('config_telephone');
				$data['email'] = $this->config->get('config_email');
			

		$data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

				if (is_mobile()) {
					if (!isset($this->request->get['route'])) {
						$data['redirect'] = $this->url->link('common/home');
					} else {
						$url_data = $this->request->get;

						unset($url_data['_route_']);

						$route = $url_data['route'];

						unset($url_data['route']);

						$url = '';

						if ($url_data) {
							$url = '&' . urldecode(http_build_query($url_data, '', '&'));
						}

						$data['redirect'] = $this->url->link($route, $url, $this->request->server['HTTPS']);
					}

					$this->load->language('mobile/mobile');
					$data['text_cancel'] = $this->language->get('text_cancel');
					$data['text_select_language'] = $this->language->get('text_select_language');
					$data['language_action'] = $this->url->link('common/language/language', '', $this->request->server['HTTPS']);
					$data['current_lang_code'] = $this->session->data['language'];
					$this->load->model('localisation/language');
					$data['languages'] = array();
					$results = $this->model_localisation_language->getLanguages();
					foreach ($results as $result) {
						if ($result['status']) {
							$data['languages'][] = array(
								'name'  => $result['name'],
								'code'  => $result['code'],
								'image' => $result['image']
							);
						}
					}

					$data['text_select_currency'] = $this->language->get('text_select_currency');
					$data['currency_action'] = $this->url->link('common/currency/currency', '', $this->request->server['HTTPS']);
					$data['current_currency_code'] = $this->currency->getCode();
					$data['currencies'] = array();
					$this->load->model('localisation/currency');
					$results = $this->model_localisation_currency->getCurrencies();
					foreach ($results as $result) {
						if ($result['status']) {
							$data['currencies'][] = array(
								'title'        => $result['title'],
								'code'         => $result['code'],
								'symbol_left'  => $result['symbol_left'],
								'symbol_right' => $result['symbol_right']
							);
						}
					}
				}
      

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}
