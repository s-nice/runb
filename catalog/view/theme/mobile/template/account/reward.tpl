<?php echo $header; ?>
<div class="container">
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <h1><?php echo $heading_title; ?></h1>
          <p><?php echo $text_total; ?> <b><?php echo $total; ?></b>.</p>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $column_date_added; ?></td>
                  <td class="text-left"><?php echo $column_description; ?></td>
                  <td class="text-right"><?php echo $column_points; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($rewards) { ?>
                <?php foreach ($rewards  as $reward) { ?>
                <tr>
                  <td class="text-left"><?php echo $reward['date_added']; ?></td>
                  <td class="text-left"><?php if ($reward['order_id']) { ?>
                    <a href="<?php echo $reward['href']; ?>"><?php echo $reward['description']; ?></a>
                    <?php } else { ?>
                    <?php echo $reward['description']; ?>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $reward['points']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="3"><?php echo $text_empty; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-sm-12 text-center"><?php echo $pagination; ?></div>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    </div>
</div>
<?php echo $footer; ?>