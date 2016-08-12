<?php echo $header; ?>
<div class="container">
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row">
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row widget first-widget">
        <div class="col-sm-6">
          <div class="well">
            <h2><?php echo $text_returning_customer; ?></h2>
            <p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
              <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary btn-block" />
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>

				<?php if ($weibo_login_status || $qq_login_status): ?>
				<div class="social-login">
					<?php if ($weibo_login_status): ?>
					<a href="#" class="weibo-login"><i class="fa fa-weibo"></i> 微博登录</a>
					<script type="text/javascript"><!--
					$(document).ready(function() {
						$('.weibo-login').click(function(e) {
							e.preventDefault();
							//以下为按钮点击事件的逻辑。注意这里要重新打开窗口
							//否则后面跳转到weibo登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
							url = "https://api.weibo.com/oauth2/authorize?response_type=code&client_id=<?php echo $weibo_login_client_id ?>&redirect_uri=<?php echo $weibo_login_return_url ?>";
							var A=window.open(url, "WeiboLogin", "width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
						});
					});
					--></script>
					<?php endif; ?>

					<?php if ($qq_login_status): ?>
					<a href="#" class="qq-login"><i class="fa fa-qq"></i> QQ登录</a>
					<script type="text/javascript"><!--
					$(document).ready(function() {
						$('.qq-login').click(function(e) {
							e.preventDefault();
							//以下为按钮点击事件的逻辑。注意这里要重新打开窗口
							//否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
							url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=<?php echo $qq_login_client_id ?>&redirect_uri=<?php echo $qq_login_return_url ?>&scope=get_user_info";
							var A=window.open(url, "TencentLogin", "width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
						});
					});
					--></script>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			
            </form>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="well">
            <h2><?php echo $text_new_customer; ?></h2>
            <p><strong><?php echo $text_register; ?></strong></p>
            <p><?php echo $text_register_account; ?></p>
            <a href="<?php echo $register; ?>" class="btn btn-default btn-block"><?php echo $button_continue; ?></a></div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
	</div>
</div>
<?php echo $footer; ?>