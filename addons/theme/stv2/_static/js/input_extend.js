// JavaScript Document
(function($){
	$.fn.extend({
		"changeTips":function(value){
			value = $.extend({
				divTip:"",
				url : "",
			},value)
			
			var $this = $(this);
			var indexLi = 0;
			var timer = null;

			//点击document隐藏下拉层
			$(document).click(function(event){
				blus();
			})
			
			//隐藏下拉层
			function blus(){
				$(value.divTip).hide();
			}
			
			//键盘上下执行的函数
			function keychang(up){
				if(up == "up"){
					if(indexLi == 0){
						indexLi = $(value.divTip).children().length-1;
					}else{
						indexLi--;
					}
				}else{
					if(indexLi ==  $(value.divTip).children().length-1){
						indexLi = 0;
					}else{
						indexLi++;
					}
				}
				$(value.divTip).children().eq(indexLi).addClass("active").siblings().removeClass();	
			}
			
			//值发生改变时
			function valChange(){
				var tex = $this.val();//输入框的值
				var fronts = "";//存放含有“@”之前的字符串
				var af = /@/;
				var regMail = new RegExp(tex.substring(tex.indexOf("@")));//有“@”之后的字符串,注意正则字面量方法，是不能用变量的。所以这里用的是new方式。


				//让提示层显示，并对里面的LI遍历
				if(tex==""){
					blus();
				}else{
					$.post(value.url, {text : tex}, function(data){
						if(data){
							$(value.divTip).html(data).show()
						}else {
							$(value.divTip).html('').hide()
						}
					} ,'html');
				}	
			}
			
			function callback () {
			    valChange();
			}
			function onSecondDelay(callback) {
			    clearTimeout(timer);
			    timer = setTimeout(callback, 300);
			}
			
			//输入框值发生改变的时候执行函数，这里的事件用判断处理浏览器兼容性;
			if($.support.msie){
				$(this).bind("propertychange",function(){
					onSecondDelay(callback);
				})
			}else{
				$(this).bind("input",function(){
					onSecondDelay(callback);
				})
			}
			

			//鼠标点击和悬停LI
			$(value.divTip).children().
			hover(function(){
				indexLi = $(this).index();//获取当前鼠标悬停时的LI索引值;
				if($(this).index()!=0){
					$(this).addClass("active").siblings().removeClass();
				}	
			})
					
		
			//按键盘的上下移动LI的背景色
			$this.keydown(function(event){
				if(event.which == 38){//向上
					keychang("up")
				}else if(event.which == 40){//向下
					keychang()
				}else if(event.which == 13){ //回车
					var liVal = $(value.divTip).children().eq(indexLi).text();
					$this.val(liVal);
					blus();
				}
			})				
		}	
	})	
})(jQuery)