{extends file='layout/layout.tpl'}
{block title}登录{/block}

{block main}
    <div class="container marketing main">
        <div class="top-block"></div>
        <div class="row">
            <form id="form" method="post">
                <div class="login-box">
                    <img src="images/login-logo.png"/>
                    <ul>
                        <li>
                            <input type="text" id="username" name="username" placeholder="用户名/手机号"/>
                        </li>
                        <li>
                            <input type="password" id="password" name="password" placeholder="密码"/>
                        </li>
                        <li><a>忘记密码？</a></li>
                        <input type="hidden" name="rtn_url" value="{$url}">
                        <li><input id="login" type="button" value="登录"/></li>
                        <li class="reg"><a href="{route('Signup')}">注册新帐号</a></li>
                    </ul>
                </div>
            </form>

        </div>
        <div class="foot-block"></div>
    </div>
{/block}

{block script}
<script>
    $("#login").click(function(){
        login();
    });

    function login(){
    
        var action = $(this).attr("login-action");

        if( action == 1){
        	return false;
        }
        
        $(this).attr("action",1);
        var login_url = "{route('LoginAction')}";
        var data = $("form").serialize();
        
    	$("#login").val("登录中……");
        
        $.ajax({
            type:'post',
            url:login_url,
            data:data,
            dataType:'json',
            success:function(data){
            	window.location.href = "{route('ViewGoodsInfo', ['goods_id'=> Session::get('share_goods_id'), 'vstore_id' => Session::get('share_vstore_id')])}";
            },
            error:function(e){
            	$(this).attr("action",0);            	
            	alert(e.responseText);
            	$("#login").val("登录");
            }
        });
    }
    
    $(document).keydown(function(e) { 
        if(e.which == 13) { 
        		login();
        } 
    }); 
    
</script>
{/block}
