<?php echo $header; ?>
<div class="container">
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-12">
          <h2><?php echo $text_address_book; ?></h2>
          <?php if ($addresses) { ?>
          <table class="table table-bordered table-hover">
            <?php foreach ($addresses as $result) { ?>
            <tr>
              <td class="text-left"><?php echo $result['address']; ?></td>
              <td class="text-right" style="width: 25%"><a href="<?php echo $result['update']; ?>" class="btn btn-info btn-block"><?php echo $button_edit; ?></a><a href="<?php echo $result['delete']; ?>" class="btn btn-danger btn-block"><?php echo $button_delete; ?></a></td>
            </tr>
            <?php } ?>
          </table>
          <?php } else { ?>
          <p><?php echo $text_empty; ?></p>
          <?php } ?>
          <div class="buttons clearfix">
            <div class="pull-right"><a href="<?php echo $add; ?>" class="btn btn-primary"><?php echo $button_new_address; ?></a></div>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    </div>
</div>
<?php echo $footer; ?>
