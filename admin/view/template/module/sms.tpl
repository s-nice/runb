<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-sms" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
		    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sms"  class="form-horizontal">
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-owner"><?php echo $entry_c123_plant; ?></label>
              <div class="col-sm-10">
                <label class="radio-inline">
                  <input type="radio" name="config_c123_plant" value="yunpian" <?php echo ($config_c123_plant == 'yunpian' ? 'checked="true"' : ''); ?>  />yunpian
                </label>
                <label class="radio-inline">
                 <input type="radio" name="config_c123_plant" value="c123" <?php echo ($config_c123_plant == 'c123' ? 'checked="true"' : ''); ?>  />c123
                </label>
                <label class="radio-inline">
                  <input type="radio" name="config_c123_plant" value="ihuyi" <?php echo ($config_c123_plant == 'ihuyi' ? 'checked="true"' : ''); ?>  />ihuyi
                </label>
                <?php if ($error_c123_plant) { ?>
                <div class="text-danger"><?php echo $error_c123_plant; ?></div>
                <?php } ?>
              </div>
            </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-ac"><?php echo $entry_c123_ac; ?></label>
            <div class="col-sm-10">
              <input type="text" name="config_c123_ac" value="<?php echo $config_c123_ac; ?>" placeholder="<?php echo $entry_c123_ac; ?>" id="input-ac" class="form-control" />
              <?php if ($error_c123_ac) { ?>
              <div class="text-danger"><?php echo $error_c123_ac; ?></div>
              <?php } ?>
            </div>
          </div>         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-authkey"><?php echo $entry_c123_authkey; ?></label>
            <div class="col-sm-10">
              <input type="text" name="config_c123_authkey" value="<?php echo $config_c123_authkey; ?>" placeholder="<?php echo $entry_c123_authkey; ?>" id="input-authkey" class="form-control" />
              <?php if ($error_c123_authkey) { ?>
              <div class="text-danger"><?php echo $error_c123_authkey; ?></div>
              <?php } ?>
            </div>
          </div>         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cgid"><?php echo $entry_c123_cgid; ?></label>
            <div class="col-sm-10">
              <input type="text" name="config_c123_cgid" value="<?php echo $config_c123_cgid; ?>" placeholder="<?php echo $entry_c123_cgid; ?>" id="input-cgid" class="form-control" />
              <?php if ($error_c123_cgid) { ?>
              <div class="text-danger"><?php echo $error_c123_cgid; ?></div>
              <?php } ?>
            </div>
          </div>         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-csid"><?php echo $entry_c123_csid; ?></label>
            <div class="col-sm-10">
              <input type="text" name="config_c123_csid" value="<?php echo $config_c123_csid; ?>" placeholder="<?php echo $entry_c123_csid; ?>" id="input-csid" class="form-control" />
            </div>
          </div>         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="config_c123_status" id="input-status" class="form-control">
                <?php if ($config_c123_status) { ?>
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
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>
//--></script> 
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>