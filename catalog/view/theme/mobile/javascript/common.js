function getURLVar(key) {
  var value = [];
  var query = String(document.location).split('?');
  if (query[1]) {
    var part = query[1].split('&');
    for (i = 0; i < part.length; i++) {
      var data = part[i].split('=');
      if (data[0] && data[1]) {
        value[data[0]] = data[1];
      }
    }

    if (value[key]) {
      return value[key];
    } else {
      return '';
    }
  }
}

$(window).load(function() {
  $("img.lazy").unveil(10, function() {
    $(this).load(function() {
      this.style.opacity = 1;
    });
  });
});

$(document).ready(function() {
  jQuery(window).scroll(function(){
    if (jQuery(this).scrollTop() > 100) {
      jQuery('.go_top').fadeIn();
      jQuery('.go_home').fadeIn();
    } else {
      jQuery('.go_top').fadeOut();
      jQuery('.go_home').fadeOut();
    }
  });
  // scroll-to-top animate
  jQuery('.go_top').click(function(){
    jQuery("html, body").animate({ scrollTop: 0 }, 400);
      return false;
  });

  // Language
  $(document).delegate('#language a', 'click', function(e){
    e.preventDefault();
    $('#language input[name=\'code\']').attr('value', $(this).attr('href'));
    $('#language').submit();
  })

  // Currency
  $(document).delegate('#currency a', 'click', function(e){
    e.preventDefault();
    $('#currency input[name=\'code\']').attr('value', $(this).attr('href'));
    $('#currency').submit();
  })

  /* Search */
  $('#search input[name=\'search\']').parent().find('input[type="button"]').on('click', function() {
    url = $('base').attr('href') + 'index.php?route=product/search';
    var value = $('#search input[name=\'search\']').val();
    if (value) {
      url += '&search=' + encodeURIComponent(value);
    }
    location = url;
  });
});

// Cart add remove functions
var cart = {
  'add': function(product_id, quantity) {
    $.ajax({
      url: 'index.php?route=mobile/cart/add',
      type: 'post',
      data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
      dataType: 'json',
      beforeSend: function() {
        $('#cart > button').button('loading');
      },
      success: function(json) {
        $('.alert, .text-danger').remove();
        $('#cart > button').button('reset');
        if (json['redirect']) {
          location = json['redirect'];
        }

        if (json['success']) {
          $('.notice').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          $('#cart-total').html(json['total']);
        }
      }
    });
  },
  'update': function(key, quantity) {
    $.ajax({
      url: 'index.php?route=checkout/cart/edit',
      type: 'post',
      data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
      dataType: 'json',
      beforeSend: function() {
        $('#cart > button').button('loading');
      },
      success: function(json) {
        $('#cart > button').button('reset');
        $('#cart-total').html(json['total']);
        if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
          location = 'index.php?route=checkout/cart';
        } else {
          $('#cart > ul').load('index.php?route=common/cart/info ul li');
        }
      }
    });
  },
  'remove': function(key) {
    $.ajax({
      url: 'index.php?route=checkout/cart/remove',
      type: 'post',
      data: 'key=' + key,
      dataType: 'json',
      beforeSend: function() {
        $('#cart > button').button('loading');
      },
      success: function(json) {
        $('#cart > button').button('reset');
        $('#cart-total').html(json['total']);
        if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
          location = 'index.php?route=checkout/cart';
        } else {
          $('#cart > ul').load('index.php?route=common/cart/info ul li');
        }
      }
    });
  }
}

var recharge = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	}
}

var wishlist = {
  'add': function(product_id) {
    $.ajax({
      url: 'index.php?route=account/wishlist/add',
      type: 'post',
      data: 'product_id=' + product_id,
      dataType: 'json',
      success: function(json) {
        if (json['success']) {
          $.Prompt(json['success'], '2000');
        }
        if (json['info']) {
          $.Prompt(json['info'], '2000');
        }
      }
    });
  },
  'remove': function() {
  }
}
