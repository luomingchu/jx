{extends file='layout/main.tpl'}

{block title}企业信息 {/block}

{block breadcrumb}
<li>系统管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('EnterpriseInfo')}">企业信息</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-title">
        <h4><i class="icon-reorder"> 编辑企业信息</i></h4>
    </div>
    <div class="widget-body form">
    <!-- BEGIN FORM-->
    <form id="goods_form" class="form-horizontal">
        <div class="control-group">
            <label class="control-label">企业名称：</label>

            <div class="controls">
                <input type="text" class="span6" id="name" name="name" value="{$data.name}" placeholder=""/>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">企业Logo图片：</label>

            <div class="controls">
                <div>
                    <div class="control-group">
                        <div style="float: left;margin-right: 10px;">
                            <div class="fileupload {if $data.logo_id}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{asset('img/no+image.gif')}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                    {if $data.logo_id}
                                        <img src="{route('FilePull',['id'=>$data.logo_id,'width'=>150])}"/>
                                    {/if}
                                </div>
                                <div class="actions">
                                       <span class="btn btn-file">
                                           <span class="fileupload-new">选择</span>
                                           <span class="fileupload-exists">修改</span>
                                           <input type="file" class="default upload_pic" />
                                       </span>
                                    <a href="#" class="btn delete_upload" style="display: none;">删除</a>
                                </div>
                                <input type="hidden"  id="logo_id" name="logo_id" value="{$data.logo_id}"/>
                            </div>
                        </div>
                        
                        <div style="clear: both;"></div>
                        <span class="label label-important">NOTE!</span>
                        <span>图片格式支持jpg、gif、png，建议图片尺寸800*800以内的正方形图片。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">企业法人：</label>

            <div class="controls">
                <div class="input-prepend input-append">
                    <input name="legal" id="legal" value="{$data.legal}" type="text"/> 
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">联系人：</label>

            <div class="controls">
                <div class="input-prepend input-append">
                    <input name="contacts" id="contacts"  value="{$data.contacts}" type="text"/> 
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">联系电话：</label>

            <div class="controls">
                <div class="input-prepend input-append">
                    <input name="phone" id="phone"  value="{$data.phone}" type="text"/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">地址：</label>

            <div class="controls">
                <div class="input-prepend input-append">
                	<select class="input-large m-wrap" id="province" tabindex="1" name="province_id">
								<option value="">--请选择省份--</option>
								{foreach $provinces as $item}
									<option value="{$item.id}" {if $data.province_id eq $item.id}selected{/if}>{$item.name}</option>
								{/foreach}
                    </select>
                    <select class="input-large m-wrap" id="city" tabindex="1" name="city_id">
								<option value="">--请选择城市--</option>
                    </select>
                    <select class="input-large m-wrap" id="district" tabindex="1" name="district_id">
								<option value="">--请选择区县--</option>
                    </select>
                    <input name="address" id="address"  value="{$data.address}" type="text"/>
                </div>
            </div>
        </div>
        
        <div class="control-group">
         	<label class="control-label">地图导航：</label>
				<div class="controls">
					<div class="col-sm-6">
						<input type="text" class="form-control" placeholder="" id="map_search"> <button type="button" onclick="searchMap();" class="btn btn-default">搜索</button>
						<p class="help-block Red">注：这里只是模糊定位，精准定位请地图上移动红点。</p>
						<div id="map" style="width: 700px; height: 300px;">
						
		             	</div>
					</div>
				</div>
			</div>

        <div class="control-group">
            <label class="control-label">企业简介：</label>

            <div class="controls">
                <textarea class="span6 " rows="5" name="description">{$data.description}</textarea>
            </div>
        </div>
        <div class="control-group">
        	<div class="controls">
        		<input type="hidden" name="longitude" id="longitude"  value="{$data.longitude}"/>
        		<input type="hidden" name="latitude"  id="latitude"  value="{$data.latitude}"/>
	            <button type="button" class="btn btn-success" id="submit_form">保存</button>
	            <button type="button" class="btn" onclick="history.go(-1);">取消</button>
	        </div>
        </div>
    </form>
    <!-- END FORM-->
</div>
<!-- END ADVANCED TABLE widget-->
</div>
</div>


    <div class="modal fade" id="MessageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Message</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
{/block}

