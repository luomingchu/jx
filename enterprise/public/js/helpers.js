
template.helper('time', function (datetime) {
    var time = (typeof datetime == 'number' ? time : datetime.replace(/\-/g,'/')),
		now = new Date(),
		date = new Date(time),
		d = date.getDate(),
		m = date.getMonth();
	if(now - date < 60000){
		return  "刚刚";
	}else if(now - date <3600000){
		return "" + Math.ceil((now - date)/60000) + "分钟前";
	}else if(now - date <86400000){
		return "" +  Math.ceil((now - date)/3600000) + "小时前";
	}else{
		return "" + (m + 1) + "月" + d + "日";
	}
});

template.helper('default', function (data, value) {
    return typeof data == 'undefined' || data === '' || data === null ? value : data;
});


/**
 * 对日期进行格式化，
 * @param date 要格式化的日期
 * @param format 进行格式化的模式字符串
 *     支持的模式字母有：
 *     Y:年,
 *     m:年中的月份(1-12),
 *     d:月份中的天(1-31),
 *     H:小时(0-23),
 *     i:分(0-59),
 *     s:秒(0-59),
 *     w:星期
 * @return String
 */
template.helper('dateFormat', function (date, format) {

    var date = typeof date == 'number' ? date : date.replace(/\-/g,'/');
    date = new Date(date);

    var map = {
        "Y": date.getFullYear(), //年
        "m": date.getMonth() + 1, //月份
        "d": date.getDate(), //日
        "H": date.getHours(), //小时
        "i": date.getMinutes(), //分
        "s": date.getSeconds(), //秒
        "w": date.getDay() //星期
    };
    var week_map = {"0":'星期天',"1":'星期一',"2":'星期二',"3":'星期三',"4":'星期四',"5":'星期五',"6":'星期六'};

    format = format.replace(/([YmdHisw])+/g, function(all, t){
        var v = map[t];
        if(v !== undefined) {
            if (t === 'w') {
                return week_map[v];
            }
            return v;
        }
        return all;
    });
    return format;
});


/**
 * 对时间进行格式化，
 * @param date 要格式化的时间
 * @param format 进行格式化的模式字符串
 *     支持的模式字母有：
 *     h:小时(0-23),
 *     i:分(0-59),
 *     s:秒(0-59),
 * @return String
 */
template.helper('timeFormat', function (date, format) {

    var dataArr = date.split(':');
    var map = {
        'h' : dataArr[0],
        'i' : dataArr[1],
        's' : dataArr[2]
    }

    format = format.replace(/([his])+/g, function(all, t){
        var v = map[t];
        if(v !== undefined) {
            return v;
        }
        return all;
    });
    return format;
});

/**
 * 显示星期
 * @return String
 */
template.helper('weekFormat', function (week) {

    var week_map = {"0":'星期天',"1":'星期一',"2":'星期二',"3":'星期三',"4":'星期四',"5":'星期五',"6":'星期六'};

    return week_map[week];
});