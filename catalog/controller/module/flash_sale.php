<?php
class ControllerModuleFlashSale extends Controller {
	public function index($setting) {
		$this->load->language('module/flash_sale');

		$this->document->addScript('catalog/view/javascript/jquery/jquery.countdown.min.js');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/flash_sale.css');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_flash_sale_countdown'] = $this->language->get('text_flash_sale_countdown');
		$data['text_day'] = $this->language->get('text_day');
		$data['text_hour'] = $this->language->get('text_hour');
		$data['text_minute'] = $this->language->get('text_minute');
		$data['text_second'] = $this->language->get('text_second');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_flash_sale_in_progress'] = $this->language->get('text_flash_sale_in_progress');
		$data['text_flash_sale_in_now'] = $this->language->get('text_flash_sale_in_now');
		$data['text_flash_sale_soon'] = $this->language->get('text_flash_sale_soon');
		$data['text_flash_sale_ended'] = $this->language->get('text_flash_sale_ended');
		$data['text_flash_sale_full_price'] = $this->language->get('text_flash_sale_full_price');
		$data['text_flash_sale_none'] = $this->language->get('text_flash_sale_none');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/flash_sale');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$data['products'] = array();

		$flash_sale_products = $this->model_catalog_flash_sale->getLatestCampaigns();

		if ($flash_sale_products) {
			$image_width = 300;
			$image_height = 300;

			foreach ($flash_sale_products as $flash_sale_product) {
				$result = $this->model_catalog_product->getProduct($flash_sale_product['product_id']);

				if ($result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $image_width, $image_height);
					}

					$original_price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					$flash_sale_price = $this->currency->format($this->tax->calculate($flash_sale_product['flash_sale_price'], $result['tax_class_id'], $this->config->get('config_tax')));

					if (strtotime($flash_sale_product['start_time']) > time()) {
						$seconds_to_start = strtotime($flash_sale_product['start_time']) - time();
					} else {
						$seconds_to_start = 0;
					}

					if (strtotime($flash_sale_product['end_time']) > time()) {
						$seconds_to_end = strtotime($flash_sale_product['end_time']) - time();
					} else {
						$seconds_to_end = 0;
					}

					$display_quantity = $flash_sale_product['quantity'] - $this->model_catalog_flash_sale->countUsedQuantity($flash_sale_product['flash_sale_id']);
					if ($seconds_to_start > 0) {
						$display_quantity = $flash_sale_product['display_quantity'];
					}

					if ($seconds_to_end <= 0) {
						$display_quantity = 0;
					}

					$data['products'][] = array(
						'product_id'           => $result['product_id'],
						'product_name'         => $flash_sale_product['product_name'],
						'thumb'                => $image,
						'quantity'             => $flash_sale_product['quantity'],
						'display_quantity'     => $display_quantity,
						'used_quantity'				 => $this->model_catalog_flash_sale->countUsedQuantity($flash_sale_product['flash_sale_id']),
						'start_time'					 => $flash_sale_product['start_time'],
						'end_time'					   => $flash_sale_product['end_time'],
						'seconds_to_start'     => $seconds_to_start,
						'seconds_to_end'       => $seconds_to_end,
						'flash_sale_price'     => $flash_sale_price,
						'original_price'       => $original_price,
						'href'                 => $this->url->link('product/flash_sale', 'id=' . $flash_sale_product['flash_sale_id']),
					);
				}

			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/flash_sale.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/flash_sale.tpl', $data);
			} else {
				return $this->load->view('default/template/module/flash_sale.tpl', $data);
			}
		}
	}
}