<?php
class ControllerModuleNews extends Controller {
	public function index($setting) {
		$this->language->load('module/news');
		
		$this->load->model('catalog/news');
		
		$this->load->model('catalog/ncomments');
		
		$this->load->model('catalog/ncategory');
		
		$this->load->model('tool/image'); 
		
		$this->document->addStyle('catalog/view/theme/default/stylesheet/blog-news.css');
		
    	$data['text_headlines'] = $this->language->get('text_headlines');
		$data['display_style'] = $this->config->get('ncategory_bnews_display_style');
		$data['text_posted_by'] = $this->language->get('text_posted_by');
		$data['text_posted_on'] = $this->language->get('text_posted_on');
		$data['text_posted_pon'] = $this->language->get('text_posted_pon');
		$data['text_posted_in'] = $this->language->get('text_posted_in');
		$data['text_updated_on'] = $this->language->get('text_updated_on');
		$data['text_comments'] = $this->language->get('text_comments');	
		$data['text_comments_v'] = $this->language->get('text_comments_v');
		$data['display_style'] = $this->config->get('ncategory_bnews_display_style');	
		$data['button_more'] = $this->language->get('button_more');	
		$data['disqus_sname'] = $this->config->get('ncategory_bnews_disqus_sname');
		$data['disqus_status'] = $this->config->get('ncategory_bnews_disqus_status');
		$data['fbcom_status'] = $this->config->get('ncategory_bnews_fbcom_status');
		$data['fbcom_appid'] = $this->config->get('ncategory_bnews_fbcom_appid');
		$data['fbcom_theme'] = $this->config->get('ncategory_bnews_fbcom_theme');
		$data['fbcom_posts'] = $this->config->get('ncategory_bnews_fbcom_posts');
		
		if ($setting['ncategory_id'] == 'all') {
    	 $data['heading_title'] = $this->language->get('heading_title');
		 $data['newslink'] = $this->url->link('news/ncategory');
		} else {
		 $ncategory_info = $this->model_catalog_ncategory->getncategory($setting['ncategory_id']);
		 if (isset($ncategory_info['name'])) {
			$data['heading_title'] = $ncategory_info['name'];
			$data['newslink'] = $this->url->link('news/ncategory', 'ncat=' . $setting['ncategory_id']);
			$catexists = true;
         } else {
			$data['heading_title'] = $this->language->get('heading_title');
			$data['newslink'] = $this->url->link('news/ncategory');
		 }
		}
		
		$data['article'] = array(); 
		
		if ($setting['ncategory_id'] == 'all' || !isset($catexists)) {	
			$sdata = array(
					'start'           => 0,
					'limit'           => $setting['news_limit'] 
			);
			$results = $this->model_catalog_news->getNews($sdata);	
		} else {	
			$sdata = array(
					'filter_ncategory_id' => $setting['ncategory_id'],
					'start'           => 0,
					'limit'           => $setting['news_limit']
			);
		
		$results = $this->model_catalog_news->getNews($sdata);	
		}
		
		$bbwidth = ($this->config->get('ncategory_bnews_image_width')) ? $this->config->get('ncategory_bnews_image_width') : 80;
		$bbheight = ($this->config->get('ncategory_bnews_image_height')) ? $this->config->get('ncategory_bnews_image_height') : 80;
			
		if($this->config->get('ncategory_bnews_display_elements')) {
				$elements = $this->config->get('ncategory_bnews_display_elements');
		} else {
				$elements = array("name","image","da","du","author","category","desc","button","com","custom1","custom2","custom3","custom4");
		}
			
		foreach ($results as $result) {
				$name = (in_array("name", $elements) && $result['title']) ? $result['title'] : '';
				$da = (in_array("da", $elements)) ? date('d M Y', strtotime($result['date_added'])) : '';
				$du = (in_array("du", $elements) && $result['date_updated'] && $result['date_updated'] != $result['date_added']) ? date('d M Y', strtotime($result['date_updated'])) : '';
				$button = (in_array("button", $elements)) ? true : false;
				$custom1 = (in_array("custom1", $elements) && $result['cfield1']) ? html_entity_decode($result['cfield1'], ENT_QUOTES, 'UTF-8') : '';
				$custom2 = (in_array("custom2", $elements) && $result['cfield2']) ? html_entity_decode($result['cfield2'], ENT_QUOTES, 'UTF-8') : '';
				$custom3 = (in_array("custom3", $elements) && $result['cfield3']) ? html_entity_decode($result['cfield3'], ENT_QUOTES, 'UTF-8') : '';
				$custom4 = (in_array("custom4", $elements) && $result['cfield4']) ? html_entity_decode($result['cfield4'], ENT_QUOTES, 'UTF-8') : '';
				if (in_array("image", $elements) && ($result['image'] || $result['image2'])) {
					if ($result['image2']) {
						$image = 'image/'.$result['image2'];
					} else {
						$image = $this->model_tool_image->resize($result['image'], $bbwidth, $bbheight);
					}
				} else {
					$image = false;
				}
				if (in_array("author", $elements) && $result['author']) {
					$author = $result['author'];
					$author_id = $result['nauthor_id'];
					$author_link = $this->url->link('news/ncategory', 'author=' . $result['nauthor_id']);
				} else {
					$author = '';
					$author_id = '';
					$author_link = '';
				}
				if (in_array("desc", $elements) && ($result['description'] || $result['description2'])) {
					if($result['description2'] && (strlen(html_entity_decode($result['description2'], ENT_QUOTES, 'UTF-8')) > 20)) {
							$desc = html_entity_decode($result['description2'], ENT_QUOTES, 'UTF-8');
					} else {
							$desc_limit = $this->config->get('ncategory_bnews_desc_length') ? $this->config->get('ncategory_bnews_desc_length') : 600;
							$desc = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $desc_limit) . '..';
					}
				} else {
					$desc = '';
				}
				if (in_array("com", $elements) && $result['acom']) {
					$com = $this->model_catalog_ncomments->getTotalNcommentsByNewsId($result['news_id']);
					if (!$com) {
						$com = " 0 ";
					}
				} else {
					$com = '';
				}
				if (in_array("category", $elements)) {
					$category = "";
					$cats = $this->model_catalog_news->getNcategoriesbyNewsId($result['news_id']);
					if ($cats) {
						$comma = 0;
						foreach($cats as $catid) {
							$catinfo = $this->model_catalog_ncategory->getncategory($catid['ncategory_id']);
							if ($catinfo) {
								if ($comma) {
									$category .= ', <a href="'.$this->url->link('news/ncategory', 'ncat=' . $catinfo['ncategory_id']).'">'.$catinfo['name'].'</a>';
								} else {
									$category .= '<a href="'.$this->url->link('news/ncategory', 'ncat=' . $catinfo['ncategory_id']).'">'.$catinfo['name'].'</a>';
								}
								$comma++;
							}
						}
					}
				} else {
					$category = '';
				}
				$href = $this->url->link('news/article', 'news_id=' . $result['news_id']);
				
				$data['article'][] = array(
					'article_id'  => $result['news_id'],
					'name'        => $name,
					'thumb'       => $image,
					'date_added'  => $da,
					'du'          => $du,
					'author'      => $author,
					'author_id'   => $author_id,
					'author_link' => $author_link,
					'description' => $desc,
					'button'      => $button,
					'custom1'     => $custom1,
					'custom2'     => $custom2,
					'custom3'     => $custom3,
					'custom4'     => $custom4,
					'category'    => $category,
					'href'        => $href,
					'total_comments' => $com
				);
		}
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/news.tpl', $data);
		} else {
			return $this->load->view('default/template/module/news.tpl', $data);
		}
	
	}
}
?>
