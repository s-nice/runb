<?php echo $header; ?>
<div class="container category-page">
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <?php if ($products) { ?>
          <?php /*Order Selections*/
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
          <ul class="cat-sort">
            <?php foreach ($sorts_format as $sort_item) : ?>
            <li><a class="<?php echo $sort_item['active'] ? 'active' : ''?>" href="<?php echo $sort_item['href']; ?>"><?php echo $sort_item['text'];?> <i class="fa <?php echo $sort_item['active'] ? ($sort_item['type'] ? 'fa-level-down' : 'fa-level-up') : 'fa-sort'?>"></i></a></li>
            <?php endforeach; ?>
          </ul>
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
          <div class="row">
            <div class="col-sm-12 text-center"><?php echo $pagination; ?></div>
          </div>
          <?php } else { ?>
            <!-- No products -->
            <p><?php echo $text_empty; ?></p>
            <div class="buttons">
              <a href="<?php echo $continue; ?>" class="btn btn-primary btn-block"><?php echo $button_continue; ?></a>
            </div>
          <?php } ?>
        </div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
</div>
<?php echo $footer; ?>
