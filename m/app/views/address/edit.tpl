{extends file='layout/layout.tpl'}

{block title}收货地址{/block}

{block head}
    <div class="site-map"><a href="javascript:history.go(-1);"><span class="icon-arrow-left"></span></a><em>{if $info}修改{else}添加{/if}收货地址</em></div>
{/block}

{block main}
    <div class="container marketing main">
        <div class="top-block"></div>
        <div class="row">
            <div class="address-info">
                <form id="address_form">
                <ul>
                    <li><dl><dt>姓名：</dt><dd><input type="text" name="consignee" id="consignee" value="{$info.consignee}" /></dd></dl></li>
                    <li><dl><dt>电话：</dt><dd><input type="text" name="mobile" id="mobile" value="{$info.mobile}" /></dd></dl></li>
                    <li class="gray"><dl><dt>固定电话：</dt><dd><input name="phone" id="phone" type="text" value="{$info.phone}" placeholder="电话号码和固定电话任选一个" /></dd></dl></li>
                    <li><dl><dt>邮编：</dt><dd><input type="text" name="zipcode" id="zipcode" value="{$info.zipcode}" /></dd></dl></li>
                    <li><dl>
                            <dt>省份：</dt>
                            <dd>
                                <select name="province_id" id="province_id">
                                    <option value="">选择所属省份</option>
                                    {foreach $province_list as $province}
                                        <option value="{$province.id}" {if $province.id eq $info.province_id}selected="selected" {/if}>{$province.name}</option>
                                    {/foreach}
                                </select>
                            </dd>
                        </dl>
                    </li>
                    <li><dl>
                            <dt>城市：</dt>
                            <dd>
                                <select name="city_id" id="city_id">
                                    <option value="">选择所属城市</option>
                                    {foreach $city_list as $city}
                                        <option value="{$city.id}" {if $city.id eq $info.city_id}selected="selected" {/if}>{$city.name}</option>
                                    {/foreach}
                                </select>
                            </dd>
                        </dl>
                    </li>
                    <li><dl>
                            <dt>区/县：</dt>
                            <dd>
                                <select name="district_id" id="district_id">
                                    <option value="">选择所属区/县</option>
                                    {foreach $district_list as $district}
                                        <option value="{$district.id}" {if $district.id eq $info.district_id}selected="selected" {/if}>{$district.name}</option>
                                    {/foreach}
                                </select>
                            </dd>
                        </dl>
                    </li>
                    <li><dl><dt>街道：</dt><dd><input type="text" name="address" id="address" value="{$info.address}" /></dd></dl></li>
                    <li>
                        <dl>
                            <dt>默认地址：</dt>
                            <dd>
                                <select name="is_default" id="is_default">
                                    <option value="{Address::ISDEFAULT}" {if Address::ISDEFAULT eq $info.is_default}selected="selected" {/if}>是</option>
                                    <option value="{Address::UNDEFAULT}" {if Address::UNDEFAULT eq $info.is_default}selected="selected" {/if}>否</option>
                                </select>
                            </dd>
                        </dl>
                    </li>
                </ul>
                <input type="hidden" name="address_id" value="{$info.id}"/>
                </form>
            </div>
        </div>
        <div class="foot-block"></div>
    </div>
{/block}

{block footer}
    <div class="foot-btn" id="save_address"><a href="javascript:;">保 存</a></div>
{/block}

{block script}
<script type="text/javascript">
    $("#province_id").change(function() {
        $("#city_id option:not(:first)").remove();
        $("#district_id option:not(:first)").remove();
        $.ajax({
            type: 'GET',
            url: '{route('GetCityList')}',
            data: { province_id : $(this).val() },
            dataType: 'json',
            success: function(data) {
                var html = "";
                for (var i in data) {
                    html += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
                }
                $("#city_id").append(html);
            },
            error: function(xhq) {
                alert(xhq.responseText);
            }
        });
    });

    $("#city_id").change(function() {
        $("#district_id option:not(:first)").remove();
        $.ajax({
            type: 'GET',
            url: '{route('GetDistrictList')}',
            data: { city_id : $(this).val() },
            dataType: 'json',
            success: function(data) {
                var html = "";
                for (var i in data) {
                    html += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
                }
                $("#district_id").append(html);
            },
            error: function(xhq) {
                alert(xhq.responseText);
            }
        });
    });

    $("#save_address").click(function() {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        $.ajax({
            type: 'POST',
            url: '{route('SaveAddress')}',
            data: $("#address_form").serialize(),
            dataType: 'json',
            success: function(data) {
                window.location.href = "{URL::previous()}";
            },
            error: function(xhq) {
                $("#save_address").attr('data-action', 0);
                alert(xhq.responseText);
            }
        });
    });
</script>
{/block}