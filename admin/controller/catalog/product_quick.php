<?php
class ControllerCatalogProductQuick extends Controller {
  private $error = array();

  public function index() {}

  public function name() {
    $json = array();

    if ($this->permission()) {
      if (isset($this->request->post['product_id'])) {
        $product_id = (int)$this->request->post['product_id'];
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品ID：product_id';
        $json['data'] = null;
      }

      if (!$json && (isset($this->request->post['name']))) {
        $name = trim($this->request->post['name']);
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品名称：name';
        $json['data'] = null;
      }
    } else {
      $json['status'] = 0;
      $json['message'] = $this->error['warning'];
      $json['data'] = null;
    }

    if (!$json) {
      $this->load->model('catalog/product_quick');
      $this->model_catalog_product_quick->editProductName($product_id, $name);

      $json['status'] = 1;
      $json['message'] = '修改产品名称成功';
      $json['data'] = array(
        'name' => $name,
      );
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function model() {
    $json = array();

    if ($this->permission()) {
      if (isset($this->request->post['product_id'])) {
        $product_id = (int)$this->request->post['product_id'];
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品ID：product_id';
        $json['data'] = null;
      }

      if (!$json && (isset($this->request->post['model']))) {
        $model = trim($this->request->post['model']);
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品名称：model';
        $json['data'] = null;
      }
    } else {
      $json['status'] = 0;
      $json['message'] = $this->error['warning'];
      $json['data'] = null;
    }

    if (!$json) {
      $this->load->model('catalog/product_quick');
      $this->model_catalog_product_quick->editProductModel($product_id, $model);

      $json['status'] = 1;
      $json['message'] = '修改产品型号成功';
      $json['data'] = array(
        'model' => $model,
      );
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function price() {
    $json = array();

    if($this->permission()) {
      if (isset($this->request->post['product_id'])) {
        $product_id = (int)$this->request->post['product_id'];
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品ID：product_id';
        $json['data'] = null;
      }

      if (!$json && (isset($this->request->post['price']))) {
        $price = trim($this->request->post['price']);
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品名称：price';
        $json['data'] = null;
      }
    } else {
      $json['status'] = 0;
      $json['message'] = $this->error['warning'];
      $json['data'] = null;
    }

    if (!$json) {
      $this->load->model('catalog/product_quick');
      $this->model_catalog_product_quick->editProductPrice($product_id, $price);

      $json['status'] = 1;
      $json['message'] = '修改产品价格成功';
      $json['data'] = array(
        'price' => $price,
      );
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function quantity() {
    $json = array();

    if ($this->permission()) {
      if (isset($this->request->post['product_id'])) {
        $product_id = (int)$this->request->post['product_id'];
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品ID：product_id';
        $json['data'] = null;
      }

      if (!$json && isset($this->request->post['quantity']) && (int)$this->request->post['quantity']) {
        $quantity = (int)$this->request->post['quantity'];
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取到值：quantity';
        $json['data'] = null;
      }
    } else {
      $json['status'] = 0;
      $json['message'] = $this->error['warning'];
      $json['data'] = null;
    }

    if (!$json) {
      $this->load->model('catalog/product_quick');
      $this->model_catalog_product_quick->editProductQuantity($product_id, $quantity);

      $json['status'] = 1;
      $json['message'] = '修改产品数量成功';
      $json['data'] = array(
        'quantity' => $quantity,
      );
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function status() {
    $json = array();

    if ($this->permission()) {
      if (isset($this->request->post['product_id'])) {
        $product_id = (int)$this->request->post['product_id'];
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取产品ID：product_id';
        $json['data'] = null;
      }

      if (!$json && isset($this->request->post['status'])) {
        if ((int)$this->request->post['status'] > 0) {
          $status = 1;
        } else
          $status = 0;
      } else {
        $json['status'] = 0;
        $json['message'] = '没有获取到值：status';
        $json['data'] = null;
      }
    } else {
      $json['status'] = 0;
      $json['message'] = $this->error['warning'];
      $json['data'] = null;
    }

    if (!$json) {
      $this->load->model('catalog/product_quick');
      $this->model_catalog_product_quick->editProductStatus($product_id, $status);

      $json['status'] = 1;
      $json['message'] = '修改产品状态成功';
      $json['data'] = array(
        'status' => $status,
      );
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  protected function permission() {
    if (!$this->user->hasPermission('modify', 'catalog/attribute')) {
      $this->error['warning'] = '您没有操作权限！';
    }

    return !$this->error;
  }
}
