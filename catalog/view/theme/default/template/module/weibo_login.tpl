<div class="panel panel-default">
  <div class="panel-body" style="text-align: right;"> 
  <a href="#" onclick='toWeiboLogin();return false;'><img src="image/login/weibo_login.png"></a>

	<script>
	 function toWeiboLogin()
	 {
	   //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
	   //否则后面跳转到weibo登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
	   url = "https://api.weibo.com/oauth2/authorize?response_type=code&client_id=<?php echo $client_id ?>&redirect_uri=<?php echo $return_url ?>";
	   var A=window.open(url, "WeiboLogin", "width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
	 } 
	</script>
  </div>
</div>
