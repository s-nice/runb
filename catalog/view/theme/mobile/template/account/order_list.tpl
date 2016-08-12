<?php echo $header; ?>
<div class="container">
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <!-- <h1><?php echo $heading_title; ?></h1> -->
          <ul class="order-type">
            <li <?php if ($type == ''): ?>class="active"<?php endif ?>><a href="<?php echo $order ?>"><?php echo $text_order_all; ?></a><span>|</span></li>
            <li <?php if ($type == 'unpaid'): ?>class="active"<?php endif ?>><a href="<?php echo $order_unpaid ?>"><?php echo $text_order_unpaid; ?></a><span>|</span></li>
            <li <?php if ($type == 'unshipped'): ?>class="active"<?php endif ?>><a href="<?php echo $order_unshipped ?>"><?php echo $text_order_unshipped; ?></a><span>|</span></li>
            <li <?php if ($type == 'shipped'): ?>class="active"<?php endif ?>><a href="<?php echo $order_shipped ?>"><?php echo $text_order_shipped; ?></a></li>
          </ul>
        </div>
      </div>

      <?php if ($orders) { ?>
      <?php foreach ($orders as $order) { ?>
      <div class="row widget">
        <div class="col-xs-12">
          <div class="order-item-wrapper">
            <div class="order-info-top">
              <div class="info">
                <a href="<?php echo $order['href']; ?>">
                  <span><?php echo $column_order_id; ?>: #<?php echo $order['order_id']; ?></span>
                  <span><?php echo $column_status; ?>: <?php echo $order['status']; ?></span>
                </a>
              </div>
              <?php if ($order['status'] == $text_order_not_pay_status): ?>
                <div class="action">
                  <a href="<?php echo $order['href']; ?>" class="btn btn-primary"><?php echo $button_continue_payment; ?></a>
                </div>
              <?php endif ?>
            </div>
            <div class="products">
              <a href="<?php echo $order['href']; ?>">
                <?php foreach ($order['product_list'] as $product) { ?>
                  <div class="product-item">
                    <div class="name"><?php echo $product['name']; ?></div>
                    <div class="price"><?php echo $product['total'] ?></div>
                  </div>
                <?php } ?>
              </a>
            </div>
            <div class="order-info-bottom">
              <a href="<?php echo $order['href']; ?>">
                <div class="total"><?php echo $column_total; ?>: <?php echo $order['total']; ?></div>
                <div class="date"><?php echo $column_date_added; ?>: <?php echo $order['date_added']; ?></div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="col-sm-12 text-center"><?php echo $pagination; ?></div>
      <?php } else { ?>
      <div class="row widget">
        <div class="col-xs-12">
          <p><?php echo $text_empty; ?></p>
        </div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    </div>
</div>
<?php echo $footer; ?>
