// 智能浮动
$.fn.smartFloat = function() {
    var position = function(element) {
        var top = element.position().top, pos = element.css("position");
        $(window).scroll(function() {
            var scrolls = $(this).scrollTop();
            if (scrolls > top) {
                if (window.XMLHttpRequest) {
                    element.css({
                        position: "fixed",
                        top: 0
                    });
                } else {
                    element.css({
                        top: scrolls
                    });
                }
            }else {
                element.css({
                    position: "absolute",
                    top: top
                });
            }
        });
    };
    return $(this).each(function() {
        position($(this));
    });
};

$(function(){
  //选择学校
  $('#comModal').on('show.bs.modal', function (e) {
      var button = $(e.relatedTarget);
      var type = button.data('whatever');
      var modal = $(this);
      if(type == 'register'){
          $('.modal-dialog').addClass('modal-sm');
          $.post(U("public/Register/ajaxReg"),{},function(data){
            modal.find('.modal-body').html(data);
          },'html');
          modal.find('.modal-title').text('感谢您的注册');
        } else if(type == 'middle_school') {
          $('.modal-dialog').addClass('modal-lg');
          $.post(U("public/Register/ajaxSchool"),{t:'middle', id: '110000'},function(data){
            modal.find('.modal-body').html(data);
          },'html');
          modal.find('.modal-title').text('选择学校');
      } else if(type == 'high_school') {
          $('.modal-dialog').addClass('modal-lg');
          $.post(U("public/Register/ajaxSchool"),{t:'high', id: '110000'},function(data){
            modal.find('.modal-body').html(data);
          },'html');
          modal.find('.modal-title').text('选择高中');
      } else if(type == 'university_school') {
          $('.modal-dialog').addClass('modal-lg');
          $.post(U("public/Register/ajaxSchool"),{t:'university', id:1},function(data){
            modal.find('.modal-body').html(data);
          },'html');
          modal.find('.modal-title').text('选择大学');
      }
  })
  //性别选择
  $('.nan').click(function(){
      $(this).addClass('sexselect');
      $('.nv').removeClass('sexselect');
      $('input[name=sex]').val('1');
      return false;
  })
  $('.nv').click(function(){
      $(this).addClass('sexselect');
      $('.nan').removeClass('sexselect');
      $('input[name=sex]').val('2');
      return false;
  })
  //获取评论
  $('.comment_btns').click(function(){
    var count = $(this).children('span').html();
    if(count > 0){
      var attrs = M.getEventArgs(this);
      if($('#comment_detail_'+attrs.row_id).css('display') == 'block'){
        $('#comment_detail_'+attrs.row_id).hide();
      } else {
        if($('#comment_detail_'+attrs.row_id).html().length > 0){
          $('#comment_detail_'+attrs.row_id).show();
        }else{
          $.post(U('weiba/Index/getCommentList'),attrs,function(data){
            $('#comment_detail_'+attrs.row_id).html(data);
            $('#comment_detail_'+attrs.row_id).show();
          },'html')
        }         
      }       
    }     
  })

  /**
   * [删除文章]
   */
  $('.post_del').click(function(){
    var attrs = M.getEventArgs(this);
    var _this = this;
    if(confirm('确定删除么？')){
      $.post(U('weiba/Index/postDel'),{post_id:attrs.post_id,log:attrs.log},function(res){
        if(res == 1){
          ui.success('删除成功');
          location.href=U('weiba/Index/index');
        }else{
          alert('删除失败');
        }
      });
    }   
  })
})

/**
 * [发布问题]
 * @param  {[type]} URL [description]
 * @return {[type]}     [description]
 */
function showquiz(type, p){
  $('#comModal .modal-body').html('');
  if (typeof(ue) != 'undefined'){
      ue.destroy();
  }
  $('#comModal .modal-header').css({'background':'#FC5241','padding':'8px 15px'});
  var title = type == 1 ? '提问' : '分享';
  $('#comModal .modal-title').html(title).css({'text-align':'center','color':'white'});
  if($('.edui-editor').length){
    $('.edui-editor').css('z-index', 1);
  }
  $.post(U('weiba/Index/quickPost'),{t:type, p: p}, function(data){
    $('#comModal .modal-body').html(data);
    $('#comModal').modal({'backdrop':'static'});
  },'html');
}

/**
 * [关闭模态框]
 * @return {[type]} [description]
 */
function close_Modal(){
  $('#comModal .modal-body').html('');
  $('#comModal button.close').click();
}

/**
 * [删除问题评论]
 * @param  {[type]} options.$vo.comment_id [description]
 * @return {[type]}                        [description]
 */
function del_reply(id, pid){
  if(id){
    $.post(U('weiba/Index/del_reply'),{id:id,pid:pid},function(data){
      if(data.status == 1) {
        $('#question'+pid+'_reply_count').html($('#question'+pid+'_reply_count').html()-1);
        $('#comment_list_'+id).remove();
      }else{
        ui.error('操作失败');
      }
    },'json');
  }else {
    ui.error('操作失败');
  } 
}

/**
 * [关注微吧]
 * @param  {[type]} obj      [description]
 * @param  {[type]} weiba_id [description]
 * @param  {[type]} type     [description]
 * @return {[type]}          [description]
 */
function followWeibas(weiba_id, type) {
  var URL = type == 'do' ? U('weiba/Index/doFollowWeiba') : U('weiba/Index/unFollowWeiba');
  var html = type == 'do' ? '已关注' : ' + 关注';
  var untype = type == 'do' ? 'un' : 'do';
  $.post(URL,{weiba_id:weiba_id}, function(data){
    if(data.status){
      $('#follow'+weiba_id).html(html);
      $('#follow'+weiba_id).bind('click',function(){
        followWeibas(weiba_id, untype);
      })
    }
  },'json');
}

/**
 * [关闭右滑评论框]
 * @return {[type]} [description]
 */
function close_rightComment(){
  $('.rightComment').animate({'left':'1260px'});
  $('.rightComment').remove();
  $('.center1 .container').eq(0).animate({'min-width':'0px'});
  $('.center1 .col-md-3').eq(0).css({'display':'block'});
}

/**
 * [微吧评论点赞]
 * @return {[type]} [description]
 */
function click_zan(reply_id){
  $.post(U('weiba/Comment/click_zan'), {rid:reply_id}, function(data){
    if(data.status == 1){
      var zan_num = $('#reply_id'+reply_id+' span').html();
      zan_num = parseInt(zan_num) + 1;
      $('#reply_id'+reply_id+' span').html(zan_num);
    }else{
      ui.error(data.info);
    }
  },'json');
}

/**
 * [弹窗发布问题和分享]
 * @param  {[type]} ue [description]
 * @return {[type]}    [description]
 */
function weibaPost_submit_check(ue) {
        var txt = ue.getContent();
        txt = txt.replace(/\s+/g,"");
        if(txt.length < 1 || txt == '请填写详情') {         
            ue.focus();
            ue.setContent('请填写详情');
            return false;
        }

        var weiba_id = $('#weiba_id').val();
        if(weiba_id.length < 1) {
            $('#weiba_flag').attr('placeholder', '请选择标签').focus();
            return false;
        }

        var title = $('#title').val();
        if(title.length < 1) {
            $('#title').attr('placeholder', '请填写标题').focus();
            return false;
        }

        var type = $('#post_type').val();
        if(type == 2 && $('#post_reason').val().length<1){
            $('#post_reason').attr('placeholder', '请填写分享原因').focus();
            return false;
        }

        ue.getKfContent(function(content){
            $('#weibaPost').submit();
        })
    }