{block script}
    <script type="text/javascript">

    var action_url = '{route("EnterpriseInfo")}';

        $(".upload_pic").change(function() {
            if ($(this).val() != '') {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                uploadPicture(formData, $(this));
            }
        });

        $(".delete_upload").click(function() {
            if (confirm('确认要删除吗')) {
                var parent = $(this).closest('.fileupload');
                parent.find('#logo_id').val('');
                parent.removeClass('fileupload-exists').addClass('fileupload-new');
                $(this).hide();
            }
            return false;
        });

        $("#submit_form").click(function() {
            var action = $(this).attr('data-action');
            if (action == 1) {
                return false;
            }
            $(this).attr('data-action', 1);
            var data = $("#goods_form").serialize();
            var obj = $(this);
            $.ajax({
                type: "POST",
                url: "{route('SaveEnterpriseInfo')}",
                dataType: 'json',
                data: data,
                success: function(data) {
                    window.location.href = action_url;
                },
                error : function(xhq) {
                    obj.attr('data-action', 0);
                    ialert(xhq.responseText);
                }
            });
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
                    dom.find('#logo_id').val(data.id);
                    dom.removeClass('fileupload-new').addClass('fileupload-exists');
                },
                error: function(xhq) {
                    dom.removeClass('fileupload-exists').addClass('fileupload-new');
                    dom.find('.actions').find('.delete_upload').hide();
                    ialert(xhq.responseText);
                }
            });
        }

        function ialert(msg)
        {
            $('#MessageModal').find('.modal-body p').text(msg).end().one('hidden.bs.modal', function(){
            }).modal();
        }

		//省市区下拉
		 
		$("#province").change(function() {
		    getCity();
		});
		
		getCity();
		
		function getCity() {
		    var province_id = $("#province").val();
		    var city_id = "{$data.city_id}";
			if( province_id > 0){
				$.ajax({
			        url: '{action("GlobalController@getCity")}',
			        data: { province_id : province_id },
			        success: function(data) {
			            var html = "";
			            for (var i in data) {
			            	if(data[i]['id'] == city_id){
			            		html += "<option value='"+data[i]['id']+"' selected >"+data[i]['name']+"</option>"
			            	}else{
			            		html += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>"
			            	}
			                
			            }
			            $("#city option").not(":first").remove();
			            $("#city").append(html);
			            
			            getDistrict();
			        }
			    });
			}else{
				$("#city option").not(":first").remove();
			}
		}
		
		
		
		$("#city").change(function() {
			getDistrict();
		});
		
		
		function getDistrict() {
		    var city_id = $("#city").val();
		    var district_id = "{$data.district_id}";
			if( city_id > 0){
				$.ajax({
			        url: '{action("GlobalController@getDistrict")}',
			        data: { city_id : city_id },
			        success: function(data) {
			            var html = "";
			            for (var i in data) {
			            	if(data[i]['id'] == district_id){
			            		html += "<option value='"+data[i]['id']+"' selected >"+data[i]['name']+"</option>"
			            	}else{
			            		html += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>"
			            	}
			                
			            }
			            $("#district option").not(":first").remove();
			            $("#district").append(html);
			        }
			    });
			}else{
				$("#district option").not(":first").remove();
			}
		}
</script>


<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=fNRGtmRhQ9t2Byno569QoYUG"></script>
<script type="text/javascript">
//创建和初始化地图函数：
function initMap() {
	var lng = $("#longitude").val();
    var lat = $("#latitude").val();
    if (lng != '' && lat != '') {
    	createMap(lng,lat);//初始化并创建地图
    }else{
    	createMap(118.145208,24.478839);//初始化并创建地图
    }
}

//地图搜索
function searchMap() {
    var area = $("#map_search").val(); //得到地区
    var ls = new BMap.LocalSearch(map);
    ls.setSearchCompleteCallback(function(rs) {
        if (ls.getStatus() == BMAP_STATUS_SUCCESS) {
            var poi = rs.getPoi(0);
            if (poi) {
                createMap(poi.point.lng, poi.point.lat);//创建地图(经度poi.point.lng,纬度poi.point.lat)
            }
        }
    });
    ls.search(area);
}

//创建地图函数：
function createMap(x, y) {
    var map = new BMap.Map("map");//在百度地图容器中创建一个地图
    var point = new BMap.Point(x, y);//定义一个中心点坐标
    map.centerAndZoom(point, 12);//设定地图的中心点和坐标并将地图显示在地图容器中
    window.map = map;//将map变量存储在全局
	
        map.addControl(new BMap.NavigationControl);
        map.addControl(new BMap.OverviewMapControl);
        map.enableScrollWheelZoom();
        map.enableContinuousZoom();
	    var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中
        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        marker.enableMassClear();
        marker.disableDragging();
		
		map.addEventListener("click",function(e){
			map.clearOverlays();
			var marker = new BMap.Marker(e.point);  // 创建标注
			map.addOverlay(marker);              // 将标注添加到地图中
			marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
			marker.enableMassClear();
			marker.disableDragging();
			document.getElementById("longitude").value=e.point.lng;
			document.getElementById("latitude").value=e.point.lat;
		});
		
}

initMap();//创建和初始化地图
</script>
{/block}