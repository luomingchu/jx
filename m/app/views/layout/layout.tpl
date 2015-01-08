<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link type="text/css" rel="stylesheet" href="{asset('css/main.css')}?20150104" />
<!--[if lt IE 9]>
<link type="text/css" rel="stylesheet" href="{asset('css/styleie.css')}" />
<![endif]-->
<title>{block title}{/block}-指帮连锁</title>
<script src="{asset('jquery/jquery-1.10.2.min.js')}"></script>
<script src="{asset('jquery/jquery.easing.1.3.js')}"></script>
<script src="{asset('jquery/bootstrap.js')}"></script>
<script src="{asset('jquery/script.js')}"></script>
<script src="{asset('jquery/default.js')}"></script>

{block css}{/block}

</head>
<body>
<header id="header">{block head}{/block}</header>
{block main}{/block}
<footer id="footer">
{block footer}
    <div class="copyright"></div>
{/block}
</footer>
<div class="fade"></div>
{block additional}{/block}
<script type="text/javascript">
    {$enterprise_id = str_replace(['zbond_', 'zblstest_'], '', Config::get('database.connections.own.database'))}
    var url = "http://{$enterprise_id}.api.zbond.com.cn/m/app-download"; //下载地址
    var isweinxin;
    var appurl;
    var browser = {
        versions: function() {
            var u = navigator.userAgent, app = navigator.appVersion;
            return {
                //移动终端浏览器版本信息
                trident: u.indexOf('Trident') > -1, //IE内核
                presto: u.indexOf('Presto') > -1, //opera内核
                webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), //是否为移动终端
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
                iPad: u.indexOf('iPad') > -1, //是否iPad
                webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
            };
        }(),
        language: (navigator.browserLanguage || navigator.language).toLowerCase()
    }

    if (browser.versions.ios || browser.versions.iPhone || browser.versions.iPad) {
        //open IOS
        appurl="openzb"+"{$enterprise_id}"+"app://openVstore";
    }else if (browser.versions.android) {
        //open android
        var enterprise_id="{$enterprise_id}";
        if(enterprise_id=='woaiwocha'){
            appurl="com.smt.zbond://businesscircle/";
        }else{
            appurl="com.smt.zbond."+"{$enterprise_id}";
        }
    }

    $(function() {
        isWeiXin();
    });

    function isWeiXin(){
        var ua = window.navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == 'micromessenger'){
            isweinxin = true;
            return true;
        }else{
            isweinxin = false;
            return false;
        }
    }

    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    }
</script>
{block script}{/block}

<!-- message -->
{if Session::has('message_success')} <script> alert('{Session::get('message_success')}'); </script> {/if}
{if Session::has('message_info')} <script> alert('{Session::get('message_info')}'); </script> {/if}
{if Session::has('message_warning')} <script> alert('{Session::get('message_warning')}'); </script> {/if}
{if Session::has('message_error')} <script> alert('{Session::get('message_error')}'); </script> {/if}
<!-- /message -->
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253759119'style='display:none;'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1253759119' type='text/javascript'%3E%3C/script%3E"));</script>
</body>
</html>
