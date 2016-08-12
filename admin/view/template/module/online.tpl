<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-online" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-online" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
            <div class="col-sm-10">
              <input type="text" name="online_telephone" id="input-telephone" class="form-control" value="<?php echo $online_telephone; ?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-qq"><?php echo $entry_qq; ?></label>
            <div class="col-sm-10">
              <input type="text" name="online_qq" id="input-qq" class="form-control" value="<?php echo $online_qq; ?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-qq2"><?php echo $entry_qq2; ?></label>
            <div class="col-sm-10">
              <input type="text" name="online_qq2" id="input-qq2" class="form-control" value="<?php echo $online_qq2; ?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-qq3"><?php echo $entry_qq3; ?></label>
            <div class="col-sm-10">
              <input type="text" name="online_qq3" id="input-qq3" class="form-control" value="<?php echo $online_qq3; ?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-10"> <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="online_image" value="<?php echo $online_image; ?>" id="input-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="online_status" id="input-status" class="form-control">
                <?php if ($online_status) { ?>
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
  </div>
</div>
<?php echo $footer; ?>