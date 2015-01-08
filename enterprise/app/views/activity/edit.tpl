{extends file='layout/main.tpl'}

{block title}活动管理{/block}

{block breadcrumb}
<li>活动管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('ActivityList', ['body_type' => $data.body_type|default:$smarty.get.body_type])}">内购活动</a> <span class="divider">&nbsp;</span></li>
<li>{if $data.id}修改{else}添加{/if}{$activities[$smarty.get.body_type]}活动 <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
{$body_type = $data.body_type|default:$smarty.get.body_type}
<div class="row-fluid">
	<div class="span12">
		<form method="post" action="{route('ActivitySave')}" class="form-horizontal" id="mainForm">
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-circle-arrow-right"></i> 第一步 设置投放区域
                    </h4>
                    <span class="tools">
                        <a href="javascript:;" class="icon-chevron-down"></a>
                    </span>
                </div>
                <div class="widget-body form">
                    <div class="control-group">
                        <label class="control-label">投放区域:</label>
                        <div class="controls">
                            <div id="groups">
                                {if $data.groups}
                                    {foreach $group_list as $glk=>$groups}
                                        <div class="groups-item" style="margin-bottom:8px;">
                                                <span class="groups-selects">
                                                    {foreach $groups as $gk=>$group}
                                                        <select style="margin-right:8px;" {if $group@last}name="groups[]"{/if}>
                                                            {foreach $group as $g}
                                                                <option value="{$g.id}" {if $g.id eq $group_select[$glk][$gk]}selected="selected" {/if}>{$g.name}</option>
                                                            {/foreach}
                                                        </select>
                                                    {/foreach}
                                                </span>
                                            <button type="button" class="groups-delete btn btn-small btn-danger">删除</button>
                                            <button type="button" class="groups-add btn btn-small btn-info">增加</button>
                                        </div>
                                    {/foreach}
                                {/if}
                            </div>
                            <script type="text/html" id="GroupsTemplate">
                                <div class="groups-item" style="margin-bottom:8px;">
                                    <span class="groups-selects"></span>
                                    <span class="groups-loading" style="margin-right:8px;">Loading...</span>
                                    <button type="button" class="groups-delete btn btn-small btn-danger">删除</button>
                                    <button type="button" class="groups-add btn btn-small btn-info">增加</button>
                                </div>
                            </script>
                        </div>
                    </div>
                    {if $smarty.get.body_type eq 'Presell'}
                        <div class="control-group">
                            <label class="control-label">预付款时间:</label>
                            <div class="controls">
                                <div class="input-append">
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                    <input class="span10" id="start_date" data-date="{$data.start_datetime}" type="text" name="start_date" value="{Input::old('start_date')|default:$data.start_datetime|date_format:'%Y-%m-%d'}" required readonly/>
                                </div>
                                <div class="input-append" style="width: 180px;">
                                    <span class="add-on"><i class="icon-time"></i></span>
                                    <input class="span5" type="text" name="start_time" id="start_time" data-max="{$max_time}" value="{$data.start_datetime|date_format:'%H:%M'|default:'00:00'}" data-mask="99:99" placeholder="">
                                </div>
                                &nbsp;&nbsp;到&nbsp;&nbsp;
                                <div class="input-append">
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                    <input class="span10" id="end_date" data-date="{$data.end_datetime}" type="text" name="end_date" value="{Input::old('end_time')|default:$data.end_datetime|date_format:'%Y-%m-%d'}" required readonly/>
                                </div>
                                <div class="input-append">
                                    <span class="add-on"><i class="icon-time"></i></span>
                                    <input class="span5" type="text" name="end_time" id="end_time" data-max="{$max_time}" value="{$data.end_datetime|date_format:'%H:%M'|default:'23:59'}" data-mask="99:99" placeholder="">
                                </div>
                            </div>
                        </div>
                    {else}
                        <div class="control-group">
                            <label class="control-label">活动时间:</label>

                            <div class="controls">
                                <div class="input-append">
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                    <input class="span10" id="start_date" data-date="{$data.start_datetime}" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} type="text" name="start_date" value="{Input::old('start_date')|default:$data.start_datetime|date_format:'%Y-%m-%d'}" required readonly/>
                                </div>
                                <div class="input-append" style="width: 180px;">
                                    <span class="add-on"><i class="icon-time"></i></span>
                                    <input class="span5" type="text" name="start_time" id="start_time" data-max="{$max_time}" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="{$data.start_datetime|date_format:'%H:%M'|default:'00:00'}" data-mask="99:99" placeholder="">

                                    <!-- <input type="text" name="start_time" id="start_time" data-max="{$max_time}" value="{$data.start_datetime|date_format:'%H:%M'|default:'00:00'}"  readonly="readonly" class="clockface" style="width: 60px;"/> -->
                                </div>
                                &nbsp;&nbsp;到&nbsp;&nbsp;
                                <div class="input-append">
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                    <input class="span10" id="end_date" data-date="{$data.end_datetime}" type="text" name="end_date" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="{Input::old('end_time')|default:$data.end_datetime|date_format:'%Y-%m-%d'}" required readonly/>
                                </div>
                                <div class="input-append">
                                    <span class="add-on"><i class="icon-time"></i></span>
                                    <input class="span5" type="text" name="end_time" id="end_time" data-max="{$max_time}" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="{$data.end_datetime|date_format:'%H:%M'|default:'23:59'}" data-mask="99:99" placeholder="">

                                    <!-- <input type="text" name="end_time" id="end_time" data-max="{$max_time}" value="{$data.end_datetime|date_format:'%H:%M'|default:'23:59'}"  readonly="readonly" class="clockface"  style="width: 60px;"/> -->
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div style="width: 100%;height: 30px;position: relative;top:-50px;display: none" id="date_shade"></div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <button type="button" id="stepToNext" class="btn btn-primary" {if $data}style="display: none;" {/if}>确 定</button>
                            <button type="button" id="prevStep" class="btn btn-danger" style="display: none;">修 改</button>
                        </div>
                    </div>
                </div>
            </div>


			<div class="widget" id="stepTwo" {if empty($data)}style="display: none;"{/if}>
				<div class="widget-title">
					<h4>
						<i class="icon-circle-arrow-right"></i> 第二步 设置活动信息
					</h4>
					<span class="tools">
						<a href="javascript:;" class="icon-chevron-down"></a>
					</span>
				</div>
				<div class="widget-body form">
					<div class="control-group">
						<label class="control-label">活动名称:</label>
						<div class="controls">
							<input type="text" placeholder="请输入活动名称" class="span12" name="title" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="{Input::old('title')|default:$data.title}" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">活动简介:</label>
						<div class="controls">
							<textarea class="span12" name="introduction" rows="6" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} required>{Input::old('introduction')|default:$data.introduction}</textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">活动图片:</label>
						<div class="controls">
							<div class="fileupload fileupload-new" data-provides="fileupload" id="upload_avatar">
								<input type="hidden" name="picture_id" id="picture_id" value="{$data.picture_id}" />
								<div class="fileupload-new thumbnail" style="width: 120px; height: 120px;">
									<img src="{$data.picture.url|default:asset('img/no+image.gif')}" style="width: 120px; height: 120px;"/>
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 120px; max-height: 120px; line-height: 20px;"></div>
								<div class="actions">
									<span class="btn btn-file" {if $data.status eq Activity::STATUS_OPEN}style="display: none;" {/if}><span class="fileupload-new" >选择图片</span>
										<span class="fileupload-exists">更改图片</span>
										<input type="file" class="default upload_pic" />
									</span>
									<a href="#" class="btn close" data-dismiss="fileupload" style="display: none;">删除</a>
								</div>
							</div>
							<span class="label label-important">注意</span> <span>图片尺寸建议 500*200 px,上传只支持最新的Firefox、Chrome、Opera、Safari和Internet Explorer 10 以上版本的浏览器。</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">当前状态:</label>
						<div class="controls">
							<label class="radio"><input type="radio" name="status" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="{Activity::STATUS_OPEN}" {if Input::old('status')|default:$data.status|default:Activity::STATUS_CLOSE eq Activity::STATUS_OPEN}checked{/if} /> 开启</label>
							<label class="radio"><input type="radio" name="status" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="{Activity::STATUS_CLOSE}" {if Input::old('status')|default:$data.status|default:Activity::STATUS_CLOSE eq Activity::STATUS_CLOSE}checked{/if} /> 未开启</label>
							<span class="help-inline">未开启状态下，活动就算在活动时间范围内也是无法进行的。</span>
						</div>
					</div>
				</div>
			</div>

			<div class="widget" id="stepThree" {if empty($data)}style="display: none;"{/if}>
				<div class="widget-title">
					<h4>
						<i class="icon-circle-arrow-right"></i> 第三步 设置活动商品
					</h4>
					<span class="tools">
						<a href="javascript:;" class="icon-chevron-down"></a>
					</span>
				</div>
				<div class="widget-body">
                    {if empty($data) || (!empty($data) && $data.status eq 'Close')}
					<div class="row-fluid">
                        <span id="goods_category">
                            <select name="category_id[]" class="sub_category" data-placeholder="选择一级分类" style="width: 100px;">
                                <option value="0">全部分类</option>
                                {foreach $category as $item}
                                    <option value="{$item.id}">{$item.name}</option>
                                {/foreach}
                            </select>
                        </span>
                        <input type="text" id="search_goods_name" placeholder="宝贝名称关键字"/>
                        <input type="text" id="search_goods_number" placeholder="商品货号"/>
                        <button type="button" class="btn btn-primary" id="GoodsFind"><i class="icon-search icon-white"></i> 查询</button>
                    </div>
					<div class="clearfix"></div>

					<table class="table table-bordered table-advance table-hover">
						<thead>
							<tr>
								<th>商品名称</th>
								<th>货号</th>
								<th>市场价</th>
								<th>门店价</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="GoodsEmpty">
							<tr>
								<td colspan="5" style="text-align:center">没有任何商品</td>
							</tr>
						</tbody>
						<tbody id="GoodsList"></tbody>
					</table>
					<div id="GoodsPagination"></div>
					<script type="text/html" id="GoodsItemTemplate">
						<|each $data|>
						<tr id="GoodsItem_<|$value.id|>">
							<td>
								<a href="<|$value.pictures[0].url|>" target="_blank">
									<img src="<|$value.pictures[0].url|>&width=25&height=25" width="25" height="25">
								</a>
								<|$value.name|>
							</td>
							<td><|$value.number|></td>
							<td><|$value.market_price|></td>
							<td><|$value.price[0]|><|if $value.price[0] != $value.price[1]|>~<|$value.price[1]|><|/if|></td>
							<td>
								<button type="button" class="goods-add btn btn-small btn-info"
									data-id="<|$value.id|>"
									data-picture="<|$value.pictures[0].url|>"
									data-name="<|$value.name|>"
									data-number="<|$value.number|>"
									data-market_price="<|$value.market_price|>"
									data-price_min="<|$value.price[0]|>"
									data-price_max="<|$value.price[1]|>"
                                    data-brokerage_ratio="<|$value.brokerage_ratio|>"
								>参与活动</button>
							</td>
						</tr>
						<|/each|>
					</script>

					<hr>

					<div class="row-fluid">
						<div class="span12" style="padding-left: 20px;">
                            <h4>已选商品</h4>
                            <div>批量设置</div>
                            <div style="">
                                <input type="checkbox" id="checkAll"> 全选
                                <span style="margin-left:10px;margin-right: 15px;">折扣 <input type="text" id="multi_discount" class="text numbers" style="width: 30px;"/></span>
                                <span style="margin-right: 15px;">限购数量 <input type="text" id="multi_limited" class="text integer" style="width: 30px;"/></span>
                            {if $smarty.get.body_type eq 'InnerPurchase'}
                                <span style="margin-right: 15px;">指币抵用最高比例 <input type="text" id="multi_coin_ratio" class="text integer" style="width: 30px;"/> %</span>
                            {else}
                                <span style="margin-right: 15px;">预售订金 <input type="text" id="multi_deposit" class="text numbers" style="width: 30px;"/></span>
                            {/if}
                                <span style="margin-right: 15px;">佣金比率 <input type="text" id="multi_brokerage" class="text numbers" style="width: 30px;"/> %</span>
                                <input type="button" value="确定" class="btn" id="multiSetup"/>
                            </div>
                        </div>
					</div>
                    {/if}
					<table class="table table-bordered table-advance table-hover" style="margin-top: 10px;">
						<thead>
							<tr>
                                <th><!-- <input type="checkbox" id="checkAll"/> 全选  --></th>
								<th>宝贝描述</th>
								<th>货号</th>
								<th>市场价</th>
                                <th>门市价</th>
                                <th>折扣</th>
								<th>内购价</th>
								{if $body_type eq Activity::TYPE_INNER_PURCHASE}
                                <th>内购额</th>
								<th>指币抵用最高比例</th>
								{elseif $body_type eq Activity::TYPE_PRESELL}
								<th>预售订金</th>
								{/if}
                                <th>佣金比率</th>
                                <th>每人限购数</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="ActivityGoodsEmpty">
							<tr>
								<td colspan="15" style="text-align:center">没有任何商品</td>
							</tr>
						</tbody>
						<tbody id="ActivityGoodsList"></tbody>
					</table>
                        <script type="text/html" id="ActivityGoodsItemTemplate">
						<tr id="ActivityGoods_<|$data.id|>" data-id="<|$data.id|>">
                            <td>
                                <input type="checkbox" name="goods_item[]" value="<|$data.id|>"/>
                            </td>
							<td>
                                <|if $data.pictures|>
                                <a href="<|$data.pictures[0].url|>" target="_blank">
                                    <img src="<|$data.pictures[0].url|>" width="25" height="25" >
                                </a>
                                <|else|>
								<a href="<|$data.picture|>" target="_blank">
									<img src="<|$data.picture|>" width="25" height="25" >
								</a>
                                <|/if|>
								<|$data.name|>
							</td>
							<td><|$data.number|></td>
							<td><|$data.market_price|></td>
                            <td><|$data.price_min|><|if $data.price_min != $data.price_max|>~<|$data.price_max|><|/if|></td>
							<td><input value="<|$data.discount|>" type="text" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} class="text discount numbers" data-price_min="<|$data.price_min|>" data-price_max="<|$data.price_max|>" id="discount_<|$data.id|>" style="width: 30px" name="discount[<|$data.id|>]"/> 折</td>
                            <td><span class="text discount_price numbers" id="discount_price_<|$data.id|>"></span></td>
                            {if $body_type eq Activity::TYPE_INNER_PURCHASE}
                                <td><span class="insource" id="insource_<|$data.id|>"></span> </td>
                                <td><input type="text" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="<|$data.coin_max_use_ratio|>" class="text coin_ratio integer" id="coin_ratio_<|$data.id|>" style="width: 30px;" name="coin_ratio[<|$data.id|>]"/> %</td>
                            {elseif $body_type eq Activity::TYPE_PRESELL}
                                <td><input type="text" value="<|$data.deposit|>" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} class="text deposit numbers" id="deposit_<|$data.id|>" style="width: 30px;" name="deposit[<|$data.id|>]"/> </td>
                            {/if}
                            <td>
                                <input type="text" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="<|$data.brokerage_ratio|>" class="text brokerage numbers" id="brokerage_<|$data.id|>" style="width: 30px;" name="brokerage[<|$data.id|>]"/> %
                            </td>
                            <td>
                                <input type="text" {if $data.status eq Activity::STATUS_OPEN}disabled="disabled" {/if} value="<|$data.quota|>" class="text limited integer" id="limited_<|$data.id|>" style="width: 30px;" name="limited[<|$data.id|>]"/>
                            </td>
							<td>
								<input type="hidden" name="goods[]" value="<|$data.id|>">
                                {if $data.status eq Activity::STATUS_OPEN}
                                    <button type="button" class="btn btn-small">已参与</button>
                                {else}
                                    <button type="button" class="goods-delete btn btn-small btn-danger" data-id="<|$data.id|>">取消参与</button>
                                {/if}
							</td>
						</tr>
					</script>
				</div>
			</div>

            {if empty($data) || (!empty($data) && $data.status eq 'Close')}
            <div class="control-group form-actions" style="{if !$data}display: none;{/if}" id="action_banner">
                <div style="position: relative;left: -150px;">
                    <input type="hidden" name="body_type" id="body_type" value="{$body_type}" />
                    <input type="checkbox" id="checkAll2"> 全选
                    <input type="button" class="btn btn-danger" value="批量删除" id="multi_remove"/>
                </div>
                <span style="float: right;margin-right: 30px;">
                    <input type="hidden" name="id" value="{$data.id}"/>
                    <button type="button" id="subForm" class="btn btn-primary"><i class="icon-ok"></i> 发 布</button>
                    <button type="button" class="btn" onclick="javascript:window.location.href='{URL::previous()}';"><i class=" icon-remove"></i> 取消</button>
                </span>
            </div>
            {/if}
		</form>
	</div>
