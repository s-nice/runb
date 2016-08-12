<?php echo $header; ?>
<div class="container">
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <h1><?php echo $heading_title; ?></h1>
          <div><?php echo $text_total; ?>: <b><?php echo $total; ?></b>.</div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $column_date_added; ?></td>
                  <td class="text-left"><?php echo $column_description; ?></td>
                  <td class="text-right"><?php echo $column_amount; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($transactions) { ?>
                <?php foreach ($transactions  as $transaction) { ?>
                <tr>
                  <td class="text-left"><?php echo $transaction['date_added']; ?></td>
                  <td class="text-left"><?php echo $transaction['description']; ?></td>
                  <td class="text-right"><?php echo $transaction['amount']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="5"><?php echo $text_empty; ?></td>
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
      <a href="<?php echo $recharge; ?>" class="btn btn-primary btn-block"><?php echo $button_recharge; ?></a>
      <?php echo $content_bottom; ?></div>
    </div>
</div>
<?php echo $footer; ?>
