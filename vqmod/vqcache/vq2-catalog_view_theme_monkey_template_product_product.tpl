<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="product-detail <?php echo $class; ?>"><?php echo $content_top; ?>
      <div class="row">
        <?php if ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-5'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-5'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?>">
          <?php if ($thumb || $images) { ?>
          <!--elevate zoom start-->
          <div class="elevate-zoom-wrapper">
            <div class="elevate-zoom-preview">
              <a href="<?php echo $popup; ?>">
                <img id="elevate-zoom" src="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>" class="img-responsive">
              </a>
            </div>

            <div id="product-thumbnail-gallery">
              <a href="<?php echo $popup; ?>" rel="fancybox" class="elevatezoom-gallery active" data-upate="" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>"><img src="<?php echo $thumb; ?>" width="60"></a>
              <?php foreach ($images as $image) {?>
              <a href="<?php echo $image['popup']; ?>" rel="fancybox" class="elevatezoom-gallery" data-image="<?php echo $image['thumb']; ?>"data-zoom-image="<?php echo $image['popup']; ?>"><img src="<?php echo $image['thumb']; ?>" width="60"></a>
              <?php } ?>
            </div>
          </div>
          <!--elevate zoom end-->
          <?php } ?>
          <div class="wishlist-share">
            <a onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i> <?php echo $button_wishlist; ?></a>
            <a onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-link"></i> <?php echo $button_compare; ?></a>
          </div>
        </div>
        <?php if ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-7'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-7'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?> product-info">
          <h1><?php echo $heading_title; ?></h1>
          <ul class="product-brief-wrapper">
            <?php if ($manufacturer) { ?>
            <li><span><?php echo $text_manufacturer; ?></span><a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></li>
            <?php } ?>
            <li><span><?php echo $text_model; ?></span><?php echo $model; ?></li>
            <?php if ($reward) { ?>
            <li><span><?php echo $text_reward; ?></span><?php echo $reward; ?></li>
            <?php } ?>
            <li><span><?php echo $text_stock; ?></span><?php echo $stock; ?></li>
          </ul>

				<!--flash sale start-->
				<?php if (isset($flash_sale)) { ?>
					<?php if ($flash_sale['flash_sale_price']) { ?>
					<ul class="list-unstyled">
					  <li><span style="text-decoration: line-through;"><?php echo $price; ?></span></li>
					  <li>
					    <h2><?php echo $flash_sale['flash_sale_price']; ?></h2>
					  </li>
					  <?php if ($tax) { ?>
					  <li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
					  <?php } ?>
					  <li><strong><?php echo $text_quantity; ?> <?php echo $flash_sale['display_quantity']; ?></strong></li>
					  <?php if ($points) { ?>
					  <li><?php echo $text_points; ?> <?php echo $points; ?></li>
					  <?php } ?>
					  <?php if ($discounts) { ?>
					  <li>
					    <hr>
					  </li>
					  <?php foreach ($discounts as $discount) { ?>
					  <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
					  <?php } ?>
					  <?php } ?>
					</ul>
					<?php } ?>
				<?php } else { ?>
				<!--flash sale end-->
			
          <?php if ($price) { ?>
          <div class="product-price-wrapper">
            <?php if (!$special) { ?>
            <span class="price-new"><?php echo $price; ?></span>
            <?php } else { ?>
            <span class="price-new"><?php echo $special; ?></span>
            <span class="price-old"><?php echo $price; ?></span>
            <?php } ?>
            <?php if ($tax) { ?>
            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
            <?php } ?>
            <?php if ($points) { ?>
            <span><?php echo $text_points; ?> <?php echo $points; ?></span>
            <?php } ?>
          </div>
          <hr>
          <?php } ?>
          <?php if ($discounts) { ?>
          <div class="product-discount-wrapper">
          <?php foreach ($discounts as $discount) { ?>
          <span><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></span>
          <?php } ?>
          </div>
          <hr>
          <?php } ?>

				<!--flash sale start-->
				<?php } ?>
				<!--flash sale end-->
			
          <div id="product">
            <?php if ($options) { ?>
            <h3><?php echo $text_option; ?></h3>
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
            <hr>
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

				<!--flash sale start-->
				<?php if (isset($flash_sale)) { ?>
				<?php if ($flash_sale['seconds_to_start']) { ?>
				<div class="flash-sale-info to-start" style="max-width: 400px">
				  <div class="countdown-title"><?php echo $text_flash_sale_countdown_start; ?></div>
				  <div class="countdown" id="flash-sale-<?php echo $flash_sale['product_id']?>-countdown">
				    <span>0<div><?php echo $text_day; ?></div></span>
				    <span>0<div><?php echo $text_hour; ?></div></span>
				    <span>0<div><?php echo $text_minute; ?></div></span>
				    <span>0<div><?php echo $text_second; ?></div></span>
				  </div>
				  <button type="button" id="button-flash-sale" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block disabled"><?php echo $text_flash_sale_soon; ?></button>
				</div>
				<?php } elseif ($flash_sale['seconds_to_end'] && ($flash_sale['used_quantity'] < $flash_sale['quantity'])) {?>
				<div class="flash-sale-info to-end" style="max-width: 400px">
				  <div class="countdown-title"><?php echo $text_flash_sale_countdown_end; ?></div>
				  <div class="countdown" id="flash-sale-<?php echo $flash_sale['product_id']?>-countdown">
				    <span>0<div><?php echo $text_day; ?></div></span>
				    <span>0<div><?php echo $text_hour; ?></div></span>
				    <span>0<div><?php echo $text_minute; ?></div></span>
				    <span>0<div><?php echo $text_second; ?></div></span>
				  </div>
				  <button type="button" id="button-flash-sale" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block"><?php echo $text_flash_sale_in_now; ?></button>
				</div>
				<?php } else { ?>
				<div class="flash-sale-info to-end" style="max-width: 400px">
				  <div class="countdown" id="flash-sale-<?php echo $flash_sale['product_id']?>-countdown">
				    <div class="ended"><?php echo $text_flash_sale_ended; ?></div>
				  </div>
				  <a href="<?php echo $flash_sale['product_href'] ?>" class="btn btn-primary btn-lg btn-block"><?php echo $text_flash_sale_full_price; ?></a>
				</div>
				<?php } ?>
				<div class="flash-sale-tips"><i class="fa fa-info-circle"></i> <?php echo $text_flash_sale_tips; ?></div>
				<input type="hidden" name="quantity" value="1" />
				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
				<input type="hidden" name="flash_sale_id" value="<?php echo $flash_sale['flash_sale_id']; ?>" />
				<?php } else { ?>
				<!--flash sale end-->
			
            <div class="product-cart-action">
              <div class="quantity-input-wrapper">
                <input type="text" name="quantity" value="<?php echo $minimum; ?>" placeholder="<?php echo $entry_qty; ?>" id="input-quantity" class="form-control" />
                <a href="#" class="quantity-up">+</a>
                <a href="#" class="quantity-down">-</a>
              </div>
              <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_cart; ?></button>
              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
            </div>

				<!--flash sale start-->
				<?php } ?>
				<!--flash sale end-->
			
            <?php if ($minimum > 1) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
            <?php } ?>
          </div>
          <?php if ($review_status) { ?>
          <div class="rating">
            <p>
              <?php for ($i = 1; $i <= 5; $i++) { ?>
              <?php if ($rating < $i) { ?>
              <span class="fa fa-stack"><i class="fa fa-star off fa-stack-1x"></i></span>
              <?php } else { ?>
              <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
              <?php } ?>
              <?php } ?>
              <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $reviews; ?></a> / <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $text_write; ?></a></p>
            <hr>
            <?php if ($tags) { ?>
            <p><strong><?php echo $text_tags; ?></strong>
              <?php for ($i = 0; $i < count($tags); $i++) { ?>
              <?php if ($i < (count($tags) - 1)) { ?>
              <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
              <?php } else { ?>
              <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
              <?php } ?>
              <?php } ?>
            </p>
            <?php } ?>
            <!-- Baidu Share BEGIN -->
            <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a></div>
            <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{"bdSize":16}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
            <!-- Baidu Share END -->
          </div>
          <?php } ?>
        </div>
      </div>

				<!--flash sale start-->
				<?php if (isset($flash_sale)) { ?>
				<?php if ($text_flash_sale_rule): ?>
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#tab-flash-sale-desc" data-toggle="tab"><?php echo $text_flash_sale_rule; ?></a></li>
				</ul>
				<div class="tab-content">
				  <div class="tab-pane active" id="tab-flash-sale-desc"><?php echo $flash_sale['description']; ?></div>
				</div>
				<?php endif ?>
				<?php } ?>
				<!--flash sale end-->
			
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
        <?php if ($attribute_groups) { ?>
        <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
        <?php } ?>

        <?php if (isset($tab_product_question)) { ?><li><a href="#tab-question" data-toggle="tab"><?php echo $tab_product_question; ?></a></li><?php } ?>
				
        <?php if ($review_status) { ?>
        <li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
        <?php } ?>
      </ul>
      <div class="tab-content">

		<div id="tab-question" class="tab-pane">
			<div id="displayQuestionAnwser">
			<?php foreach ($showInProductPage as $valueQuestion) {?>
				<div class="item">
					<div class="user">
						<span class="u-name"><?php echo $text_customer_name;?><?php echo $valueQuestion['user_name'];?></span>
						<span class="u-level"><font style="color:">  </font></span>
						<span class="date-ask"><?php echo $valueQuestion['question_asked_date'];?></span>
					</div>
						<dl class="ask">
						<dt><b></b><?php echo $text_question;?></dt>
						<dd><?php echo $valueQuestion['product_question'];?></dd>
					</dl>
						<dl class="answer">
						<dt><b></b><?php echo $text_answer;?></dt>
						<dd>
							<div class="content"><?php echo $valueQuestion['product_answer'];?>
								<div class="date-answer"><?php echo $valueQuestion['question_answred_date']; ?></div>
							</div>
						</dd>
					</dl>
				</div>
				<style type="text/css">
					#displayQuestionAnwser .item {
					    padding: 8px 0px;
					    border-bottom: 1px dotted #DEDEDE;
					    font: 12px/150% Arial,Verdana,"宋体";
					    margin: 0px 0px 10px;
					}
					#displayQuestionAnwser .user {
					    color: #9C9A9C;
					    margin: 0px;
					    padding: 0px;
					}
					#displayQuestionAnwser .user span {
					    margin-right: 20px;
					}
					#displayQuestionAnwser .user .date-ask {
					    margin-right: 0px;
					}
					#displayQuestionAnwser dl {
							padding: 0px;
							margin: 0px;
					    margin-top: 5px;
					    overflow: hidden;
					}
					#displayQuestionAnwser dt {
					    float: left;
					    width: auto;
					    text-align: justify;
					}
					#displayQuestionAnwser dd {
							width: 90%;
							float: right;
							overflow: hidden;
							margin: 0px;
							padding: 0px;
					}
					#displayQuestionAnwser .content {
					    padding: 0px;
					    margin-bottom: 0px;
					    border: 0px;
					}
					#displayQuestionAnwser .answer {
					    color: #FF6500;
					}
					.date-answer{
					    text-align: right;
					    float: right;
					    color: #9C9A9C;
					}
				</style>
			<?php } ?>
			</div>
			<div class="form-horizontal" id="form-question">
				<h2><?php echo $entry_question_title; ?></h2>
				<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />
		    <div class="form-group required">
		      <div class="col-sm-12">
		        <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
		        <input type="text" name="questionerName" value="" id="questionerName" class="form-control" />
		      </div>
		    </div>
		    <div class="form-group required">
          <div class="col-sm-12">
            <label class="control-label" for="input-questionAnswer"><?php echo $entry_question; ?></label>
            <textarea name="questionAnswer" rows="5" id="questionAnswer" class="form-control"></textarea>
            <div class="help-block"><?php echo $text_note; ?></div>
          </div>
        </div>
				<div class="LoadingQuestion" style="margin-left: 282px;margin-top: -112px;position: absolute; display:none"></div>

				<div class="alert alert-success" id="qusetionSuccess" style="display:none"></div>
				<div class="alert alert-danger" id="qusetionWarning" style="display:none"></div>
		    <div class="buttons">
		      <div class="right"><a id="button-question" class="btn btn-primary"><?php echo $text_submit; ?></a></div>
		    </div>
	    </div>
		</div>
		
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
          
               <div id="review"></div>
              <form class="form-horizontal hidden" id="form-review">
			

            <h2><?php echo $text_write; ?></h2>
            <?php if ($review_guest) { ?>
            <div class="form-group required">
              <div class="col-sm-12">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="name" value="" id="input-name" class="form-control" />
              </div>
            </div>
            <div class="form-group required">
              <div class="col-sm-12">
                <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                <div class="help-block"><?php echo $text_note; ?></div>
              </div>
            </div>
            <div class="form-group required">
              <div class="col-sm-12">
                <label class="control-label"><?php echo $entry_rating; ?></label>
                &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
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
            <div class="buttons clearfix">
              <div class="pull-right">
                <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
              </div>
            </div>
            <?php } else { ?>
            <?php echo $text_login; ?>
            <?php } ?>
          </form>
        </div>
        <?php } ?>
      </div>
      <?php if ($products) { ?>
      <h3><?php echo $text_related; ?></h3>
      <div class="row">
        <?php foreach ($products as $product) { ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
        <?php } else { ?>
        <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
        <?php } ?>

        <div class="product-layout product-grid <?php echo $class ?>">
          <div class="product-wrapper">
            <div class="product-image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div class="product-info">
              <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
              <div class="product-description"><p><?php echo $product['description']; ?></p></div>
              <?php if ($product['price']) { ?>
              <div class="product-price">
                <span class="price-new"><?php echo $product['special'] ? $product['special'] : $product['price']; ?></span>
                <?php if ($product['special']) { ?><span class="price-old"><?php echo $product['price']; ?></span><?php } ?>
                <?php if ($product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                  <?php } ?>
              </div>
              <?php } ?>
              <?php if ($product['rating']): ?>
              <div class="rating">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                <?php if ($product['rating'] < $i) { ?>
                <span class="fa fa-stack"><i class="fa fa-star off fa-stack-2x"></i></span>
                <?php } else { ?>
                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                <?php } ?>
                <?php } ?>
              </div>
              <?php endif ?>
              <div class="product-action">
                <button type="button" class="add-to-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span><?php echo $button_cart; ?></span></button>
                <button type="button" class="wishlist" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart-o"></i> <span><?php echo $button_wishlist; ?></span></button>
                <button type="button" class="compare" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-bars"></i> <span><?php echo $button_compare; ?></span></button>
              </div>
            </div>
          </div>
        </div>

        <?php } ?>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php if ($thumb || $images) { ?>
<script type="text/javascript"><!--
  $(document).ready(function(){
    if ($(window).width() >= 768) {
      $('#elevate-zoom').elevateZoom({
        lensShape: 'basic',
        lensSize: 150,
        zoomWindowOffetx: 10,
        zoomWindowWidth: 450,
        zoomWindowHeight: 450,
        borderSize: 1,
        borderColour: '#eaeaea',
        gallery: 'product-thumbnail-gallery',
        galleryActiveClass: 'active',
        cursor:'pointer',
      });

      $('#elevate-zoom').bind('click', function(e) {
        var ez = $('#elevate-zoom').data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return false;
      });
    } else {
      $('.elevatezoom-gallery').fancybox();
      $('.elevate-zoom-preview a').bind('click', function(e) {
        $('.elevatezoom-gallery').eq(0).trigger('click');
        return false;
      });
    }
  });
//--></script>
<?php } ?>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				$('#cart #cart-total').html(json['total']);
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('#cart > .cart-content').load('index.php?route=common/cart/info ul li');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=account/oreview/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
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
			}
		}
	});
});

