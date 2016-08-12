<div class="row widget">
<span class="title"><?php echo $mobile_hot_search_title; ?></span>
  <div class="col-sm-12">
    <ul class="list-inline search-hot-keywords">
      <?php foreach($hot_search_keywords as $keyword) : ?>
      <?php if($keyword['keyword']) : ?>
      <li><a href="<?php echo $keyword['href'] ? $keyword['href'] : 'index.php?route=product/search&search=' . $keyword['keyword']; ?>" <?php echo $keyword['style'] ? 'style="' . $keyword['style'] . '"' : '';?>><?php echo $keyword['keyword']?></a></li>
      <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</div>