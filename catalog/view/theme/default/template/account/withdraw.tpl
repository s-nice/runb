<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
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
      <p><?php echo $text_description; ?></p>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group required hidden">
          <div class="col-sm-10">
            <input type="text" name="customer_id" value="<?php echo $customer_id; ?>" id="input-customer-id" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-amount"><span data-toggle="tooltip" title="<?php echo $help_amount; ?>"><?php echo $entry_amount; ?></span></label>
          <div class="col-sm-10">
            <input type="text" name="amount" value="<?php echo $amount; ?>" id="input-amount" class="form-control" size="5" />
            <?php if ($error_amount) { ?>
            <div class="text-danger"><?php echo $error_amount; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-bank-account"><span data-toggle="tooltip" title="<?php echo $help_bank_account; ?>"><?php echo $entry_bank_account; ?></span></label>
          <div class="col-sm-10">
            <input type="text" name="bank_account" value="<?php echo $bank_account; ?>" id="input-bank-account" class="form-control" size="5" />
            <?php if ($error_bank_account) { ?>
            <div class="text-danger"><?php echo $error_bank_account; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-message"><span data-toggle="tooltip" title="<?php echo $help_message; ?>"><?php echo $entry_message; ?></span></label>
          <div class="col-sm-10">
            <textarea name="message" cols="40" rows="5" id="input-message" class="form-control"><?php echo $message; ?></textarea>
          </div>
        </div>
        <input type="hidden" name="agree" value="1" />
        <div class="buttons clearfix">
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
