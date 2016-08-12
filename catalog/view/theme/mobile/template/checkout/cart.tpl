<?php echo $header; ?>
<div class="container cart_page">
  <?php if ($attention) { ?>
  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
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
    <div id="content" class="col-xs-12"><?php echo $content_top; ?>
      <!-- Product list start -->
      <div class="row widget">
        <div class="col-xs-12">
          <h1><?php echo $heading_title; ?></h1>
          <form id="cart" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <ul class="product_list">
              <?php foreach ($products as $product) : ?>
              <li>
                <div class="selected">
                  <div class="cart-select">
                    <input type="checkbox" value="<?php echo $product['cart_id']; ?>" id="checkbox-<?php echo $product['cart_id']; ?>" name="selected[]" onchange="cart_select();" <?php if ($product['selected']) { ?>checked<?php } ?> />
                    <label for="checkbox-<?php echo $product['cart_id']; ?>"></label>
                  </div>
                </div>
                <div class="thumbnail">
                  <?php if ($product['thumb']) { ?>
                  <a href="<?php echo $product['href']; ?>"><img data-src="<?php echo $product['thumb']; ?>" src="<?php echo $placeholder; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="lazy img-responsive" /></a>
                  <?php } ?>
                </div>
                <div class="details">
                  <div class="product_name"><?php echo $product['name'] . (!$product['stock'] ? '***' : ''); ?></div>
                  <div class="unit_price"><?php echo $column_price; ?>: <?php echo $product['price']; ?></div>
                  <div class="options">
                    <?php if ($product['option']) { ?>
                    <?php foreach ($product['option'] as $option) { ?>
                    <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($product['reward']) { ?>
                    <small><?php echo $product['reward']; ?></small>
                    <?php } ?>
                    <?php if ($product['recurring']) { ?>
                    <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                    <?php } ?>
                  </div>
                  <div class="actions">
                    <div id="product-quantity">
                      <input type="button" class="qty_substract" value="-" />
                      <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" oncart_idup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" size="2" class="input_quantity" />
                      <input type="button" class="qty_add" value="+" />
                    </div>
                    <div class="remove_button"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><?php echo $button_remove; ?></button>
                    </div>
                  </div>
                  <div class="sub_total"><?php echo $column_total; ?>: <?php echo $product['total']; ?></div>
                </div>
              </li>
              <?php endforeach; ?>
            </ul>
          </form>
        </div>
      </div>
      <!-- Product list end -->

      <!-- Coupon start -->
      <?php if ($coupon || $voucher || $reward || $shipping) { ?>
      <div class="row widget">
        <div class="col-xs-12">
          <h2><?php echo $text_next; ?></h2>
          <p><?php echo $text_next_choice; ?></p>
          <div class="panel-group" id="accordion"><?php echo $coupon; ?><?php echo $voucher; ?><?php echo $reward; ?><?php echo $shipping; ?></div>
        </div>
      </div>
      <?php } ?>
      <!-- Coupon end -->

      <!-- Payment start -->
      <div class="row widget">
        <div class="col-xs-12">
          <table id="cart-totals" class="table table-bordered">
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
      <!-- Payment end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('.qty_substract').click(function(){
    qty_input = $(this).siblings('.input_quantity');
    if (qty_input.val() <= 1) {
      qty_input.val(1);
    } else {
      qty_input.val(qty_input.val() - 1);
    }
    setTimeout(function () {
      $('form#cart').submit();
    }, 1000);
  });

  $('.qty_add').click(function(){
    qty_input = $(this).siblings('.input_quantity');
    qty_input.val(qty_input.val() * 1 + 1);
    setTimeout(function () {
      $('form#cart').submit();
    }, 1000);
  });

  $('.input_quantity').change(function(){
    setTimeout(function () {
      $('form#cart').submit();
    }, 1000);
  });
});

function cart_select(){
  $.ajax({
    url: 'index.php?route=checkout/cart/cartSelect',
    type: 'post',
    dataType: 'json',
    data: $('input[name^=\'selected\']:checked:enabled'),
    beforeSend: function() {
    },
    complete: function() {
    },
    success: function(json) {
      if (json['error']) {
        alert(json['error']);
      } else {
        $.ajax({
          url: "index.php?route=checkout/cart/getShipping",
          success: function(html){
            $("#cart-shipping").html(html);
          }
        });
        $.ajax({
          url: "index.php?route=checkout/cart/getReward",
          success: function(html){
            $("#cart-reward").html(html);
          }
        });
        $.ajax({
          url: "index.php?route=checkout/cart/getTotals",
          success: function(html){
            $("#cart-totals").html(html);
          }
        });
        $.ajax({
          url: "index.php?route=checkout/cart/getTotals&type=json",
          success: function(json){
            $('.total_price .number').html(json[json.length - 1]['value']);
          }
        });
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

//Calculate total payment on footer
$('.total_price .number').html('<?php echo $totals[count($totals) - 1]['text']; ?>');
//--></script>
<?php echo $footer; ?>
