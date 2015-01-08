<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>指帮连锁</title>
<link rel="stylesheet" type="text/css" href="{asset('zbsq/css/sbsq.login.resets.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('zbsq/css/sbsq.login.main.css')}" />
<!--[if IE 6]> 
<script type="text/javascript" src="{asset('zbsq/js/DD_belatedPNG_0.0.8a-min.js')}"></script> 
<script type="text/javascript"> 
DD_belatedPNG.fix('.login_logo img,.login_jt'); 
</script> 
<![endif]--> 
</head>
<body>
<div class="login_main" {if $data.login_color}style="background: none repeat scroll 0% 0% {$data.login_color};"{/if}>
  <div class="login_Box">
    <div class="login_logo">
    	{if $data.login_logo_hash}<img src="{route('FilePull', ['hash' => $data.login_logo_hash,width=>320,height=>80])}" />{/if}
    </div>
    <form id ="loginForm"  >
    <div class="login_con">
      <h3>欢迎登录!</h3>      
      <ul>
			<li><em id="info"></em><span><i></i></span><input name="username" id="username" type="text" placeholder="请输入用户名/邮箱"></li>
     		<li><span><i></i></span><input name="password" id="password" type="password" placeholder="请输入密码" onkeydown=KeyDown()></li>
	  </ul>
      <p class="login_tip"><span>如登录出现异常，请清理浏览器缓存后在尝试</span><!-- <a href="###">忘记密码？</a> --></p>
      <p class="button"><button name="" type="button"  id="login-btn" {if $data.login_color}style="background: none repeat scroll 0% 0% {$data.login_color};"{/if}>登&nbsp;录</button></p>
      <p class="copyright">Copyright © <a href="http://www.xmsmt.com.cn" target="_blank">厦门速卖通</a></p>
    </div>
    </form>
  </div>
</div>
<div class="login_img" style="background: url('{route('FilePull', ['hash' => $data.login_big_hash])}')  top center no-repeat transparent; background-size: cover;"></div>

</body>
</html>

<script type="text/javascript" src="{asset('js/jquery-1.8.3.min.js')}"></script>
<script>
$("#login-btn").click(function() {
	login();
});

function login(){

	var action_url = "{route('LoginAction')}";	
    var action = $(this).attr('data-action');

    if (action == 1) {
        return false;
    }
    $(this).attr('data-action', 1);
    var data = $("#loginForm").serialize();
    var obj = $(this);
    $("#login-btn").html("登录中……");
    $.ajax({
        type: "POST",
        url: action_url,
        dataType: 'json',
        data: data,
        success: function(data) {
            window.location.href = '/';
        },
        error : function(xhq) {
            obj.attr('data-action', 0);
            $("#info").html(xhq.responseText);
            $("#login-btn").html("登录");
        }
    });
}

$(document).keydown(function(e) { 
    if(e.which == 13) { 
    		login();
    } 
});   
</script>