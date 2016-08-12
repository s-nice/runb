<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cod" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cod" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_total" value="<?php echo $alipay_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><?php echo $entry_seller_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_seller_email" value="<?php echo $alipay_seller_email; ?>" placeholder="<?php echo $entry_seller_email; ?>" id="input-total" class="form-control" />
            </div>
          </div>
          
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-security-code"><?php echo $entry_security_code; ?></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_security_code" value="<?php echo $alipay_security_code; ?>" placeholder="<?php echo $alipay_security_code; ?>" id="input-security-code" class="form-control" />
            </div>
          </div>
          
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-entry-partner"><?php echo $entry_partner; ?></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_partner" value="<?php echo $alipay_partner; ?>" placeholder="<?php echo $alipay_partner; ?>" id="input-entry-partner" class="form-control" />
            </div>
          </div>
          
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-currency-code"><?php echo $entry_currency_code; ?></label>
            <div class="col-sm-10">
              <select name="alipay_currency_code" id="input-currency-code" class="form-control">
                <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency['code'] == $alipay_currency_code) { ?>
                <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          
          
          	<div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="alipay_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $alipay_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          
					<div class="form-group">
            <label class="col-sm-2 control-label" for="input-wait-buyer-pay"><?php echo $entry_wait_buyer_pay; ?></label>
            <div class="col-sm-10">
              <select name="alipay_wait_buyer_pay" id="input-wait-buyer-pay" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $alipay_wait_buyer_pay) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-wait-seller-send"><?php echo $entry_wait_seller_send; ?></label>
            <div class="col-sm-10">
              <select name="alipay_wait_seller_send" id="input-wait-seller-send" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $alipay_wait_seller_send) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-wait-buyer-confirm"><?php echo $entry_wait_buyer_confirm; ?></label>
            <div class="col-sm-10">
              <select name="alipay_wait_buyer_confirm" id="input-wait-buyer-confirm" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $alipay_wait_buyer_confirm) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-trade-finished"><?php echo $entry_trade_finished; ?></label>
            <div class="col-sm-10">
              <select name="alipay_trade_finished" id="input-trade-finished" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $alipay_trade_finished) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="alipay_status" id="input-status" class="form-control">
                <?php if ($alipay_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_sort_order" value="<?php echo $alipay_sort_order; ?>" placeholder="<?php echo $alipay_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 