<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <div class="panel-group" id="accordion">
        <?php if ($shipping_required) { ?>
        <div class="panel panel-default">
          <div class="panel-collapse" id="collapse-shipping-address">
            <div class="panel-body"></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-collapse" id="collapse-shipping-method">
            <div class="panel-body"></div>
          </div>
        </div>
        <?php } ?>
        <div class="panel panel-default" style="border: 0px solid;" id="collapse-payment-method">
        </div>
        <div class="panel panel-default hidden">
          <div class="panel-collapse" id="collapse-checkout-confirm">
            <div class="panel-body"></div>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
		<?php if ($shipping_required) { ?>
		get_shipping_address();
		<?php } else { ?>
    get_payment_method();
		<?php } ?>
});

// Add Shipping Address
$(document).delegate('#button-shipping-address', 'click', function(){
	save_shipping_address();
});

// Shipping Address
//$(document).delegate('#button-shipping-address', 'click', function(){
$(document).delegate('#shipping-existing > select[name="address_id"]', 'change', function(){
	save_shipping_address();
});

// Shipping Method
//$(document).delegate('#button-shipping-method', 'click', function(){
$(document).delegate('#collapse-shipping-method input[type="radio"]', 'click', function(){
	save_shipping_method();
});

$(document).delegate('#button-payment-method', 'click', function(){
	//save_payment_method();  //submit
	save_agree_submit();
});

$(document).delegate('#collapse-payment-method input[type="radio"]', 'click', function(){
	save_payment_method();
});

function get_shipping_address() {
    $.ajax({
        url: 'index.php?route=checkout/shipping_address',
        dataType: 'html',
        success: function(html) {
						$('#collapse-shipping-address .panel-body').html(html);
						get_shipping_method();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function save_shipping_address() {
    $.ajax({
        url: 'index.php?route=checkout/shipping_address/save',
        type: 'post',
        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'hidden\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
        dataType: 'json',
        beforeSend: function() {
						//$('#button-shipping-address').button('loading');
		    },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                //$('#button-shipping-address').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

								for (i in json['error']) {
									var element = $('#input-shipping-' + i.replace('_', '-'));
				
									if ($(element).parent().hasClass('input-group')) {
										$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
									} else {
										$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
									}
								}
				
								// Highlight any found errors
								$('.text-danger').parent().parent().addClass('has-error');
            } else {
								get_shipping_address();
								get_shipping_method();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function get_shipping_method() {
		$.ajax({
		    url: 'index.php?route=checkout/shipping_method',
		    dataType: 'html',
		    complete: function() {
		        //$('#button-shipping-address').button('reset');
		    },
		    success: function(html) {
		        $('#collapse-shipping-method .panel-body').html(html);
		        save_shipping_method();
		    },
		    error: function(xhr, ajaxOptions, thrownError) {
		        //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		    }
		});
}

function save_shipping_method() {
    $.ajax({
        url: 'index.php?route=checkout/shipping_method/save',
        type: 'post',
        data: $('#collapse-shipping-method input[type=\'radio\']:checked, #collapse-shipping-method textarea'),
        dataType: 'json',
        beforeSend: function() {
        		//$('#button-shipping-method').button('loading');
				},
        complete: function() {
            //$('#button-shipping-method').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                //$('#button-shipping-method').button('reset');
                
                if (json['error']['warning']) {
                    $('#collapse-shipping-method .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {
								get_payment_method();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function get_payment_method() {
    $.ajax({
        url: 'index.php?route=checkout/payment_method',
        dataType: 'html',
        complete: function() {
            //$('#button-shipping-method').button('reset');
        },
        success: function(html) {
            $('#collapse-payment-method').html(html);
            save_payment_method();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}


function save_payment_method() {
    $.ajax({
        url: 'index.php?route=checkout/payment_method/save',
        type: 'post',
        data: $('#collapse-payment-method input[type=\'radio\']:checked, #collapse-payment-method input[type=\'checkbox\']:checked, #collapse-payment-method textarea'),
        dataType: 'json',
        beforeSend: function() {
         	//$('#button-payment-method').button('loading');
				},
        complete: function() {
            //$('#button-payment-method').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-payment-method').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {
            		//success
            		get_pruduct_list();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function save_agree_submit() {
		save_payment_method();
    $.ajax({
        url: 'index.php?route=checkout/payment_method/saveagree',
        type: 'post',
        data: $('#collapse-payment-method input[type=\'checkbox\']:checked'),
        dataType: 'json',
        beforeSend: function() {
         	//$('#button-payment-method').button('loading');
				},
        complete: function() {
            //$('#button-payment-method').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-payment-method').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {
            		//success
            		get_confirm();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function get_confirm() {
		$.ajax({
				url: 'index.php?route=checkout/confirm',
				dataType: 'html',
				complete: function() {
				  	//$('#button-payment-method').button('reset');
				},
				success: function(html) {
				  	$('#collapse-checkout-confirm .panel-body').html(html);
				  	$('#button-confirm').click();
				},
				error: function(xhr, ajaxOptions, thrownError) {
				  	//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
		});
}

function get_pruduct_list() {
		$.ajax({
				url: 'index.php?route=checkout/confirm/productlist',
				dataType: 'html',
				complete: function() {
				  	//$('#button-payment-method').button('reset');
				},
				success: function(html) {
				  	//$('#collapse-checkout-productlist .panel-body').html(html);
				  	$('#product-list').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
				  	//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
		});
}
//--></script>
<?php echo $footer; ?>