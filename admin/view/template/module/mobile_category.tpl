<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-title"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mobile_category_title" value="<?php echo $mobile_category_title; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="mobile_category_status" id="input-status" class="form-control">
                <?php if ($mobile_category_status) { ?>
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
              <td class="text-left"><?php echo $entry_sort_order; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="left"></td>
            </tr>
            </thead>
            <tbody>
            <?php $module_row = 0; ?>
            <?php if (isset($mobile_category) && !empty($mobile_category)):?>
            <?php foreach ( $mobile_category as $key => $v ):?>
            <tr id="module-row<?php echo $module_row; ?>">
              <td>
                  <select name="mobile_category[<?php echo $module_row ?>][category_id]" class="form-control">
                  <?php if (isset($categorys) && !empty($categorys) && is_array($categorys)):?>
                    <?php foreach ( $categorys as $value):?>
                      <?php if( $value['category_id']== $v['category_id']):?>
                        <option value="<?php echo $value['category_id']?>" selected><?php echo $value['name'];?></option>
                      <?php else:?>
                        <option value="<?php echo $value['category_id']?>"><?php echo $value['name'];?></option>
                      <?php endif;?>
                    <?php endforeach;?>
                  <?php endif;?>
                  </select>
              </td>
              <td>
                <input type="text" name="mobile_category[<?php echo $module_row ?>][sort_order]" value="<?php echo $v['sort_order']?>" size="2" class="form-control" placeholder="<?php echo $entry_sort_order; ?>"/>
              </td>
              <td>
                <select name="mobile_category[<?php echo $module_row ?>][status]" class="form-control">
                  <option value="1"<?php if($v['status']==1) echo "selected"?>><?php echo $text_enabled; ?></option>
                  <option value="0" <?php if($v['status']!=1) echo "selected"?>><?php echo $text_disabled; ?></option>
                  </select>
              </td>
              <td>
                <button type="button" onclick="$('#module-row<?php echo $module_row?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
              </td>
            </tr>
            <?php $module_row ++;?>
            <?php endforeach;?>
            <?php endif;?>

            </tbody>
            <tfoot>
            <tr>
              <td colspan="3"></td>
              <td class="text-left"><button type="button" onclick="addModule();" data-toggle="tooltip" title="<?php echo $button_add_module; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
            </tr>
            </tfoot>
          </table>
          <input type="hidden" name="mobile_category_mobile_only" value="1" />
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript"><!--
    var module_row = <?php echo $module_row; ?>;
    var select_type = '';
    <?php if (isset($categorys) && !empty($categorys)):?>
    <?php foreach($categorys as $value):?>
    select_type += '<option value="<?php echo $value['category_id']?>"><?php echo $value['name'];?></option>';
    <?php endforeach;?>
    <?php endif;?>

    function addModule() {
      html  = '<tr id="module-row' + module_row + '">';
      html += '    <td class="text-left"><select name="mobile_category[' + module_row + '][category_id]" class="form-control">';
      html +=     select_type;
      html +=      '</select></td>';
      html += '    <td class="text-left"><input type="text" name="mobile_category[' + module_row + '][sort_order]" value="" size="2" class="form-control" placeholder="<?php echo $entry_sort_order; ?>"/></td>';
      html += '    <td class="text-left"><select name="mobile_category[' + module_row + '][status]" class="form-control">';
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
