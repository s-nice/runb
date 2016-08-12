<?php
// Heading
$_['heading_title']    = '秒杀活动';
$_['text_module']      = '模块';
$_['text_success']     = '成功修改秒杀活动模块';
$_['text_add']               = '添加秒杀活动';
$_['text_edit']        = '秒杀活动管理';
$_['text_list']        = '秒杀活动列表';
$_['$text_none']        = '-- 无 --';
$_['text_notes']       = '<p><strong>使用说明及功能描述：</strong></p>
<ul>
<li>请先启用秒杀活动模块，然后可以在布局中将秒杀活动模块添加至任何页面；</li>
<li>点击右下角“添加秒杀活动”，创建秒杀活动;</li>
<li>秒杀结束时间要大于开始时间；</li>
<li>同一商品的秒杀时间段不要重叠；</li>
<li>实际活动数量与页面显示的数量可不相同；</li>
<li>为防止用户秒杀成功但支付失败，秒杀商品的“实际活动数量”应该少于商品实际库存量；</li>
<li>为便于用户参与秒杀活动，秒杀商品最好不要带有选项；</li>
<li>当前版本默认秒杀数量为“1”，不能设置。请将秒杀商品的最小起订量设置为“1”，否则用户将秒杀失败；</li>
<li>用户需要登录后才能参与秒杀；</li>
<li>用户秒杀到商品后需要在15分钟内完成支付，超过时间自动恢复原价；</li>
</ul>
<p><strong>使用帮助和技术支持</strong></p>
<p>在使用过程中有任何问题，请发送邮件至：support@opencart.cn 与我们取得联系。</p>
<p>www.opencart.cn 感谢您的支持！</p>';
$_['tab_general'] = '编辑秒杀活动';
// Column
$_['column_product_name']            = '商品名称';
$_['column_product_quantity']            = '实际活动数量';
$_['column_product_display_quantity']            = '显示活动数量';
$_['column_product_used_quantity']            = '参与人数';
$_['column_product_price']            = '活动价格';
$_['column_start_time']            = '活动开始时间';
$_['column_end_time']            = '活动结束时间';
$_['column_status']          = '状态';
$_['column_sort_order']      = '排序';
$_['column_action']          = '操作';
// Entry
$_['entry_product_id']            = '选择商品';
$_['entry_product_name']            = '活动商品名称';
$_['entry_price']              = '活动商品价格';
$_['entry_quantity']           = '实际活动商品数量';
$_['entry_display_quantity']           = '显示活动商品数量';
$_['entry_start_time']           = '活动开始时间';
$_['entry_end_time']           = '活动结束时间';
$_['entry_description']      = '活动介绍（规则）';
$_['entry_status']     			= '状态';
//Button
$_['button_add']    = '添加秒杀商品';
// Error
$_['error_warning'] = '警告：相关数据未填写！';
$_['error_product_id'] = '请选择一款商品';
$_['error_product_name'] = '商品名称必须在3到64个字之间';
$_['error_price'] = '秒杀价格不能小于0';
$_['error_quantity'] = '实际商品数量不能小于0';
$_['error_display_quantity'] = '显示商品数量不能小于0';
$_['error_start_time_empty'] = '请设置活动开始时间';
$_['error_end_time_empty'] = '请设置活动结束时间';
$_['error_permission'] = '警告： 您没有权限变更秒杀活动模块！';
//Help
$_['help_auto_complete']            = '输入商品名称搜索';
$_['help_status']            = '秒杀活动状态';