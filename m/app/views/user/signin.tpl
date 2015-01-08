{extends file='../layout.tpl'}
{block title}注册{/block}
{block head}
<header id="header">
  <div class="site-map"><a href="javascript:history.go(-1);"><span class="icon-arrow-left"></span></a><em>获取验证码</em></div>
</header>
{/block}
{block main}
<div class="container marketing main">
  <div class="top-block"></div>
  <div class="row">
    <div class="reg-box">
     <ul>
      <li><input type="text" /></li>
      <li><div class="col-xs-7"><input type="text" /></div><div class="col-xs-5"><input type="button" value="获取验证码" /></div></li>
      <li><input type="button" value="确认绑定，下一步" /></li>
     </ul>
    </div>
  </div>
  <div class="foot-block"></div>
</div>
{/block}
