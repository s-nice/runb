<?php
class ControllerCheckoutCart extends Controller {

	public function getCoupon() {
			$this->response->setOutput($this->load->controller('total/coupon'));
	}
			
	public function index() {
		$this->load->language('checkout/cart');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);

		if ($this->cart->hasCartProducts() || !empty($this->session->data['vouchers']) || !empty($this->session->data['recharges'])) {
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_next'] = $this->language->get('text_next');
			$data['text_next_choice'] = $this->language->get('text_next_choice');

				if (is_mobile()) {
					$this->load->language('mobile/mobile');
				}
      

			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['button_update'] = $this->language->get('button_update');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_shopping'] = $this->language->get('button_shopping');
			$data['button_checkout'] = $this->language->get('button_checkout');

			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$data['error_warning'] = $this->language->get('error_stock');
			} elseif (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$data['attention'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link('checkout/cart/edit', '', true);

			if ($this->config->get('config_cart_weight')) {
				$data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$data['weight'] = '';
			}

			$this->load->model('tool/image');
			$this->load->model('tool/upload');

			$data['products'] = array();

			$products = $this->cart->getCartProducts();

				if (is_mobile()) {
					$data['placeholder'] = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				}
      

			foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				}

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}

				$data['products'][] = array(
					'cart_id'   => $product['cart_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'selected'  => $product['selected'],
					'model'     => $product['model'],
					'option'    => $option_data,
					'recurring' => $recurring,
					'quantity'  => $product['quantity'],
					'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'     => $price,
					'total'     => $total,
					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

			// Recharge
			$data['recharges'] = array();

			if (!empty($this->session->data['recharges'])) {
				foreach ($this->session->data['recharges'] as $key => $recharge) {
					$data['recharges'][] = array(
						'key'         => $key,
						'description' => $recharge['description'],
						'amount'      => $this->currency->format($recharge['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

			// Totals
			$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);

						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}

			$data['totals'] = array();

			foreach ($total_data as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'])
				);
			}

			$data['continue'] = $this->url->link('common/home');

			$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

			$this->load->model('extension/extension');

			$data['checkout_buttons'] = array();

			$files = glob(DIR_APPLICATION . '/controller/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$extension = basename($file, '.php');

					$data[$extension] = $this->load->controller('total/' . $extension);
				}
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/cart.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/checkout/cart.tpl', $data));
			}
		} else {
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_error'] = $this->language->get('text_empty');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			
				if (is_mobile()) {
					$data['home'] = $this->url->link('common/home');
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart_empty.tpl')) {
						$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/cart_empty.tpl', $data));
					} else {
						$this->response->setOutput($this->load->view('default/template/checkout/cart_empty.tpl', $data));
					}
				} else {
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
						$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
					} else {
						$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
					}
				}
      




		}
	}

	public function add() {
		$this->load->language('checkout/cart');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->post['quantity']) && ((int)$this->request->post['quantity'] >= $product_info['minimum'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}

			if (!$json) {
				$this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);

				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

				// Unset all shipping and payment methods
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);

				// Totals
				$this->load->model('extension/extension');

				$total_data = array();
				$total = 0;
				$taxes = $this->cart->getTaxes();

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);

							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
					}

					$sort_order = array();

					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $total_data);
				}

				$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0) + (isset($this->session->data['recharges']) ? count($this->session->data['recharges']) : 0), $this->currency->format($total));
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


				/*flash sale start*/
				public function add_flash_sale() {
					$this->load->language('checkout/cart');
					$this->load->language('product/flash_sale');

					$json = array();

					$flash_sale_id = 0;
					$product_id = 0;
					if (isset($this->request->post['flash_sale_id'])) {
						$flash_sale_id = (int)$this->request->post['flash_sale_id'];
					}
					if (isset($this->request->post['product_id'])) {
						$product_id = (int)$this->request->post['product_id'];
					}

					if (!$flash_sale_id || !$product_id) {
						$json['error']['flash_sale'] = 'flash_sale_id, or product_id NULL';
						$this->response->addHeader('Content-Type: application/json');
						$this->response->setOutput(json_encode($json));
						return;
					}

					$this->load->model('catalog/flash_sale');
					$flash_sale_info = $this->model_catalog_flash_sale->getCampaign($flash_sale_id);

					//åˆ¤æ–­èƒ½å¦ç§’æ€
					if (!$this->customer->isLogged()) { // æ˜¯å¦ç™»å½•ï¼Ÿ
						$json['error']['flash_sale'] = $this->language->get('error_login_required');
					} elseif (!$flash_sale_info['status']) { // ç§’æ€æ´»åŠ¨æ˜¯å¦å¯ç”¨ï¼Ÿ
						$json['error']['flash_sale'] = $this->language->get('error_flash_sale_disabled');
					} elseif (time() < strtotime($flash_sale_info['start_time'])) { // æ˜¯å¦å·²å¼€å§‹ï¼Ÿ
						$json['error']['flash_sale'] = $this->language->get('error_flash_sale_not_started');
					} elseif (time() > strtotime($flash_sale_info['end_time'])) { // æ˜¯å¦å·²ç»“æŸï¼Ÿ
						$json['error']['flash_sale'] = $this->language->get('error_flash_sale_ended');
					} elseif (!$this->model_catalog_flash_sale->validateCustomerPermission($flash_sale_id, $this->customer->getId())) { // æ˜¯å¦å·²ç§’è¿‡ï¼Ÿ
						$json['error']['flash_sale'] = $this->language->get('error_flash_sale_only_once');
					} elseif ($this->model_catalog_flash_sale->countUsedQuantity($flash_sale_id) >= $flash_sale_info['quantity']) { // æ˜¯å¦å·²æŠ¢å®Œï¼Ÿ
						$json['error']['flash_sale'] = $this->language->get('error_flash_sale_none');
					}

					if (isset($json['error']['flash_sale'])) {
						$this->response->addHeader('Content-Type: application/json');
						$this->response->setOutput(json_encode($json));
						return;
					}

					//æ¸…ç©ºè´­ç‰©è½¦
					$this->cart->clear();

					$product_id = (int)$flash_sale_info['product_id'];

					$this->load->model('catalog/product');

					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {

						//å¼ºåˆ¶è´­ä¹°æ•°é‡ä¸º1
						$quantity = 1;

						if (isset($this->request->post['option'])) {
							$option = array_filter($this->request->post['option']);
						} else {
							$option = array();
						}

						$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

						foreach ($product_options as $product_option) {
							if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
								$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
							}
						}

						if (isset($this->request->post['recurring_id'])) {
							$recurring_id = $this->request->post['recurring_id'];
						} else {
							$recurring_id = 0;
						}

						$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

						if ($recurrings) {
							$recurring_ids = array();

							foreach ($recurrings as $recurring) {
								$recurring_ids[] = $recurring['recurring_id'];
							}

							if (!in_array($recurring_id, $recurring_ids)) {
								$json['error']['recurring'] = $this->language->get('error_recurring_required');
							}
						}

						if (!$json) {

							//æ·»åŠ ç§’æ€è®°å½•
							$flash_sale_info = $this->model_catalog_flash_sale->addCustomerActivity($flash_sale_id, $this->customer->getId(), $product_id);

							$this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);

							$json['success'] = sprintf($this->language->get('text_flash_sale_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

							unset($this->session->data['shipping_method']);
							unset($this->session->data['shipping_methods']);
							unset($this->session->data['payment_method']);
							unset($this->session->data['payment_methods']);

							// Totals
							$this->load->model('extension/extension');

							$total_data = array();
							$total = 0;
							$taxes = $this->cart->getTaxes();

							// Display prices
							if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
								$sort_order = array();

								$results = $this->model_extension_extension->getExtensions('total');

								foreach ($results as $key => $value) {
									$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
								}

								array_multisort($sort_order, SORT_ASC, $results);

								foreach ($results as $result) {
									if ($this->config->get($result['code'] . '_status')) {
										$this->load->model('total/' . $result['code']);

										$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
									}
								}

								$sort_order = array();

								foreach ($total_data as $key => $value) {
									$sort_order[$key] = $value['sort_order'];
								}

								array_multisort($sort_order, SORT_ASC, $total_data);
							}

							$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
						} else {
							$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
						}
					}

					$this->response->addHeader('Content-Type: application/json');
					$this->response->setOutput(json_encode($json));
				}
				/*flash sale end*/
			
	public function edit() {
		$this->load->language('checkout/cart');

		$json = array();

		// Update
		if (!empty($this->request->post['quantity'])) {
			foreach ($this->request->post['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			$this->response->redirect($this->url->link('checkout/cart'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('checkout/cart');

		$json = array();

		// Remove
		if (isset($this->request->post['key'])) {
			$this->cart->remove($this->request->post['key']);

			unset($this->session->data['vouchers'][$this->request->post['key']]);
			unset($this->session->data['recharges'][$this->request->post['key']]);

			$this->session->data['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			// Totals
			$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);

						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}

			$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0) + (isset($this->session->data['recharges']) ? count($this->session->data['recharges']) : 0), $this->currency->format($total));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function cartSelect() {
		$this->load->language('checkout/cart');

		$json = array();

		if (isset($this->request->post['selected'])) {
			$this->cart->select($this->request->post['selected']);
		} else {
			$this->cart->select();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/*
	* ?¨²1o??3¦Ì¨°3??¡ê?¦Ì¡À1o??3¦Ì2¨²?¡¤????¡¤¡é¨¦¨²¡À??¡¥¨º¡ÀD¨¨ajax¡¤¡é?¨ªcartSelect()?¨¹D?¨¢?session?D????¦Ì?¨°???cart_id??o¨®D¨¨¨°a??D??¨®????¡¤??¡è1¨¤?¡ê?¨¦¡ê?¨°?¨¨¡¤?¡§¦Ì¡À?¡ã1o??3¦Ì????2¨²?¡¤¨º?¡¤?¨®DD¨¨¨°a???¨ª¦Ì?¨¦¨¬?¡¤
	*/
	public function getShipping() {
			$this->response->setOutput($this->load->controller('total/shipping'));
	}

	/*
	* ?¨²1o??3¦Ì¨°3??¡ê?¦Ì¡À1o??3¦Ì2¨²?¡¤????¡¤¡é¨¦¨²¡À??¡¥¨º¡ÀD¨¨ajax¡¤¡é?¨ªcartSelect()?¨¹D?¨¢?session?D????¦Ì?¨°???cart_id??o¨®D¨¨¨°a??D??¨®??¡¤¦Ì¦Ì??¡ê?¨¦¡ê?¨°?¨¨¡¤?¡§¦Ì¡À?¡ã1o??3¦Ì????2¨²?¡¤¦Ì?¡¤¦Ì¦Ì?¨ºy
	*/
	public function getReward() {
			$this->response->setOutput($this->load->controller('total/reward'));
	}

	/*
	* ?¨²1o??3¦Ì¨°3??¡ê?¦Ì¡À1o??3¦Ì2¨²?¡¤????¡¤¡é¨¦¨²¡À??¡¥¨º¡ÀD¨¨ajax¡¤¡é?¨ªcartSelect()?¨¹D?¨¢?session?D????¦Ì?¨°???cart_id??o¨®D¨¨¨°a??D??¨®??total?¡ê?¨¦(id?acart-totals¦Ì??a???¨²2??¨²¨¨Y)¡ê?¨°?¨¨¡¤?¡§¦Ì¡À?¡ã1o??3¦Ìtotal¨ºy?Y
	*/
	public function getTotals() {
			// Totals
			$this->load->model('extension/extension');
			$type = '';
			if (isset($this->request->get['type']) && $this->request->get['type'] == 'json') {
				$type = 'json';
			}

			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);

						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}

			if ($type != 'json') {
				$totals_html = "";

				foreach ($total_data as $total) {
					$totals_html .= "<tr><td class=\"text-right\"><strong>" . $total['title'] . ":</strong></td><td class=\"text-right\">" . $this->currency->format($total['value']) . "</td></tr>";
				}

				$this->response->setOutput($totals_html);
			} else {
				$json = array();
				foreach ($total_data as $total) {
					$json[] = array(
						'title' => $total['title'],
						'value'	=> $this->currency->format($total['value'])
					);
				}
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			}
	}
}
