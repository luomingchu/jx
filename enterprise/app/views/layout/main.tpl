<!DOCTYPE html>
<!--[if IE 8]> <html lang="zh" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="zh" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="zh"> <!--<![endif]-->
<!-- begin head -->
<head>
<meta charset="utf-8" />
<title>{block title}{{$smarty.block.child}|strip_tags|default:'管理中心'} - {/block}企业自由营销平台</title>
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
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-colorpicker/css/colorpicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/data-tables/DT_bootstrap.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-daterangepicker/daterangepicker.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/dropzone/css/dropzone.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/messenger/build/css/messenger.css')}" />
<link rel="stylesheet" type="text/css" href="{asset('assets/messenger/build/css/messenger-theme-future.css')}" />
<script src="{asset('js/jquery-1.8.2.min.js')}"></script>
<script src="{asset('assets/artTemplate/template.js')}"></script>
<!--script src="{asset('assets/artTemplate/template-native.js')}"></script-->
<script src="{asset('js/helpers.js')}"></script>
<script src="{asset('js/common.js')}"></script>
<!--[if IE 6]> 
<script type="text/javascript" src="{asset('js/DD_belatedPNG_0.0.8a-min.js')}"></script> 
<script type="text/javascript"> 
DD_belatedPNG.fix('.brand img'); 
</script> 
<![endif]--> 
<style>
	#globalLoading { background-image: url('{asset("assets/pre-loader/Fading squares.gif")}'); position: absolute; width: 60px; height: 9px; top: 35%; left: 50%; margin:-4px 0 0 -30px; }
</style>
{block head}{/block}
</head>
<!-- end head -->

