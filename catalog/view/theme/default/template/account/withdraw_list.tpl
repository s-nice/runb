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
      <p><?php echo $text_total; ?> <b><?php echo $total; ?></b>.  &nbsp;&nbsp;&nbsp;<a href="<?php echo $recharge; ?>" class="btn btn-primary"><?php echo $button_withdraw; ?></a></p>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_date_added; ?></td>
              <td class="text-left"><?php echo $column_message; ?></td>
              <td class="text-left"><?php echo $column_bank_account; ?></td>
              <td class="text-right"><?php echo $column_amount; ?></td>
              <td class="text-right"><?php echo $column_status; ?></td>
              <td class="text-right"><?php echo $column_refused; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($withdraws) { ?>
            <?php foreach ($withdraws  as $withdraw) { ?>
            <tr>
              <td class="text-left"><?php echo $withdraw['date_added']; ?></td>
              <td class="text-left"><?php echo $withdraw['message']; ?></td>
              <td class="text-left"><?php echo $withdraw['bank_account']; ?></td>
              <td class="text-right"><?php echo $withdraw['amount']; ?></td>
              <td class="text-right"><?php echo $withdraw['status'] ? $text_withdraw_status_1 : $text_withdraw_status_0; ?></td>
              <td class="text-right"><?php echo $withdraw['refused'] ? $text_withdraw_refused_1 : $text_withdraw_refused_0; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="6"><?php echo $text_empty; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
