<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-2">
              <select name="flash_sale_status" id="input-status" class="form-control">
                <?php if ($flash_sale_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="#" method="post" enctype="multipart/form-data" id="form-size-chart-list">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $column_product_name; ?></td>
                  <td class="text-right"><?php echo $column_product_quantity; ?></td>
                  <td class="text-right"><?php echo $column_product_display_quantity; ?></td>
                  <td class="text-right"><?php echo $column_product_used_quantity; ?></td>
                  <td class="text-right"><?php echo $column_product_price; ?></td>
                  <td class="text-right"><?php echo $column_start_time; ?></td>
                  <td class="text-right"><?php echo $column_end_time; ?></td>
                  <td class="text-right"><?php echo $entry_status; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($flash_sales) { ?>
                <?php foreach ($flash_sales as $flash_sale) { ?>
                <tr>
                  <td class="text-left"><a href="<?php echo $flash_sale['href']; ?>" target="_blank"><?php echo $flash_sale['product_name']; ?></a></td>
                  <td class="text-right"><?php echo $flash_sale['quantity']; ?></td>
                  <td class="text-right"><?php echo $flash_sale['display_quantity']; ?></td>
                  <td class="text-right"><?php echo $flash_sale['used_quantity']; ?></td>
                  <td class="text-right"><?php echo $flash_sale['flash_sale_price']; ?></td>
                  <td class="text-right"><?php echo $flash_sale['start_time']; ?></td>
                  <td class="text-right"><?php echo $flash_sale['end_time']; ?></td>
                  <td class="text-right"><?php echo $flash_sale['status'] ? $text_enabled : $text_disabled; ?></td>
                  <td class="text-right">
                    <a href="<?php echo $flash_sale['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo $flash_sale['delete']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? true : event.preventDefault();"><i class="fa fa-trash-o"></i></i></a>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td class="text-right" colspan="9"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><?php echo $button_add; ?></a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </form>

        <div class="alert alert-info">
          <?php echo $text_notes; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>