<?php
class ModelCatalogProductQuick extends Model {
  public function editProductName($product_id, $name) {
    $this->db->query("UPDATE " . DB_PREFIX . "product_description SET name = '" . $this->db->escape($name) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
  }

  public function editProductModel($product_id, $model) {
    $this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($model) . "' WHERE product_id = '" . (int)$product_id . "'");
  }

  public function editProductPrice($product_id, $price) {
    $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (float)$price . "' WHERE product_id = '" . (int)$product_id . "'");
  }

  public function editProductQuantity($product_id, $quantity) {
    $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE product_id = '" . (int)$product_id . "'");
  }

  public function editProductStatus($product_id, $status) {
    $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '" . (int)$status . "' WHERE product_id = '" . (int)$product_id . "'");
  }
}