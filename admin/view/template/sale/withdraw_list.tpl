<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-withdraw-id"><?php echo $entry_withdraw_id; ?></label>
                <input type="text" name="filter_withdraw_id" value="<?php echo $filter_withdraw_id; ?>" placeholder="<?php echo $entry_withdraw_id; ?>" id="input-withdraw-id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-refused"><?php echo $entry_refused; ?></label>
                <select name="filter_refused" id="input-refused" class="form-control">
                  <?php if($filter_refused === NULL) { ?>
                  <option value="*" selected="selected"></option>
                  <option value="0"><?php echo $text_withdraw_refused_0; ?></option>
                  <option value="1"><?php echo $text_withdraw_refused_1; ?></option>
                  <?php } else if (0 == $filter_refused) { ?>
                  <option value="*"></option>
                  <option value="0" selected="selected"><?php echo $text_withdraw_refused_0; ?></option>
                  <option value="1"><?php echo $text_withdraw_refused_1; ?></option>
                  <?php } else { ?>
                  <option value="*"></option>
                  <option value="0"><?php echo $text_withdraw_refused_0; ?></option>
                  <option value="1" selected="selected"><?php echo $text_withdraw_refused_1; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <?php if($filter_status === NULL) { ?>
                  <option value="*" selected="selected"></option>
                  <option value="0"><?php echo $text_withdraw_status_0; ?></option>
                  <option value="1"><?php echo $text_withdraw_status_1; ?></option>
                  <?php } else if (0 == $filter_status) { ?>
                  <option value="*"></option>
                  <option value="0" selected="selected"><?php echo $text_withdraw_status_0; ?></option>
                  <option value="1"><?php echo $text_withdraw_status_1; ?></option>
                  <?php } else { ?>
                  <option value="*"></option>
                  <option value="0"><?php echo $text_withdraw_status_0; ?></option>
                  <option value="1" selected="selected"><?php echo $text_withdraw_status_1; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php //echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-withdraw">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-right"><?php if ($sort == 'withdraw_id') { ?>
                    <a href="<?php echo $sort_withdraw_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_withdraw_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_withdraw_id; ?>"><?php echo $column_withdraw_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_customer; ?>
                    </td>
                  <td class="text-left"><?php echo $column_bank_account; ?>
                    </td>
                  <td class="text-left"><?php echo $column_amount; ?>
                    </td>
                  <td class="text-left"><?php echo $column_message; ?>
                    </td>
                  <td class="text-left"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'refused') { ?>
                    <a href="<?php echo $sort_refused; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_refused; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_refused; ?>"><?php echo $column_refused; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($withdraws) { ?>
                <?php foreach ($withdraws as $withdraw) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($withdraw['withdraw_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $withdraw['withdraw_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $withdraw['withdraw_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-right"><?php echo $withdraw['withdraw_id']; ?></td>
                  <td class="text-left"><?php echo $withdraw['customer']; ?></td>
                  <td class="text-left"><?php echo $withdraw['bank_account']; ?></td>
                  <td class="text-left"><?php echo $withdraw['amount']; ?></td>
                  <td class="text-left"><?php echo $withdraw['message']; ?></td>
                  <td class="text-left"><?php echo $withdraw['status'] ? $text_withdraw_status_1 : $text_withdraw_status_0; ?></td>
                  <td class="text-left"><?php echo $withdraw['refused'] ? $text_withdraw_refused_1 : $text_withdraw_refused_0; ?></td>
                  <td class="text-left"><?php echo $withdraw['date_added']; ?></td>
                  <td class="text-right"><a href="<?php echo $withdraw['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/withdraw&token=<?php echo $token; ?>';
	
	var filter_withdraw_id = $('input[name=\'filter_withdraw_id\']').val();
	
	if (filter_withdraw_id) {
		url += '&filter_withdraw_id=' + encodeURIComponent(filter_withdraw_id);
	}
	
	var filter_status = $('select[name=\'filter_status\']').val();
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	var filter_refused = $('select[name=\'filter_refused\']').val();
	
	if (filter_refused != '*') {
		url += '&filter_refused=' + encodeURIComponent(filter_refused);
	}	
		
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}	
});

$('input[name=\'filter_product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_product\']').val(item['label']);
	}	
});

$('input[name=\'filter_model\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_model\']').val(item['label']);
	}	
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?> 