<div class="row widget">
<span class="title"><?php echo $heading_title; ?></span>
  <div class="col-xs-12">
    <div class="row">
      <?php foreach ($products as $product) { ?>
      <div class="col-xs-12 product-list">
        <div class="product-thumb transition">
          <div class="image"><a href="<?php echo $product['href']; ?>"><img data-src="<?php echo $product['thumb']; ?>" src="<?php echo $placeholder; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="lazy img-responsive" /></a></div>
          <div class="caption">
            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <p><?php echo $product['description']; ?></p>
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
