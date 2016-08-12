<?php
class ControllerModuleCategory3 extends Controller {
	public function index() {
		$this->load->language('module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		if (isset($parts[2])) {
			$data['son_id'] = $parts[2];
		} else {
			$data['son_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = array();

			if ($category['category_id'] == $data['category_id']) {
				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					$sons_data = array();
		
					if ($child['category_id'] == $data['child_id']) {
						$sons = $this->model_catalog_category->getCategories($child['category_id']);
						foreach($sons as $son) {
							$filter_data = array(
								'filter_category_id' => $son['category_id'], 
								'filter_sub_category' => true
							);
		
							$sons_data[] = array(
								'category_id' => $son['category_id'], 
								'name' => $son['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''), 
								'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $son['category_id'])
							);
						}
					}

					$filter_data = array(
						'filter_category_id' => $child['category_id'], 
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'category_id' => $child['category_id'], 
						'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''), 
						'sons'    => $sons_data,
						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category3.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/category3.tpl', $data);
		} else {
			return $this->load->view('default/template/module/category3.tpl', $data);
		}
	}
}