<?php
class ModelCatalogOreview extends Model {
	public function addReview($data) {
		$this->event->trigger('pre.admin.order_product_review.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "order_product_review SET order_product_id = '" . (int)$data['order_product_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$order_product_review_id = $this->db->getLastId();

		$this->cache->delete('product');

		$this->event->trigger('post.admin.order_product_review.add', $order_product_review_id);

		return $order_product_review_id;
	}

	public function editReview($order_product_review_id, $data) {
		$this->event->trigger('pre.admin.order_product_review.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "order_product_review SET text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE order_product_review_id = '" . (int)$order_product_review_id . "'");

		$this->cache->delete('product');

		$this->event->trigger('post.admin.order_product_review.edit', $order_product_review_id);
	}

	public function deleteReview($order_product_review_id) {
		$this->event->trigger('pre.admin.order_product_review.delete', $order_product_review_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product_review WHERE order_product_review_id = '" . (int)$order_product_review_id . "'");

		$this->cache->delete('product');

		$this->event->trigger('post.admin.order_product_review.delete', $order_product_review_id);
	}

	public function getReview($order_product_review_id) {
		$query = $this->db->query("SELECT DISTINCT *, op.name AS product FROM " . DB_PREFIX . "order_product_review r LEFT JOIN " . DB_PREFIX . "order_product op ON (r.order_product_id = op.order_product_id) WHERE r.order_product_review_id = '" . (int)$order_product_review_id . "'");

		return $query->row;
	}

	public function getReviews($data = array()) {
		$sql = "SELECT r.order_product_review_id, op.name, c.firstname AS customer, r.customer_id, r.rating, r.status, r.date_added 
						FROM " . DB_PREFIX . "order_product_review r 
						LEFT JOIN " . DB_PREFIX . "order_product op ON (r.order_product_id = op.order_product_id) 
						LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = r.customer_id) 
						WHERE 1=1";

		if (!empty($data['filter_product'])) {
			$sql .= " AND op.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND c.firstname LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'op.name',
			'customer',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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
	}

	public function getTotalReviews($data = array()) {
		$sql = "SELECT COUNT(*) AS total 
						FROM " . DB_PREFIX . "order_product_review r 
						LEFT JOIN " . DB_PREFIX . "order_product op ON (r.order_product_id = op.order_product_id) 
						LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = r.customer_id) 
						WHERE 1=1";

		if (!empty($data['filter_product'])) {
			$sql .= " AND op.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND c.firstname LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_product_review WHERE status = '0'");

		return $query->row['total'];
	}
}