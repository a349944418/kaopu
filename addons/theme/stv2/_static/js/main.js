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
  //显示回到顶部框
  $(window).scroll(function(){
    var scrolls = $(this).scrollTop();
    if(scrolls > 200) {
      $('#topcontrol').css('display', 'block');
    } else {
      $('#topcontrol').css('display', 'none');
    }
  })

  //回复快捷
  $('.to_answer').click(function(){
    var h = $('.friend').offset().top;
    $('html,body').animate({'scrollTop':h+'px'});
  })

  //选择学校
  $('#comModal').on('show.bs.modal', function (e) {
      var button = $(e.relatedTarget);
      var type = button.data('whatever');
      var modal = $(this);
      if(type == 'register') {
          modal.find('.modal-title').text('欢迎您的注册');
          modal.find('.modal-content').css({'background':'#000', 'color':'#fff'})
          modal.find('.modal-body').html('<img src="'+THEME_URL+'/image/loading1.gif" style="display:block;width:75px;margin:30px auto;">');
          $('.close').css({'color':'#fff', 'opacity':'1', 'font-weight':'normal', 'font-size': '30px'});
          $('.close:hover').css({'color':'#fff'})
          $('.modal-dialog').addClass('modal-sm');
          $.post(U("public/Register/ajaxReg"),{},function(data){
              modal.find('.modal-body').html(data);
          },'html');
      } else if (type == 'login') {
          modal.find('.modal-title').text('登陆社区');
          modal.find('.modal-content').css({'background':'#000', 'color':'#fff'})
          modal.find('.modal-body').html('<img src="'+THEME_URL+'/image/loading1.gif" style="display:block;width:75px;margin:30px auto;">');
          $('.close').css({'color':'#fff', 'opacity':'1', 'font-weight':'normal', 'font-size': '30px'});
          $('.close:hover').css({'color':'#fff'})
          $('.modal-dialog').addClass('modal-sm');
          $.post(U("public/Passport/ajaxlogin"),{},function(data){
              modal.find('.modal-body').html(data);
          },'html');
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
    var attrs = M.getEventArgs(this);
    if($('#comment_detail_'+attrs.comment_id).css('display') == 'block'){
      $('#comment_detail_'+attrs.comment_id).hide();
    } else {
      if($('#comment_detail_'+attrs.comment_id).html()){
        $('#comment_detail_'+attrs.comment_id).show();
      }else{
        $.post(U('weiba/Comment/reply_commentList'),attrs,function(data){
          data = '<div class="arrow" style="left: 20%;top:-16px;border-width:8px;"></div>'+data;
          $('#comment_detail_'+attrs.comment_id).html(data);
          $('#comment_detail_'+attrs.comment_id).show();
        },'html')
      }         
    }     
  })


  //默认页面高度
  var windowh = $(window).height();
  $('.center1').css('min-height', (windowh-283)+'px');
  $('.center').css('min-height', (windowh-283)+'px'); 
  $('#main-wrap').css('min-height', (windowh-283)+'px');


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
function showquiz(type){
  $('#comModal .modal-header').css({'background':'#FC5241','padding':'8px 15px'});
  var title = type == 1 ? '提问' : '分享';
  $('#comModal .modal-title').html(title).css({'text-align':'center','color':'white'});
  if($('.edui-editor').length){
    $('.edui-editor').css('z-index', 1);
  }
  $.post(U('weiba/Index/quickPost'),{t:type}, function(data){
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
        $('#weiba_flag1').attr('placeholder', '请选择标签').focus();
        return false;
    }

    var title = $('#weiba_title').val();
    if(title.length < 1) {
        $('#weiba_title').attr('placeholder', '请填写标题').focus();
        return false;
    }

    var type = $('#post_type').val();
    if(type == 2 && $('#post_reason').val().length<1){
        $('#weiba_reason').attr('placeholder', '请填写分享原因').focus();
        return false;
    }

    ue.getKfContent(function(content){
        $('#weibaPost').submit();
    })
}

/**
 * [ 弹窗简单模式发布 ]
 * @return {[type]} [description]
 */
function weibaPost_simple_submit_check(){
    var txt = $('#wb_content').val();
    if(txt.length < 1 ) {         
        $('#wb_content').attr('placeholder', '请填写详情').focus();
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

    $('#weibaPost').submit();
}

// 检查手机号
function checkMobile(value) {
    if (!(/^1[3|4|5|7|8][0-9]\d{8}$/.test(value))) {
        return false;
    }
    return true;
}

// 检查身份证号
function checkIdcard(value, element, sexE, birthdayE) {
    value = trim(value);
    $(element).val(value);
    var area = {11: "北京", 12: "天津", 13: "河北", 14: "山西", 15: "内蒙古", 21: "辽宁", 22: "吉林", 23: "黑龙江", 31: "上海", 32: "江苏", 33: "浙江", 34: "安徽", 35: "福建", 36: "江西", 37: "山东", 41: "河南", 42: "湖北", 43: "湖南", 44: "广东", 45: "广西", 46: "海南", 50: "重庆", 51: "四川", 52: "贵州", 53: "云南", 54: "西藏", 61: "陕西", 62: "甘肃", 63: "青海", 64: "宁夏", 65: "xinjiang", 71: "台湾", 81: "香港", 82: "澳门", 91: "国外"};
    var idcard = value;
    var Y, JYM;
    var S, M;
    var sex_val;
    var idcard_array = new Array();
    idcard_array = idcard.split("");
    if (area[parseInt(idcard.substr(0, 2))] == null) {
        return false;
    }
    switch (idcard.length) {
        case 15:
            if ((parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0 || ((parseInt(idcard.substr(6, 2)) + 1900) % 100 == 0 && (parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0)) {
                ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;
            } else {
                ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;
            }
            if (ereg.test(idcard)) {
                if (parseInt(idcard_array[14]) % 2 == 0) {
                    sex_val = '女';
                } else {
                    sex_val = '男';
                }
                if (sexE) {
                    //sexE.find('#sex_select').text(sex_val);
                    sexE.find('input[name^=person_sex]').each(function(){
                        if($(this).val()==sex_val){
                            $(this).attr('checked','checked');
                            return false;
                        }
                    });
                }
                birthdayE && birthdayE.val('19' + idcard.substr(6, 2) + '-' + idcard.substr(8, 2) + '-' + idcard.substr(10, 2));
                birthdayE && birthdayE.next('b.wrongTips').remove();
                return true;
            } else {
                return false;
            }
            break;
        case 18:
            if (parseInt(idcard.substr(6, 4)) % 4 == 0 || (parseInt(idcard.substr(6, 4)) % 100 == 0 && parseInt(idcard.substr(6, 4)) % 4 == 0)) {
                ereg = /^[1-9][0-9]{5}(19|20)[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;
            } else {
                ereg = /^[1-9][0-9]{5}(19|20)[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;
            }
            if (ereg.test(idcard)) {
                S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7 + (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9 + (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10 + (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5 + (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8 + (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4 + (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2 + parseInt(idcard_array[7]) * 1 + parseInt(idcard_array[8]) * 6 + parseInt(idcard_array[9]) * 3;
                Y = S % 11;
                M = "F";
                JYM = "10X98765432";
                M = JYM.substr(Y, 1);
                if (M == idcard_array[17]) {
                    if (parseInt(idcard_array[16]) % 2 == 0) {
                        sex_val = '女';
                    } else {
                        sex_val = '男';
                    }
                    if (sexE) {
                        //sexE.find('#sex_select').text(sex_val);
                        sexE.find('input[name^=person_sex]').each(function(){
                            if($(this).val()==sex_val){
                                $(this).attr('checked','checked');
                return false;
                            }
                        });
                    }
                    birthdayE && birthdayE.val(idcard.substr(6, 4) + '-' + idcard.substr(10, 2) + '-' + idcard.substr(12, 2));
                    birthdayE && birthdayE.next('b.wrongTips').remove();
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        default:
            return false;
            break;
    }
}