<?php
class ControllerMobileCategoryhome extends Controller {
  public function index() {
    $this->document->setTitle($this->config->get('config_meta_title'));
    $this->document->setDescription($this->config->get('config_meta_description'));
    $this->document->setKeywords($this->config->get('config_meta_keyword'));

    if (isset($this->request->get['route'])) {
      $this->document->addLink(HTTP_SERVER, 'canonical');
    }

    $this->load->language('common/header');
    $data['text_category'] = $this->language->get('text_category');
    $data['text_all'] = $this->language->get('text_all');

    $data['search'] = $this->load->controller('common/search');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['header'] = $this->load->controller('common/header');
    $data['footer'] = $this->load->controller('common/footer');

    $data['placeholder'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
    // Menu
    $this->load->model('catalog/category');

    $this->load->model('catalog/product');

    $data['categories'] = array();

    $categories = $this->model_catalog_category->getCategories(0);

    foreach ($categories as $category) {
      // Level 2
      $children_data = array();

      $children = $this->model_catalog_category->getCategories($category['category_id']);

      foreach ($children as $child) {
        $filter_data = array(
          'filter_category_id'  => $child['category_id'],
          'filter_sub_category' => true
        );

        $mobile_image = $this->model_catalog_category->getCategoryMobileImage($child['category_id']);
        if ($mobile_image) {
          $image = $this->model_tool_image->resize($mobile_image, 100, 100);
        } else {
          if ($child['image']) {
            $image = $this->model_tool_image->resize($child['image'], 100, 100);
          } else {
            $image = $this->model_tool_image->resize('placeholder.png', 100, 100);
          }
        }

        $children_data[] = array(
          'thumb'    => $image,
          'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
          'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
        );
      }

      $mobile_image = $this->model_catalog_category->getCategoryMobileImage($category['category_id']);
      if ($mobile_image) {
        $image = $this->model_tool_image->resize($mobile_image, 100, 100);
      } else {
        if ($category['image']) {
          $image = $this->model_tool_image->resize($category['image'], 100, 100);
        } else {
          $image = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
      }
      // Level 1
      $data['categories'][] = array(
        'name'     => $category['name'],
        'thumb'    => $image,
        'children' => $children_data,
        'column'   => $category['column'] ? $category['column'] : 1,
        'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
      );
    }
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile/categoryhome.tpl')) {
      $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/mobile/categoryhome.tpl', $data));
    } else {
      $this->response->setOutput($this->load->view('default/template/default/categoryhome.tpl', $data));
    }
  }
}