$("#product select[name*='option']").change(function(){
  refresh_price();
});

$("#product input[type='radio'], #product input[type='checkbox']").on("click",function(){
  refresh_price();
});

$('.quantity-input-wrapper a').click(function(e){
  e.preventDefault();
  if( $(this).hasClass('quantity-up')) {
    $('#input-quantity').val( parseInt($('#input-quantity').val()) + 1 );
  } else {
    if( parseInt($('#input-quantity').val())  > <?php echo $minimum; ?> ) {
      $('#input-quantity').val( parseInt($('#input-quantity').val()) - 1 );
    }
  }
  refresh_price();
});

$("#product input[name*=\'quantity\']").keyup(function() {
  if (parseInt($(this).val()) < <?php echo $minimum; ?>) {
    $(this).val(<?php echo $minimum; ?>);
  }
  refresh_price();
});

$("#product input[name*=\'quantity\']").on("focusout", function(){
  this.value = this.value.replace(/[^0-9\.]/g,'');
  if(this.value < <?php echo $minimum; ?>) {
    this.value = <?php echo $minimum; ?>;
  }
  refresh_price();
});

<?php if ($minimum > 1) { ?>
$(document).ready(function() {
  refresh_price();
});
<?php } ?>

function refresh_price() {
  $.ajax({
    url: 'index.php?route=product/product/price',
    type: 'post',
    data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
    dataType: 'json',
    beforeSend: function() {
    },
    complete: function() {
    },
    success: function(json) {
      if (json['special'] !== undefined) {
        $('.product-price-wrapper .price-new').html(json['special']);
        if (!$('.product-price-wrapper .price-old').length) {
          $('.product-price-wrapper .price-new').after("<span class=\"price-old\"></span>");
        }
        $('.product-price-wrapper .price-old').html(json['price']);
      } else {
        $('.product-price-wrapper .price-new').html(json['price']);
        $('.product-price-wrapper .price-old').remove();
      }

      if (json['tax'] !== undefined) {
        $('.product-price-wrapper .price-tax').html(json['tax']);
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
    }
  });
}
//--></script>

				<!--flash sale start-->
				<?php if (isset($flash_sale)) { ?>
				<script type="text/javascript"><!--
					$('#tab-flash-sale-desc img').addClass('img-responsive');
					<?php if ($flash_sale['seconds_to_start']): ?>
					  $('#flash-sale-<?php echo $flash_sale['product_id']?>-countdown').countdown('<?php echo $flash_sale['start_time']; ?>')
					  .on('update.countdown', function (event) {
					    $(this).html(event.strftime('<span>%D<div><?php echo $text_day; ?></div></span><span>%H<div><?php echo $text_minute; ?></div></span><span>%M<div><?php echo $text_hour; ?></div></span><span>%S<div><?php echo $text_second; ?></div></span>'));
					  })
					  .on('finish.countdown', function(event) {
					    $('.countdown-title').html('<?php echo $text_flash_sale_countdown_end; ?>');
					    $('.flash-sale-info').removeClass('to-start');
					    $('.flash-sale-info').addClass('to-end');
					    $(this).siblings('button').html('<?php echo $text_flash_sale_in_now; ?>');
					    $(this).siblings('button').removeClass('disabled');
					    $('#flash-sale-<?php echo $flash_sale['product_id']?>-countdown').countdown('<?php echo $flash_sale['end_time']; ?>')
					    .on('update.countdown', function (event) {
					      $(this).html(event.strftime('<span>%D<div><?php echo $text_day; ?></div></span><span>%H<div><?php echo $text_minute; ?></div></span><span>%M<div><?php echo $text_hour; ?></div></span><span>%S<div><?php echo $text_second; ?></div></span>'));
					    })
					    .on('finish.countdown', function(event) {
					      $(this).html('<div class="ended"><?php echo $text_flash_sale_ended; ?></div>');
					      $('#button-flash-sale').remove();
					      $('.flash-sale-info').append('<a href="<?php echo $flash_sale['product_href'] ?>" class="btn btn-primary btn-lg btn-block"><?php echo $text_flash_sale_full_price; ?></a>');
					    })
					  })
					<?php endif; ?>
					<?php if (!$flash_sale['seconds_to_start'] && $flash_sale['seconds_to_end']): ?>
					$('#flash-sale-<?php echo $flash_sale['product_id']?>-countdown').countdown('<?php echo $flash_sale['end_time']; ?>')
					  .on('update.countdown', function (event) {
					    $(this).html(event.strftime('<span>%D<div><?php echo $text_day; ?></div></span><span>%H<div><?php echo $text_minute; ?></div></span><span>%M<div><?php echo $text_hour; ?></div></span><span>%S<div><?php echo $text_second; ?></div></span>'));
					  })
					  .on('finish.countdown', function(event) {
					    $(this).html('<div class="ended"><?php echo $text_flash_sale_ended; ?></div>');
					    $('#button-flash-sale').remove();
					    $('.flash-sale-info').append('<a href="<?php echo $flash_sale['product_href'] ?>" class="btn btn-primary btn-lg btn-block"><?php echo $text_flash_sale_full_price; ?></a>');
					  })
					<?php endif; ?>
				//--></script>
				<?php } ?>
				<!--flash sale end-->
			

				<!--flash sale start-->
				<?php if (isset($flash_sale)) { ?>
				<script type="text/javascript"><!--
				$('#button-flash-sale').on('click', function() {
				  $.ajax({
				    url: 'index.php?route=checkout/cart/add_flash_sale',
				    type: 'post',
				    data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
				    dataType: 'json',
				    beforeSend: function() {
				      $('#button-flash-sale').button('loading');
				    },
				    complete: function() {
				      $('#button-flash-sale').button('reset');
				    },
				    success: function(json) {
				      $('.alert, .text-danger').remove();
				      $('.form-group').removeClass('has-error');

				      if (json['error']) {
				        if (json['error']['option']) {
				          for (i in json['error']['option']) {
				            var element = $('#input-option' + i.replace('_', '-'));

				            if (element.parent().hasClass('input-group')) {
				              element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
				            } else {
				              element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
				            }
				          }
				        }

				        if (json['error']['recurring']) {
				          $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				        }

				        if (json['error']['flash_sale']) {
				          $('.breadcrumb').after('<div class="alert alert-danger">' + json['error']['flash_sale'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				        }

				        // Highlight any found errors
				        $('.text-danger').parent().addClass('has-error');
				      }

				      if (json['success']) {
				        $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				        $('#cart #cart-total').html(json['total']);
				        $('html, body').animate({ scrollTop: 0 }, 'slow');
				        $('#cart > .cart-content').load('index.php?route=common/cart/info ul li');
				      }
				    },
				        error: function(xhr, ajaxOptions, thrownError) {
				            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				        }
				  });
				});
				//--></script>
				<?php } ?>
				<!--flash sale end-->
			
<?php echo $footer; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#button-question').click(function() {
			var product_id=$('#product_id').val();
			var questionerName=$('#questionerName').val();
			var questionerQuestion=$('#questionAnswer').val();
			if(questionerName==''){
				$('#qusetionSuccess').animate({opacity:"hide"},"slow");
				$('#qusetionWarning').animate({opacity:"hide"},"slow");
				$('#qusetionWarning').animate({opacity:"show"},"slow").html('<?php echo $error_name_empty; ?>');
				$('#questionerName').focus();
			}else if(questionerQuestion==''){
				$('#qusetionSuccess').animate({opacity:"hide"},"slow");
				$('#qusetionWarning').animate({opacity:"hide"},"slow");
				$('#qusetionWarning').animate({opacity:"show"},"slow").html('<?php echo $error_queston_empty; ?>');
				$('#questionerQuestion').focus();
			}else{
				$.ajax({
					type:'get',
					url:'index.php?route=product/askquestion/questionAnswer',
					data:'questionProductId='+product_id+"&questionerName="+questionerName+"&questionerQuestion="+questionerQuestion,
					beforeSend:function()	{
						$('.LoadingQuestion').animate({opacity:"show"},"slow").html('<img src="catalog/view/theme/default/image/loading.gif">');
					},
					complete:function()	{},
					success:function(result){
						$('.LoadingQuestion').animate({opacity:"hide"},"slow");
						$('#qusetionWarning').animate({opacity:"hide"},"slow");
						$('#qusetionSuccess').animate({opacity:"show"},"slow").html(result);
						$('#questionerName').val('');
						$('#questionAnswer').val('');
					}
				});
			}
		});
	});
	</script>
