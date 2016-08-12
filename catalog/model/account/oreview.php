<?php
class ModelAccountOreview extends Model {
	public function addOreview($order_product_id, $data) {
		$this->event->trigger('pre.oreview.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "order_product_review SET customer_id = '" . (int)$this->customer->getId() . "', order_product_id = '" . (int)$order_product_id . "', text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "', date_added = NOW()");

		$oreview_id = $this->db->getLastId();
/*
		if ($this->config->get('config_review_mail')) {
			$this->load->language('mail/review');
			$this->load->model('catalog/product');
			
			$product_info = $this->model_catalog_product->getProduct($product_id);

			$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

			$message  = $this->language->get('text_waiting') . "\n";
			$message .= sprintf($this->language->get('text_product'), html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')) . "\n";
			$message .= sprintf($this->language->get('text_reviewer'), html_entity_decode($data['name'], ENT_QUOTES, 'UTF-8')) . "\n";
			$message .= sprintf($this->language->get('text_rating'), $data['rating']) . "\n";
			$message .= $this->language->get('text_review') . "\n";
			$message .= html_entity_decode($data['text'], ENT_QUOTES, 'UTF-8') . "\n\n";

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setText($message);
			$mail->send();

			// Send to additional alert emails
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
*/
		$this->event->trigger('post.oreview.add', $oreview_id);
	}

	public function getOreviewsByProductId($product_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT r.order_product_review_id, r.author, r.rating, r.text, p.product_id, pd.name, p.price, p.image, r.date_added FROM " . DB_PREFIX . "order_product_review r LEFT JOIN " . DB_PREFIX . "order_product op ON (r.order_product_id = op.order_product_id) LEFT JOIN " . DB_PREFIX . "product p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalOreviewsByProductId($product_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_product_review r LEFT JOIN " . DB_PREFIX . "order_product op ON (r.order_product_id = op.order_product_id) LEFT JOIN " . DB_PREFIX . "product p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}

	public function isReviewed($order_product_id) {
		$query = $this->db->query("SELECT order_product_review_id FROM " . DB_PREFIX . "order_product_review r WHERE order_product_id = '" . (int)$order_product_id . "' AND status = '1' AND customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->num_rows;
	}

	/*
	* 获取当用户购买完成的订单产品列表
	* config_complete_status：订单正常成功完成的状态（不包含取消和关闭的订单）
	*/
	public function getOreviews($data = array()) {
		$order_statuses = $this->config->get('config_complete_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		$sql = "SELECT op.*, o.date_added, p.image, opr.text, opr.rating, order_product_review_id AS reviewed
						FROM " . DB_PREFIX . "order_product op 
						LEFT JOIN " . DB_PREFIX . "order o ON (o.order_id = op.order_id) 
						LEFT JOIN " . DB_PREFIX . "product p ON (op.product_id = p.product_id) 
						LEFT JOIN " . DB_PREFIX . "order_product_review opr ON (opr.order_product_id = op.order_product_id) 
						WHERE (" . implode(" OR ", $implode) . ")";

		$implode = array();

		if (isset($data['filter_reviewed'])) {
			if ($data['filter_reviewed']) {
				$implode[] = "opr.order_product_review_id IS NOT NULL";
			} else {
				$implode[] = "opr.order_product_review_id IS NULL";
			}
		}

		if (isset($data['filter_customer_id'])) {
			$implode[] = "o.customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (isset($data['filter_order_id'])) {
			$implode[] = "o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (isset($data['filter_date_added'])) {
			$implode[] = "DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'o.order_id',
			'o.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalOreviews($data = array()) {
		$order_statuses = $this->config->get('config_complete_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		$sql = "SELECT COUNT(*) AS total
						FROM " . DB_PREFIX . "order_product op 
						LEFT JOIN " . DB_PREFIX . "order o ON (o.order_id = op.order_id) 
						LEFT JOIN " . DB_PREFIX . "order_product_review opr ON (opr.order_product_id = op.order_product_id) 
						WHERE (" . implode(" OR ", $implode) . ")";

		$implode = array();

		if (isset($data['filter_reviewed'])) {
			if ($data['filter_reviewed']) {
				$implode[] = "opr.order_product_review_id IS NOT NULL";
			} else {
				$implode[] = "opr.order_product_review_id IS NULL";
			}
		}

		if (isset($data['filter_reviewed'])) {
			if ($data['filter_reviewed']) {
				$implode[] = "opr.order_product_review_id IS NOT NULL";
			} else {
				$implode[] = "opr.order_product_review_id IS NULL";
			}
		}

		if (isset($data['filter_customer_id'])) {
			$implode[] = "o.customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (isset($data['filter_order_id'])) {
			$implode[] = "o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (isset($data['filter_date_added'])) {
			$implode[] = "DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}


	public function getOreview($order_product_review_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product_review WHERE order_product_review_id = '" . (int)$order_product_review_id . "' AND status = '1'");

		return $query->row;
	}

	public function getRatingByProductId($product_id){
		$query = $this->db->query("SELECT AVG(rating) AS rating FROM " . DB_PREFIX . "order_product_review r LEFT JOIN " . DB_PREFIX . "order_product op ON (r.order_product_id = op.order_product_id) WHERE op.product_id = '" . (int)$product_id . "' AND r.status = '1' ");

		return $query->row['rating'];
	}
}