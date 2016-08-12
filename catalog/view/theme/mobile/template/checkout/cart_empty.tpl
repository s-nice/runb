<?php echo $header; ?>
<div class="container empty-cart-page">
  <div id="content" class="col-sm-12"><?php echo $content_top; ?>
    <div class="row">
      <div class="col-sm-12">
        <span class="icon"><i class="iconfont icon-iconfontgouwuche"></i></span>
        <span class="msg"><?php echo $text_error; ?></span>
        <a class="link" href="<?php echo $home; ?>"><?php echo $button_continue; ?></a>
      </div>
    </div>
    <?php echo $content_bottom; ?>
  </div>
</div>
<?php echo $footer; ?>
