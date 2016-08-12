<?php echo $header; ?>
<div class="container">
  <div class="row">
    <div id="content" class="col-sm-12">
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <div id="search" class="input-group">
            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" class="form-control" />
            <input type="hidden" name="category_id" value="0"/>
            <input type="hidden" name="sub_category" value="1"/>
            <input type="hidden" name="description" value="1"/>
            <span class="input-group-btn">
              <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" />
            </span>
          </div>
        </div>
      </div>
      <?php if (!$products) { ?>
      <?php echo $content_top; ?>
      <?php } ?>
      <?php if ($products) { ?>
      <?php /*Order start*/
      $sorts_format = array();

      /*默认*/
      $sorts_format[] = array(
        'text' => $sorts[0]['text'],
        'href' => $sorts[0]['href'],
        'active' => $sort . '-' . $order == $sorts[0]['value'] ? true : false,
        'type' => true,
      );

      for ($i=1; $i < count($sorts); $i+=2) {
        $sorts_format[] = array(
        'text' => mb_substr($sorts[$i]['text'], 0, mb_strpos($sorts[$i]['text'], ' ')),
        'href' => $sort . '-' . $order == $sorts[$i]['value'] ? $sorts[$i+1]['href'] : $sorts[$i]['href'],
        'active' => ($sort . '-' . $order == $sorts[$i]['value'] || $sort . '-' . $order == $sorts[$i+1]['value']) ? true : false,
        'type' => $sort . '-' . $order == $sorts[$i]['value'] ? false : true,
      );
      }?>
      <div class="row widget">
        <div class="col-sm-12">
          <ul class="cat-sort">
            <?php foreach ($sorts_format as $sort_item) : ?>
            <li><a class="<?php echo $sort_item['active'] ? 'active' : ''?>" href="<?php echo $sort_item['href']; ?>"><?php echo $sort_item['text'];?> <i class="fa <?php echo $sort_item['active'] ? ($sort_item['type'] ? 'fa-level-down' : 'fa-level-up') : 'fa-sort'?>"></i></a></li>
            <?php endforeach; ?>
          </ul>

          <!-- Product list start -->
          <div class="row product-grid">
            <?php foreach ($products as $product) { ?>
            <div class="col-xs-6">
              <div class="product-thumb transition">
                <div class="image"><a href="<?php echo $product['href']; ?>"><img data-src="<?php echo $product['thumb']; ?>" src="<?php echo $placeholder; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="lazy img-responsive" /></a></div>
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
          <!-- Product list end -->

          <div class="row">
            <div class="col-sm-12 text-center"><?php echo $pagination; ?></div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>
