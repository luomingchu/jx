{extends file='layout/outside.tpl'}

{block title}管理员登陆{/block}

{block main}
<div id="login">
	<form class="form-vertical no-padding no-margin" action="{route('LoginAction')}" method="post">
		{include 'layout/message.tpl'}
		<div class="lock">
			<i class="icon-lock"></i>
		</div>
		<div class="control-wrap">
			<h4>管理员登陆</h4>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input id="input-username" type="text" name="username" value="{Input::old('username')|escape}" placeholder="用户名/手机" />
					</div>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-key"></i></span>
						<input id="input-password" type="password" name="password" placeholder="密码" />
					</div>
					<div class="mtop10">
						<div class="block-hint pull-left small">
							<input type="checkbox" name="remember_me" value="true"> 记住我
						</div>
					</div>

					<div class="clearfix space5"></div>
				</div>

			</div>
		</div>

		<input type="submit" id="login-btn" class="btn btn-block login-btn" value="登 录" data-loading-text="登录中..." />
	</form>
</div>
{/block}
