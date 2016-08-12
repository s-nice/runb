<?php echo $header; ?>
<div class="container">
	<div class="notice"></div>
    <div class="row">
      <div id="content" class="col-sm-12 product-details-page"><?php echo $content_top; ?>
        <!--Slide start-->
        <?php if ($thumb || $images) { ?>
        <div class="row widget first-widget">
          <div id="slides" class="owl-carousel owl-theme">
            <?php if($thumb) { ?>
            <div class="item">
              <a class="popups" href="<?php echo $thumb; ?>"><img src="<?php echo $thumb; ?>" alt="" class="img-responsive" /></a>
            </div>
            <?php } ?>
            <?php foreach ($images as $image) { ?>
            <div class="item">
              <a class="popups" href="<?php echo $image['popup']; ?>"><img src="<?php echo $image['popup']; ?>" alt="" class="img-responsive" /></a>
            </div>
            <?php } ?>
          </div>
        </div>
        <script type="text/javascript"><!--
          $('#slides').owlCarousel({
            items:1,
            loop:true,
          });

          $(document).ready(function() {
            $('.popups').swipebox({
              useCSS : true,
              useSVG : true,
            });
          });
          --></script>
        <?php } ?>
        <!--Slide end-->

        <!--Price start-->
        <div class="row widget">
          <div class="col-xs-12">
            <span class="product_name"><?php echo $heading_title; ?></span>
            <?php if ($price) { ?>
            <div class="price">
              <?php if (!$special) { ?>
              <span><?php echo $price; ?></span>
              <?php } else { ?>
              <span><?php echo $special; ?></span>
              <span class="old_price"><?php echo $price; ?></span>
              <?php } ?>
              <?php if ($points) { ?>
              <span class="points"><?php echo $text_points; ?> <?php echo $points; ?></span>
              <?php } ?>
            </div>
            <?php } ?>
            <?php if ($discounts) { ?>
            <span class="product-info-list-item"><b><?php echo $text_discount_label; ?></b>:
              <?php $discount_text = array(); ?>
              <?php foreach ($discounts as $discount) { ?>
              <?php $discount_text[] = $discount['quantity'] . $text_discount . $discount['price']; ?>
              <?php } ?>
              <?php echo implode('; ', $discount_text); ?>
            </span>
            <?php } ?>
            <?php if ($manufacturer) { ?>
            <span class="product-info-list-item"><b><?php echo $text_manufacturer; ?></b>: <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></span>
            <?php } ?>
            <span class="product-info-list-item"><b><?php echo $text_model; ?></b>: <?php echo $model; ?></span>
            <?php if ($reward) { ?>
            <span class="product-info-list-item"><b><?php echo $text_reward; ?></b>: <?php echo $reward; ?></span>
            <?php } ?>
            <span class="product-info-list-item"><b><?php echo $text_stock; ?></b>: <?php echo $stock; ?></span>
          </div>
        </div>
        <!--Price end-->

        <!--Details start-->
        <div class="row widget">
          <div class="col-xs-12">
            <a class="scroll_to_desc" href="#"><?php echo $text_details; ?></a>
            <script type="text/javascript"><!--
              $(document).ready(function() {
                $('.scroll_to_desc').click(function(){
                 $('html, body').animate({scrollTop: $(".nav-tabs").offset().top}, 300);
                  return false;
                });
              });
            --></script>
          </div>
        </div>
        <!--Details end-->

        <!--Option Start-->
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
        <div class="row widget product_options">
          <div class="col-xs-12">
            <span class="title"><?php echo $text_option; ?></span>
            <div id="options">
              <?php if ($options) { ?>
              <?php foreach ($options as $option) { ?>
              <?php if ($option['type'] == 'select') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($option['product_option_value'] as $option_value) { ?>
                  <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'radio') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label"><?php echo $option['name']; ?></label>
                <div id="input-option<?php echo $option['product_option_id']; ?>">
                  <?php foreach ($option['product_option_value'] as $option_value) { ?>
                  <label class="radio">
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <span><?php echo $option_value['name']; ?></span>
                  </label>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'checkbox') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label"><?php echo $option['name']; ?></label>
                <div id="input-option<?php echo $option['product_option_id']; ?>">
                  <?php foreach ($option['product_option_value'] as $option_value) { ?>
                  <label class="checkbox">
                    <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <span><?php echo $option_value['name']; ?></span>
                  </label>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'image') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label"><?php echo $option['name']; ?></label>
                <div id="input-option<?php echo $option['product_option_id']; ?>">
                  <?php foreach ($option['product_option_value'] as $option_value) { ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                      <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                      <?php if ($option_value['price']) { ?>
                      (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                      <?php } ?>
                    </label>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'text') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'textarea') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'file') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label"><?php echo $option['name']; ?></label>
                <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'date') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                <div class="input-group date">
                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'datetime') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                <div class="input-group datetime">
                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <?php } ?>
              <?php if ($option['type'] == 'time') { ?>
              <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                <div class="input-group time">
                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <?php } ?>
              <?php } ?>
              <?php if ($recurrings) { ?>
              <hr>
              <h3><?php echo $text_payment_recurring ?></h3>
              <div class="form-group required">
                <select name="recurring_id" class="form-control">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($recurrings as $recurring) { ?>
                  <option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
                  <?php } ?>
                </select>
                <div class="help-block" id="recurring-description"></div>
              </div>
              <?php } ?>
              <?php } ?>

              <div class="option_item">
                <div id="product-quantity">
                  <input type="button" id="qty_substract" value="-" />
                  <input type="text" name="quantity" value="<?php echo $minimum; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" size="2" id="input_quantity" />
                  <input type="button" id="qty_add" value="+" />
                </div>
                <?php if ($minimum > 1) { ?>
                <div class="minimum-note"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
                <?php } ?>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
              </div>
            </div>
          </div>
        </div>
        <!--Option end-->

        <!--Tabs start-->
        <div class="row widget">
          <div class="col-xs-12">
            <!--Tab nav start-->
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
              <?php if ($attribute_groups) { ?>
              <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
              <?php } ?>
              <?php if ($review_status) { ?>
              <li><a href="#tab-review" data-toggle="tab"><?php echo $text_tab_review; ?></a></li>
              <?php } ?>
            </ul>
            <!--Tab nav end-->

            <!--Tab content start-->
            <div class="tab-content">
              <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>
              <?php if ($attribute_groups) { ?>
              <div class="tab-pane" id="tab-specification">
                <table class="table table-bordered">
                  <?php foreach ($attribute_groups as $attribute_group) { ?>
                  <thead>
                    <tr>
                      <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                    <tr>
                      <td><?php echo $attribute['name']; ?></td>
                      <td><?php echo $attribute['text']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                  <?php } ?>
                </table>
              </div>
              <?php } ?>
              <?php if ($review_status) { ?>
              <div class="tab-pane" id="tab-review">
                <form>
                  <div id="review"></div>
                  <span class="review_title"><?php echo $text_write; ?></span>
                  <?php if ($review_guest) { ?>
                  <div class="form-group">
                    <div class="left_title">
                      <span><?php echo $entry_name; ?></span>
                    </div>
                    <div class="right_list">
                      <input type="text" name="name" value="" id="input-name" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="left_title">
                      <span><?php echo $entry_review; ?></span>
                    </div>
                    <div class="right_list">
                      <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="help-block"><?php echo $text_note; ?></div>
                  <div class="form-group">
                    <div class="left_title">
                      <span><?php echo $entry_rating; ?></span>
                    </div>
                    <div class="right_list">
                      <?php echo $entry_bad; ?>&nbsp;
                      <input type="radio" name="rating" value="1" />
                      &nbsp;
                      <input type="radio" name="rating" value="2" />
                      &nbsp;
                      <input type="radio" name="rating" value="3" />
                      &nbsp;
                      <input type="radio" name="rating" value="4" />
                      &nbsp;
                      <input type="radio" name="rating" value="5" />
                      &nbsp;<?php echo $entry_good; ?></div>
                  </div>
                  <?php echo $captcha; ?>
                  <div class="button_center">
                    <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-block"><?php echo $button_continue; ?></button>
                  </div>
                  <?php } else { ?>
                  <?php echo $text_login; ?>
                  <?php } ?>
                </form>
              </div>
              <?php } ?>
            </div>
            <!--Tab content end-->
          </div>
        </div>
        <!--Tabs end-->

        <?php if($products) : ?>
        <!--Related products start-->
        <div class="row widget">
        <h3><?php echo $text_related; ?></h3>
          <div class="col-xs-12">
            <div class="row">
              <?php foreach ($products as $product) { ?>
              <div class="col-xs-6">
                <div class="product-thumb transition">
                  <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                  <div class="caption">
                    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    <?php if ($product['price']) { ?>
                    <div class="price">
                      <?php if (!$product['special']) { ?>
                      <span class="price-new"><?php echo $product['price']; ?></span>
                      <?php } else { ?>
                      <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                      <?php } ?>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <!--Related products end-->
        <?php endif; ?>
        <?php echo $content_bottom; ?>
      </div>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('#tab-description img').not('[img-responsive]').addClass('img-responsive'); // Make description image responsive

  $('#qty_substract').click(function(){
    qty_input = $('#input_quantity');
    if (qty_input.val() <= <?php echo $minimum; ?>) {
      qty_input.val(<?php echo $minimum; ?>);
    } else {
      qty_input.val(qty_input.val() - 1);
    }
  });

  $('#qty_add').click(function(){
    qty_input = $('#input_quantity');
    qty_input.val(qty_input.val() * 1 + 1);
  });
});

