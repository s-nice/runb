<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-withdraw" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-withdraw" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
          </ul>
          <div class="tab-content">
          <div class="tab-pane active" id="tab-general">
            <fieldset>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-bank-account"><span data-toggle="tooltip" title="<?php echo $help_bank_account; ?>"><?php echo $entry_bank_account; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="bank_account" value="<?php echo $bank_account; ?>" placeholder="<?php echo $entry_bank_account; ?>" id="input-bank-account" class="form-control" />
                  <?php if ($error_bank_account) { ?>
                  <div class="text-danger"><?php echo $error_bank_account; ?></div>
                  <?php  } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status == 0) { ?>
                    <option value="0" selected="selected"><?php echo $text_withdraw_status_0; ?></option>
                    <option value="1"><?php echo $text_withdraw_status_1; ?></option>
                    <?php } else { ?>
                    <option value="0"><?php echo $text_withdraw_status_0; ?></option>
                    <option value="1" selected="selected"><?php echo $text_withdraw_status_1; ?></option>
                    <?php } ?>
                  </select>
                  <?php if ($error_status) { ?>
                  <div class="text-danger"><?php echo $error_status; ?></div>
                  <?php  } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-refused"><?php echo $entry_refused; ?></label>
                <div class="col-sm-10">
                  <select name="refused" id="input-refused" class="form-control">
                    <?php if ($refused == 0) { ?>
                    <option value="0" selected="selected"><?php echo $text_withdraw_refused_0; ?></option>
                    <option value="1"><?php echo $text_withdraw_refused_1; ?></option>
                    <?php } else { ?>
                    <option value="0"><?php echo $text_withdraw_refused_0; ?></option>
                    <option value="1" selected="selected"><?php echo $text_withdraw_refused_1; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </fieldset>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('input[name=\'customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						category: item['customer_group'],
						label: item['name'],
						value: item['customer_id'],
						firstname: item['firstname'],
						email: item['email'],
						telephone: item['telephone']			
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'customer\']').val(item['label']);
		$('input[name=\'customer_id\']').val(item['value']);
		$('input[name=\'firstname\']').attr('value', item['firstname']);
		$('input[name=\'email\']').attr('value', item['email']);
		$('input[name=\'telephone\']').attr('value', item['telephone']);
	}
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id'],
						model: item['model']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val(item['label']);
		$('input[name=\'product_id\']').val(item['value']);	
		$('input[name=\'model\']').val(item['model']);	
	}
});

$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();
	
	$('#history').load(this.href);
});			

$('#history').load('index.php?route=sale/withdraw/history&token=<?php echo $token; ?>&return_id=<?php echo $return_id; ?>');

$('#button-history').on('click', function(e) {
  e.preventDefault();

	$.ajax({
		url: 'index.php?route=sale/return/history&token=<?php echo $token; ?>&return_id=<?php echo $return_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'return_status_id=' + encodeURIComponent($('select[name=\'return_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'history_comment\']').val()),
		beforeSend: function() {
			$('#button-history').button('loading');	
		},
		complete: function() {
			$('#button-history').button('reset');	
		},
		success: function(html) {
			$('.alert').remove();
			
			$('#history').html(html);
			
			$('textarea[name=\'history_comment\']').val('');
		}
	});
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>