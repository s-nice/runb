<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-banner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">
	        <table class="form">
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-owner"><?php echo $entry_platform; ?></label>
              <div class="col-sm-10">
                <label class="radio-inline">
                 <input type="radio" name="kuaidi_chaxun_platform" value="kuaidi" <?php echo ($kuaidi_chaxun_platform == 'kuaidi' ? 'checked="true"' : ''); ?>  />快递鸟
                </label>
                <label class="radio-inline">
                  <input type="radio" name="kuaidi_chaxun_platform" value="kuaidi100" <?php echo ($kuaidi_chaxun_platform == 'kuaidi100' ? 'checked="true"' : ''); ?>  />快递100
                </label>
                <?php if ($error_platform) { ?>
                <div class="text-danger"><?php echo $error_platform; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-owner"><?php echo $entry_key; ?></label>
              <div class="col-sm-10">
                <input type="text" name="kuaidi_chaxun_key" value="<?php echo $kuaidi_chaxun_key; ?>" placeholder="<?php echo $kuaidi_chaxun_key; ?>"  class="form-control" />
                <?php if ($error_key) { ?>
                <div class="text-danger"><?php echo $error_key; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-owner"><?php echo $entry_id; ?></label>
              <div class="col-sm-10">
                <input type="text" name="kuaidi_chaxun_id" value="<?php echo $kuaidi_chaxun_id; ?>" placeholder="<?php echo $kuaidi_chaxun_id; ?>"  class="form-control" />
                <?php if ($error_id) { ?>
                <div class="text-danger"><?php echo $error_id; ?></div>
                <?php } ?>
              </div>
            </div>
	        </table>

              <div class="table-responsive">
                <table id="kuaidi" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                     <td class="text-left"><?php echo $entry_code; ?></td>
                      <td class="text-left"><?php echo $entry_name; ?></td>
                      <td class="text-left"><?php echo $entry_status; ?></td>
                      <td class="text-right"><?php echo $entry_sort_order; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $kuaidi_row = 0; ?>
                    <?php foreach ($modules as $kuaidi_chaxun_shuju) { ?>
                    <tr id="kuaidi-row<?php echo $kuaidi_row; ?>">
                      <td class="text-left"><input type="text" name="kuaidi_chaxun_shuju[<?php echo $kuaidi_row; ?>][code]" value="<?php echo $kuaidi_chaxun_shuju['code']; ?>" placeholder="<?php echo $entry_code; ?>" class="form-control" /></td>
                      <td class="text-left"><input type="text" name="kuaidi_chaxun_shuju[<?php echo $kuaidi_row; ?>][name]" value="<?php echo $kuaidi_chaxun_shuju['name']; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" /></td>
                      <td class="text-left"><input type="text" name="kuaidi_chaxun_shuju[<?php echo $kuaidi_row; ?>][status]" value="<?php echo $kuaidi_chaxun_shuju['status']; ?>" placeholder="<?php echo $entry_status; ?>" class="form-control" /></td>
                      <td class="text-right"><input type="text" name="kuaidi_chaxun_shuju[<?php echo $kuaidi_row; ?>][sort_order]" value="<?php echo $kuaidi_chaxun_shuju['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                      <td class="text-left"><button type="button" onclick="$('#kuaidi-row<?php echo $kuaidi_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $kuaidi_row++; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"></td>
                      <td class="text-left"><button type="button" onclick="addKuaidi();" data-toggle="tooltip" title="<?php echo $button_add_module; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
	      <!-- 支持的信息 -->
	      <div class="support">
	        <h3>帮助信息</h3>
	        <ol style="line-height:20px;">
	        	<li><b>使用本插件前，请先安装VQMOD</b></li>
	            <li><b>本插件支持“快递100”和“快递鸟”两个快递平台接口。使用本插件前，需要先向<a target="_blank" href="http://www.kuaidi100.com/openapi/applyapi.shtml">《快递100》</a>或<a target="_blank" href="http://www.kdniao.com/ServiceApply.aspx">《快递鸟》</a>申请API的授权KEY和商户ID（仅快递鸟有ID）。</b>
	            </li>
	            <li><b>快递100支持的快递公司，详细的公司名单请查看：</b> <a target="_blank" href="http://www.kuaidi100.com/download/api_kuaidi100_com(20140729).doc">快递100 API</a>和</b> <a target="_blank" href="http://www.kuaidi100.com/download/api_international(20140729).doc">快递查询API所支持的国际邮政、ems和快递及参数说明</a></li>
	            <li><b>快递鸟平台支持的快递公司详细名单和快递公司代码请查看<a href="http://www.kdniao.com/file/ExpressCode.xls" target="_blank">快递公司编码</a></b></li>
	            <li><b>本插件在安装的时候会自动初始化快递公司和代码信息,该部分快递公司代码是基于快递鸟平台的代码，如使用快递100请将这些公司全部移除，根据需要重新添加,设置常用的快递公司.</b></li>
	            <li><b>如果您法完成本插件的安装和使用,请访问本公司官方网站<a target="_blank" href="http://www.opencart.cn">opencart中文官方网站</a>或发邮件到  support@opencart.cn  获取帮助</b></li>
	        </ol>
	    </div>
	    <!-- 支持的信息 -->
      
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
var kuaidi_row = <?php echo $kuaidi_row; ?>;

function addKuaidi() {
	html  = '<tr id="kuaidi-row' + kuaidi_row + '">'; 
    html += '  <td class="text-left"><input type="text" name="kuaidi_chaxun_shuju[' + kuaidi_row + '][code]" value="" placeholder="<?php echo $entry_code; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><input type="text" name="kuaidi_chaxun_shuju[' + kuaidi_row + '][name]" value="" placeholder="<?php echo $entry_name; ?>" class="form-control" /></td>';
		html += '  <td class="text-left"><select name="kuaidi_chaxun_shuju[' + kuaidi_row + '][status] class="form-control">';
	    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
	    html += '    </select></td>';
    html += '  <td class="text-right"><input type="text" name="kuaidi_chaxun_shuju[' + kuaidi_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#kuaidi-row' + kuaidi_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#kuaidi tbody').append(html);

	kuaidi_row++;
}
//--></script> 
<?php echo $footer; ?>