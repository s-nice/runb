<?php echo $header; ?>
<div class="container">
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row">
    <div id="content" class="col-xs-12">
      <div class="row widget first-widget">
        <div class="col-xs-12">
          <h1><?php echo $heading_title; ?></h1>
          <p><?php echo $text_description; ?></p>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
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
              <label class="col-sm-2 control-label" for="input-message"><span data-toggle="tooltip" title="<?php echo $help_message; ?>"><?php echo $entry_message; ?></span></label>
              <div class="col-sm-10">
                <textarea name="message" cols="40" rows="5" id="input-message" class="form-control"><?php echo $message; ?></textarea>
              </div>
            </div>
            <?php if ($agree) { ?>
            <input type="checkbox" name="agree" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree" value="1" />
            <?php } ?>
            <?php echo $text_agree; ?>
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary btn-block" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
