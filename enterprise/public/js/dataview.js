/**
 * 分页列表
 */
function DataView(opt){
	"use strict";

	opt = $.extend({
		dataTemplate		: 'DataViewTemplate',
		dataContainer		: 'DataView',
		paginationContainer	: 'Pagination',
		params				: {},
		autoAnchor			: true
	}, opt || {});

	if(typeof opt['dataUrl'] == 'undefined' || typeof opt['counterUrl'] == 'undefined'){
		throw new Error('必须提供dataUrl与counterUrl参数。');
	}

	var _this = this, page = 1, limit = 10, total_count = 0, total_page = 0;
	var xhr_count = null, xhr_data = null;

	_this.setParam = function(key, value){
		opt.params[key] = value;
		return _this;
	};
	
	_this.setParams = function(value){
		opt.params = value;
		return _this;
	};
	
	_this.getParams = function(){
		var data = {};
		for( var k in opt.params){
			if(opt.params[k] !== '' && opt.params[k] !== null){
				data[k] = opt.params[k];
			}
		}
		return data;
	};
	
	_this.setLImit = function(value){
		limit = value;
		if(limit > 200) limit = 200;
		else if(limit < 1) limit = 1;
		return _this;
	};
	
	var counter = function(success){
		xhr_count = $.get(opt.counterUrl, _this.getParams(), function(count){
			total_count = parseInt(count);
			if(isNaN(total_count) || total_count < 1) total_count = 1;
			total_page = Math.ceil(total_count / limit);
			success.call(_this, total_count);
		});
	};
	
	var refresh_pagination = function(){
		$('#' + opt.paginationContainer).empty();
		if(total_page > 1){
			var pagination = '<div class="pagination pagination-right"><ul>';
			pagination += '<li class="' + (page == 1 ? 'disabled' : '') + '"><a href="#" class="prev">«</a></li>';
			for(var i = 1; i <= total_page; i++){
				pagination += '<li class="' + (i == page ? 'active' : '') + '"><a href="#" class="page">' + i + '</a></li>';
			}
			pagination += '<li class="' + (page == total_page ? 'disabled' : '') + '"><a href="#" class="next">»</a></li>';
			pagination += '</ul></div>';
			$('#' + opt.paginationContainer).html(pagination);
			$('#' + opt.paginationContainer).find('.prev').on('click', function(e){
				e.preventDefault();
				_this.prev();
			});
			$('#' + opt.paginationContainer).find('.next').on('click', function(e){
				e.preventDefault();
				_this.next();
			});
			$('#' + opt.paginationContainer).find('.page').on('click', function(e){
				e.preventDefault();
				_this.load($(this).text(), false);
			});
		}
	};
	
	var loadpage = function(p){
		page = parseInt(p);
		if(isNaN(page) || page < 1) page = 1;
		if(page > 200) page = 200;
		if(page > total_page) page = total_page;
		if(opt.autoAnchor) location.hash = '/page=' + page;
		xhr_data = $.get(opt.dataUrl, $.extend({ page : page, limit : limit }, _this.getParams() || {}), function(data){
			$('#' + opt.dataContainer).html(template(opt.dataTemplate, data));
			refresh_pagination();
			event_dataloaded();
		});
	};
	
	var event_dataload = function(){
		$('#' + opt.dataContainer).trigger('dataload');
	};
	var event_dataloaded = function(){
		$('#' + opt.dataContainer).trigger('dataloaded');
	};
	
	_this.load = function(p, c){
		var t = location.hash.match(/\/page=(\d+)/i);
		if(typeof p == 'undefined') p = (opt.autoAnchor && t ? t[1] : 1);
		if(typeof c == 'undefined') c = true;
		event_dataload();
		if(xhr_count != null) xhr_count.abort();
		if(xhr_data != null) xhr_data.abort();
		if(c){
			counter(function(){
				loadpage(p);
			});
		}else{
			loadpage(p);
		}
	};
	
	_this.reload = function(){
		_this.load(page);
	};
	
	_this.prev = function(){
		if(page > 1){
			_this.load(page - 1, false);
		}
	};
	
	_this.next = function(){
		if(page < total_page){
			_this.load(page + 1, false);
		}
	};
}