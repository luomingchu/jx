{extends file='layout/layout.tpl'}

{block title}{$data.name}{/block}
{block css}style="padding-bottom:10px;"{/block}
{block main}
<div class="shop_details">
	<div class="mainPic">
		<div class="proinfo-slides pro-slides">
			{foreach $data.pictures as $picture}
				<a class="example1" title="产品图片" href="javascript:();"><p><img alt="example1" src="{$picture.url}" width="400" height="400"/></p></a>
			{/foreach}
      	</div>
      	<script>
		$('.pro-slides').slidesjs({
	        //width: 100%,
	        //height: 210,
	        navigation: false,
	        start: 1,
	        play: {
	          auto: false
	        }
      	});
      	</script>
	</div>
    <!--.mainPic end//-->
    
	<div class="pro_info">
		{if $end_time}
			<div class="countdown"><i></i><b>距内购结束</b><span class="day">-</span>天<span class="hour">-</span>时<span class="minute">-</span>分<span class="second">-</span>秒</div>
		{/if}
		<div class="titleBox">
        	<h1>{$data.name|truncate:50}</h1>
        	<div class="fxTsM1"><i></i><span>收藏</span></div>
		</div>
      	<div class="price"><span><em>内购价：</em>￥<b>{if !empty($discount_price)}{$discount_price}{else}{$data.price}{/if}</b></span><div class="cls"></div>
      		{if $end_time}<span>指币抵{if $coin_max_use gt 0}{$coin_max_use}%{/if}</span><span>内购额{$discount_price}</span>{/if}</div>
      	<div class="price_old">原价：<span>￥{$data.market_price}</span></div>
      	<div class="bott_con"><span>快递 包邮</span><span>销量{$data.trade_quantity}</span><span>{$data.store.name}</span></div>
	</div>
    <!--.pro_info end//-->
    
    <div class="select_color"><a href="javascript:open_ov_cdd()"><span>选择</span><span>颜色尺码</span></a></div>
    
    <section class="tabbtn">
      <ul class="Fadetab">
        <li class="current"><a href="javascript:void(0)">图文详情</a></li>
        <li><a href="javascript:void(0)">产品参数</a></li>
        <li><a href="javascript:void(0)">猜你喜欢</a></li>
      </ul>
    </section>
    
    <div class="Fadecon">
      <div class="imgText" id="goods_detail">
        {$data.description}
      </div>
      <!--图文详情 end//-->
      
      <div class="shop_description" >
        {$data.parameter}
      </div>
      <!--产品参数 end//-->
      
      <ul class="shop_prod_list fxTsM5" style="margin-top:-10px;">
      	{foreach $cai as $item}
      		<li><a href="javascript:();"><span><img src="{$item.thumbnail_url}"></span> <span><b>{$item.name}</b></span> 
      		<span><b>￥</b>{$item.price}<del>￥{$item.market_price}</del></span> <span>库存：<b>{$item.stock}</b>已售：<b>{$item.trade_quantity}</b></span> </a> </li>
      	{/foreach}
      </ul>
      <!--猜你喜欢 end//-->
    </div>
    <!--.Fadecon end//-->
    
    {*<dl class="shop_buts">
     <dt><a class="fxTsM5" href="javascript:();"><i>电话</i></a><a class="fxTsM4" href="javascript:(0);"><i>购物车</i></a></dt>
     <dd><a class="fxTsM2" href="javascript:();">立即购买</a><a class="fxTsM3" href="javascript:(0);">到店体验</a></dd>
    </dl>*}
    <div class="shop_buts"> <a class="" href="{route('OrderConfirm')}?goods_id={$data.id}">立即购买</a> </div>
    <!--  <div class="shop_buts"> <a class="" href="javascript:;">去APP购买</a> </div> -->
    <!--.shop_buts end//-->     
  </div>
{/block}

{block script}
<script type="text/javascript">
function resizeImg(obj, maxw) {
    var obj = document.getElementById(obj);
    var imgs = obj.getElementsByTagName('img');
    var imgCount = imgs.length;
    if(imgCount==0) return;
    for(var i=0; i<imgCount; i++) {
        if(imgs[i].width>maxw) {
            var oldw = imgs[i].width;
            if (maxw > 470) {
                maxw = 470;
            }
            var oldh = imgs[i].height;
            imgs[i].style.width = (maxw-20) +'px';
            imgs[i].style.height = (maxw/oldw*oldh) +'px';
        }
    }
}

$(function() {
    resizeImg('goods_detail', document.body.clientWidth);
})
//距内购结束-剩余倒计时
$(function(){
	countDown("{$end_time}",".countdown .day",".countdown .hour",".countdown .minute",".countdown .second");
	
	/* if(!isweinxin){
		$('.shop_buts a').attr('href',appurl);
	}
	
	$('.shop_buts a').bind('click',function(e){
        e.preventDefault();
		if(isweinxin){
			$('.fade').show();
			$('.fade').click(function(){
				$(this).fadeOut(300);
			});
		}else{
			//$('.shop_buts a').attr('href',url);
			setTimeout("window.location.href='"+url+"'",500);
		}
	}) */
});
</script>
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253759119'style='display:none;'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1253759119' type='text/javascript'%3E%3C/script%3E"));</script>
{/block}