$('#add_to_wishlist').on('click', function(){
  wishlist.add(<?php echo $product_id; ?>);
});
$('.add_to_cart').on('click', function() {
  $.ajax({
    url: 'index.php?route=checkout/cart/add',
    type: 'post',
    data: $('input[name=\'product_id\'], #options input[type=\'text\'], #options input[type=\'hidden\'], #options input[type=\'radio\']:checked, #options input[type=\'checkbox\']:checked, #options select, #options textarea'),
    dataType: 'json',
    beforeSend: function() {
      $('.add_to_cart').button('loading');
    },
    complete: function() {
      $('.add_to_cart').button('reset');
    },
    success: function(json) {
      console.log(json);
      $('.right_list').removeClass('has_error');
      $('.text-danger').remove();

      if (json['error']) {
        $('html, body').animate({scrollTop: $("#options").parent().offset().top}, 0);
        $.Prompt('<?php echo $text_option_required; ?>', '1500');
        if (json['error']['option']) {
          for (i in json['error']['option']) {
            var element = $('#option_item_' + i + ' .right_list');
            element.addClass('has_error');
            element.append('<div class="text-danger">' + json['error']['option'][i] + '</div>');
          }
        }

        if (json['error']['recurring']) {
          $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
        }
      }

      if (json['success']) {
        $.Prompt('<?php echo $text_added_to_cart; ?>', '500');
        $('.cart_total').show();
      }
    }
  });
});

