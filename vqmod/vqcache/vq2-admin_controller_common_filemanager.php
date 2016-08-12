<?php
class ControllerCommonFileManager extends Controller {

        public function pim() {
          if ($this->config->get('pim_status')) {
            $this->load->language('common/filemanager');
            $data['heading_title'] = $this->language->get('heading_title');
            $this->document->setTitle($this->language->get('heading_title'));
            $data['token'] = $this->session->data['token'];
            $data['lang'] = 'en';
            $data['width'] = $this->config->get('pim_width');
            $data['height'] = $this->config->get('pim_height');
            if ($this->config->get('pim_language')) {
              $data['lang'] = $this->config->get('pim_language');
            }
            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
            
            
            $this->response->setOutput($this->load->view('common/pim.tpl', $data));
            return;
          } else {
            die('Power Image Manager is not installed. Please go back, install and configure the module in Extension > Modules.');
          }
         }
      
	public function index() {

        if ($this->config->get('pim_status')) {
          $this->load->language('common/filemanager');
          $data['heading_title'] = $this->language->get('heading_title');
          $this->document->setTitle($this->language->get('heading_title'));
          $data['token'] = $this->session->data['token'];
          $data['lang'] = 'en';
          $data['width'] = $this->config->get('pim_width');
          $data['height'] = $this->config->get('pim_height');
          if ($this->config->get('pim_language')) {
            $data['lang'] = $this->config->get('pim_language');
          }
          $data['header'] = '';//$this->load->controller('common/header');
          $data['footer'] = '';//$this->load->controller('common/footer');
          $data['cke'] = '';
          $data['target'] = '';
          $data['thumb']  = '';
          if (isset($this->request->get['CKEditor'])) {
            $data['cke'] = $this->request->get['CKEditor'];
          }
          if ($this->request->server['HTTPS']) {
            $data['base'] = HTTPS_SERVER;
          } else {
            $data['base'] = HTTP_SERVER;
          }
          
          if (isset($this->request->get['target'])) {
            $data['target'] = $this->request->get['target'];
          }
          if (isset($this->request->get['thumb'])) {
            $data['thumb'] = $this->request->get['thumb'];
          }
          
          $this->response->setOutput($this->load->view('common/pim.tpl', $data));
          return;
        }       
      
		$this->load->language('common/filemanager');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $this->request->get['filter_name']), '/');
		} else {
			$filter_name = null;
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['images'] = array();

		$this->load->model('tool/image');

		// Get directories
		$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

		if (!$directories) {
			$directories = array();
		}

		// Get files
		$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

		if (!$files) {
			$files = array();
		}

		// Merge directories and files
		$images = array_merge($directories, $files);

		// Get total number of files and directories
		$image_total = count($images);

		// Split the array based on current page number and max number of items per page of 10
		$images = array_splice($images, ($page - 1) * 16, 16);

		foreach ($images as $image) {
			$name = str_split(basename($image), 14);

			if (is_dir($image)) {
				$url = '';

				if (isset($this->request->get['target'])) {
					$url .= '&target=' . $this->request->get['target'];
				}

				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}

				$data['images'][] = array(
					'thumb' => '',
					'name'  => implode(' ', $name),
					'type'  => 'directory',
					'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
					'href'  => $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . '&directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE . 'catalog/'))) . $url, 'SSL')
				);
			} elseif (is_file($image)) {
				// Find which protocol to use to pass the full image link back
				if ($this->request->server['HTTPS']) {
					$server = HTTPS_CATALOG;
				} else {
					$server = HTTP_CATALOG;
				}

				$data['images'][] = array(
					'thumb' => $this->model_tool_image->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
					'name'  => implode(' ', $name),
					'type'  => 'image',
					'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
					'href'  => $server . 'image/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
				);
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_search'] = $this->language->get('entry_search');
		$data['entry_folder'] = $this->language->get('entry_folder');

		$data['button_parent'] = $this->language->get('button_parent');
		$data['button_refresh'] = $this->language->get('button_refresh');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_folder'] = $this->language->get('button_folder');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_search'] = $this->language->get('button_search');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['directory'])) {
			$data['directory'] = urlencode($this->request->get['directory']);
		} else {
			$data['directory'] = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if (isset($this->request->get['target'])) {
			$data['target'] = $this->request->get['target'];
		} else {
			$data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if (isset($this->request->get['thumb'])) {
			$data['thumb'] = $this->request->get['thumb'];
		} else {
			$data['thumb'] = '';
		}

		// Parent
		$url = '';

		if (isset($this->request->get['directory'])) {
			$pos = strrpos($this->request->get['directory'], '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->request->get['directory'], 0, $pos));
			}
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		$data['parent'] = $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Refresh
		$url = '';

		if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode($this->request->get['directory']);
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		$data['refresh'] = $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode(html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		$pagination = new Pagination();
		$pagination->total = $image_total;
		$pagination->page = $page;
		$pagination->limit = 16;
		$pagination->url = $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$this->response->setOutput($this->load->view('common/filemanager.tpl', $data));
	}

	public function upload() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$json) {
			if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				if ((utf8_strlen($filename) < 2) || (utf8_strlen($filename) > 255)) {
					$json['error'] = $this->language->get('error_filename');
				}

				// Allowed file extension types
				$allowed = array(
					'jpg',
					'jpeg',
					'gif',
					'png'
				);

				if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Allowed file mime types
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif'
				);

				if (!in_array($this->request->files['file']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($this->request->files['file']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Return any upload error
				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!$json) {
			move_uploaded_file($this->request->files['file']['tmp_name'], $directory . '/' . $filename);

			$json['success'] = $this->language->get('text_uploaded');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function folder() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$json) {
			// Sanitize the folder name
			$folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($this->request->post['folder'], ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((utf8_strlen($folder) < 2) || (utf8_strlen($folder) > 128)) {
				$json['error'] = $this->language->get('error_folder');
			}

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = $this->language->get('error_exists');
			}
		}

		if (!$json) {
			mkdir($directory . '/' . $folder, 0777);
			chmod($directory . '/' . $folder, 0777);

			$json['success'] = $this->language->get('text_directory');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


        public function connector() {
          include_once DIR_SYSTEM.'library/filemanager/elFinderConnector.class.php';
          include_once DIR_SYSTEM.'library/filemanager/elFinder.class.php';
          include_once DIR_SYSTEM.'library/filemanager/elFinderVolumeDriver.class.php';
          $volumes = $this->config->get('pim_volumes');

          include_once DIR_SYSTEM.'library/filemanager/volumes/LocalFileSystem.class.php';
          
          $volumes = $this->config->get('pim_volumes');
          if (empty($volumes)) { $volumes = array(); }
          foreach ($volumes as $driver => $something) {
            if ($driver == 'LocalFileSystem') {continue;}
            if (file_exists(DIR_SYSTEM.'library/filemanager/volumes/'.$driver.'.class.php')) {
              include_once DIR_SYSTEM.'library/filemanager/volumes/'.$driver.'.class.php';
            }
          }

          if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $base = HTTPS_CATALOG."image/";
          } else {
            $base = HTTP_CATALOG."image/";
          }

          $this->config->set('config_error_display', 0);
          $this->config->set('config_error_log', 0);
          function access($attr, $path, $data, $volume) {
            return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
              ? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
              :  null;                                    // else elFinder decide it itself
            }
            $tmbURL = DIR_IMAGE.'tmb/';

            $plugins =  $this->config->get('pim_modules');
            $binds = array ();
            $plugin_options = array();
            if (!empty($plugins)) {
              foreach ($plugins as $key=>$val) {
                $binds['upload.presave'][] =  'Plugin.'.$key.'.onUpLoadPreSave';
                $plugin_data =  $this->config->get('pim_'.$key);
                if (!empty($plugin_data)) {
                  foreach ($plugin_data as $data_key=>$data_val){
                    if ($data_key == 'source') { // watermark source
                      $data_val = DIR_IMAGE.$data_val;
                    }
                    $plugin_options[$key][$data_key] = $data_val;
                  }
                }
              }
            }

            if (empty($volumes)) { // default settings
              $bits = array(
               array(
                  'driver'          => 'LocalFileSystem',         // driver for accessing file system (REQUIRED)
                  'path'            => DIR_IMAGE.'catalog/',      // path to files (REQUIRED)
                  'URL'             => $base.'catalog/',          // URL to files (REQUIRED)
                  'accessControl'   => 'access',                  // disable and hide dot starting files (OPTIONAL)
                  'fileMode'        => 0644,                       // new files mode
                  'dirMode'         => 0755,                       // new folders mode
                  'uploadAllow'     => array('image', 'application/pdf'),
                  'uploadDeny'      => array('all'),
                  'uploadOrder'     => 'deny,allow',                                      
                  'tmbBgColor'      => 'transparent',             // transparent background
                  'tmbCrop'         => 'false',                   // do not crop
                  'tmbSize'         => '59',                      // default tmb size.
                  'copyOverwrite'   => $this->config->get('pim_copyOverwrite'),
                  'uploadOverwrite' => $this->config->get('pim_uploadOverwrite'),
                  'uploadMaxSize'   => ''.$this->config->get('pim_uploadMaxSize').''.$this->config->get('pim_uploadMaxType'),
                ),
             );
            } else {
              $bits = array();
              $i=0;
              foreach ($volumes as $driver => $volume) { 
                foreach ($volume as $vkey => $vdata) {
                  if ($vdata['status']) {
                    $bits[$i]['driver'] = $driver;
                    $bits[$i]['uploadAllow']     = array('image', 'application/pdf');
                    $bits[$i]['uploadDeny']      = array('all');
                    $bits[$i]['uploadOrder']     = 'deny,allow';                     
                    $bits[$i]['accessControl']   = 'access';
                    $bits[$i]['fileMode']        = 0644;
                    $bits[$i]['dirMode']         = 0755;
                    $bits[$i]['tmpPath']         = '.tmp';
                    $bits[$i]['tmbBgColor']      = 'transparent';
                    $bits[$i]['tmbCrop']         = 'false';
                    $bits[$i]['tmbSize']         = '59';
                    $bits[$i]['copyOverwrite']   = $this->config->get('pim_copyOverwrite');
                    $bits[$i]['uploadOverwrite'] = $this->config->get('pim_uploadOverwrite');
                    $bits[$i]['uploadMaxSize']   = ''.$this->config->get('pim_uploadMaxSize').''.$this->config->get('pim_uploadMaxType');
                   
                    foreach ($vdata as $var_key => $var_val) {

                      $bits[$i][$var_key] = $var_val;
                      if ($driver == 'FTP') { 
                           $bits[$i]['tmbPath']      = 'tmb';
                           $bits[$i]['tmbURL']       = dirname($_SERVER['PHP_SELF']).'/tmb';
                           $bits[$i]['tmpPath']      = '/tmp';                 
                      }
                    }     
                    $i++;
                  }
                }   
              }          
            }

            $roots['roots'] = $bits;
            $opts = $roots;


            if (!empty($binds)) {
              $opts['bind'] = $binds;
            }
            if (!empty($plugin_options)) {
              $opts['plugin'] = $plugin_options;
            }

            $connector = new elFinderConnector(new elFinder($opts));
            $connector->run();
        }
      
	public function delete() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['path'])) {
			$paths = $this->request->post['path'];
		} else {
			$paths = array();
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			$path = rtrim(DIR_IMAGE . str_replace(array('../', '..\\', '..'), '', $path), '/');

			// Check path exsists
			if ($path == DIR_IMAGE . 'catalog') {
				$json['error'] = $this->language->get('error_delete');

				break;
			}
		}

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim(DIR_IMAGE . str_replace(array('../', '..\\', '..'), '', $path), '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

				// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path . '*');

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}

			$json['success'] = $this->language->get('text_delete');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
