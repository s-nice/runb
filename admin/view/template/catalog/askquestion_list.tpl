<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
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
                <label class="control-label" for="input-name"><?php echo $column_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $column_name; ?>" id="input-name" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $column_model; ?></label>
                <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $column_model; ?>" id="input-model" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-customername"><?php echo $column_customer_name; ?></label>
                <input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" placeholder="<?php echo $column_customer_name; ?>" id="input-customername" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-question"><?php echo $column_question; ?></label>
                <input type="text" name="filter_question" value="<?php echo $filter_question; ?>" placeholder="<?php echo $column_question; ?>" id="input-question" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $column_status; ?></label>
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
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-askquestion">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
		            <tr>
		              <td class="text-left"><?php if ($sort == 'pq.user_name') { ?>
		                <a href="<?php echo $sort_customer_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_name; ?></a>
		                <?php } else { ?>
		                <a href="<?php echo $sort_customer_name; ?>"><?php echo $column_customer_name; ?></a>
		                <?php } ?></td>
		              <td class="text-left"><?php if ($sort == 'pd.name') { ?>
		                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
		                <?php } else { ?>
		                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
		                <?php } ?></td>
		              <td class="text-left"><?php if ($sort == 'pq.model') { ?>
		                <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
		                <?php } else { ?>
		                <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
		                <?php } ?></td>
		              <td class="text-left"><?php if ($sort == 'pq.product_question') { ?>
		                <a href="<?php echo $sort_question; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_question; ?></a>
		                <?php } else { ?>
		                <a href="<?php echo $sort_question; ?>"><?php echo $column_question; ?></a>
		                <?php } ?></td>
		              <td class="text-left"><?php echo $column_answer; ?></td>
		              <td class="text-left"><?php if ($sort == 'pq.product_status') { ?>
		                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
		                <?php } else { ?>
		                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
		                <?php } ?></td>
		              <td class="text-left"><?php if ($sort == 'pq.question_asked_date') { ?>
		                <a href="<?php echo $sort_question_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_question_added; ?></a>
		                <?php } else { ?>
		                <a href="<?php echo $sort_question_added; ?>"><?php echo $column_question_added; ?></a>
		                <?php } ?></td>
		              <td class="text-left"><?php if ($sort == 'pq.question_answred_date') { ?>
		                <a href="<?php echo $sort_answer_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_answer_added; ?></a>
		                <?php } else { ?>
		                <a href="<?php echo $sort_answer_added; ?>"><?php echo $column_answer_added; ?></a>
		                <?php } ?></td>
		              <td class="right"><?php echo $column_action; ?></td>
		            </tr>
		          </thead>
		          <tbody>
					<?php foreach($getQues as $proQues)
					{
					?>
					<tr id="totalUserQues_<?php echo $proQues['id']; ?>">
					<td class="text-left"><?php echo $proQues['user_name']; ?></td>
					<td class="text-left"><a target="_blank" href="<?php echo $proQues['href'] ?>"><?php echo $proQues['name']; ?></a></td>
					<td class="text-left"><?php echo $proQues['model']; ?></td>
					<td class="text-left"><?php echo $proQues['product_question']; ?></td>
					<?php if($proQues['product_answer']=='') {?><td class="center"><a id="<?php echo $proQues['id']; ?>" class="answerForQuestion" style="color:red;text-decoration:none"><?php echo $text_click_answer ?></a>
					 <?php }else {?><td class="center"><a id="<?php echo $proQues['id']; ?>" class="answerForQuestion" style="color:green;text-decoration:none"><?php echo $text_view_anwser?></a>
					 <?php } ?>
					<div class="focusField" id="questions_<?php echo $proQues['id']; ?>" style="display:none">
					<span style="color:black;margin-left:300px;text-decoration: none;"><a class="closeQuestions" id="<?php echo $proQues['id']; ?>"><?php echo $text_close?></a></span>
					<div>
					<label><?php echo $text_question; ?></label><br>
					<label><?php echo $proQues['product_question']; ?></label><br>
					<label><?php echo $text_your_answer; ?></label><br>
					<input type="hidden" name="hiddenproduct" value="<?php echo $proQues['id']; ?>" class="hiddenproductid_<?php echo $proQues['id']; ?>">
					<?php if($proQues['product_answer']!="")
					{
					?>
					<textarea name="solutionForQuestion" id="solutionForQuestion_<?php echo $proQues['id']; ?>" cols="40" rows="5"><?php echo $proQues['product_answer']; ?></textarea><br>
					
					<?php } else {?><textarea name="solutionForQuestion" id="solutionForQuestion_<?php echo $proQues['id']; ?>" cols="40" rows="5"></textarea><br>
					 <?php } ?>
					
					<br><a class="button" id="solutionForQuestionSubmit_<?php echo $proQues['id']; ?>" data="<?php echo $proQues['id']; ?>" ><?php echo $text_answer; ?></a><br>
					<span class="errorQuestion" style="display:none;color:red"></span>
					<span class="AnsweredSuccess" style="display:none;rgb(5, 197, 74);"></span>
					</div>
					
					</div></td>
					<td class="text-left"><?php if($proQues['product_status']=='1'){echo $text_enabled; }else {echo $text_disabled; } ?></td>
					<td class="text-center"><?php echo $proQues['question_asked_date']; ?></td>
					<td class="text-center"><?php echo $proQues['question_answred_date']; ?></td>
					<td class="text-right"><a id="questionDelete_<?php echo $proQues['id']; ?>" class="questionDelete btn btn-danger" title="<?php echo $text_delete;?>"><i class="fa fa-trash-o"></i></a></td>
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
	var url = 'index.php?route=catalog/askquestion&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_model = $('input[name=\'filter_model\']').val();

	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}

	var filter_customer_name = $('input[name=\'filter_customer_name\']').val();

	if (filter_customer_name) {
		url += '&filter_customer_name=' + encodeURIComponent(filter_customer_name);
	}

	var filter_question = $('input[name=\'filter_question\']').val();

	if (filter_question) {
		url += '&filter_question=' + encodeURIComponent(filter_question);
	}

	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = url;
})
//--></script> 

