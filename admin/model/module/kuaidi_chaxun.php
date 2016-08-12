<?php
class ModelModuleKuaiDiChaxun extends Model {
	public function addOrderShippingtrack($order_id, $data) {
		$this->load->model('sale/order');
		$order_info = $this->model_sale_order->getOrder($order_id);
		$language = new Language($order_info['language_directory']);
		$language->load('default');
		$language->load('mail/order');
		
		//增加快递单号和快递公司信息
		if($data['kd_kuaidi_code']){
			//更新订单状态 并 记录快递单号
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_shippingtrack SET order_id = '" . (int)$order_id . "', kd_kuaidi_code = '" . trim($data['kd_kuaidi_code']) . "', kd_kuaidi_number = '" . trim($data['kd_kuaidi_number']) . "', kd_comment = '" . trim($data['kd_comment']) . "', date_added = NOW()");
		}
	}

	public function delOrderShippingtrack($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_shippingtrack WHERE id = '" . (int)$id . "'");
	}

	public function getOrderShippingtracks($order_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_shippingtrack WHERE order_id = '" . (int)$order_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalOrderShippingtracks($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_shippingtrack WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getShippingtrack($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_shippingtrack WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getKuaidiNameByCode($code) {
		$kd_kuaidi_shuju = $this->config->get('kuaidi_chaxun_shuju');
		
		foreach ($kd_kuaidi_shuju as $kuaidi) {
			if($kuaidi['code'] == $code){
				return $kuaidi['name'];
			}
		}

		return $code;
	}
}
