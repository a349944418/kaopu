$(function(){

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
function showquiz(URL){
  $('#comModal .modal-header').css({'background':'#FC5241','padding':'8px 15px'});
  $('#comModal .modal-title').html('提问').css({'text-align':'center','color':'white'});
  $.post(URL,{}, function(data){
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