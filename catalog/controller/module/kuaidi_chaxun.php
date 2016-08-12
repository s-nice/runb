<?php 
class ControllerModuleKuaiDiChaXun extends Controller {
	public function index() {

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
}
?>