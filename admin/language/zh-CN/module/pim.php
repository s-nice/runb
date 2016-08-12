<?php
// Heading
$_['heading_title']               = '批量图片管理';

// Text
$_['text_module']                 = '模块管理';
$_['text_success']                = '成功：批量图片管理模块更新完成！';

// Entry
$_['entry_delete_def_image']      = '<span data-toggle="tooltip" title="启用时，主图将在保存时被从附加图片中移除。">附加图片中移除主图文件</span>';

$_['text_yes']                    = "是";
$_['text_no']                     = "否";
$_['entry_status']                = '状态:';

// patches
$_['entry_miu_patch']             = '<span data-toggle="tooltip" title="Enable this if you have Multi Image Uploader installed."> Multi Image Uploader Patch: </span>';

//options
$_['entry_dimensions']            = '管理器窗口大小 (宽x高):';
$_['entry_language']              = '语言: ';

// Root options
$_['entry_copyOverwrite']         = '<span data-toggle="tooltip" title="文件同名时，启用将用新复制的文件覆盖原文件，禁用时将重命名复制的文件">复制时覆盖原文件:</span>';
$_['entry_uploadOverwrite']       = '<span data-toggle="tooltip" title="文件同名时，启用将用新上传文件覆盖原文件，禁用时将重命名新上传的文件">上传时覆盖原文件: </span>';
$_['entry_uploadMaxSize']         = '<span data-toggle="tooltip" title="仍需在PHP中设置最大上传文件大小值">最大上传文件大小: </span>';


// Client options
$_['entry_defaultView']           = 'Default View:';
$_['entry_dragUploadAllow']       = 'Allow to drag and drop to upload: ';
$_['entry_loadTmbs']              = '<span data-toggle="tooltip" title="Amount of thumbnails to create per one request">Load thumbs: </span>';

// tabs
$_['tab_general']                 = '通用设置';
$_['tab_volume']                  = 'Volumes';
$_['tab_module']                  = '子模块';
$_['tab_help']                    = '帮助';
$_['text_enabled']                = '启用';
$_['text_disabled']               = '禁用';

// Text
$_['text_module_installed']       = '成功：子模块 %s 安装成功!';
$_['text_volume_installed']       = 'Success: You have installed %s volume!';

$_['text_module_uninstalled']     = '成功：子模块 %s 已卸载!';
$_['text_volume_uninstalled']     = 'Success: You have uninstalled %s volume!';
$_['text_confirm']                = '确认要执行操作吗？';
$_['text_layout']                 = 'After you have installed and configured a module you can add it to a layout <a href="%s" class="alert-link">here</a>!';
$_['text_add']                    = 'Add Module';
$_['text_list']                   = 'Module List';

// Column
$_['column_name']                 = '模块名称';
$_['column_description']          = '介绍';
$_['column_action']               = '操作';

// Entry
$_['entry_code']                  = '模块';
$_['entry_name']                  = '模块名称';

// Mods
$_['text_AutoResize']             = '此插件可在上传图片时自动压缩图片至指定尺寸。';
$_['text_Normalizer']             = '';
$_['text_Sanitizer']              = '此插件可自动将上传图片文件名中的特殊字符替换为下划线 _ 。';
$_['text_Watermark']              = '此插件可在上传图片时给图片加上水印。';

// vols
$_['text_volume_LocalFileSystem'] = 'The default driver for accessing the local file system';
$_['text_volume_MySQL']           = 'MySQL - stores files inside the database.';
$_['text_volume_VolumeS3']        = 'Connects to Amazon S3';

$_['error_mui']                   = 'Error: You are trying to enable a patch without having Multi Image Uplodaer module installed.';

?>