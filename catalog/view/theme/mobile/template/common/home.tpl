<?php echo $header; ?>
<div class="container">
	<div class="notice"></div>
	<header>
    <div id="search" class="input-group">
      <input type="text" name="search" value="" placeholder="<?php echo $text_search; ?>" class="form-control" />
      <input type="hidden" name="category_id" value="0"/>
      <input type="hidden" name="sub_category" value="1"/>
      <input type="hidden" name="description" value="1"/>
      <span class="input-group-btn">
        <input type="button" value="<?php echo $text_search; ?>" id="button-search" class="btn btn-primary" />
      </span>
    </div>
	</header>
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?><?php echo $content_bottom; ?></div>
  </div>
</div>
<?php echo $footer; ?>
