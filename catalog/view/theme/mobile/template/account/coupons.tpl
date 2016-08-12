<?php echo $header; ?>
<div class="container">
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row">
    <div id="content" class="col-xs-12">
      <div class="row widget first-widget">
        <div class="col-xs-12">
          <h2><?php echo $heading_title; ?></h2>
          <!-- <h3><?php echo $text_customer_coupons; ?></h3> -->
          <?php if(isset($coupons) && $coupons) { ?>
          <?php foreach ($coupons as $coupon): ?>
          <div class="coupon-item">
            <div class="amount">
              <?php echo $coupon['discount'] ?>
            </div>
            <div class="info">
              <div><?php echo $coupon['name']; ?></div>
              <div><?php echo $text_coupon_code; ?>: <strong><?php echo $coupon['code']; ?></strong></div>
              <div class="text-yes"><?php echo $text_valid; ?>: <span> <?php echo $coupon['valid'] ? $text_yes : $text_no; ?></span> </div>
              <div><?php echo $coupon['date_start']; ?> ~ <?php echo $coupon['date_end']; ?></div>
            </div>
          </div>
          <?php endforeach ?>
        <?php } ?>
        </div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>
