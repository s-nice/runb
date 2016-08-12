<?php echo $header; ?>
<?php if ($categories) { ?>
<div class="container category-list-page">
  <div class="row">
    <div id="content" class="col-xs-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <?php foreach ($categories as $category) : ?>
          <div class="row">
            <div class="col-sm-12 title"><?php echo $category['name']; ?></div>
            <div class="col-sm-12">
              <div class="row">
                <div class="col-xs-3 cat-item"><a href="<?php echo $category['href']; ?>"><img data-src="<?php echo $category['thumb'];?>" src="<?php echo $placeholder; ?>" class="lazy img-responsive"/><span><?php echo $text_all; ?></span></a></div>

                <?php if ($category['children']) { ?>
                <?php $total = count($category['children']) + 1;
                $items_per_row = 4;
                $current_item = 1; ?>
                <?php foreach ($category['children'] as $child) : ?>
                <?php if ($current_item % $items_per_row == 0) : ?>
                <div class="row">
                <?php endif; ?>
                <div class="col-xs-3 cat-item"><a href="<?php echo $child['href']; ?>"><img data-src="<?php echo $child['thumb'];?>" src="<?php echo $placeholder; ?>" class="lazy img-responsive"/><span><?php echo $child['name']; ?></span></a></div>
                <?php $current_item++;
                if(($current_item % $items_per_row == 0) || $current_item == $total) : ?>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>

              <?php } else { ?>
              </div>
              <?php } ?>
            </div>
          </div>
          <?php endforeach;?>

        </div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
  </div>


</div>
<?php } ?>
<?php echo $footer; ?>
</body></html>
