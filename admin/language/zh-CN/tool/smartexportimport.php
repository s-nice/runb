<?php
// Heading
$_['heading_title']     = 'Smart 导入/导出';

// Text
$_['text_success']      = '成功：您已成功导入您的分类和商品';
$_['text_nochange']     = '服务器上的数据没有发生改变';
$_['text_log_details']  = '更多细节参见系统错误日志';

// Entry
$_['entry_restore']     = '从Excel中导入';
$_['entry_description'] = '使用smart导入/导出Excel文件来管理您的商品';
$_['entry_exportway_sel'] = '请选择您希望导出您商品的方式：';
$_['entry_start_id'] = '商品开始id：';
$_['entry_end_id']   = '商品结束id:';
$_['entry_start_index'] = '导出数量';
$_['entry_end_index'] = '导出批号:';


// Button labels
$_['button_import']     = '增量导入';
$_['button_export']     = '增量导出';
$_['button_export_pid']     = '以商品id导出';
$_['button_export_page']     = '批量导出';

//Error
$_['error_exist_product'] = '商品id %s 在数据库中已经存在, 请检查您的excel文件!';
$_['error_permission']          = '警告: 您没有权限修改导入/导出!';
$_['error_upload']              = '导入的电子表格无效或其中的数据格式错误!';
$_['error_sheet_count']         = '导入/导出: 无效的工作表数量, 期望值：8';
$_['error_categories_header']   = '导入/导出: 分类表的header头无效';
$_['error_filtergroups_header']   = '导入/导出: 过滤器分组表的header头无效';
$_['error_filters_header']   = '导入/导出: 过滤器表的header头无效';
$_['error_products_header']     = '导入/导出: 商品表的header头无效';
$_['error_descriptions_header']     = '导入/导出: 描述表的header头无效';
$_['error_additionalimages_header']     = '导入/导出: 附加图像表的header头无效';
$_['error_product_options_header']      = '导入/导出: 商品选项表的header头无效';
$_['error_options_header']      = '导入/导出: 选项表的header头无效';
$_['error_option_values_header']      = '导入/导出: 选项值表的header头无效';
$_['error_attributes_header']   = '导入/导出: 属性表的header头无效';
$_['error_specials_header']     = '导入/导出: 特价表的header头无效';
$_['error_discounts_header']    = '导入/导出: 折扣表的header头无效';
$_['error_rewards_header']      = '导入/导出: 报酬表的header头无效';
$_['error_select_file']         = '导入/导出: 单击\"导入\"之前请选择文件';
$_['error_post_max_size']       = '导入/导出: 文件大小超过 %1 (查看php设置 \'post_max_size\')';
$_['error_upload_max_filesize'] = '导入/导出: 文件大小超过 %1 (查看php设置 \'upload_max_filesize\')';
$_['error_pid_no_data']         = '没有制定商品的开始和结束id';
$_['error_page_no_data']        = '没有更多的产品数据';
$_['error_param_not_number']        = '参数必须为数字';
?>