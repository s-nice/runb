<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<script src="catalog/view/theme/monkey/javascript/jquery-1.11.3.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/monkey/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/theme/monkey/javascript/common.js" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>
</head>
<body class="<?php echo $class; ?>">

				<?php if($online_status){ ?>
				<link href="catalog/view/theme/default/stylesheet/online.css" rel="stylesheet" type="text/css" />

				<script type="text/javascript"><!--
				$(document).ready(function(){
					$("#floatShow").bind("click",function(){
						$("#floatShow").attr("style","display:none");
						$("#floatHide").attr("style","display:block");
						$("#onlineService").animate({width:"show", opacity:"show"}, "fast" ,function(){
							$("#onlineService").show();
						});
						return false;
					});
					$("#floatHide").bind("click",function(){
						$("#floatShow").attr("style","display:block");
						$("#floatHide").attr("style","display:none");
						$("#onlineService").animate({width:"hide", opacity:"hide"}, "fast" ,function(){
							$("#onlineService").hide();
						});
						return false;
					});
				});
				//--></script>
				<div id="online_qq_layer">
					<div id="online_qq_tab">
						<a id="floatShow" style="display:block;" href="javascript:void(0);">收缩</a>
						<a id="floatHide" style="display:none;" href="javascript:void(0);">展开</a>
					</div>
					<div id="onlineService">
						<?php if($online_telephone){ ?>
						<div class="onlineMenu">
							<h3 class="tele" style="font-family: 'Open Sans',sans-serif;font-weight: 600;"><?php echo $text_telephone; ?></h3>
							<ul>
								<li class="tli phone"><?php echo $online_telephone; ?></li>
							</ul>
						</div>
						<?php } ?>
						<?php if($online_qq || $online_qq2 || $online_qq3){ ?>
						<div class="onlineMenu">
							<h3 class="tQQ" style="font-family: 'Open Sans',sans-serif;font-weight: 600;"><?php echo $text_qq; ?></h3>
							<ul>
							<!--
								<li class="tli zixun">在线咨询</li>
								-->
								<?php if($online_qq){ ?>
								<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $online_qq; ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:55203824:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a></li>
								<?php } ?>
								<?php if($online_qq2){ ?>
								<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $online_qq2; ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:55203824:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a></li>
								<?php } ?>
								<?php if($online_qq3){ ?>
								<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $online_qq3; ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:55203824:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a></li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
						<?php if($online_image){ ?>
						<div class="onlineMenu">
							<h3 class="weixin" style="font-family: 'Open Sans',sans-serif;font-weight: 600;"><?php echo $text_weixin_qrcode; ?></h3>
							<ul>
								<li style="height:100px"><img src="<?php echo $online_image; ?>"></img></li>
							</ul>
						</div>
						<?php } ?>
						<div class="btmbg"></div>
					</div>
				</div>
				<?php } ?>
			
<nav id="top">
  <div class="container">
    <?php echo $currency; ?>
    <?php echo $language; ?>
    <div id="top-links" class="nav pull-right">
      <ul class="list-inline">
        <li><a href="<?php echo $contact; ?>"><i class="fa fa-phone"></i></a> <span class="hidden-xs hidden-sm"><?php echo $telephone; ?></span></li>
        <li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs"><?php echo $text_account; ?></span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php if ($logged) { ?>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
            <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
            <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
            <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm"><?php echo $text_wishlist; ?></span></a></li>
        <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm"><?php echo $text_shopping_cart; ?></span></a></li>
        <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><i class="fa fa-jpy"></i> <span><?php echo $text_checkout; ?></span></a></li>
      </ul>
    </div>
  </div>
</nav>
<header>
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div id="logo">
          <?php if ($logo) { ?>
          <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
          <?php } else { ?>
          <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
          <?php } ?>
        </div>
      </div>
      <div class="col-sm-5"><?php echo $search; ?>
      </div>
      <div class="col-sm-3 mini-cart"><?php echo $cart; ?></div>
    </div>
  </div>
</header>
<?php if ($categories) { ?>
<div class="main-menu-wrapper">
  <div class="container">
    <div class="main-menu-mobile">
      菜单
      <span class="main-menu-toggle">
        <i class="fa fa-bars"></i>
      </span>
    </div>
    <div class="main-menu-container">
      <ul class="main-menu">
        <li class="parent"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a></li>
        <?php foreach ($categories as $category) { ?>
        <li class="parent <?php echo $category['children'] ? 'with-sub-menu' : '' ?>"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
          <?php if ($category['children']) { ?>
          <div class="open-sub-menu">+</div>
          <ul class="sub-menu">
            <?php foreach ($category['children'] as $child) { ?>
            <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
            <?php } ?>
          </ul>
          <?php } ?>
        </li>
        <?php } ?>
      </ul>
    </div>


    <?php if (false): ?>      
    <nav id="menu" class="navbar">
      <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
        <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <li><a href="<?php echo $home; ?>"><i class="fa fa-home"></i></a></li>
          <?php foreach ($categories as $category) { ?>
          <?php if ($category['children']) { ?>
          <li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
            <div class="dropdown-menu">
              <div class="dropdown-inner">
                <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                <ul class="list-unstyled">
                  <?php foreach ($children as $child) { ?>
                  <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                  <?php } ?>
                </ul>
                <?php } ?>
              </div>
              <a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
          </li>
          <?php } else { ?>
          <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </nav>
    <?php endif ?>
  </div>
</div>
<?php } ?>
