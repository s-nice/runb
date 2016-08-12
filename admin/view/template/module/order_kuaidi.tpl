<?php if ($error) { ?>
<div class="warning"><?php echo $error; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<table class="table table-bordered">
  <thead>
    <tr>
      <td class="text-left"><?php echo $column_date_added; ?></td>
      <td class="text-left"><?php echo $column_kuaidi_code; ?></td>
      <td class="text-left"><?php echo $column_kuaidi_number; ?></td>
      <td class="text-left"><?php echo $column_comment; ?></td>
      <td class="text-left"><?php echo $column_kuaidi_track; ?></td>
      <td class="text-right"><?php echo $column_action; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($histories) { ?>
    <?php foreach ($histories as $history) { ?>
    <tr>
      <td class="text-left"><?php echo $history['date_added']; ?></td>
      <td class="text-left"><?php echo $history['kd_kuaidi_code']; ?></td>
      <td class="text-left"><?php echo $history['kd_kuaidi_number']; ?></td>
      <td class="text-left"><?php echo $history['kd_comment']; ?></td>
      <td class="text-left">
      	<a target="_bank" href="<?php echo $history['kd_track']; ?>"><?php echo $text_view; ?></a>
      </td>
      <td class="text-right">
      	<button id="button-del<?php echo $history['id']; ?>" class="btn-small btn-info" onclick="delKuaidi(<?php echo $history['id']; ?>)" ><?php echo $button_delete; ?></button>
      </td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
</div>
<script type="text/javascript"><!--
function delKuaidi(id){
	var status_id = $('select[name="order_status_id"]').val();

	$.ajax({
		url: 'index.php?route=module/kuaidi_chaxun/delete&token=<?php echo $token; ?>&id=' + id,
		type: 'post',
		dataType: 'json',
		data: '',
						beforeSend: function() {
							$('#button-del'+id).button('loading');
						},
						complete: function() {
							$('#button-del'+id).button('reset');
						},
						success: function(json) {
							$('.alert').remove();
				
							if (json['error']) {
								$('#kuaidi').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							}
				
							if (json['success']) {
								$('#kuaidi').load('index.php?route=module/kuaidi_chaxun/getList&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
				
								$('#kuaidi').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
	});
}

$(document).ready(function() {
	changeStatus();
});

$('select[name="order_status_id"]').change(function(){
	changeStatus();
});
//--></script>
