<ul class="sidebar-menu">
    {if Manager::checkAccess('SystemManageModule')}
        <li class="has-sub">
            <a href="javascript:;" > <span class="icon-box"> <i class="icon-cog"></i></span> 系统管理 <span class="arrow"></span> </a>
            <ul class="has-sub-menu">
                {if Manager::checkAccess('EnterpriseManageModule')}
                    <li class="has-sub">
                        <a href="javascript:;" class="">企业信息<span class="arrow"></span></a>
                        <ul class="sub" >
                            {if Manager::checkAccess('EnterpriseInfo')}
                                <li><a class="" href="{route('EnterpriseInfo')}">基本信息</a></li>
                            {/if}
                            {if Manager::checkAccess('AccountManage')}
                            <li><a class="" href="{route('AccountManage')}">账户管理</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}
                {if Manager::checkAccess('NoticeManageModule')}
                    <li class="has-sub"><a class="" href="javascript:;">公告管理<span class="arrow"></span></a>
                        <ul class="sub">
                            {if Manager::checkAccess('EditNotice')}
                                <li><a class="" href="{route('EditNotice')}">发布公告</a></li>
                            {/if}
                            {if Manager::checkAccess('GetNoticeList')}
                                <li><a class="" href="{route('GetNoticeList')}">公告列表</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}
                {*{if Manager::checkAccess('InsourceManageModule')}
                    <li class="has-sub"><a class="" href="javascript:;">内购额管理<span class="arrow"></span></a>
                        <ul class="sub">
                            {if Manager::checkAccess('EditMemberInsource')}
                                <li><a class="" href="{route('EditMemberInsource')}">内购额发放</a></li>
                            {/if}
                            {if Manager::checkAccess('GetInsourceLogList')}
                                <li><a class="" href="{route('GetInsourceLogList')}">内购额列表</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}*}
                {*{if Manager::checkAccess('CoinManageModule')}
                    <li class="has-sub"><a class="" href="javascript:;">指币管理<span class="arrow"></span></a>
                        <ul class="sub">
                            {if Manager::checkAccess('EditMemberCoin')}
                                <li><a class="" href="{route('EditMemberCoin')}">发放指币</a></li>
                            {/if}
                            {if Manager::checkAccess('GetCoinLogList')}
                                <li><a class="" href="{route('GetCoinLogList')}">发放列表</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}*}
                {if Manager::checkAccess('PermissionManageModule')}
                    <li class="has-sub"><a class="" href="javascript:;">权限管理<span class="arrow"></span></a>
                        <ul class="sub">
                            {if Manager::checkAccess('GetManagerList')}
                                <li><a class="" href="{route('GetManagerList')}">管理员列表</a></li>
                            {/if}
                            {if Manager::checkAccess('GetRoleList')}
                                <li><a class="" href="{route('GetRoleList')}">角色管理</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}
                {*{if Manager::checkAccess('StoreManageModule')}
                    <li class="has-sub"><a class="" href="javascript:;">区域/门店管理<span class="arrow"></span></a>
                        <ul class="sub">
                            {if Manager::checkAccess('GroupList')}
                                <li><a class="" href="{route('GroupList')}">区域列表</a></li>
                            {/if}
                            {if Manager::checkAccess('StoreList')}
                                <li><a class="" href="{route('StoreList')}">门店列表</a></li>
                            {/if}
                            {if Manager::checkAccess('AreaStoreManagerList')}
                                *}{*<li><a class="" href="{route('AreaStoreManagerList')}">区域负责人</a></li>*}{*
                            {/if}
                            {if Manager::checkAccess('storeManagerList')}
                                <li><a class="" href="{route('storeManagerList')}">门店管理员</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}
                {if Manager::checkAccess('StaffList')}
                    <li class="no-sub"><a href="{route('StaffList')}">员工列表</a></li>
                {/if}
                {if Manager::checkAccess('ManageMember')}
                    <li class="no-sub"><a href="{route('ManageMember')}">会员列表</a></li>
                {/if}
                {if Manager::checkAccess('ManageMemberLevel')}
                    <li class="no-sub"><a href="{route('ManageMemberLevel')}">会员等级设置</a></li>
                {/if}*}
                {if Manager::checkAccess('SuggestList')}
                    <li class="no-sub"><a href="{route('SuggestList')}">反馈列表</a></li>
                {/if}
                {*{if Manager::checkAccess('GetQuestionnaireList')}
                    <li class="no-sub"><a href="{route('GetQuestionnaireList')}">问卷调查</a></li>
                {/if}*}
                {if Manager::checkAccess('EditPushMessage')}
                    <li class="no-sub"><a href="{route('EditPushMessage')}">消息推送</a> </li>
                {/if}
                {if Manager::checkAccess('ConfigsList')}
                    <li class="no-sub"><a href="{route('ConfigsList')}">系统参数</a></li>
                {/if}
                {if Manager::checkAccess('EnterpriseConfigEdit')}
                    <li class="no-sub"><a href="{route('EnterpriseConfigEdit')}">系统皮肤设置</a></li>
                {/if}
                {if Manager::checkAccess('GetModifyPassword')}
                    <li class="no-sub"><a href="{route('GetModifyPassword')}">修改密码</a></li>
                {/if}
            </ul>
        </li>
    {/if}

    {if Manager::checkAccess('GoodsManageModule')}
        <li class="has-sub">
            <a href="javascript:;"><span class="icon-box"> <i class="icon-shopping-cart"></i></span> 商品管理 <span class="arrow"></span></a>
            <ul class="has-sub-menu">
                {if Manager::checkAccess('GoodsSetup')}
                    <li class="has-sub"> <a href="javascript:;" class="">商品设置<span class="arrow"></span></a>
                        <ul class="sub">
                            {if Manager::checkAccess('GoodsCategoryList')}
                                <li><a href="{route('GoodsCategoryList')}">商品分类</a></li>
                            {/if}
                            {if Manager::checkAccess('GetGoodsTypeList')}
                                <li><a href="{route('GetGoodsTypeList')}">商品类目</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}
                {if Manager::checkAccess('EnterpriseGoodsEdit')}
                    <li class="no-sub"><a href="{route('EnterpriseGoodsEdit')}">添加商品</a></li>
                {/if}
                {if Manager::checkAccess('GetSaleEnterpriseGoodsList')}
                    <li class="no-sub"><a href="{route('GetSaleEnterpriseGoodsList')}">上架商品</a></li>
                {/if}
                {if Manager::checkAccess('GetRepertoryEnterpriseGoodsList')}
                    <li class="no-sub"><a href="{route('GetRepertoryEnterpriseGoodsList')}">仓库商品</a></li>
                {/if}
            </ul>
        </li>
    {/if}
    {if Manager::checkAccess('OrderManageModule')}
        <li class="has-sub">
            <a href="javascript:;"><span class="icon-box"><i class="icon-qrcode"></i></span> 订单管理 <span class="arrow"></span></a>
            <ul class="sub">
                {if Manager::checkAccess('OrderList')}
                    <li><a href="{route('OrderList')}">订单列表</a></li>
                    <li><a href="{route('WaitForShipmentOrderList',['status'=>Order::STATUS_PREPARING_FOR_SHIPMENT])}">发货订单</a></li>
                {/if}
                <li><a href="{route('RefundManage')}">退款/退货列表</a> </li>
            </ul>
        </li>
    {/if}
    {*{if Manager::checkAccess('ActivityManageModule')}
        <li class="has-sub">
            <a href="javascript:;"><span class="icon-box"><i class="icon-gift"></i></span> 活动管理 <span class="arrow"></span></a>
            <ul class="sub">
                {if Manager::checkAccess('ActivityList')}
                    <li><a href="{route('ActivityList',['body_type'=>'InnerPurchase'])}">内购活动</a></li>
                {/if}
                {if Manager::checkAccess('ActivityList')}
                    *}{*<li><a href="{route('ActivityList',['body_type'=>'Presell'])}">预售活动</a></li>*}{*
                {/if}
                {if Manager::checkAccess('GetAdvertiseSpaceList')}
                    <li><a href="{route('GetAdvertiseSpaceList')}">广告管理</a></li>
                {/if}
            </ul>
        </li>
    {/if}*}
    {*{if Manager::checkAccess('TaskManageModule')}
        <li class="has-sub">
            <a href="javascript:;"><span class="icon-box"><i class="icon-tasks"></i></span> 任务管理 <span class="arrow"></span></a>
            <ul class="sub">
                {if Manager::checkAccess('TaskList')}
                    <li><a href="{route('TaskList')}">任务设置</a></li>
                {/if}
            </ul>
        </li>
    {/if}*}
    {if Manager::checkAccess('VstoreManageModule')}
        <li class="has-sub">
            <a href="javascript:;"><span class="icon-box"><i class="icon-inbox"></i></span> 指店管理 <span class="arrow"></span></a>
            <ul class="sub">
                {if Manager::checkAccess('VstoreList')}
                    <li><a href="{route('VstoreList')}">指店列表</a></li>
                    <li><a href="{route('WaitAuditVstoreList',['status'=>Vstore::STATUS_ENTERPRISE_AUDITING])}">待审核指店</a></li>
                {/if}
                {if Manager::checkAccess('VstoreLevelManage')}
                <li><a href="{route('VstoreLevelManage')}">指店等级设置</a> </li>
                {/if}
            </ul>
        </li>
    {/if}
    {if Manager::checkAccess('AnalysisManageModule')}
        <li class="has-sub">
            <a href="javascript:;"><span class="icon-box"><i class="icon-bar-chart"></i></span> 统计分析 <span class="arrow"></span></a>
            <ul class="sub">
                {if Manager::checkAccess('ReportOrderList')}
                    <li><a href="{route('ReportOrderList')}">销售概况</a></li>
                    {*<li><a href="javascript:ialert('您的权限不够，请联系超级管理员！');">销售概况</a></li>*}
                {/if}
                {if Manager::checkAccess('ReportMemberList')}
                    <li><a href="{route('ReportMemberList')}">用户统计</a></li>
                    {*<li><a href="javascript:ialert('您的权限不够，请联系超级管理员！');">用户统计</a></li>*}
                {/if}
                {if Manager::checkAccess('ReportVstoreList')}
                    <li><a href="{route('ReportVstoreList')}">指店统计</a></li>
                    {*<li><a href="javascript:ialert('您的权限不够，请联系超级管理员！');">指店统计</a></li>*}
                {/if}
            </ul>
        </li>
    {/if}
    {if Manager::checkAccess('ReportManageModule')}
        <li class="has-sub">
            <a href="javascript:;"><span class="icon-box"><i class="icon-money"></i></span> 财务报表 <span class="arrow"></span></a>
            <ul class="sub">
                {if Manager::checkAccess('ReportBrokerageList')}
                    <li><a href="{route('ReportBrokerageList')}">佣金报表</a></li>
                {/if}
                {if Manager::checkAccess('ReportStoreBrokerageList')}
                    <li><a href="{route('ReportStoreBrokerageList')}">货款报表</a></li>
                {/if}
            </ul>
        </li>
    {/if}
</ul>