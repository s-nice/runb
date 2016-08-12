<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-flash-sale" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-flash-sale" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-product-name"><span data-toggle="tooltip" title="<?php echo $help_auto_complete; ?>"><?php echo $entry_product_id; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="product_name" value="<?php echo $product_name ?>" placeholder="<?php echo $entry_product_id; ?>" id="input-product-name" class="form-control" />
                  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                  <?php if ($error_product_id) { ?>
                  <div class="text-danger"><?php echo $error_product_id; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="flash_sale_price" value="<?php echo $flash_sale_price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
                  <?php if ($error_price) { ?>
                  <div class="text-danger"><?php echo $error_price; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
                  <?php if ($error_quantity) { ?>
                  <div class="text-danger"><?php echo $error_quantity; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-display-quantity"><?php echo $entry_display_quantity; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="display_quantity" value="<?php echo $display_quantity; ?>" placeholder="<?php echo $entry_display_quantity; ?>" id="input-display-quantity" class="form-control" />
                  <?php if ($error_display_quantity) { ?>
                  <div class="text-danger"><?php echo $error_display_quantity; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-start-time"><?php echo $entry_start_time; ?></label>
                <div class="col-sm-3">
                  <div class="input-group datetime">
                    <input type="text" name="start_time" value="<?php echo $start_time; ?>" placeholder="<?php echo $entry_start_time; ?>" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-start-time" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span></div>
                  </div>
                  <?php if ($error_start_time) { ?>
                  <div class="text-danger"><?php echo $error_start_time; ?></div>
                  <?php } ?>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-end-time"><?php echo $entry_end_time; ?></label>
                <div class="col-sm-3">
                  <div class="input-group datetime">
                    <input type="text" name="end_time" value="<?php echo $end_time; ?>" placeholder="<?php echo $entry_end_time; ?>" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-end-time" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                  </div>
                  <?php if ($error_end_time) { ?>
                  <div class="text-danger"><?php echo $error_end_time; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span></label>
                <div class="col-sm-3">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-product-name<?php echo $language['language_id']; ?>"><?php echo $entry_product_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="flash_sale_description[<?php echo $language['language_id']; ?>][product_name]" value="<?php echo isset($flash_sale_description[$language['language_id']]) ? $flash_sale_description[$language['language_id']]['product_name'] : ''; ?>" placeholder="<?php echo $entry_product_name; ?>" id="input-product-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_product_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_product_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="flash_sale_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($flash_sale_description[$language['language_id']]) ? $flash_sale_description[$language['language_id']]['description'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
              <hr />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
  $('.date').datetimepicker({
    pickTime: false
  });

  $('.time').datetimepicker({
    pickDate: false
  });

  $('.datetime').datetimepicker({
    pickDate: true,
    pickTime: true,
  });
  //--></script>

  <script type="text/javascript"><!--
  // Product
  $('input[name=\'product_name\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          json.unshift({
            product_id: 0,
            name: '<?php echo $text_none; ?>'
          });

          response($.map(json, function(item) {
            return {
              label: item['name'],
              value: item['product_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('input[name=\'product_name\']').val(item['label']);
      $('input[name=\'product_id\']').val(item['value']);

      $.ajax({
        url: 'index.php?route=module/flash_sale/ajaxGetProductInfo&token=<?php echo $token; ?>&product_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(json) {
          var product_info = json.product_info;
          if (product_info != "") {
            $('input[name=\'flash_sale_price\']').val(product_info['price']);
            <?php foreach ($languages as $language): ?>
            $('input[name=\'flash_sale_description[<?php echo $language['language_id']; ?>][product_name]\']').val(product_info['name']);
            <?php endforeach; ?>
          };
        }
      });
    }
  });
  //--></script>
  <script type="text/javascript"><!--
    <?php foreach ($languages as $language) { ?>
    $('#input-description<?php echo $language['language_id']; ?>').summernote({
  	 height: 300
    });
    <?php } ?>
  //--></script>
    <script type="text/javascript"><!--
  $('#language a:first').tab('show');
  //--></script>
</div>
<?php echo $footer; ?>