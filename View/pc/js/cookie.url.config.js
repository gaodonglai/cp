/*
* cookie url 等js配置函数
* v1.0
* ijitao
* 2016/3/11 11：53
* */
/*调用方法
$.n('');
*/
/*$.alerts*/
function Alert(msg){
	this.msg=msg
}
Alert.prototype={
	constructor:Alert,
	alertInfo:function(){
		var html="<div class='addAlert'></div>";
		if(jQuery(".addAlert").length<1){
			jQuery("body").append(html)
		}
		jQuery(".addAlert").css({
			"position":"fixed",
			"top":"50%",
			"left":"50%",
			"padding":"10px 20px",
			"width":"200px",
			"border-radius":"5px",
			"font-size":"13px",
			"color":"#fff",
			"background-color":"rgba(0, 0, 0, 0.79)",
			"text-align":"center",
			"line-height":"1.5em",
			"margin-top":"-60px",
			"margin-left":"-100px",
			"display":"none",
			"z-index":"9999"
		}).text(this.msg)
			.stop(true)
			.fadeIn(300)
			.delay(500)
			.fadeOut(1000);
	}
};
	jQuery.extend({
		alerts:function(msg){
			var alerts=new Alert(msg);
			alerts.alertInfo()
		},
		/*设置cookie*/
		SetCookie: function (name,value,days) {
			var exp=new Date();
			if(!days){
				days=30
				}
			exp.setTime(exp.getTime()+days*60*1000);
			document.cookie=name+"="+escape(value)+";expires="+exp.toGMTString()+";path="+window.location.pathname+""
		},
		/*获取cookie*/
		GetCookie: function(name){
			var arr,
				reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
			if(arr=document.cookie.match(reg))
				return unescape(arr[2]);
			else
				return null
		},
		DelCookie: function(name){
			var exp=new Date();
			exp.setTime(exp.getTime()-1);
			var cval=getCookie(name);
			if(cval!=null)
				document.cookie=name+"="+cval+";expires="+exp.toGMTString()+";path="+window.location.pathname+""
		},
		/*获取URL参数*/
		Request: function (m) {
			var sValue = location.search.match(new RegExp("[\?\&]" + m + "=([^\&]*)(\&?)", "i"));
			return sValue ? sValue[1] : sValue;
		},
		/*更新URL参数*/
		UrlUpdateParams: function (url, name, value) {
			var r = url;
			if (r != null && r != 'undefined' && r != "") {
				value = encodeURIComponent(value);
				var reg = new RegExp("(^|)" + name + "=([^&]*)(|$)");
				var tmp = name + "=" + value;
				if (url.match(reg) != null) {
					r = url.replace(eval(reg), tmp);
				}
				else {
					if (url.match("[\?]")) {
						r = url + "&" + tmp;
					} else {
						r = url + "?" + tmp;
					}
				}
			}
			return r;
		},
		/*删除URL参数*/
		DelParams: function (url, ref) //删除参数值
		{
		var str = "";
	
		if (url.indexOf('?') != -1)
			str = url.substr(url.indexOf('?') + 1);
		else
			return url;
		var arr = "";
		var returnurl = "";
		var setparam = "";
		if (str.indexOf('&') != -1) {
			arr = str.split('&');
			for (i in arr) {
				if (arr[i].split('=')[0] != ref) {
					returnurl = returnurl + arr[i].split('=')[0] + "=" + arr[i].split('=')[1] + "&";
				}
			}
			return url.substr(0, url.indexOf('?')) + "?" + returnurl.substr(0, returnurl.length - 1);
		}
		else {
			arr = str.split('=');
			if (arr[0] == ref)
				return url.substr(0, url.indexOf('?'));
			else
				return url;
		}
	},
	/*倒计时*/
	_nTime: function(){
		var mydate = new Date();
	    var code = jQuery.GetCookie('code');
	    if(code != null){
	        var code = code.split(',');
	        var _this_gettime = mydate.getTime();
	        var nTime = _this_gettime-code[1];
	        var day = nTime / 1000;
	        var _return = Math.floor(code[0]-day);
	        if(_return>0){
	            return _return;
	        }else{
	            return false;
	        }
	    }
	},
	InterValObjFn: function(t,type,fn){
		var mydate = new Date();
		_gettime = mydate.getTime();
		jQuery.SetCookie('code','120,'+_gettime,'1');

	    var InterValObj; //timer变量，控制时间
	    if(jQuery._nTime()){
	        var curCount = jQuery._nTime();
	        if(type == 'html'){
	            t.addClass('display').html( '<b>'+ curCount + "</b> 秒后再获取");
	        }else{
	            t.val(curCount + "秒后再获取");
	            t.attr("disabled","true")
	        }
	    }else{
	        var curCount = 120; //间隔函数，1秒执行
	    }
	    //var curCount;//当前剩余秒数
	    InterValObj = window.setInterval(function(){
	        if (curCount == 0) {
	            t.one('click',fn);
	            window.clearInterval(InterValObj);//停止计时器
	            if(type == 'html'){
	                t.removeClass('display').html("重新获取");
	            }else{
	                t.val("重新获取");
	                t.removeAttr("disabled");//启用按钮
	            }
	        }
	        else {
	            curCount--;
	            if(type == 'html'){
	                t.addClass('display').html( '<b>'+ curCount + "</b> 秒后再获取");
	            }else{
	                t.val(curCount + "秒后再获取");
	                t.attr("disabled","true")
	            }
	        }
	    }, 1000);
	}
  });