<div class="row widget">
  <!-- <span class="title"><?php echo $heading_title; ?></span> -->
  <?php foreach ($categories as $category) : ?>
  <div class="col-xs-3 cat-grid">
    <a href="<?php echo $category['href']; ?>" class="">
      <img data-src="<?php echo $category['image'];?>" src="<?php echo $placeholder; ?>" class="lazy img-responsive">
    </a>
  	<span><?php echo $category['name']; ?></span>
    </div>
  <?php endforeach; ?>
</div>
