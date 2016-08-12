<?php
class ControllerProductAskquestion extends Controller {
	private $error = array();

	public function questionAnswer()
	{
	
		$this->load->model('catalog/askquestion');
		$this->load->language('product/askquestion');
		
		if(isset($this->request->get['questionProductId'])){
			$productId=$this->request->get['questionProductId'];
			$productQuestionerName=$this->request->get['questionerName'];
			$productQuestion=$this->request->get['questionerQuestion'];
			$questionStatus="0";
			$this->model_catalog_askquestion->addQuestionAnswer($productId,$productQuestionerName,$productQuestion,$questionStatus); 
			
			echo $this->language->get('text_success');//"Thanks your question has been valuble to us.we will answer you shortly";
		}
	}
}
?>