</div>
{/block}

{block script}
<script src="{asset('js/dataview.js')}"></script>
<script type="text/javascript">
	// 投放区域选择框。
	var groups_cache = { };
    var goods_list = {if $data}{$data.goods}{else}new Array(){/if};

    if (goods_list.length > 0) {
        $("#ActivityGoodsEmpty").html('');
        for (var i in goods_list) {
            var goods = goods_list[i]['enterprise_goods'];
            goods['deposit'] = goods_list[i]['deposit'];
            goods['coin_max_use_ratio'] = goods_list[i]['coin_max_use_ratio'];
            goods['quota'] = goods_list[i]['quota'];
            goods['discount'] = goods_list[i]['discount'];
            goods['discount_price'] = goods_list[i]['discount_price'];
            goods['brokerage_ratio'] = goods_list[i]['brokerage_ratio'];
            $('#ActivityGoodsList').append(template('ActivityGoodsItemTemplate', goods));
        }
        $("#groups .groups-delete").show();
        $("#groups .groups-add").hide();
        if ($("#groups .groups-delete").size() <= 1) {
            $("#groups .groups-delete:first").hide();
        }
        if ({$data|default:'false'} == 'false' || "{$data.status}" == 'Close') {
            $("#groups .groups-add:last").show();
        }
        $(".discount").each(function() {
            getPrice($(this));
        });
    } else {
        addGroup();
    }

	function FillSelectOption(selector, data, parent){
		var AppendOption = function($select, key, value){
			var $option = $('<option />');
			$option.val(key);
			$option.text(value);
			$select.append($option);
		}
		$select = $(selector);
        if (! parent) {
            AppendOption($select, '', '所有区域');
        }
		$.each(data, function(){
			AppendOption($select, this.id, this.name);
		});
		return $select;
	}
	function LoadSubGroup($con, parent_id, parent){
		parent_id = parent_id || 0;
		$con.parent().find('.groups-loading').show();
		var callback = function(json){
			if(json.length){
				$select = FillSelectOption('<select style="margin-right:8px;" />', json, parent);
				$con.append($select);
				$select.trigger('change');
			}
			$con.parent().find('.groups-loading').hide();
		};
		if(typeof groups_cache[parent_id] == 'undefined'){
			$.get('{route('GroupSub')}', { parent_id: parent_id }, function(json){
				groups_cache[parent_id] = json;
				callback(json);
			}, 'json');
		}else{
			callback(groups_cache[parent_id]);
		}
	}

    function addGroup()
    {
        $('#groups').append(template('GroupsTemplate'));
        LoadSubGroup($('#groups .groups-item:last .groups-selects'), 0, true);
        $("#groups .groups-delete").show();
        $("#groups .groups-add").hide();
        if ($("#groups .groups-delete").size() <= 1) {
            $("#groups .groups-delete:first").hide();
        }
        $("#groups .groups-add:last").show();
    }

    $(document).on('click', '.groups-add', function() {
        addGroup();
    });

	$('#groups').on('click', '.groups-delete', function(){
		$(this).parents('.groups-item').remove();
        $("#groups .groups-delete").show();
        $("#groups .groups-add").hide();
        if ($("#groups .groups-delete").size() <= 1) {
            $("#groups .groups-delete:first").hide();
        }
        $("#groups .groups-add:last").show();
	});
	$('#groups').on('change', 'select', function(){
		$(this).nextAll().remove();
		var group_id = $(this).val();
		if(group_id){
			$(this).attr('name', 'groups[]');
			$(this).prevAll().removeAttr('name');
			LoadSubGroup($(this).parent(), group_id, false);
		}
	});

	// 参与商品选择功能。
	var dv = new DataView({
		'dataTemplate'			: 'GoodsItemTemplate',
		'dataContainer'			: 'GoodsList',
		'paginationContainer'	: 'GoodsPagination',
		'autoAnchor'			: false,
		'dataUrl'				: '{route('EnterpriseGoodsListAjax')}',
		'counterUrl'			: '{route('EnterpriseGoodsListCountAjax')}'
	});
	$('#GoodsFind').on('click', function(){
        var category_id = '';
        $(".sub_category").each(function() {
            if ($(this).val() != '') {
                category_id = $(this).val();
            }
        });
		$('#GoodsPagination').hide();
		dv.setParam('number', $('#search_goods_number').val());
		dv.setParam('name', $('#search_goods_name').val());
        dv.setParam('category_id', category_id);
        dv.setParam('body_type', "{$smarty.get.body_type}");
        dv.setParam('start_date', $("#start_date").val());
        dv.setParam('end_date', $("#end_date").val());
        dv.setParam('start_time', $("#start_time").val());
        dv.setParam('end_time', $("#end_time").val());
        var groups = new Array();
        $("[name='groups[]']").each(function() {
            groups.push($(this).val());
        });
        dv.setParam('groups', groups);
		dv.load();
	});
	$('#GoodsList').on('dataload', function(){
		$('#GoodsEmpty').hide();
		$('#GoodsList').html('<tr><td colspan="5" style="text-align:center"><img src="{asset('assets/pre-loader/Fading squares.gif')}"></td></tr>');
	}).on('dataloaded', function(){
		$('#GoodsPagination').show();
		if($('#GoodsList tr:first').length){
			$('#GoodsList .goods-add').each(function(){
				if($('#ActivityGoods_' + $(this).data('id')).length){
					$(this).addClass('disabled').text('已经添加');
				}
			});
		}else{
			$('#GoodsEmpty').show();
		}
	});

	$('#GoodsList').on('click', '.goods-add:not(.disabled)', function(){
		var goods = $(this).data();
		$('#GoodsItem_' + goods.id + ' .goods-add').addClass('disabled').removeClass('btn-info').text('已经添加');
		$('#ActivityGoodsEmpty').hide();
		$('#ActivityGoodsList').append(template('ActivityGoodsItemTemplate', goods));
	});
	$('#ActivityGoodsList').on('click', '.goods-delete', function(){
		var goods_id = $(this).data('id');
		$('#ActivityGoods_' + goods_id).remove();
		$('#GoodsItem_' + goods_id + ' .goods-add').removeClass('disabled').addClass('btn-info').text('参与活动');
		if( ! $('#ActivityGoodsList tr:first').length){
			$('#ActivityGoodsEmpty').show();
		}
	});


    $(".upload_pic").change(function() {
        if ($(this).val() != '') {
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            uploadPicture(formData, $(this));
        }
    });

    function uploadPicture(data, dom) {
        var dom = dom.closest('.fileupload');
        dom.find('.actions').find('.delete_upload').show();
        $.ajax({
            type:"POST",
            url: "{route('FileUpload')}",
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                dom.find('#picture_id').val(data.id);
                dom.removeClass('fileupload-new').addClass('fileupload-exists');
            },
            error: function(xhq) {
                dom.removeClass('fileupload-exists').addClass('fileupload-new');
                dom.find('.actions').find('.delete_upload').hide();
                ialert(xhq.responseText);
            }
        });
    }

    $("#stepToNext").click(function() {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var start_time = $("#start_time").val();
        var end_time = $("#end_time").val();
        var type = $("#body_type").val();
        if (start_date == '') {
            ialert('活动开始日期不能为空！'); return false;
        }
        if (end_date == '') {
            ialert('活动结束日期不能为空！'); return false;
        }
        if (start_time == '') {
            ialert('活动开始时间不能为空！'); return false;
        }
        if (end_time == '') {
            ialert('活动结束时间不能为空！'); return false;
        }
        $(".groups-item select").attr('readonly', 'readonly');
        $(".groups-delete,.groups-add").hide();
        $("#stepTwo").show();
        $("#stepThree").show();
        $("#prevStep").show();
        $("#date_shade").show();
        $("#stepToNext").hide();
        $("#action_banner").show();

        {*var selected_groups = new Array();*}
        {*$("[name='groups[]']").each(function() {*}
            {*selected_groups.push($(this).val());*}
        {*});*}
        {*$.ajax({*}
            {*type: 'GET',*}
            {*data: { start_date: start_date, end_date: end_date, start_time: start_time, end_time: start_time, type: type, selected_groups: selected_groups },*}
            {*url: "{route('CheckActivityGroupValid')}",*}
            {*dataType: 'text',*}
            {*success: function() {*}
                {*$(".groups-item select").attr('readonly', 'readonly');*}
                {*$(".groups-delete,.groups-add").hide();*}
                {*$("#stepTwo").show();*}
                {*$("#stepThree").show();*}
                {*$("#prevStep").show();*}
                {*$("#date_shade").show();*}
                {*$("#stepToNext").hide();*}
                {*$("#action_banner").show();*}
            {*}*}
        {*});*}
    });

    $("#prevStep").click(function() {
        $(this).hide();
        $(".groups-item select").removeAttr('readonly');
        $(".groups-delete").show();
        $('.groups-add:last').show();
        if ($('.groups-item').size() == 1) {
            $(".groups-delete:first").hide();
        }
        $("#stepToNext").show();
        $("#stepTwo").hide();
        $("#stepThree").hide();
        $("#date_shade").hide();
        $("#action_banner").hide();
        $("#ActivityGoodsList").html('<tr><td colspan="15" style="text-align:center">没有任何商品</td></tr>');
        $("#GoodsList").html('<tr><td colspan="5" style="text-align:center">没有任何商品</td></tr>');
    });

    $(".clockface").clockface({
        format: 'HH:mm'
    });

    //产生下级分类
    $(document).on('change', ".sub_category", function() {
        var parent_id = $(this).val();
        var obj = $(this);
        obj.nextAll().remove();
        $.getJSON("{route("GoodsCategorySub")}", { parent_id:parent_id }, function(data) {
            if (data.length > 0) {
                var select = '<select class="sub_category" name="category_id[]" style="width: 100px;"><option value="">请选择</option>';
                $(data).each(function(i, e) {
                    select += "<option value='"+ e.id+"'>"+ e.name+"</option> ";
                });
                select += "</select>";
                obj.parent().append(select);
            }
        });
    });


    $('#start_date,#end_date,#start_settle_date,#end_settle_date').datepicker({
        format: "yyyy/mm/dd",
        language: "zh-CN",
    });

    $(document).on('keyup', '.numbers', function() {
        if ($(this).val() != '' && isNaN($(this).val())) {
            ialert('请输入数字字符');
            $(this).val('');
        }
    })

    $(document).on('keyup', '.integer', function() {
        if ($(this).val() != '' && !/^[0-9]+$/.test($(this).val())) {
            ialert('请输入整数');
            $(this).val('');
        }
    });

    $(document).on('keyup', '.discount', function() {
        getPrice($(this));
    });


    function getPrice(obj)
    {
        var price_min = parseFloat(obj.attr('data-price_min'));
        var price_max = parseFloat(obj.attr('data-price_max'));
        var id = obj.closest('tr').attr('data-id');
        if (obj.val() == '' || isNaN(obj.val())) {
            $("#discount_price_"+id).html('');
            if ($("#insource_"+id).size()) {
                $("#insource_"+id).html('');
            }
        } else {
            var inner = "{$inner_ratio}";
            var val = parseFloat(obj.val());
            price_min = toDecimal2(price_min * val / 10);
            price_max = toDecimal2(price_max * val / 10);
            if (price_min != price_max) {
                $("#discount_price_"+id).html(price_min+'~'+price_max);
                $("#insource_"+id).text(toDecimal2(price_min * parseFloat(inner) / 100)+'~'+toDecimal2(price_max * parseFloat(inner) / 100));
            } else {
                $("#discount_price_"+id).html(price_min);
                $("#insource_"+id).text(toDecimal2(price_min * parseFloat(inner) / 100));
            }
        }
    }

    $("#multiSetup").click(function() {
        if ($("[name='goods_item[]']:checked").size() < 1) {
            ialert('请先选择要生效的商品！');
            return false;
        }
        $("[name='goods_item[]']:checked").each(function() {
            var gid = $(this).val();
            $("#discount_"+gid).attr('data-selected', 1);
            $("#coin_ratio_"+gid).attr('data-selected', 1);
            $("#limited_"+gid).attr('data-selected', 1);
            $("#deposit_"+gid).attr('data-selected', 1);
            $("#brokerage_"+gid).attr('data-selected', 1);
        });
        var multi_coin_ratio = $("#multi_coin_ratio").val();
        var multi_limited = $("#multi_limited").val();
        var multi_discount = $("#multi_discount").val();
        var multi_brokerage = $("#multi_brokerage").val();
        $(".discount").filter('[data-selected="1"]').val(multi_discount);
        $(".coin_ratio").filter('[data-selected="1"]').val(multi_coin_ratio);
        $(".limited").filter('[data-selected="1"]').val(multi_limited);
        $(".brokerage").filter('[data-selected="1"]').val(multi_brokerage);
        if ($("#multi_deposit").size()) {
            $(".deposit").filter('[data-selected="1"]').val($("#multi_deposit").val());
        }
        $(".discount").each(function() {
            getPrice($(this));
        });
    });

    $("#checkAll,#checkAll2").click(function() {
        if ($(this).parent().hasClass('checked')) {
            $("[name='goods_item[]']").removeAttr('checked');
        } else {
            $("[name='goods_item[]']").attr('checked', 'checked');
        }
    });

    $("#multi_remove").click(function() {
        $("[name='goods_item[]']:checked").each(function() {
            $('#GoodsItem_' + $(this).val() + ' .goods-add').removeClass('disabled').addClass('btn-info').text('参与活动');
            $(this).closest('tr').remove();
        });
        if( ! $('#ActivityGoodsList tr:first').length){
            $('#ActivityGoodsEmpty').show();
        }
    });

    $("#subForm").click(function() {
        if( ! $('[name="goods[]"]').length){
            ialert('活动必须添加至少一个参与商品');
            return false;
        }
        var flag = true;
        $(".discount").each(function() {
            if ($.trim($(this).val()) == '') {
                ialert('请填写参加活动所有商品的折扣！');
                flag = false;
                return false;
            }
        });
        if (flag) {
            $(".coin_ratio").each(function() {
                if ($.trim($(this).val()) == '') {
                    ialert('请填写参加活动所有商品的指币抵用最高比例！');
                    flag = false;
                    return false;
                }
            });
        }
        if (flag) {
            $(".limited").each(function() {
                if ($.trim($(this).val()) == '') {
                    ialert('请填写参加活动所有商品的每人限购数！');
                    flag = false;
                    return false;
                }
            });
        }
        if (flag) {
            $(".deposit").each(function() {
                if ($.trim($(this).val()) == '') {
                    ialert('请填写参加活动所有商品的预售订金！');
                    flag = false;
                    return false;
                }
            });
        }
        if (flag) {
            var status = 'Close';
            $("[name='status']").each(function() {
                if ($(this).parent().hasClass('checked')) {
                    status = $(this).val();
                    return false;
                }
            });
            if ($("#subForm").attr('data-action') == 1) {
                ialert('已提交数据，请稍后！');
                return false;
            }
            $("#subForm").attr('data-action', 1);
            if (status == 'Open') {
                iconfirm('您选择此活动立即开启，活动开启后，活动的相关信息及活动商品将不能再进行修改，确定要马上开启吗？', function() {
                    $.ajax({
                        type: 'POST',
                        url: '{route("ActivitySave")}',
                        data: $("#mainForm").serialize(),
                        success: function(data) {
                            window.location.href = "{URL::previous()}";
                        },
                        error: function(xhq) {
                            ialert(xhq.responseText);
                            $("#subForm").attr('data-action', 0);
                        }
                    });
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: '{route("ActivitySave")}',
                    data: $("#mainForm").serialize(),
                    success: function(data) {
                        window.location.href = "{URL::previous()}";
                    },
                    error: function(xhq) {
                        ialert(xhq.responseText);
                        $("#subForm").attr('data-action', 0);
                    }
                });
            }
        }
    });

</script>
{/block}