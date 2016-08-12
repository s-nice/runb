<?php
class ControllerModuleMobileHotSearch extends Controller {
	public function index($setting) {
		$data['hot_search_keywords'] = array();
			if($this->config->get('mobile_hot_search_status')) {
				$data['mobile_hot_search_title'] = $this->config->get('mobile_hot_search_title');
				$hot_search_keywords = array();
				$hot_search_keywords = $this->config->get('mobile_hot_search');
				if (!$hot_search_keywords) {
					return;
				}
				$sort_order = array();
				foreach ($hot_search_keywords as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
				array_multisort($sort_order, SORT_ASC, $hot_search_keywords);

				foreach($hot_search_keywords as $keyword) {
					if($keyword['status']) {
						$data['hot_search_keywords'][] = $keyword;
					}
				}
			}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/mobile_hot_search.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/mobile_hot_search.tpl', $data);
		} else {
			return $this->load->view('default/template/module/mobile_hot_search.tpl', $data);
		}
	}
}