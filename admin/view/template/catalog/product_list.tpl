<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default" onclick="$('#form-product').attr('action', '<?php echo $copy; ?>').submit()"><i class="fa fa-copy"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-product').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
                <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-price"><?php echo $entry_price; ?></label>
                <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                <input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!$filter_status && !is_null($filter_status)) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-category"><?php echo $entry_category; ?></label>
                <select name="filter_category" id="input-category" class="form-control">
                  <option value="*"></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if ($filter_category_id==$category['category_id']) { ?>
                  <option value="<?php echo $category['category_id'] ?>" selected="selected"><?php echo $category['name'] ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id'] ?>"><?php echo $category['name'] ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-center"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php if ($sort == 'pd.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.model') { ?>
                    <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'p.price') { ?>
                    <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'p.quantity') { ?>
                    <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($products) { ?>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($product['image']) { ?>
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?> <b style="display:none"><?php echo $product['product_id']; ?></b></td>
                  <td class="text-left pname ">
                    <span ><?php echo $product['name']; ?></span>
                  </td>
                  <td class="text-left model"><span><?php echo $product['model']; ?></span></td>
                  <td class="text-right price"><span><?php echo $product['price']; ?></span></td>
                  <td class="text-right quantity"><?php if ($product['quantity'] <= 0) { ?>
                    <span class="label label-warning"><?php echo $product['quantity']; ?></span>
                    <?php } elseif ($product['quantity'] <= 5) { ?>
                    <span class="label label-danger"><?php echo $product['quantity']; ?></span>
                    <?php } else { ?>
                    <span class="label label-success"><?php echo $product['quantity']; ?></span>
                    <?php } ?></td>
                  <td class="text-left "><div class='tg-list-item'><input class='tgl tgl-skewed status' id="<?php echo $product['product_id']; ?>" type='checkbox' value=""  <?php if ($product['status'] == $text_enabled) { ?>checked="checked"    <?php } ?> /><label class='tgl-btn' data-tg-off='<?php echo $text_disabled; ?>' data-tg-on='<?php echo $text_enabled; ?>' for="<?php echo $product['product_id']; ?>"></label></div></td>
                  <td class="text-right"><a href="<?php echo $product['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    $('#button-filter').on('click', function() {
     var url = 'index.php?route=catalog/product&token=<?php echo $token; ?>';

     var filter_name = $('input[name=\'filter_name\']').val();

     if (filter_name) {
      url += '&filter_name=' + encodeURIComponent(filter_name);
    }

    var filter_model = $('input[name=\'filter_model\']').val();

    if (filter_model) {
      url += '&filter_model=' + encodeURIComponent(filter_model);
    }

    var filter_price = $('input[name=\'filter_price\']').val();

    if (filter_price) {
      url += '&filter_price=' + encodeURIComponent(filter_price);
    }

    var filter_quantity = $('input[name=\'filter_quantity\']').val();

    if (filter_quantity) {
      url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
    }

    var filter_category = $('select[name=\'filter_category\']').val();

    if (filter_category != '*') {
      url += '&filter_category_id=' + encodeURIComponent(filter_category);
    }

    var filter_status = $('select[name=\'filter_status\']').val();

    if (filter_status != '*') {
      url += '&filter_status=' + encodeURIComponent(filter_status);
    }

    location = url;
  });
  //--></script>
  <script type="text/javascript"><!--
  $('input[name=\'filter_name\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
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
      $('input[name=\'filter_name\']').val(item['label']);
    }
  });

  $('input[name=\'filter_model\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['model'],
              value: item['product_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('input[name=\'filter_model\']').val(item['label']);
    }
  });

  (new ProductAjax()).Init('.pname','name','index.php?route=catalog/product_quick/name');

  (new ProductAjax()).Init('.model','model','index.php?route=catalog/product_quick/model');

  (new ProductAjax()).Init('.price','price','index.php?route=catalog/product_quick/price');

  (new ProductAjax()).Init('.quantity','quantity','index.php?route=catalog/product_quick/quantity');

  function ProductAjax() {
    var self = this;
    self.ptype = '';
    self.url = '';
    this.Init = function(ele, type, url){
      self.ptype = type;
      self.url = url;
      $(ele).dblclick(self.pclick);
      $(ele).on('blur', 'input', self.pblur);
    }
    this.pclick = function(){
      $(this).find('span').css('display', 'none');
      if($(this).find('input').length == 0){
        $(this).append('<input type="text" name="" value="' + $(this).find('span').html() + '" class="ptxt">');
        $(this).find('input').focus();
      }
    }
    this.pblur = function() {
     var id = $(this).parent().parent().find('b').html();
     var value = $(this).val();
     self.PAjax(this, id, self.ptype, value);
    }
    this.PAjax = function(obj, id, key, value){
      var span = $(obj).parent().find('span');
      var spanVal = span.html();
      span.html(value);
      span.css('font-weight', 'bold');
      $(obj).parent().find('span').css('display', 'inline');
      $(obj).remove();
      if(self.ptype == 'price'){
        value = parseFloat(value);
        if(!value || value < 0){
          span.css('font-weight', 'normal');
          span.html(spanVal);
          return;
        }
      }
      if(self.ptype == 'quantity') {
        value = parseInt(value);
        if(!value || value < 0){
        span.css('font-weight','normal');
          span.html(spanVal);
          return;
        }
      }
      if(self.ptype == 'name' || self.ptype == 'model'){
        value = trim(value);
      }

      if(value && (spanVal != value)) {
        $.ajax({
          url: self.url + '&token=<?php echo $token; ?>',
          type: 'post',
          dataType: 'json',
          data: "product_id=" + id + "&" + key + "=" + value,
          success: function(json) {
            span.css('font-weight', 'normal');
            if(json.status == 0){
              span.html(spanVal);
              //$('.panel-default').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>' + json.message + '<button type="button" class="close" data-dismiss="alert">&times;</button> </div>');
            } else {
              if(json.data.price) {
                json.data.price = parseFloat(json.data.price);
                json.data.price.toFixed(4);
                span.html(json.data.price);
              }
              if(json.data.quantity) {
                json.data.quantity = parseInt(json.data.quantity);
                span.html(json.data.quantity);
              }
            }
          }
        });
      } else {
        span.css('font-weight', 'normal');
        span.html(spanVal);
      }
    }
  }

  $('.status').change(function(event) {
    var statusElement = $(this);
    var id = this.id;
    this.value = this.checked ? 1 : 0;
    $.ajax({
      url: 'index.php?route=catalog/product_quick/status'+'&token=<?php echo $token; ?>',
      type: 'post',
      dataType: 'json',
      data: "product_id=" + id + "&status=" + this.value,
      success: function(json) {
        if(json.status == 0){
          statusElement.val(statusElement.prop('checked') ? 0 : 1);
          statusElement.prop('checked', statusElement.prop('checked') ? false : true);
        }
      }
    });
  });

  function trim(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");
  }
  --></script>
</div>
<?php echo $footer; ?>

