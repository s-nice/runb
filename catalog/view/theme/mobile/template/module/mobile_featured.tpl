<div class="row widget">
  <span class="title"><?php echo $heading_title; ?></span>
  <div class="col-sm-12">
    <div class="row">
      <?php foreach ($products as $product) { ?>
      <div class="col-xs-6 product-grid">
        <div class="product-thumb transition">
          <div class="image"><a href="<?php echo $product['href']; ?>">
          <img data-src="<?php echo $product['thumb'] ?>" src="<?php echo $placeholder ?>" class="lazy img-responsive"></a></div>
          <div class="caption">
            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <?php if ($product['price']) { ?>
            <div class="price">
              <?php if (!$product['special']) { ?>
              <span class="price-new"><?php echo $product['price']; ?></span>
              <?php } else { ?>
              <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
              <?php } ?>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
