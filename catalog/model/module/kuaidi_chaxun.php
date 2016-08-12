<?php
class ModelModuleKuaidiChaxun extends Model {
	public function getOrderShippingtrack($order_id) {
		$order_track_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_shippingtrack` WHERE order_id = '" . (int)$order_id . "'");

		return $order_track_query->rows;
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