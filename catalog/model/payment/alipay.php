<?php 
class ModelPaymentAlipay extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('payment/alipay');
		
		if ($this->config->get('alipay_total') > 0 && $this->config->get('alipay_total') > $total) {
			$status = false;
		} else {
			$status = true;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'         => 'alipay',
        		'title'      => $this->language->get('text_title'),
        		'terms'      => '',
						'sort_order' => $this->config->get('alipay_sort_order')
      		);
    	}
	
    	return $method_data;
  	}
  	
  	//sunboy add
	public function getOrderProduct($order_id) {
		$order_query = $this->db->query("SELECT op.order_id,op.product_id,
																							op.name,op.model,op.quantity,op.total,
																							orde.shipping_firstname,orde.shipping_address_1,
																							orde.telephone,orde.shipping_postcode
																							 FROM `" . DB_PREFIX . "order_product` as op, 
																								`" . DB_PREFIX . "order` as orde 
		 WHERE op.order_id = orde.order_id and op.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {			

			return array(
				'order_id'                => $order_query->row['order_id'],
				'product_id'                => $order_query->row['product_id'],
				'product_name'                => $order_query->row['name'],
				'product_model'               => $order_query->row['model'],
				'product_quantity'           => $order_query->row['quantity'],
				'product_total'              => $order_query->row['total'],
				
				'receive_name'               => $order_query->row['shipping_firstname']	,				
				'receive_address'            => $order_query->row['shipping_address_1']	,
				'receive_phone'              => $order_query->row['telephone']	,
				'receive_zip'                => $order_query->row['shipping_postcode']	
			);
		} else {
			$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
			return array(
				'product_name'          =>$order_query->row['description'],
				'product_quantity'      => 1
			);
		}
		
	}
}