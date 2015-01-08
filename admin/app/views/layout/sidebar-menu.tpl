<ul class="sidebar-menu">
	<li class="has-sub">
		<a href="javascript:;"><span class="icon-box"> <i class="icon-dashboard"></i></span> 企业管理 <span class="arrow"></span></a>
		<ul class="sub">
			<li><a href="{route('GetEnterpriseList')}">企业列表</a></li>
			<li><a href="{route('EditEnterprise')}">新增企业</a></li>
		</ul>
	</li>
	
	<li class="has-sub">
		<a href="javascript:;"><span class="icon-box"> <i class="icon-dashboard"></i></span> 会员管理 <span class="arrow"></span></a>
		<ul class="sub">
			<li><a href="{route('MemberList')}">会员列表</a></li>
			<li><a href="{route('RealNameList')}">实名审核</a></li>
			<li><a href="{route('SuggestionList')}">会员反馈列表</a></li>
		</ul>
	</li>
	<li class="has-sub">
		<a href="javascript:;"><span class="icon-box"> <i class="icon-dashboard"></i></span> 商品管理 <span class="arrow"></span></a>
		<ul class="sub">
			<li><a href="{route('GetGoodsTypeList')}">商品类目</a></li>
		</ul>
	</li>
	<li class="has-sub">
		<a href="javascript:;"><span class="icon-box"> <i class="icon-dashboard"></i></span> 账户管理 <span class="arrow"></span></a>
		<ul class="sub">
			<li><a href="{route('GetBankList')}">银行列表</a></li>
            <li><a href="{route('EditAccountInfo')}">账户信息</a> </li>
		</ul>
	</li>
	<li class="has-sub">
		<a href="javascript:;"><span class="icon-box"> <i class="icon-dashboard"></i></span> 权限管理 <span class="arrow"></span></a>
		<ul class="sub">
			<li><a href="{route('GetPurviewList')}">权限列表</a></li>
		</ul>
	</li>
</ul>