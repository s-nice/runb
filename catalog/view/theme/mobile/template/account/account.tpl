<?php echo $header; ?>
<div class="container account-page">
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget">
        <div class="col-sm-12">
          <ul class="list-inline grid-links">
            <li><a href="<?php echo $order; ?>"><i class="iconfont icon-iconfontquanbudingdan"></i><span><?php echo $text_order_all; ?></span></a></li>
            <li><a href="<?php echo $order_unpaid; ?>"><i class="iconfont icon-daifukuan"></i><?php if ($unpaid_total): ?><span class="text-number"><?php echo $unpaid_total; ?></span><?php endif ?><span><?php echo $text_order_unpaid; ?></span></a></li>
            <li><a href="<?php echo $order_unshipped; ?>"><i class="iconfont icon-tabsdaifahuo"></i><?php if ($unshipped_total): ?><span class="text-number"><?php echo $unshipped_total; ?></span><?php endif ?><span><?php echo $text_order_unshipped; ?></span></a></li>
            <li><a href="<?php echo $order_shipped; ?>"><i class="iconfont icon-iconfontdaishouhuo"></i><?php if ($shipped_total): ?><span class="text-number"><?php echo $shipped_total; ?></span><?php endif ?><span><?php echo $text_order_shipped; ?></span></a></li>
          </ul>
        </div>
      </div>
      <div class="row widget">
        <div class="col-sm-12">
          <!-- <h2><?php echo $text_my_account; ?></h2> -->
          <ul class="accordion-list list-unstyled">
            <li><a href="<?php echo $edit; ?>"><i class="iconfont icon-zhanghuxinxi"></i> <?php echo $text_edit; ?></a></li>
            <li><a href="<?php echo $password; ?>"><i class="iconfont icon-iconfontmima"></i> <?php echo $text_password; ?></a></li>
            <li><a href="<?php echo $address; ?>"><i class="iconfont icon-iconfontchanpincanshu"></i> <?php echo $text_address; ?></a></li>
            <li><a href="<?php echo $wishlist; ?>"><i class="iconfont icon-iconfontyouhuiquan"></i> <?php echo $text_wishlist; ?></a></li>
          </ul>
        </div>
      </div>
      <div class="row widget">
        <div class="col-sm-12">
          <!-- <h2><?php echo $text_my_orders; ?></h2> -->
          <ul class="accordion-list list-unstyled">
            <li><a href="<?php echo $order; ?>"><i class="iconfont icon-iconfontquanbudingdan"></i> <?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $download; ?>"><i class="iconfont icon-iconxiazai"></i> <?php echo $text_download; ?></a></li>
            <li><a href="<?php echo $coupons; ?>"><i class="iconfont icon-iconfontwodeyouhuijuan"></i> <?php echo $text_coupons; ?></a></li>
            <?php if ($reward) { ?>
            <li><a href="<?php echo $reward; ?>"><i class="iconfont icon-iconfontwodehuiyuanqia"></i> <?php echo $text_reward; ?></a></li>
            <?php } ?>
            <li><a href="<?php echo $return; ?>"><i class="iconfont icon-tuihuo"></i> <?php echo $text_return; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><i class="iconfont icon-custom-take-notes"></i> <?php echo $text_transaction; ?></a></li>
            <!-- <li><a href="<?php echo $recurring; ?>"><i class="iconfont">&#xf00bb;</i> <?php echo $text_recurring; ?></a></li> -->
          </ul>
        </div>
      </div>
      <div class="row widget">
        <div class="col-sm-12">
          <!--<h2><?php echo $text_my_newsletter; ?></h2>-->
          <ul class="accordion-list list-unstyled">
            <li><a href="<?php echo $newsletter; ?>"><i class="iconfont icon-iconfontyoujian"></i> <?php echo $text_newsletter; ?></a></li>
            <li><a href="<?php echo $logout; ?>"><i class="iconfont icon-iconfont31wode"></i> <?php echo $text_logout; ?></a></li>
          </ul>
        </div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>
