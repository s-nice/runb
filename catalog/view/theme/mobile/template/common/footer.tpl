<footer>
  <div class="container">
  	<?php if(count($languages) > 1) : ?>
  	<?php foreach ($languages as $language) { ?>
  	  <?php if ($language['code'] == $current_lang_code) { ?>
  	  <a href="#" class="lang-select"><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"></a>
  	  <?php } ?>
  	  <?php } ?>
  	<?php endif; ?>
  	<?php if (count($currencies) > 1) { ?>
  	<?php foreach ($currencies as $currency) { ?>
  	  <?php if ($currency['code'] == $current_currency_code) { ?>
  	  <a href="#" class="currency-select"><?php echo $currency['symbol_left']; echo $currency['symbol_right'] ?> <?php echo $currency['title'];?></a>
  	  <?php } ?>
  	  <?php } ?>
  	<?php } ?>
    <p><?php echo $powered; ?></p>
  </div>
</footer>
</body>
<?php if(count($languages) > 1) : ?>
<script type="text/javascript">
$(document).ready(function() {
  //language select
  $('.lang-select').on('click', function(e){
    e.preventDefault();
    $('#lang-select-div').remove();
    html  = '<div id="lang-select-div" class="modal">';
    html += '  <div class="modal-dialog">';
    html += '    <div class="modal-content">';
    html += '      <div class="modal-header">';
    html += '        <h1 class="modal-title"><?php echo $text_select_language; ?></h1>';
    html += '      </div>';
    html += '      <div class="modal-body">';
    html += '      <form action="<?php echo $language_action; ?>" method="post" enctype="multipart/form-data" id="language">';
    html += ' <input type="hidden" name="code" value="" />';
    html += ' <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />';
    html += '      <div class="list-group">';
    <?php foreach($languages as $lang) : ?>
     html += '<a href="<?php echo $lang['code']; ?>" class="list-group-item"><img src="image/flags/<?php echo $lang['image']; ?>"/> <?php echo $lang['name'];?></a>';
    <?php endforeach; ?>
    html += '      </div>';
    html += '      </form>';
    html += '      </div>';
    html += '      <div class="modal-footer">';
    html += '        <a href="#" class="btn btn-primary btn-block" data-dismiss="modal"><?php echo $text_cancel;?></a>';
    html += '      </div';
    html += '    </div';
    html += '    </div';
    html += '    </div';
    $('body').append(html);
    $('#lang-select-div').modal('show');
  });
});
</script>
<?php endif; ?>

<?php if (count($currencies) > 1) : ?>
<script type="text/javascript">
$(document).ready(function(){
    //Currency select
  $('.currency-select').on('click', function(e){
    e.preventDefault();
    $('#currency-select-div').remove();
    html  = '<div id="currency-select-div" class="modal">';
    html += '  <div class="modal-dialog">';
    html += '    <div class="modal-content">';
    html += '      <div class="modal-header">';
    html += '        <h1 class="modal-title"><?php echo $text_select_currency;?></h1>';
    html += '      </div>';
    html += '      <div class="modal-body">';
    html += '      <form action="<?php echo $currency_action; ?>" method="post" enctype="multipart/form-data" id="currency">';
    html += ' <input type="hidden" name="code" value="" />';
    html += ' <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />';
    html += '      <div class="list-group">';
    <?php foreach($currencies as $currency) : ?>
    html += '<a href="<?php echo $currency['code']; ?>" class="list-group-item"><?php echo $currency['symbol_left'];echo $currency['symbol_right'];?> <?php echo $currency['title'];?></a>';
    <?php endforeach; ?>
    html += '      </div>';
    html += '      </form>';
    html += '      </div>';
    html += '      <div class="modal-footer">';
    html += '        <a href="#" class="btn btn-primary btn-block" data-dismiss="modal"><?php echo $text_cancel;?></a>';
    html += '      </div';
    html += '    </div';
    html += '    </div';
    html += '    </div';
    $('body').append(html);
    $('#currency-select-div').modal('show');
  });
});
</script>
<?php endif; ?>
</html>