<style type="text/css">		
.focusField {
	color: #000;
	border: solid 2px #EEEEEE !important;
	background: #fff !important;
	position: absolute;
	width: auto;
	z-index: 9000;
	/*
	margin-left: 168px;
	*/
	margin-top: 5px;
	height: auto;
	box-shadow: aqua;
	box-shadow: 1px 1px 2px 1px #333333;
	border-radius: 5px;
	padding-top:10px;
	padding-left:10px;
	font-weight:bold;
}
.focusField > div {
	text-align: left;
}
textarea {
	width: 95%;
}
</style>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.answerForQuestion').click(function() {
		var getProductId=$(this).attr('id');

		$('.errorQuestion').hide();
		$('.AnsweredSuccess').hide();
		$('#questions_'+getProductId).animate({opacity:"hide"},"slow");
		$('#questions_'+getProductId).animate({opacity:"show"},"slow");	

		$('#solutionForQuestionSubmit_'+getProductId).click(function() {
			var InsertGetProductId=$(this).attr('data');
			var InsertAnswer=$('#solutionForQuestion_'+getProductId).val();
			if(InsertAnswer=="")
			{
				$('.errorQuestion').animate({opacity:"show"},"slow").html('Please provide answer');
			}
			else
			{
				$.ajax({
					type:'get',
					url:'index.php?route=catalog/askquestion/insertAnswerForQues&<?php echo $sessionAjax; ?>',
					data:"productidForQus="+InsertGetProductId+"&InsertanswerForQus="+InsertAnswer,
					beforeSend:function() {},
					complete: function() {},
					success:function(result){
						$('.errorQuestion').animate({opacity:"hide"},"slow");
						$('.AnsweredSuccess').animate({opacity:"show"},"slow").html("<span style=\"color:red;\">"+result+"</span>");
						$('.errorQuestion').parent().parent().animate({opacity:"hide"},1500);
						location.reload(true);
					}
				});
			}
		});
	});	
	$('.closeQuestions').click(function() {
		var closeGetProductId=$(this).attr('id');
		$('#questions_'+closeGetProductId).animate({opacity:"hide"},"slow");
	});

	$('.questionStatus').click(function() {
		var quesStatusId=$(this).attr('id');
		var splitProductId=quesStatusId.split('_');
		var sendData="productId="+splitProductId[1];
		$.ajax({
			type:'get',
			url:'index.php?route=catalog/askquestion/changeQuesStatus&<?php echo $sessionAjax; ?>',
			data:sendData,
			beforeSend:function() {},
			complete: function() {},
			success:function(result){
				if(result=='Enabled')
				{
					$("#questionStatus_"+splitProductId[1]).animate({opacity:"hide"},"slow").html('Enabled');
					$("#questionStatus_"+splitProductId[1]).animate({opacity:"show"},"slow").html('Enabled');
				}
				else if(result=='Disabled')
				{
					$("#questionStatus_"+splitProductId[1]).animate({opacity:"hide"},"slow").html('Disabled');
					$("#questionStatus_"+splitProductId[1]).animate({opacity:"show"},"slow").html('Disabled');
				}
			}
		});
	});

	$('.questionDelete').click(function(){
		var quesDeleteId=$(this).attr('id');
		var splitQuesId=quesDeleteId.split('_');
		var sendData="quesId="+splitQuesId[1];
		$.ajax({
			type:'get',
			url:'index.php?route=catalog/askquestion/changeQuesDelete&<?php echo $sessionAjax; ?>',
			data:sendData,
			beforeSend:function(){},
			complete: function() {},
			success:function(result){
				$("#totalUserQues_"+splitQuesId[1]).animate({opacity:"hide"},"slow");
			}
		});
	});
});
</script>
<?php echo $footer; ?>
