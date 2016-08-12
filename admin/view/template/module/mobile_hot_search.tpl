<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-title"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mobile_hot_search_title" value="<?php echo $mobile_hot_search_title; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name" class="form-control" />
              <?php if ($error_mobile_hot_search_title) { ?>
              <div class="text-danger"><?php echo $error_mobile_hot_search_title; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="mobile_hot_search_status" id="input-status" class="form-control">
                <?php if ($mobile_hot_search_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <table id="module" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php echo $entry_keyword; ?></td>
                <td class="text-left"><?php echo $entry_url; ?></td>
                <td class="text-left"><?php echo $entry_style; ?></td>
                <td class="text-right"><?php echo $entry_sort_order; ?></td>
                <td class="left"><?php echo $entry_status; ?></td>
                <td class="left"></td>
              </tr>
            </thead>
            <tbody>

              <?php $module_row = 0; ?>
              <?php foreach ($modules as $module) { ?>
              <tr id="module-row<?php echo $module_row; ?>">
                <td class="text-left">
                  <input type="text" name="mobile_hot_search[<?php echo $module_row; ?>][keyword]" value="<?php echo $module['keyword']; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />

                  <?php if (isset($error_mobile_hot_search[$module_row]['keyword'])) { ?>
                  <div class="text-danger"><?php echo $error_mobile_hot_search[$module_row]['keyword']; ?></div>
                  <?php } ?></td>

                <td class="text-left" style="width: 30%;"><input type="text" name="mobile_hot_search[<?php echo $module_row; ?>][href]" value="<?php echo $module['href']; ?>" placeholder="<?php echo $entry_url; ?>" class="form-control" /></td>

                <td class="text-left" style="width: 30%;"><input type="text" name="mobile_hot_search[<?php echo $module_row; ?>][style]" value="<?php echo $module['style']; ?>" placeholder="<?php echo $entry_style; ?>" class="form-control" /></td>

                <td class="text-right"><input type="text" name="mobile_hot_search[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>

                <td class="text-left"><select name="mobile_hot_search[<?php echo $module_row; ?>][status]" class="form-control">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>

                <td class="text-left"><button type="button" onclick="$('#module-row<?php echo $module_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $module_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="5"></td>
                <td class="text-left"><button type="button" onclick="addModule();" data-toggle="tooltip" title="<?php echo $button_add_module; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>
          <input type="hidden" name="mobile_hot_search_mobile_only" value="1" />
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript"><!--
    var module_row = <?php echo $module_row; ?>;
    function addModule() {
        html  = '<tr id="module-row' + module_row + '">';
        html += '    <td class="text-left"><input type="text" name="mobile_hot_search[' + module_row + '][keyword]" value="" size="20" class="form-control" placeholder="<?php echo $entry_title; ?>"/></td>';
        html += '    <td class="text-left"><input type="text" name="mobile_hot_search[' + module_row + '][href]" value="" size="40" class="form-control" placeholder="<?php echo $entry_url; ?>"/></td>';
        html += '    <td class="text-left"><input type="text" name="mobile_hot_search[' + module_row + '][style]" value="" size="30" class="form-control" placeholder="<?php echo $entry_style; ?>"/></td>';
        html += '    <td class="text-left"><input type="text" name="mobile_hot_search[' + module_row + '][sort_order]" value="" size="2" class="form-control" placeholder="<?php echo $entry_sort_order; ?>"/></td>';
        html += '    <td class="text-left"><select name="mobile_hot_search[' + module_row + '][status]" class="form-control">';
        html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
        html += '      <option value="0"><?php echo $text_disabled; ?></option>';
        html += '    </select></td>';
        html += '   <td class="text-left"><button type="button" onclick="$(\'#module-row' + module_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '  </tr>';
        $('#module tbody').append(html);
        module_row++;
    }
    //--></script>
</div>
<?php echo $footer; ?>
