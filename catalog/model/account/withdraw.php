<?php
class ModelAccountWithdraw extends Model {
	public function addWithdraw($data) {
		$this->event->trigger('pre.customer.add.withdraw', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "withdraw SET customer_id = '" . (int)$this->customer->getId() . "', amount = '" . (float)$data['amount'] . "', bank_account = '" . trim($data['bank_account']) . "', status = 0, refused = 0, message = '" . $this->db->escape($data['message']) . "', date_added =  NOW()");

		$withdraw_id = $this->db->getLastId();

		// Add transaction
		$this->load->language('account/withdraw');
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$this->customer->getId() . "', order_id = 0, order_recharge_id = 0, description = '" . $this->language->get('text_withdraw_trans') . $withdraw_id . "', amount = '" . -(float)$data['amount'] . "', withdraw_id = '" . (int)$withdraw_id . "', date_added = NOW()");
		//$this->load->model('account/transaction');
		//$this->model_account_transaction->addTransaction($this->customer->getId(), $description = '', $data['amount'], 0, 0, $withdraw_id);

		$this->event->trigger('post.customer.add.withdraw', $withdraw_id);

		return $withdraw_id;
	}

	public function getWithdraws($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "withdraw` WHERE customer_id = '" . (int)$this->customer->getId() . "'";

		$sort_data = array(
			'amount',
			'message',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
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

	public function getTotalWithdraws() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "withdraw` WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->row['total'];
	}
}