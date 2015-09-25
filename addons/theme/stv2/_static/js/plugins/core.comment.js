/**
 * 扩展核心评论对象
 * @author jason <yangjs17@yeah.net>
 * @version TS3.0
 */
core.comment = {
	// 给工厂调用的接口
	_init:function(attrs) {
		if(attrs.length == 3) {
			core.comment.init(attrs[1], attrs[2]);
		} else {
			return false;
		}
	},
	// 初始化评论对象
	init: function(attrs, commentListObj) {
		// 这些参数必须传入
		this.app_uid = attrs.app_uid,
		this.row_id  = attrs.row_id,
		this.to_comment_id = attrs.to_comment_id,
		this.to_uid = attrs.to_uid;
		this.app_row_id = attrs.app_row_id;//原文ID
		this.app_row_table = attrs.app_row_table;
		this.addToEnd = "undefined" == typeof(attrs.addToEnd) ? 0 : attrs.addToEnd;
		this.canrepost = "undefined" == typeof(attrs.canrepost) ? 1 : attrs.canrepost;
		this.cancomment = "undefined" == typeof(attrs.cancomment) ?  1 : attrs.cancomment;
		this.cancomment_old = "undefined" == typeof(attrs.cancomment_old) ?  1 : attrs.cancomment_old;
		if("undefined" != typeof(attrs.app_name)) {
			this.app_name = attrs.app_name;
		} else {
			this.app_name = "public";	//默认应用
		}
		if("undefined" != typeof(attrs.table)) {
			this.table = attrs.table;
		} else {
			this.table = 'feed';	//默认表
		}
		if("undefined" != typeof(attrs.to_comment_uname)) {
			this.to_comment_uname = attrs.to_comment_uname;
		}
		if("undefined" != typeof(commentListObj)) {
			this.commentListObj = commentListObj;
		}
		if("undefined" != typeof(attrs.app_detail_summary)) {
			this.app_detail_summary = attrs.app_detail_summary;
		}		
	},
	// 显示回复块
	display: function() {	
		var commentListObj = this.commentListObj;
		if("undefined" == typeof this.table) {
			this.table = 'feed';
		}
		if(commentListObj.style.display == 'none') {
			if(commentListObj.innerHTML !=''){
				commentListObj.style.display = 'block';
			}else{
				var rowid = this.row_id;
				var appname = this.app_name;
				var table = this.table;
				var cancomment = this.cancomment;
				commentListObj.style.display = 'block';
				commentListObj.innerHTML = '<img src="'+THEME_URL+'/image/load.gif" style="text-align:center;display:block;margin:0 auto;"/>';
				$.post(U('widget/Comment/render'),{app_uid:this.app_uid,row_id:this.row_id,app_row_id:this.app_row_id,app_row_table:this.app_row_table,isAjax:1,showlist:0,
						cancomment:this.cancomment,cancomment_old:this.cancomment_old,app_name:this.app_name,table:this.table,
						canrepost:this.canrepost },function(html){
							if(html.status =='0'){
								commentListObj.style.display = 'none';
								ui.error(html.data)
							}else{
								commentListObj.innerHTML = html.data;
								$('#commentlist_'+rowid).html('<img src="'+THEME_URL+'/image/load.gif" style="text-align:center;display:block;margin:0 auto;"/>');
								$.post(U('widget/Comment/getCommentList'),{app_name:appname,table:table,row_id:rowid,cancomment:cancomment},function (res){
									$('#commentlist_'+rowid).html(res);
									M($('#commentlist_'+rowid).get(0));
								});
								M(commentListObj);
								//@评论框
								atWho($(commentListObj).find('textarea'));
								$(commentListObj).find('textarea').focus();
							}
				},'json');
			}
		}else{
			commentListObj.style.display = 'none';
		}
	},
	// 初始化回复操作
	initReply: function() {	
		this.comment_textarea = this.commentListObj.childModels['comment_textarea'][0];
		var mini_editor = this.comment_textarea.childModels['mini_editor'][0];
		var _textarea = $(mini_editor).find('textarea');
		var html = L('PUBLIC_RESAVE')+'@'+this.to_comment_uname+' ：';			
		//_textarea.focus();
		_textarea.val(html);
		_textarea.focus();
	},
	// 发表评论
	addComment:function(afterComment,obj) {
		var commentListObj = this.commentListObj;
		this.comment_textarea = commentListObj.childModels['comment_textarea'][0];
		var mini_editor = this.comment_textarea.childModels['mini_editor'][0];
		var _textarea = $(mini_editor).find('textarea').get(0);
		var strlen = core.getLength(_textarea.value);
		var leftnums = initNums - strlen;
		if(leftnums < 0 || leftnums == initNums) {
			flashTextarea(_textarea);
			return false;
		}
		
		// 如果转发到自己的微博
		if(this.canrepost == 1){
			var ischecked = $(this.comment_textarea).find("input[name='shareFeed']").get(0).checked;
			if(ischecked == true) {
				var ifShareFeed = 1;
			} else {
				var ifShareFeed = 0;
			}
		}else{
			var ifShareFeed = 0;
		}
		var isold = $(this.comment_textarea).find("input[name='comment']");
		var comment_old = 0;
		if( isold.get(0) != undefined) {
			if ( isold.get(0).checked == true  ){
				var comment_old = 1;
			}
		}
		var content = _textarea.value;	
		if(content == '') {
			ui.error(L('PUBLIC_CONCENT_TIPES'));
		}
		if("undefined" != typeof(this.addComment) && (this.addComment == true)) {
			return false;	//不要重复评论
		}
		var addcomment = this.addComment;
		var addToEnd = this.addToEnd;

		var _this = this;
		obj.innerHTML = '回复中..';
		$.post(U('widget/Comment/addcomment'),{
			app_name:this.app_name,
			table_name:this.table,
			app_uid:this.app_uid,
			row_id:this.row_id,
			to_comment_id:this.to_comment_id,
			to_uid:this.to_uid,
			app_row_id:this.app_row_id,
			app_row_table:this.app_row_table,
			content:content,
			ifShareFeed:ifShareFeed,
			comment_old:comment_old,
			app_detail_summary:$("#app_detail_summary").val(),
			app_detail_url:document.location.href
			},function(msg){
				if ( obj != undefined ){
					obj.innerHTML = '回复';
				}
				//alert(msg);return false;
				if(msg.status == "0"){
					ui.error(msg.data);
				}else{
					if("undefined" != typeof(commentListObj.childModels['comment_list']) ){
						if(addToEnd == 1){
							$(commentListObj).find(' .comment_lists').eq(0).prepend(msg.data);
						}else{
							if(_this.table == 'event') {
								$('.member_user img[data-id='+MID+']').click();
								/*
								var nowDate = new Date();
								var nowYear = nowDate.getFullYear();
								var nowMonth = parseInt(nowDate.getMonth()) + 1;
								var nowDay = nowDate.getDate();
								if($('#T'+nowYear+nowMonth+nowDay).length > 0 ) {
									$(msg.data).insertBefore($(commentListObj.childModels['comment_list'][0]));
								} else {
									var zbq_event_comment = '<div class="clearfix" id="T'+nowYear+nowMonth+nowDay+'"><div class="responses-left"><p class="clearfix"><span>'+nowYear+'-'+nowMonth+'</span><b>'+nowDay+'</b></p></div><div class="responses-right">'+msg.data+'</div></div>';
									var old_zbq_event_comment = $('#commentlist_'+_this.row_id).html();
									$('#commentlist_'+_this.row_id).html(zbq_event_comment + old_zbq_event_comment);
								}
								*/
							} else {
								$(msg.data).insertBefore($(commentListObj.childModels['comment_list'][0]));
							}							
						}
					}else{
						if(_this.table == 'event') {
							var nowDate = new Date();
							var nowYear = nowDate.getFullYear();
							var nowMonth = parseInt(nowDate.getMonth()) + 1;
							var nowDay = nowDate.getDate();
							if($('#T'+nowYear+nowMonth+nowDay).length > 0 ) {
								$(commentListObj).find('.comment_lists').eq(0).html(msg.data);
							} else {
								var zbq_event_comment = '<div class="clearfix" id="T'+nowYear+nowMonth+nowDay+'"><div class="responses-left col-xs-2"><p class="clearfix"><span>'+nowYear+'-'+nowMonth+'</span><b>'+nowDay+'</b></p></div><div class="responses-right col-xs-10">'+msg.data+'</div></div>';
								var old_zbq_event_comment = $('#commentlist_'+_this.row_id).html();
								$('#commentlist_'+_this.row_id).html(zbq_event_comment + old_zbq_event_comment);
							}
						} else {
							$(commentListObj).find('.comment_lists').eq(0).html(msg.data);
						}						
					}
					M(commentListObj);
					//重置
					_textarea.value = '';
					_this.to_comment_id = 0;
					_this.to_uid = 0;
					if("function" == typeof(afterComment)){
						afterComment();
					}
					// 动态添加字数
					var commentDom = $('#feed'+core.comment.row_id).find('a[event-node="comment"]');
					var oldHtml = commentDom.html();
					if (oldHtml != null) {
						var commentVal = oldHtml.replace(/\(\d+\)$/, function (num) {
							num = '(' + (parseInt(num.slice(1, -1)) + 1) + ')';
							return num;
						});
						if (oldHtml === commentVal) {
							commentVal += '(1)';
						}
						commentDom.html(commentVal);
					}
				}
				addComment = false;
			//});
			},'json');
	},
	delComment:function(comment_id){
		$.post(U('widget/Comment/delcomment'),{comment_id:comment_id},function(msg){
			// 动态添加字数
			var commentDom = $('#feed'+core.comment.row_id).find('a[event-node="comment"]');
			var oldHtml = commentDom.html();
			if (oldHtml != null) {
				var commentVal = oldHtml.replace(/\(\d+\)$/, function (num) {
					var cnum = parseInt(num.slice(1, -1)) - 1;
					if (cnum <= 0) {
						return '';
					}
					num = '(' + cnum + ')';
					return num;
				});
				commentDom.html(commentVal);
			}
		});
	}
};
