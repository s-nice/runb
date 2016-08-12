<?php 
class ModelPaymentupop extends Model {
  	public function getMethod($address) {
		$this->load->language('payment/upop');
		
		if ($this->config->get('upop_status')) {
      		$status = TRUE;
      	} else {
			$status = FALSE;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'         => 'upop',
        		'title'      => $this->language->get('text_title'),
        		'terms'      => '',
				'sort_order' => $this->config->get('upop_sort_order')
			
      		);
    	}
	
    	return $method_data;
  	}
}
?>