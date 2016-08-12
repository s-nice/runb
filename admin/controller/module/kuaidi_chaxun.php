<?php
class ControllerModuleKuaiDiChaxun extends Controller {
	private $error = array(); 
	
	/*
	* 后台模块首页 
	*/
	public function index() {
				
		//加载语言文件
		$this->load->language('module/kuaidi_chaxun');
		
		//设置titile
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//编辑
			$this->model_setting_setting->editSetting('kuaidi_chaxun', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		//授权的key
		$data['entry_key'] = $this->language->get('entry_key');
		//商户ID
		$data['entry_id'] = $this->language->get('entry_id');
		//快递平台
		$data['entry_platform'] = $this->language->get('entry_platform');
		//快递公司代码
		$data['entry_code'] = $this->language->get('entry_code');
		//公司名称
		$data['entry_name'] = $this->language->get('entry_name');
		//是否可用
		$data['entry_status'] = $this->language->get('entry_status');
		//排列顺序
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		//保存
		$data['button_save'] = $this->language->get('button_save');
		//取消
		$data['button_cancel'] = $this->language->get('button_cancel');
		//添加
		$data['button_add_module'] = $this->language->get('button_add_module');
		//移出
		$data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['key'])) {
			$data['error_key'] = $this->error['key'];
		} else {
			$data['error_key'] = '';
		}

 		if (isset($this->error['id'])) {
			$data['error_id'] = $this->error['id'];
		} else {
			$data['error_id'] = '';
		}

 		if (isset($this->error['platform'])) {
			$data['error_platform'] = $this->error['platform'];
		} else {
			$data['error_platform'] = '';
		}
		
		$data['breadcrumbs'] = array();

