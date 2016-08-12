<?php if (!isset($error)) { ?>
<?php echo $payment; ?>
<?php } else { ?>
<script type="text/javascript"><!--
alert('<?php echo $error; ?>');
//--></script>
<?php } ?>
