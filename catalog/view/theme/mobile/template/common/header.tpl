<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="catalog/view/theme/mobile/javascript/jquery/jquery.unveil.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/mobile/stylesheet/stylesheet.css" rel="stylesheet">
<link href="catalog/view/theme/mobile/stylesheet/font-iconfont/iconfont.css" rel="stylesheet" type="text/css">
<script src="catalog/view/theme/mobile/javascript/jquery/simple-popup/jquery.prompt.js" type="text/javascript"></script>
<link href="catalog/view/theme/mobile/javascript/jquery/simple-popup/jquery.prompt.css" rel="stylesheet" type="text/css">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/theme/mobile/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>
</head>
<body class="<?php echo $class; ?>">
<a href="#page_top" class="go_top"><i class="iconfont icon-iconfontshangsheng"></i></a>
<a href="<?php echo $home;?>" class="go_home"><i class="iconfont icon-31shouyexuanzhong"></i></a>
<!-- <div class="topbar">
  <div class="top-logo"><a href="<?php echo $home;?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"></a></div>
</div> -->
<?php if(strpos($class, '-product-')) { //bottom nav, for product page ?>
<nav id="bottom_add_to_cart">
  <ul class="list-unstyled">
    <li style="width:15%"><button id="add_to_wishlist"><i class="fa fa-heart"></i><div><?php echo $text_wishlist_text;?></div></button></li>
    <li style="width:35%"><button data-loading-text="<?php echo $text_please_wait; ?>" class="add_to_cart"><?php echo $text_add_to_cart;?></button></li>
    <li style="width:35%"><button data-loading-text="<?php echo $text_please_wait; ?>" class="buy_now"><?php echo $text_buy_now;?></button></li>
    <li style="width:15%"><a href="<?php echo $shopping_cart; ?>"><i class="iconfont icon-iconfontgouwuche"><span class="cart_total" style="<?php echo $cart_count <=0 ? 'display:none;' : ''; ?>"></span></i><div class="name"><?php echo $text_shopping_cart; ?></div></a></li>
  </ul>
</nav>
<?php } elseif(strpos($class, '-cart') && $cart_count > 0) {  //bottom nav, for checkout page ?>
<nav id="bottom_checkout">
  <ul class="list-unstyled">
    <li style="width:25%">
      <div class="cart-select" style="margin: 10px 5px 0 5px;display: block;float: left;">
        <input type="checkbox" value="" id="checkbox-all" onclick="$('input[name*=\'selected\']').prop('checked', this.checked); cart_select();" style="visibility: hidden"/>
        <label for="checkbox-all"></label>
      </div>
      <span style="display: block;float: left;line-height: 40px;font-weight: bold"><?php echo $text_select_all ?></span>
    </li>
    <li style="width:40%">
      <span class="total_price"><?php echo $text_to_pay; ?><strong class="number">0</strong></span>
    </li>
    <li style="width:25%" class="checkout"><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
  </ul>
</nav>
<?php } else {  //bottom nav, for other pages ?>
<nav id="bottom_tab_menu">
  <ul class="list-unstyled">
    <li><a href="<?php echo $home; ?>"<?php echo strpos($class, '-home') ? 'class=" active"' : ''; ?>><i class="iconfont icon-shouye-copy"></i> <div class="name"><?php echo $text_home; ?></div></a></li>
    <li><a href="<?php echo $link_search; ?>"<?php echo strpos($class, '-search') ? 'class=" active"' : ''; ?>><i class="iconfont icon-search"></i> <div class="name"><?php echo $text_search; ?></div></a></li>
    <li><a href="<?php echo $link_category; ?>"<?php echo strpos($class, '-category') ? 'class=" active"' : ''; ?>><i class="iconfont icon-31leimu"></i> <div class="name"><?php echo $text_category; ?></div></a></li>
    <li><a href="<?php echo $shopping_cart; ?>"><i class="iconfont icon-iconfontgouwuche"><span class="cart_total" style="<?php echo $cart_count <= 0 ? 'display:none;' : ''; ?>"></span></i><div class="name"><?php echo $text_shopping_cart; ?></div>
    </a></li>
    <li><a href="<?php echo $account; ?>"<?php echo strpos($class, '-account') ? 'class=" active"' : ''; ?>><i class="iconfont icon-iconfont31wode"></i> <div class="name"><?php echo $text_account; ?></div> </a></li>
  </ul>
</nav>
<?php } ?>