 		$data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => false
 		);

 		$data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('text_module'),
				'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => ' :: '
 		);
	
 		$data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('module/kuaidi_chaxun', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => ' :: '
 		);
		
		$data['action'] = $this->url->link('module/kuaidi_chaxun', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		//获取KEY
		if (isset($this->request->post['kuaidi_chaxun_key'])) {
			$data['kuaidi_chaxun_key'] = $this->request->post['kuaidi_chaxun_key'];
		} else {
			$data['kuaidi_chaxun_key'] = $this->config->get('kuaidi_chaxun_key');
		}	

		if (isset($this->request->post['kuaidi_chaxun_id'])) {
			$data['kuaidi_chaxun_id'] = $this->request->post['kuaidi_chaxun_id'];
		} else {
			$data['kuaidi_chaxun_id'] = $this->config->get('kuaidi_chaxun_id');
		}	

		if (isset($this->request->post['kuaidi_chaxun_platform'])) {
			$data['kuaidi_chaxun_platform'] = $this->request->post['kuaidi_chaxun_platform'];
		} else {
			$data['kuaidi_chaxun_platform'] = $this->config->get('kuaidi_chaxun_platform');
		}	
		
		$data['modules'] = array();
		
		//所有快递公司的信息
		if (isset($this->request->post['kuaidi_chaxun_shuju'])) {
			$data['modules'] = $this->request->post['kuaidi_chaxun_shuju'];
		} elseif ($this->config->get('kuaidi_chaxun_shuju')) { 
			$data['modules'] = $this->config->get('kuaidi_chaxun_shuju');
		}			
				
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/kuaidi_chaxun.tpl', $data));
	}

	public function add() {
		$this->load->language('sale/order');
		$this->load->language('module/kuaidi_chaxun');
		
		$json = array();
		
		$this->load->model('sale/order');
		$this->load->model('module/kuaidi_chaxun');
		
		if (!$this->user->hasPermission('modify', 'sale/order')) { 
			$json['error'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['kd_kuaidi_code'] || !$this->request->post['kd_kuaidi_number']) { 
			$json['error'] = $this->language->get('error_kuaidi_code_number_required');
		}
		if (!isset($json['error'])) { 
			$this->model_module_kuaidi_chaxun->addOrderShippingtrack($this->request->get['order_id'], $this->request->post);
			$json['success'] = $this->language->get('text_add_success');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->load->language('sale/order');
		$this->load->language('module/kuaidi_chaxun');
		
		$json = array();
		
		$this->load->model('sale/order');
		$this->load->model('module/kuaidi_chaxun');
		
		if (!$this->user->hasPermission('modify', 'sale/order')) { 
			$json['error'] = $this->language->get('error_permission');
		} else { 
			$this->model_module_kuaidi_chaxun->delOrderShippingtrack($this->request->get['id']);
			$json['success'] = $this->language->get('text_del_success');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/*
	* 后台订单详情页快递历史列表及添加快递单号
	*/
	public function getList() {
		$this->load->language('sale/order');
		$this->load->language('module/kuaidi_chaxun');
		
		$data['error'] = '';
		$data['success'] = '';
		
		$this->load->model('sale/order');
		$this->load->model('module/kuaidi_chaxun');
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_view'] = $this->language->get('text_view');
		$data['button_delete'] = $this->language->get('button_delete');
		
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_kuaidi_code'] = $this->language->get('column_kuaidi_code');
		$data['column_kuaidi_number'] = $this->language->get('column_kuaidi_number');
		$data['column_kuaidi_track'] = $this->language->get('column_kuaidi_track');
		$data['column_comment'] = $this->language->get('column_comment');
		$data['column_action'] = $this->language->get('column_action');
	
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$data['histories'] = array();
		
		$results = $this->model_module_kuaidi_chaxun->getOrderShippingtracks($this->request->get['order_id'], ($page - 1) * 10, 10);
		
		foreach ($results as $result) {
			//快递code
			$kuaidi_code = $result['kd_kuaidi_code'];
			//快递单号	
			$kuaidi_number = $result['kd_kuaidi_number'];
			
			$typeCom = $kuaidi_code;//快递公司
			$typeNu = $kuaidi_number;  //快递单号
			$track = $this->url->link('module/kuaidi_chaxun/getTrace', 'com=' . $typeCom . '&nu=' . $typeNu . '&token=' . $this->session->data['token']);

			$data['histories'][] = array(
				'kd_kuaidi_code'     => $result['kd_kuaidi_code'],
				'kd_kuaidi_number'   => $result['kd_kuaidi_number'],
				'kd_comment'         => $result['kd_comment'],
				'id'                 => $result['id'],
				'kd_track'           => $track,
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}	
				
		$data['token'] = $this->session->data['token'];
		$data['order_id'] = $this->request->get['order_id'];
		
		$history_total = $this->model_module_kuaidi_chaxun->getTotalOrderShippingtracks($this->request->get['order_id']);
		
		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/kuaidi_chaxun/kuaidi', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');
		
		$data['pagination'] = $pagination->render();
		
		$this->response->setOutput($this->load->view('module/order_kuaidi.tpl', $data));
	}

	public function getTrace() {
		$this->load->language('module/kuaidi_chaxun');

		if (isset($this->request->get['com'])) {
			$typeCom = $this->request->get['com'];
		} else {
			$typeCom = 0;
		}  
		if (isset($this->request->get['nu'])) {
			$typeNu = $this->request->get['nu'];
		} else {
			$typeNu = 0;
		}  

		$key = $this->config->get('kuaidi_chaxun_key');
		$id = $this->config->get('kuaidi_chaxun_id');
		
		$class = $this->config->get('kuaidi_chaxun_platform');
		$kuaidi = new $class($id, $key);
		$tracking = $kuaidi->getOrderTraces($typeCom, $typeNu);
		
		if (isset($tracking['message'])) { //查询出错
			$track = "<div id=errordiv style=width:500px;border:#fe8d1d 1px solid;padding:20px;background:#FFFAE2;>
									<p style=line-height:28px;margin:0px;padding:0px;color:#F21818;>" . $tracking['message'] . "</p>
								</div>";
		} else {
			$track = "<table width='520px' border='0' cellspacing='0' cellpadding='0' id='showtablecontext' style='border-collapse:collapse;border-spacing:0;'>";
			
			$track .= "<tr>
					<td width='163' style='background:#64AADB;border:1px solid #75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;'>" . $this->language->get('text_time') . "</td>
					<td width='354' style='background:#64AADB;border:1px solid #75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;'>" . $this->language->get('text_station') . "</td>
				</tr>";
			foreach ($tracking['traces'] as $trace) {
				$track .= "<tr>
						<td width='163' style='border:1px solid #DDDDDD;font-size:12px;line-height:22px;padding:3px 5px;'>" . $trace['time'] . "</td>
						<td width='354' style='border:1px solid #DDDDDD;font-size:12px;line-height:22px;padding:3px 5px;'>" . $trace['station'] . "</td>
					</tr>";
			}
			$track .= "</table>";
		}
		$this->response->setOutput($track);
	}
			
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/kuaidi_chaxun')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['kuaidi_chaxun_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}
		
		if (!$this->request->post['kuaidi_chaxun_platform']) {
			$this->error['platform'] = $this->language->get('error_platform');
		}

		if ($this->request->post['kuaidi_chaxun_platform'] == 'kuaidi' && !$this->request->post['kuaidi_chaxun_id']) {  //对于快递鸟id为必填，kuaidi表示快递鸟kuaidi100表示快递100
			$this->error['id'] = $this->language->get('error_id');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}


	public function install() {
		$this->load->model('extension/event');

		//在安装快递单插件的时候默认初始一些数据进去
		//自动添加一些基本数据
		$store_id = 0;
		$sql_tt = '[{"code":"STO","name":"申通","status":"1","sort_order":"1"},{"code":"ems","name":"EMS","status":"1","sort_order":"2"},{"code":"SF","name":"顺丰速递","status":"1","sort_order":"3"},{"code":"YTO","name":"圆通速递","status":"1","sort_order":"4"},{"code":"ZTO","name":"中通速递","status":"1","sort_order":"5"},{"code":"YD","name":"韵达快运","status":"1","sort_order":"6"},{"code":"HHTT","name":"天天快递","status":"1","sort_order":"7"},{"code":"HTKY","name":"百世汇通","status":"1","sort_order":"8"},{"code":"QFKD","name":"全峰快递","status":"1","sort_order":"9"},{"code":"DBL","name":"德邦物流","status":"1","sort_order":"10"},{"code":"ZJS","name":"宅急送","status":"1","sort_order":"11"}]';
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = 'kuaidi_chaxun', `key` = 'kuaidi_chaxun_shuju', `value` = '" . $sql_tt . "' , `serialized` = '1' ");		
		
		//增加快递code/name/number字段
		//$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "order_shippingtrack`;");
		$this->db->query("CREATE TABLE `" . DB_PREFIX . "order_shippingtrack` ( " .
											  "`id` int(11) NOT NULL AUTO_INCREMENT, " .
											  "`order_id` int(11) NOT NULL, " .
											  "`kd_kuaidi_code` varchar(64) NOT NULL, " .
											  "`kd_kuaidi_number` varchar(64) NOT NULL, " .
											  "`kd_comment` varchar(128), " .
											  "`date_added` int(3) NOT NULL, " .
											  "PRIMARY KEY (`id`) " .
											") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
			
		$this->model_extension_event->addEvent('kuaidi_chaxun', 'post.module.kuaidi_chaxun', 'module/kuaidi_chaxun/install');
	}

	public function uninstall() {
		$this->load->model('extension/event');

		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = 'kuaidi_chaxun'");		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "order_shippingtrack`;");

		$this->model_extension_event->deleteEvent('kuaidi_chaxun');
	}
}
?>