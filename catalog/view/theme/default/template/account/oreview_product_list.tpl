<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($oreviews) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-right"><?php echo $column_order_id; ?></td>
              <td class="text-left"><?php echo $column_product; ?></td>
              <td class="text-left"><?php echo $column_date_added; ?></td>
              <td class="text-left"><?php echo $column_review_text; ?></td>
              <td class="text-left"><?php echo $column_rating; ?></td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($oreviews as $oreview) { ?>
            <tr>
              <td class="text-right">#<?php echo $oreview['order_id']; ?></td>
              <td class="text-left"><?php echo $oreview['name']; ?></td>
              <td class="text-left"><?php echo $oreview['date_added']; ?></td>
              <td class="text-left"><?php echo $oreview['text']; ?></td>
              <td class="text-left"><?php echo $oreview['rating']; ?></td>
              <td class="text-right">
                <?php if($oreview['href']) { ?>
                <a class="btn btn-danger" href="<?php echo $oreview['href']; ?>" data-toggle="tooltip" title="<?php echo $button_review; ?>" class="btn btn-info"><i class="fa fa-pencil-square-o"></i></a>
                <?php } ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="text-right"><?php echo $pagination; ?></div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>