<!-- begin body -->
<body class="fixed-top">
<div id="globalLoading"></div>
<div id="globalContainer" style="visibility:hidden;">
	<!-- begin header -->
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<!-- begin top navigation bar -->
		{$enterprise_id = str_replace('zbond_', '', Config::get('database.connections.own.database'))}
		{$enterprise_config = EnterpriseConfig::whereEnterpriseId($enterprise_id)->first()}
		{$admin_logo_hash = null}
		{if ! is_null($enterprise_config)}
			{$admin_logo_hash = $enterprise_config->admin_logo_hash}
			{$login_color = $enterprise_config->login_color}
		{/if}
		<div class="navbar-inner" {if $login_color}style="background: none repeat-x scroll 0% 0% {$login_color} !important;"{/if}>
			<div class="container-fluid">
				<!-- begin logo {asset('img/only_logo.png')}-->
				<a class="brand" href="{route('Dashboard')}">
				
				<img src="{if $admin_logo_hash}{route('FilePull', ['hash' => $admin_logo_hash])}{else}{asset('img/login_logo.png')}{/if}" alt="" style="height: 45px;"/></a>
				<!-- end logo -->
				<!-- begin responsive menu toggler -->
				<a class="btn btn-navbar collapsed" id="main_menu_trigger"
					data-toggle="collapse" data-target=".nav-collapse"> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span> <span class="arrow"></span>
				</a>
				<!-- end responsive menu toggler -->
				<div id="top_menu" class="nav notify-row">
					<ul class="nav top-menu">
						<li class="dropdown" id="header_inbox_bar">
                            <a href="{route('GetHistoryMessage')}" class="dropdown-toggle">
                                <i class="icon-envelope-alt"></i>
                                <span class="badge badge-important sys_msg_num" style="display: none;">0</span>
						    </a>
						</li>
					</ul>
				</div>

				<div class="top-nav">
					<ul class="nav pull-right top-menu">
						<!-- begin user login dropdown -->
						<li class="dropdown"><a href="#" class="dropdown-toggle"
							data-toggle="dropdown"> <img src="{Auth::user()->avatar.url|default:asset('img/avatar.png?')}&width=30&height=30" alt="" style="width:30px;height:30px;"> <span
								class="username">{Auth::user()->username}</span> <b class="caret"></b>
						</a>
							<ul class="dropdown-menu">
								<!-- <li><a href=""><i class="icon-user"></i> 个人信息</a></li> -->
								<!-- <li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
							<li><a href="#"><i class="icon-calendar"></i> Calendar</a></li>
							<li class="divider"></li> -->
								<li><a href="{route('Logout')}"><i class="icon-key"></i> 退出</a></li>
								<li><a href="{route('GetModifyPassword')}"><i class="icon-edit"></i> 修改密码</a></li>
							</ul></li>
						<!-- end user login dropdown -->
					</ul>
				</div>
			</div>
		</div>
		<!-- end top navigation bar -->
	</div>
	<!-- end header -->
	<!-- begin container -->
	<div id="container" class="row-fluid">
		<!-- begin sidebar -->
		<div id="sidebar" class="nav-collapse collapse">
			<div class="sidebar-toggler hidden-phone"></div>
			<!-- begin responsive quick search form -->
			<div class="navbar-inverse">
				<form class="navbar-search visible-phone">
					<input type="text" class="search-query" placeholder="Search" />
				</form>
			</div>
			<!-- end responsive quick search form -->
			<!-- begin sidebar menu -->
			{include 'layout/sidebar-menu.tpl'}
			<!-- end sidebar menu -->
		</div>
		<!-- end sidebar -->
		<!-- begin page -->
		<div id="main-content">
			<!-- begin page container-->
			<div class="container-fluid">
				<!-- begin page header-->
				<div class="row-fluid">
					<div class="span12">
						<!-- begin theme customizer-->
						<div id="theme-change" class="hidden-phone">
							<i class="icon-cogs"></i> <span class="settings"> <span
								class="text">Theme:</span> <span class="colors"> <span
									class="color-default" data-style="default"></span> <span
									class="color-gray" data-style="gray"></span> <span
									class="color-purple" data-style="purple"></span> <span
									class="color-navy-blue" data-style="navy-blue"></span>
							</span>
							</span>
						</div>
						<!-- end theme customizer-->
						<!-- begin page title & breadcrumb-->
						<h3 class="page-title">{block title}{/block}{block smallTitle}{if {$smarty.block.child}} <small>{$smarty.block.child}</small>{/if}{/block}</h3>
						<ul class="breadcrumb">
							<li><a href="{route('Dashboard')}"><i class="icon-home"></i></a> <span class="divider">&nbsp;</span></li>
							{block breadcrumb}<li><a href="#">Last Divider</a> <span class="divider-last">&nbsp;</span></li>{/block}
							<script>
                                $('.sidebar-menu .has-sub-menu').hide();
								// 固定左侧滑动菜单。
								var breadcrumb = [], subMenu;
								$('.breadcrumb a[href]').each(function(){
									breadcrumb.unshift(this.href);
								});
								$('.sidebar-menu a[href]').each(function(){
                                    if ($(this).attr('href').indexOf('http') > -1) {
                                        var flag = false;
                                        for(var i in breadcrumb){
                                            if(this.href == breadcrumb[i]){
                                                subMenu = $(this);
                                                flag = true;
                                                break;
                                            }
                                        }
                                        /* if(this.href == breadcrumb[0]) {
                                            subMenu = $(this);
                                            flag = true;
                                        } */
                                        if (flag) {
                                            return false;
                                        }
                                    }
								});

                                if (typeof subMenu != 'undefined') {
                                    subMenu.css('background', '#fff');
                                    subMenu.parent().addClass('active')
                                            .parents('.sub').show()
                                            .parents('li.has-sub').addClass('open')
                                            .find('.arrow').addClass('open');
                                    subMenu.closest('.has-sub-menu').show();
                                }
							</script>
						</ul>
						<!-- end page title & breadcrumb-->
					</div>
				</div>
				<!-- end page header-->

				{include 'layout/message.tpl'}

				<!-- begin page content-->
				{block main}{/block}
				<!-- end page content-->

                <div id="alertModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel1">提示</h3>
                    </div>
                    <div class="modal-body">
                        <p id="alertMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                    </div>
                </div>
                
                <div id="confirmModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel1">操作确认</h3>
                    </div>
                    <div class="modal-body">
                        <p id="confirmMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmAction">确定</button>
                        <button type="button" class="btn" data-dismiss="modal" id="confirmCancelAction">取消</button>
                    </div>
                </div>

			</div>
			<!-- end page container-->
		</div>
		<!-- end page -->
	</div>
	<!-- end container -->

	<!-- begin footer -->
	<div id="footer">
		Copyright 2014 &copy; XMSMT.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-arrow-up"></i></span>
		</div>
	</div>
	<!-- end footer -->
