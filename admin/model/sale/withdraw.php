<?php
class ModelSaleWithdraw extends Model {
	public function getWithdraws($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "withdraw` w";

		$implode = array();

		if (!empty($data['filter_withdraw_id'])) {
			$implode[] = "withdraw_id = '" . (int)$data['filter_withdraw_id'] . "'";
		}

		if (isset($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_refused'])) {
			$implode[] = "refused = '" . (int)$data['filter_refused'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'withdraw_id',
			'status',
			'refused',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY withdraw_id";
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

	public function getTotalWithdraws($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "withdraw`r";

		$implode = array();

		if (!empty($data['filter_withdraw_id'])) {
			$implode[] = "withdraw_id = '" . (int)$data['filter_withdraw_id'] . "'";
		}

		if (!empty($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_refused'])) {
			$implode[] = "refused = '" . (int)$data['filter_refused'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function editWithdraw($withdraw_id, $data) {
		//�������Ҫ���ڴ���֮ǰ���Ա���ȫ��
		$this->load->language('sale/withdraw');
		if (!(int)$data['refused']) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_transaction WHERE withdraw_id = '" . (int)$withdraw_id . "'");
			if (!$query->rows) {
				$withdraw_info = $this->getWithdraw($withdraw_id);
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . $withdraw_info['customer_id'] . "', order_id = 0, order_recharge_id = 0, description = '" . $this->language->get('text_withdraw_trans') . $withdraw_info['withdraw_id'] . "', amount = '" . -(float)$withdraw_info['amount'] . "', withdraw_id = '" . $withdraw_info['withdraw_id'] . "', date_added = NOW()");
			}
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "withdraw` SET `bank_account` = '" . trim($data['bank_account']) . "', `status` = " . (int)$data['status'] . ", `refused` = " . (int)$data['refused'] . " WHERE withdraw_id = '" . (int)$withdraw_id . "'");

		//�������Ҫ���ڴ�����֮�����ӣ��Ա���ȫ��
		if ((int)$data['refused']) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_transaction` WHERE withdraw_id = '" . (int)$withdraw_id . "'");
		}
	}

	public function getWithdraw($withdraw_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "withdraw WHERE withdraw_id = '" . (int)$withdraw_id . "'");

		return $query->row;
	}

/*
	public function addWithdraw($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "withdraw` SET order_id = '" . (int)$data['order_id'] . "', product_id = '" . (int)$data['product_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', withdraw_reason_id = '" . (int)$data['withdraw_reason_id'] . "', withdraw_action_id = '" . (int)$data['withdraw_action_id'] . "', withdraw_status_id = '" . (int)$data['withdraw_status_id'] . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_added = NOW(), date_modified = NOW()");
	}

	public function deleteWithdraw($withdraw_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "withdraw` WHERE withdraw_id = '" . (int)$withdraw_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "withdraw_history WHERE withdraw_id = '" . (int)$withdraw_id . "'");
	}

	public function getTotalWithdrawsByWithdrawStatusId($withdraw_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "withdraw` WHERE withdraw_status_id = '" . (int)$withdraw_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalWithdrawsByWithdrawReasonId($withdraw_reason_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "withdraw` WHERE withdraw_reason_id = '" . (int)$withdraw_reason_id . "'");

		return $query->row['total'];
	}

	public function getTotalWithdrawsByWithdrawActionId($withdraw_action_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "withdraw` WHERE withdraw_action_id = '" . (int)$withdraw_action_id . "'");

		return $query->row['total'];
	}
*/
}