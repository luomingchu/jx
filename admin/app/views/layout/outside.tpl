<!DOCTYPE html>
<!--[if IE 8]> <html lang="zh" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="zh" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="zh"> <!--<![endif]-->
<!-- begin head -->
<head>
<meta charset="utf-8" />
<title>{block title}{{$smarty.block.child}|default:'管理中心'} - {/block}企业自由营销平台</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap/css/bootstrap.min.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap/css/bootstrap-responsive.min.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap/css/bootstrap-fileupload.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/font-awesome/css/font-awesome.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('css/style.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('css/style_responsive.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('css/style_default.css')}" id="style_color" />
<link rel="stylesheet" type="text/css" href="{asset('css/mighty.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('css/search.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/fancybox/source/jquery.fancybox.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/gritter/css/jquery.gritter.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/uniform/css/uniform.default.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/chosen-bootstrap/chosen/chosen.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/jquery-tags-input/jquery.tagsinput.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/clockface/css/clockface.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-datepicker/css/datepicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-datepicker-master/css/datepicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-timepicker/compiled/timepicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-timepicker-master/css/bootstrap-timepicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-colorpicker/css/colorpicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/data-tables/DT_bootstrap.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-daterangepicker/daterangepicker.css')}" />
{block head}{/block}
</head>
<!-- end head -->

<!-- begin body -->
<body id="login-body">
	<div class="login-header">
		<!-- BEGIN LOGO -->
		<div id="logo" class="center">
			<a href="{route('Dashboard')}"><img src="{asset('img/logo.png')}" alt="logo" class="center" /></a>
		</div>
		<!-- END LOGO -->
	</div>

	{block main}
		{$_child = {$smarty.block.child}}
		{if stripos($_child, '<!-- Call merged included template "layout/message.tpl" -->') === false}
			{include 'layout/message.tpl'}
		{/if}
		{$_child}
	{/block}
	
	<!-- BEGIN COPYRIGHT -->
	<div id="login-copyright">Copyright 2014 &copy;  厦门速卖通.</div>
	<!-- END COPYRIGHT -->

	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="{asset('js/jquery-1.8.3.min.js')}"></script>
	<script src="{asset('assets/bootstrap/js/bootstrap.min.js')}"></script>
	<script src="{asset('js/jquery.blockui.js')}"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="{asset('js/excanvas.js')}"></script>
	<script src="{asset('js/respond.js')}"></script>
	<![endif]-->
	<script src="{asset('assets/chosen-bootstrap/chosen/chosen.jquery.min.js')}"></script>
	<script src="{asset('assets/uniform/jquery.uniform.min.js')}"></script>
	<script src="{asset('js/scripts.js')}"></script>
	{block script}{/block}
	<script>
		$(function() {
			// initiate layout and plugins
			App.init();
			App.initLogin();
		});
	</script>
	<!-- end javascripts -->
</body>
<!-- end body -->
</html>