</div>
	<!-- begin javascripts -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
    <script src="{asset('assets/jmeditor/JMEditor.js')}"></script>
	<script src="{asset('assets/bootstrap/js/bootstrap.min.js')}"></script>
	<script src="{asset('assets/bootstrap/js/bootstrap-fileupload.js')}"></script>
	<script src="{asset('assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}"></script>
	<script src="{asset('js/jquery.blockui.js')}"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="{asset('js/excanvas.js')}"></script>
	<script src="{asset('js/respond.js')}"></script>
	<![endif]-->
	<script src="{asset('assets/chosen-bootstrap/chosen/chosen.jquery.min.js')}"></script>
	<script src="{asset('assets/uniform/jquery.uniform.min.js')}"></script>
	<script src="{asset('assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}"></script>
	<script src="{asset('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}"></script>
	<script src="{asset('assets/clockface/js/clockface.js')}"></script>
	<script src="{asset('assets/jquery-tags-input/jquery.tagsinput.min.js')}"></script>
	<script src="{asset('assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js')}"></script>
	<script src="{asset('assets/bootstrap-datepicker-master/js/bootstrap-datepicker.js')}"></script>
	<script src="{asset('assets/bootstrap-datepicker-master/js/locales/bootstrap-datepicker.zh-CN.js')}"></script>
	<script src="{asset('assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js')}"></script>
	<script src="{asset('assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.zh-CN.js')}"></script>
	<script src="{asset('assets/bootstrap-daterangepicker/date.js')}"></script>
	<script src="{asset('assets/bootstrap-daterangepicker/daterangepicker.js')}"></script>
	<script src="{asset('assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}"></script>
	<script src="{asset('assets/bootstrap-timepicker/js/bootstrap-timepicker.js')}"></script>
	<script src="{asset('assets/bootstrap-timepicker-master/js/bootstrap-timepicker.js')}"></script>
	<script src="{asset('assets/bootstrap-inputmask/bootstrap-inputmask.min.js')}"></script>
	<script src="{asset('assets/fancybox/source/jquery.fancybox.pack.js')}"></script>
	<script src="{asset('assets/dropzone/dropzone.js')}"></script>
	<script src="{asset('assets/messenger/build/js/messenger.js')}"></script>
	<script src="{asset('assets/messenger/build/js/messenger-theme-future.js')}"></script>
	<script src="{asset('js/scripts.js')}"></script>
	<!--script src="{asset('js/mighty.js')}"></script-->
	{block script}{/block}
	<script>

        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-theme-future messenger-on-bottom messenger-on-right',
            theme: 'flat'
        };

        setInterval(function() {
            getMessage();
        }, 60000);

        getMessage();

        function getMessage() {
            Messenger().run({
                errorMessage: ""
            }, {
                url: "{route('GetMessageList')}",
                success: function(data) {
                    var msg;
                    if (data.length > 0) {
                        for (var i in data) {
                            msg = Messenger().post({
                                message: data[i]['description'],
                                type: 'info',
                                actions: {
                                    cancel: {
                                        label: '查看',
                                        action: function() {
                                            window.location.href = "{route('GetRefundInfo', ['refund_id' => ''])}/"+data[i]['body']['id'];
                                        }
                                    }
                                }
                            });
                        }
                    }
                }
            });
        }


		$.ajaxSetup({
	        type: 'GET',
	        dataType: 'json',
	        error: function(xhq) {
	        	if(xhq.status){
	            	ialert(xhq.responseText);
	        	}
	        }
	    });

        $.get('{route("GetUnreadMessageNumber")}', function(data) {
            if (data != 0) {
                $(".sys_msg_num").show();
            }
            $(".sys_msg_num").text(data);
        }, 'text');
	
	    function ialert(msg) {
	        $("#alertMessage").html(msg);
	        $("#alertModal").modal('show');
	    }
	
	    function iconfirm(msg, func)
	    {
	        $("#confirmMessage").html(msg);
	        $("#confirmModal").modal('show');
	        $("#confirmAction").one('click', function() {
	            func();
	        });
            if (arguments[2]) {
                $("#confirmCancelAction").one('click', function() {
                    arguments[2]();
                })
            }
            $('#confirmModal').on('hidden.bs.modal', function (e) {
                $("#confirmAction").unbind('click');
            })
	    }
		// initiate layout and plugins
		App.init();
		$('.go-top').parent().show();
		
		$('#globalContainer').css({ 'visibility': 'visible', 'opacity': 0 }).animate({ 'opacity': 1 }, { duration: 'slow', queue: false, complete: function(){ $('#globalLoading').hide(); } });
	</script>
	<!-- end javascripts -->
</body>
<!-- end body -->
</html>