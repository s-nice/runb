<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> <a href="<?php echo $repair; ?>" data-toggle="tooltip" title="<?php echo $button_rebuild; ?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-category').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-category">
          <div class="table-responsive">
            <div  id="nestable">
             <ol class="dd-list"><?php  tree($categories, $column_sort_order); ?></ol>
           </div>
           <?php function tree($cateArray, $column_sort_order){
             foreach ($cateArray as $key => $value) { ?>  
              <li class="dd-item" > 
               <div class="dd-nodrag">
                 <input type="checkbox" name="selected[]" value="<?php echo $value['category_id']; ?>" />
                 <?php echo  $value['name'] ; ?>
                 <a href="<?php echo $value['edit']; ?>" data-toggle="tooltip" title="" class="btn btn-primary opbtn"><i class="fa fa-pencil"></i></a>
                 <span><?php echo $column_sort_order; ?>: <?php echo $value['sort_order']; ?></span>
               </div>   
               <?php if($value['sub_categories']){ ?>
               <ol class="dd-list">
                 <?php tree($value['sub_categories'], $column_sort_order); ?>
               </ol>
             </li>
             <?php
           }
         }
       } ?>
     </div>
   </form>
   <div class="row">
    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
  </div>
</div>
</div>
</div>
</div>
<style type="text/css">
  #nestable {
    position: relative;
    display: block;
    margin: 0;
    padding: 0;
    list-style: none;
    font-size: 13px;
    line-height: 20px;
  }
  #nestable .dd-list {
    display: block;
    position: relative;
    margin: 0;
    padding: 0;
    list-style: none;
  }
  #nestable .dd-list .dd-list {
    padding-left: 30px;
  }
  #nestable .dd-collapsed .dd-list {
    display: none;
  }
  #nestable .dd-item,
  #nestable .dd-empty,
  #nestable .dd-placeholder {
    display: block;
    position: relative;
    margin: 0;
    padding: 0;
    min-height: 20px;
    font-size: 13px;
    line-height: 20px;
  }
  #nestable .dd-nodrag {
    display: block;
    height: 40px;
    margin: 5px 0;
    padding: 5px 10px;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    line-height: 30px;
  }
  #nestable .dd-nodrag:hover {
    color: #2ea8e5;
    background: #fff;
  }
  #nestable .dd-item > button {
    display: block;
    position: relative;
    cursor: pointer;
    float: left;
    width: 25px;
    height: 20px;
    margin: 10px 0;
    padding: 0;
    text-indent: 100%;
    white-space: nowrap;
    overflow: hidden;
    border: 0;
    background: transparent;
    font-size: 12px;
    line-height: 1;
    text-align: center;
    font-weight: bold;
  }
  #nestable .dd-item > button:before {
    content: '\f0da';
    font-family: 'FontAwesome';
    display: block;
    position: absolute;
    width: 100%;
    text-align: center;
    text-indent: 0;
    color: #1E91CF;
  }
  #nestable .dd-item > button[data-action="collapse"]:before {
    content: '\f0d7';
    font-family: 'FontAwesome';
    color: #1E91CF;
  }
  #nestable .dd-placeholder,
  #nestable .dd-empty {
    margin: 5px 0;
    padding: 0;
    min-height: 30px;
    background: #f2fbff;
    border: 1px dashed #b6bcbf;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
  }
  #nestable .dd-empty {
    border: 1px dashed #bbb;
    min-height: 100px;
    background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
  }
  #nestable .dd-dragel {
    position: absolute;
    pointer-events: none;
    z-index: 9999;
  }
  #nestable .dd-dragel > .dd-item .dd-nodrag {
    margin-top: 0;
  }
  #nestable .dd-dragel .dd-nodrag {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
    box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
  }
  #nestable .opbtn {
    padding: 5px 13px;
  }
  #nestable .dd-nodrag a {
    float: right;
  }
  #nestable .dd-nodrag span {
    float: right;
    margin-right: 80px;
  }
  #nestable .dd-nodrag input {
    margin: 0 5px;
  }
</style>
<script>
  $(document).ready(function(){
    $('#nestable').nestable({
      group: 1
    });
  });
</script>

<?php echo $footer; ?>