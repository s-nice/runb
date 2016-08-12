<?php echo $header; ?>
<div class="container">
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
    <div class="row widget first-widget">
      <div class="col-sm-12">
        <!-- <h2><?php echo $text_order_detail; ?></h2> -->
        <div class="order-info">
          <?php if ($invoice_no) { ?>
          <b><?php echo $text_invoice_no; ?></b>: <?php echo $invoice_no; ?><br />
          <?php } ?>
          <b><?php echo $text_order_id; ?></b>: #<?php echo $order_id; ?><br />
          <b><?php echo $text_date_added; ?></b>: <?php echo $date_added; ?><br />
          <?php if ($payment_method) { ?>
          <b><?php echo $text_payment_method; ?></b>: <?php echo $payment_method; ?><br />
          <?php } ?>
          <?php if ($shipping_method) { ?>
          <b><?php echo $text_shipping_method; ?></b>: <?php echo $shipping_method; ?><br />
          <?php } ?>
        </div>
      </div>
    </div>
    <?php if ($payment): ?>
      <div id="checkout-payment" class="clearfix"><?php echo $payment; ?></div>
    <?php endif ?>
    <div class="row widget">
      <div class="col-xs-12">
        <?php foreach ($products as $product) { ?>
        <div class="product-item">
          <div class="name"><?php echo $product['name']; ?></div>
          <?php if ($product['option']): ?>
          <div class="option">
            <?php foreach ($product['option'] as $option) { ?>
            &nbsp;<?php echo $option['name']; ?>: <?php echo $option['value']; ?>
          <?php } ?>
          </div>
          <?php endif ?>
          <div class="product-data">
            <div class="model"><b><?php echo $column_model; ?></b>: <?php echo $product['model']; ?></div>
            <div class="total"><?php echo $product['price']; ?> x <?php echo $product['quantity']; ?> = <strong><?php echo $product['total']; ?></strong></div>
          </div>
          <div class="product-action">
            <?php if ($product['reorder']) { ?>
            <a href="<?php echo $product['reorder']; ?>" class="btn btn-default"><?php echo $button_reorder; ?></a>
            <?php } ?>
            <a href="<?php echo $product['return']; ?>" class="btn btn-default"><?php echo $button_return; ?></a>
          </div>
        </div>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <div class="product-item">
          <div class="name"><?php echo $voucher['description']; ?></div>
          <div class="product-data">
            <div class="total"><?php echo $voucher['amount']; ?> x 1 = <strong><?php echo $voucher['amount']; ?></strong></div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="row widget">
      <div class="col-xs-12">
        <?php foreach ($totals as $total) { ?>
          <b><?php echo $total['title']; ?></b>: <?php echo $total['text']; ?> <br/>
        <?php } ?>
      </div>
    </div>
    <?php if ($comment) { ?>
    <div class="row widget">
      <div class="col-xs-12">
        <?php echo $text_comment; ?>: <?php echo $comment; ?>
      </div>
    </div>
    <?php } ?>
    <?php if ($histories) { ?>
    <div class="row widget">
      <div class="col-xs-12">
        <strong><?php echo $text_history; ?></strong> <br/>
        <?php foreach ($histories as $history) { ?>
        <b><?php echo $column_date_added; ?></b>: <?php echo $history['date_added']; ?><br/>
        <b><?php echo $column_status; ?></b>: <?php echo $history['status']; ?><br/>
        <b><?php echo $column_comment; ?></b>: <?php echo $history['comment']; ?></br>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
    <?php echo $content_bottom; ?></div>
    </div>
</div>
<?php echo $footer; ?>
