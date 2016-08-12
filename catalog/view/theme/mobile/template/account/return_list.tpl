<?php echo $header; ?>
<div class="container">
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <h1><?php echo $heading_title; ?></h1>
          <?php if ($returns) { ?>
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-right"><?php echo $column_return_id; ?></td>
                <td class="text-left"><?php echo $column_status; ?></td>
                <td class="text-left"><?php echo $column_date_added; ?></td>
                <td class="text-right"><?php echo $column_order_id; ?></td>
                <td class="text-left"><?php echo $column_customer; ?></td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($returns as $return) { ?>
              <tr>
                <td class="text-right">#<?php echo $return['return_id']; ?></td>
                <td class="text-left"><?php echo $return['status']; ?></td>
                <td class="text-left"><?php echo $return['date_added']; ?></td>
                <td class="text-right"><?php echo $return['order_id']; ?></td>
                <td class="text-left"><?php echo $return['name']; ?></td>
                <td><a href="<?php echo $return['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <div class="col-sm-12 text-center"><?php echo $pagination; ?></div>
          <?php } else { ?>
          <p><?php echo $text_empty; ?></p>
          <?php } ?>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    </div>
</div>
<?php echo $footer; ?>