
function ialert(msg) {
    var func = arguments[1];
    $('#alertModal').find('.modal-body p').text(msg).end().one('hidden.bs.modal', function(){
        if (typeof func == 'function') {
            func.call(this);
        }
    }).modal();
}

$.ajaxSetup({
    error		: function(xhr) {
    	switch(xhr.status){
    		case 400: location.reload(); break;
    		case 401: location.href = '/login'; break; // {route('Login')}
    		case 402: ialert(xhr.responseText); break;
    		case 403: ialert('没有权限！'); break;
    		case 410: // 请求的接口已废弃。
    		case 500:
    			try{
    				var error = eval('(' + xhr.responseText + ').error;');
    				console.debug('ErrorType: ' + error.type + '\nErrorMessage: ' + error.message + '\nErrorFile: ' + error.file + '\nErrorLine: ' + error.line);
    			}catch(e){}
				ialert('服务器好像出了点小小的问题，请稍后再试。');
				break;
    	}
    }
});

// 保留两位小数
// 功能：将浮点数四舍五入，取小数点后2位。
function toDecimal(x) {  
    var f = parseFloat(x);  
    if (isNaN(f)) {
        return 0;
    }
    f = Math.round(x*100)/100;
    return f;
}

// 强制保留2位小数，如：2，会在2后面补上00.即2.00
function toDecimal2(x) {
    var f = parseFloat(x);
    if (isNaN(f)) {
        return '0.00';
    }
    var f = Math.round(x*100)/100;
    var s = f.toString();
    var rs = s.indexOf('.');
    if (rs < 0) {
        rs = s.length;
        s += '.';
    }
    while (s.length <= rs + 2) {
        s += '0';
    }
    return s;  
}



