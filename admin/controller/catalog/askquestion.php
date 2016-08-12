<?php 
class ControllerCatalogAskquestion extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('catalog/askquestion');

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->load->model('catalog/product');

		$this->getList();
	}

public function changeQuesStatus()
	{
		$this->load->language('catalog/askquestion');
		$productId=$_GET['productId'];
		
		$query=mysql_query("SELECT product_status FROM " . DB_PREFIX . "product_questions where id='".$productId."'");
		
		while($row=mysql_fetch_object($query))
		{
			$statusId=$row->product_status;
		}
		$setZero=0;
		$setOne=1;
		if($statusId=='1')
		{
			$this->db->query("UPDATE " . DB_PREFIX . "product_questions SET product_status = '" . $setZero . "' where id='".$productId."'");
			echo $this->language->get('text_disabled');//"Disabled";
		
		}
		elseif($statusId=='0')
		{
			$this->db->query("UPDATE " . DB_PREFIX . "product_questions SET product_status = '" . $setOne . "' where id='".$productId."'");
			echo $this->language->get('text_enabled');//"Enabled";
		}
		else
		{
		}
	}
	public function changeQuesDelete()
	{
		$quesId=$_GET['quesId'];
		
		$sql = "Delete FROM " . DB_PREFIX . "product_questions where id='".$quesId."'";
		$query = $this->db->query($sql);
		
		echo "deleted";
}

	public function insertAnswerForQues()
	{
		$this->load->language('catalog/askquestion');

		$this->load->model('catalog/product');
		$getProduct_id=$this->request->get['productidForQus'];
		$getQuestionAnswer=$this->request->get['InsertanswerForQus'];
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product_questions SET product_answer = '" . $getQuestionAnswer. "',product_status = '1', question_answred_date = NOW() where id='".$getProduct_id."'");
    echo $this->language->get('text_answered');//"You have answered this question";
	}

	protected function getList() {
		$this->load->language('catalog/askquestion');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_customer_name'])) {
			$filter_customer_name = $this->request->get['filter_customer_name'];
		} else {
			$filter_customer_name = null;
		}

		if (isset($this->request->get['filter_question'])) {
			$filter_question = $this->request->get['filter_question'];
		} else {
			$filter_question = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.askdate';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}

		if (isset($this->request->get['filter_question'])) {
			$url .= '&filter_question=' . $this->request->get['filter_question'];
		}		

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['delete'] = $this->url->link('catalog/product/changeQuesDelete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['getQues'] = array();

		$fdata = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_customer_name'	  => $filter_customer_name,
			'filter_question' => $filter_question,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$this->load->model('catalog/askquestion');
    $results = $this->model_catalog_askquestion->GetQuestionProduct($fdata);

		$url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG);	
    foreach($results as $result){
    	$data['getQues'][] = array(
    			'id' => $result['id'],
    			'user_name' => $result['user_name'],
    			'name' => $result['name'],
    			'model' => $result['model'],
    			'product_question' => $result['product_question'],
    			'product_answer' => $result['product_answer'],
    			'product_status' => $result['product_status'],
    			'question_asked_date' => $result['question_asked_date'],
    			'question_answred_date' => $result['question_answred_date'],
    			'href' => $url->link('product/product', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL'),
    		);
    }
    
		$data['sessionAjax']="token=".$this->session->data['token'];

		$data['heading_title'] = $this->language->get('heading_title');		

		$data['text_enabled'] = $this->language->get('text_enabled');		
		$data['text_disabled'] = $this->language->get('text_disabled');		
		$data['text_no_results'] = $this->language->get('text_no_results');		
		$data['text_image_manager'] = $this->language->get('text_image_manager');		
		$data['text_view_anwser'] = $this->language->get('text_view_anwser');		
		$data['text_close'] = $this->language->get('text_close');		
		$data['text_question'] = $this->language->get('text_question');		
		$data['text_answer'] = $this->language->get('text_answer');		
		$data['text_your_answer'] = $this->language->get('text_your_answer');		
		$data['text_click_answer'] = $this->language->get('text_click_answer');		
		$data['text_delete'] = $this->language->get('text_delete');		
		$data['text_list'] = $this->language->get('text_list');		

		$data['column_image'] = $this->language->get('column_image');		
		$data['column_name'] = $this->language->get('column_name');		
		$data['column_model'] = $this->language->get('column_model');		
		$data['column_customer_name'] = $this->language->get('column_customer_name');		
		$data['column_question'] = $this->language->get('column_question');		
		$data['column_answer'] = $this->language->get('column_answer');		
		$data['column_question_added'] = $this->language->get('column_question_added');		
		$data['column_answer_added'] = $this->language->get('column_answer_added');		
		$data['column_status'] = $this->language->get('column_status');		
		$data['column_action'] = $this->language->get('column_action');		

		$data['button_delete'] = $this->language->get('button_delete');		
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}

		if (isset($this->request->get['filter_question'])) {
			$url .= '&filter_question=' . $this->request->get['filter_question'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_model'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$data['sort_customer_name'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=pq.user_name' . $url, 'SSL');
		$data['sort_question'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=pq.product_question' . $url, 'SSL');
		$data['sort_question_added'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=pq.question_asked_date' . $url, 'SSL');
		$data['sort_answer_added'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=pq.question_answred_date' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=pq.product_status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . '&sort=pq.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_question=' . $this->request->get['filter_question'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$ask_total = $this->model_catalog_askquestion->GetTotalQuestion();

		$pagination = new Pagination();
		$pagination->total = $ask_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/askquestion', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_customer_name'] = $filter_customer_name;
		$data['filter_question'] = $filter_question;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['results'] = sprintf($this->language->get('text_pagination'), ($ask_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ask_total - $this->config->get('config_limit_admin'))) ? $ask_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ask_total, ceil($ask_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/askquestion_list.tpl', $data));
	}
}
?>