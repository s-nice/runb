<?php
class ModelModuleFlashSale extends Model {
	public function createTables(){ //Create tables
		//Create  main table
		$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX ."flash_sale (flash_sale_id int(11) NOT NULL AUTO_INCREMENT, product_id int(11) NOT NULL, quantity int(4) default 1, display_quantity int(4) default 1, flash_sale_price decimal(15,4) default 0, start_time datetime NOT NULL, end_time datetime NOT NULL, status tinyint(1) default 0, PRIMARY KEY(flash_sale_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
		$this->db->query($sql);

		//Create description table
		$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX ."flash_sale_description (flash_sale_id int(11) NOT NULL, language_id int(11) NOT NULL, product_name varchar(64) NOT NULL, description text NOT NULL, PRIMARY KEY(flash_sale_id, language_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
		$this->db->query($sql);

		//Create customer activity table
		$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX ."flash_sale_activity (activity_id int(11) NOT NULL AUTO_INCREMENT, flash_sale_id int(11) NOT NULL, customer_id int(11) NOT NULL, product_id int(11) NOT NULL, date_added datetime NOT NULL, PRIMARY KEY(activity_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
		$this->db->query($sql);
	}

	public function getAllFlashSales($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "flash_sale fs LEFT JOIN " . DB_PREFIX . "flash_sale_description fsd ON (fs.flash_sale_id = fsd.flash_sale_id) WHERE fsd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'fsd.product_name',
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY fsd.product_name";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "flash_sale fs LEFT JOIN " . DB_PREFIX . "flash_sale_description fsd ON (fs.flash_sale_id = fsd.flash_sale_id) WHERE fsd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY fsd.product_name");
			return $query->rows;
		}
	}

	public function getProductInfo($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "'");

		return $query->row;
	}

	public function addFlashSale($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "flash_sale SET product_id = '" . (int)$data['product_id'] . "', quantity = '" .(int)$data['quantity'] . "', display_quantity = '" .(int)$data['display_quantity'] . "', flash_sale_price = '" . (float)$data['flash_sale_price'] . "', start_time = '" . $this->db->escape($data['start_time']) . "', end_time = '" . $this->db->escape($data['end_time']) . "', status = '" . (int)$data['status'] . "'");

		$flash_sale_id = $this->db->getLastId();
		foreach ($data['flash_sale_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "flash_sale_description SET flash_sale_id = '" . (int)$flash_sale_id . "', language_id = '" . (int)$language_id . "', product_name = '" . $this->db->escape($value['product_name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		return $flash_sale_id;
	}

	public function editFlashSale($flash_sale_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "flash_sale SET product_id = '" . (int)$data['product_id'] . "', quantity = '" . (int)$data['quantity'] . "', display_quantity = '" . (int)$data['display_quantity'] . "', flash_sale_price = '" . (float)$data['flash_sale_price'] . "', start_time = '" . $this->db->escape($data['start_time']) . "', end_time = '" . $this->db->escape($data['end_time']) . "', status = '" . (int)$data['status'] . "' WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "flash_sale_description WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");

		foreach ($data['flash_sale_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "flash_sale_description SET flash_sale_id = '" . (int)$flash_sale_id . "', language_id = '" . (int)$language_id . "', product_name = '" . $this->db->escape($value['product_name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
	}

	public function getFlashSale($flash_sale_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "flash_sale WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");
		return $query->row;
	}

	public function getFlashSaleDescriptions($flash_sale_id) {
		$flash_sale_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "flash_sale_description WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");
		foreach ($query->rows as $result) {
			$flash_sale_description_data[$result['language_id']] = array(
				'product_name'            => $result['product_name'],
				'description'      => $result['description'],
			);
		}

		return $flash_sale_description_data;
	}

	public function deleteFlashSale($flash_sale_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "flash_sale WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "flash_sale_description WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");
	}

	public function countUsedQuantity($flash_sale_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT flash_sale_id) AS total FROM " . DB_PREFIX . "flash_sale_activity WHERE flash_sale_id = '" . (int)$flash_sale_id . "'");
		if (isset($query->row['total'])) {
			return (int)$query->row['total'];
		} else {
			return 0;
		}
	}
}