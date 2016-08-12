<?php
class ControllerModuleMobileCategory extends Controller {
	public function index() {
    $this->load->language('module/mobile_category');
    if ($this->config->get('mobile_category_title')) {
    	$data['heading_title'] = $this->config->get('mobile_category_title');
    } else {
	    $data['heading_title'] = $this->language->get('heading_title');
    }

		$this->load->model('catalog/category');
		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));

		$data['categories'] = array();
		$results = $this->config->get('mobile_category');
		if ($results) {
			foreach ($results as $result) {
				if (!$result['status']) {
					continue;
				}
				$category = $this->model_catalog_category->getCategory($result['category_id']);
				if (!$category) {
					continue;
				}

				$mobile_image = $this->model_catalog_category->getCategoryMobileImage($result['category_id']);
	      if ($mobile_image) {
	        $image = $this->model_tool_image->resize($mobile_image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
	      } else {
	        if ($category['image']) {
	          $image = $this->model_tool_image->resize($category['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
	        } else {
	          $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
	        }
	      }

				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'],
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id']),
					'image'       => $image
				);
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/mobile_category.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/mobile_category.tpl', $data);
		} else {
			return $this->load->view('default/template/module/mobile_category.tpl', $data);
		}
	}
}
