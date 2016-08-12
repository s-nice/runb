<?php
class ModelCatalogFlashSale extends Model {
	public function getLatestCampaigns() {
		$product_data = array();

		$query = $this->db->query("SELECT fs.flash_sale_id, fs.product_id, fs.quantity, fs.display_quantity, fs.flash_sale_price, fs.start_time, fs.end_time, fsd.product_name FROM " . DB_PREFIX . "flash_sale fs LEFT JOIN " . DB_PREFIX . "flash_sale_description fsd ON (fs.flash_sale_id = fsd.flash_sale_id AND fsd.language_id ='" . $this->config->get('config_language_id') . "') LEFT JOIN " . DB_PREFIX . "product p ON (fs.product_id = p.product_id) WHERE p.status = '1' AND fs.status = '1' ORDER BY fs.start_time DESC LIMIT 5");
		if ($query->num_rows) {
			foreach ($query->rows as $result) {
				$product_data[] = array(
					'flash_sale_id' => $result['flash_sale_id'],
					'product_id' => $result['product_id'],
					'product_name' => $result['product_name'],
					'quantity' => $result['quantity'],
					'display_quantity' => $result['display_quantity'],
					'flash_sale_price' => $result['flash_sale_price'],
					'start_time' => $result['start_time'],
					'end_time' => $result['end_time'],
				);
			}
		}

		return $product_data;
	}

	public function getCampaign($flash_sale_id) {
		$query = $this->db->query("SELECT fs.flash_sale_id, fs.product_id, fs.quantity, fs.display_quantity, fs.flash_sale_price, fs.start_time, fs.end_time, fs.status, fsd.product_name, fsd.description FROM " . DB_PREFIX . "flash_sale fs LEFT JOIN " . DB_PREFIX . "flash_sale_description fsd ON (fs.flash_sale_id = fsd.flash_sale_id AND fsd.language_id ='" . $this->config->get('config_language_id') . "') LEFT JOIN " . DB_PREFIX . "product p ON (fs.product_id = p.product_id) WHERE fs.flash_sale_id = '" . (int)$flash_sale_id . "' AND p.status = '1' AND fs.status = '1'");

		if ($query->num_rows) {
			return array(
				'flash_sale_id' => $query->row['flash_sale_id'],
				'product_id' => $query->row['product_id'],
				'product_name' => $query->row['product_name'],
				'description' => $query->row['description'],
				'quantity' => $query->row['quantity'],
				'display_quantity' => $query->row['display_quantity'],
				'flash_sale_price' => $query->row['flash_sale_price'],
				'start_time' => $query->row['start_time'],
				'end_time' => $query->row['end_time'],
				'status' => (int)$query->row['status'],
			);
		} else {
			return false;
		}
	}

	public function validateCustomerPermission($flash_sale_id, $customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "flash_sale_activity WHERE flash_sale_id = '" . (int)$flash_sale_id . "' AND customer_id = '" . (int)$customer_id . "'");
		if ($query->num_rows) {
			return false;
		} else {
			return true;
		}
	}

	public function addCustomerActivity($flash_sale_id, $customer_id, $product_id) {
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "flash_sale_activity SET flash_sale_id = '" . (int)$flash_sale_id . "', customer_id = '" . (int)$customer_id . "', product_id = '" . (int)$product_id . "', date_added = NOW()");
	}

	public function countUsedQuantity($flash_sale_id) {
		$query = $this->db->query("SELECT COUNT(flash_sale_id) AS total FROM " . DB_PREFIX . "flash_sale_activity WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");
		if (isset($query->row['total'])) {
			return (int)$query->row['total'];
		} else {
			return 0;
		}
	}

	public function checkProductHasCampaign($product_id) {
		$query = $this->db->query("SELECT fs.flash_sale_id FROM " . DB_PREFIX . "flash_sale fs WHERE fs.product_id = '" . (int)$product_id . "' AND fs.start_time < NOW() AND fs.end_time > NOW() AND fs.status = '1'");
		if ($query->num_rows) {
			return (int)$query->row['flash_sale_id'];
		} else {
			return false;
		}
	}
}