$('.buy_now').on('click', function() {
  $.ajax({
    url: 'index.php?route=checkout/cart/add',
    type: 'post',
    data: $('input[name=\'product_id\'], #options input[type=\'text\'], #options input[type=\'hidden\'], #options input[type=\'radio\']:checked, #options input[type=\'checkbox\']:checked, #options select, #options textarea'),
    dataType: 'json',
    beforeSend: function() {
      $('.buy_now').button('loading');
    },
    complete: function() {
      $('.buy_now').button('reset');
    },
    success: function(json) {
      $('.right_list').removeClass('has_error');
      $('.text-danger').remove();

      if (json['error']) {
        $('html, body').animate({scrollTop: $("#options").parent().offset().top}, 0);
        $.Prompt('<?php echo $text_option_required; ?>', '1500');
        if (json['error']['option']) {
          for (i in json['error']['option']) {
            var element = $('#option_item_' + i + ' .right_list');
            element.addClass('has_error');
            element.append('<div class="text-danger">' + json['error']['option'][i] + '</div>');
          }
        }

        if (json['error']['recurring']) {
          $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
        }
      }

      if (json['success']) {
        $('.cart_total').show();
        $.Prompt('<?php echo $text_added_to_cart_redirect; ?>', '100000');
        location = 'index.php?route=checkout/cart';
      }
    }
  });
});

$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
  $.ajax({
    url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
    type: 'post',
    dataType: 'json',
    data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
    beforeSend: function() {
      $('#button-review').button('loading');
    },
    complete: function() {
      $('#button-review').button('reset');
      $('#captcha').attr('src', 'index.php?route=tool/captcha#'+new Date().getTime());
      $('input[name=\'captcha\']').val('');
    },
    success: function(json) {
      $('.alert-success, .alert-danger').remove();

      if (json['error']) {
        $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
      }

      if (json['success']) {
        $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

        $('input[name=\'name\']').val('');
        $('textarea[name=\'text\']').val('');
        $('input[name=\'rating\']:checked').prop('checked', false);
        $('input[name=\'captcha\']').val('');
      }
    }
  });
});
//--></script>

<?php echo $footer; ?>
