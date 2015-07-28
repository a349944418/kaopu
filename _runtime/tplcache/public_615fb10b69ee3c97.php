<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if(($_title)  !=  ""): ?><?php echo ($_title); ?> - <?php echo ($site["site_name"]); ?><?php else: ?><?php echo ($site["site_name"]); ?> - <?php echo ($site["site_slogan"]); ?><?php endif; ?></title>
<meta content="<?php if(($_keywords)  !=  ""): ?><?php echo ($_keywords); ?><?php else: ?><?php echo ($site["site_header_keywords"]); ?><?php endif; ?>" name="keywords">
<meta content="<?php if(($_description)  !=  ""): ?><?php echo ($_description); ?><?php else: ?><?php echo ($site["site_header_description"]); ?><?php endif; ?>" name="description">
<?php echo Addons::hook('public_meta');?>
<link href="__THEME__/image/favicon.ico?v=<?php echo ($site["sys_version"]); ?>" type="image/x-icon" rel="shortcut icon">
<link href="__THEME__/css/bootstrap.min.css?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css" />
<link href="__THEME__/css/page.css?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css" />
<?php if(!empty($appCssList)): ?>
<?php if(is_array($appCssList)): ?><?php $i = 0;?><?php $__LIST__ = $appCssList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$cl): ?><?php ++$i;?><?php $mod = ($i % 2 )?><link href="<?php echo APP_PUBLIC_URL;?>/<?php echo ($cl); ?>?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css"/><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
<?php endif; ?>
<script>
/**
 * 全局变量
 */
var SITE_URL  = '<?php echo SITE_URL; ?>';
var UPLOAD_URL= '<?php echo UPLOAD_URL; ?>';
var THEME_URL = '__THEME__';
var APPNAME   = '<?php echo APP_NAME; ?>';
var MID		  = '<?php echo $mid; ?>';
var UID		  = '<?php echo $uid; ?>';
var initNums  =  '<?php echo $initNums; ?>';
var SYS_VERSION = '<?php echo $site["sys_version"]; ?>'
var Get_Comment_List_URL = '<?php echo U("widget/Comment/getCommentList"); ?>';
// Js语言变量
var LANG = new Array();
</script>
<?php if(!empty($langJsList)) { ?>
<?php if(is_array($langJsList)): ?><?php $i = 0;?><?php $__LIST__ = $langJsList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><script src="<?php echo ($vo); ?>?v=<?php echo ($site["sys_version"]); ?>"></script><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
<?php } ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="__THEME__/js/js.php?t=js&f=jquery-1.7.1.min.js,common.js,core.js,module.js,module.common.js,jwidget_1.0.0.js,jquery.atwho.js,jquery.caret.js,ui.core.js,ui.draggable.js,plugins/core.comment.js,plugins/core.digg.js,jquery.min.js,bootstrap.min.js,jquery.form.js,jquery.validate.min.js&v=<?php echo ($site["sys_version"]); ?>.js"></script>
<script type="text/javascript" charset="utf-8" src="__THEME__/js/editor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__THEME__/js/weiba.js"></script>
<?php echo Addons::hook('public_head',array('uid'=>$uid));?>
</head>
<body>
<div id="login-bg" style="background:url(<?php echo ($login_bg); ?>) top center">
  <div class="container" style="padding-top:52px; padding-bottom:194px;">
    <div class="row" style="color:#fff;">
          <div class="col-md-6 col-md-offset-3">
            <a href="#"><img src="<?php echo APP_PUBLIC_URL;?>/image/yw-spectrum10.png" width="100%"/></a>
          </div>
      </div>
      <div class="row" style="color:#fff; padding-top:27px;">
          <div class="col-md-6 col-md-offset-3" style="padding:0 10%;">
            <a href="#"><img src="<?php echo APP_PUBLIC_URL;?>/image/yw-spectrum11.png" width="100%"/></a>
          </div>
      </div>
    <div class="row" style="color:#fff;">
          <div class="col-md-6 col-md-offset-3">
              <?php echo W('UserList', array('widget_appname'=>'people','cid'=>0,'uids'=>'','type'=>'indexOfficial','verify'=>0,'pid'=>0));?>           
          </div>
      </div>
  </div>
  <div class="yw-box">
      <div class="toggle kp_top"></div>
    <div class="container" style="color:#fff;">
        <div class="row" style="margin-top:32px;">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                          <form class="form-inline" id="ajax_login_form" method="POST" action="<?php echo U('public/Passport/doLogin');?>">
                              <div class="form-group" style="">
                                  <label class="sr-only" for="account_input">账号</label>
                                  <input type="email" class="form-control s-txt1" id="account_input" name="login_email" autocomplete="off" placeholder="账号" style=" min-width:190px;">
                              </div>
                              <div class="form-group" style="margin-right:10px;">
                                  <label class="sr-only" for="exampleInputPassword3 pwd_input">Password</label>
                                  <input type="password" class="form-control s-txt1" id="pwd_input" name="login_password" autocomplete="off" placeholder="密码">
                              </div>
                              <div class="checkbox" style="margin-right:10px; font-size:12px;">
                                  <label>
                                  <input type="checkbox" style="float:left;"> <span style=" float:left; margin-left:8px;">记住密码</span>
                                  </label>
                              </div>
                              <button type="submit" class="btn btn-default btn-login" style="margin-right:10px;" onclick="$('#ajax_login_form').submit();" >登录</button>
                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#comModal" data-whatever="register" >注册</button>
                          </form>                         
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="modal fade " id="comModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"></h4>
      </div>
      <div class="modal-body">       
      </div>
    </div>
  </div>
</div>
<style>
  body {background: #000;}
  #comModal .modal-title {font-family: 微软雅黑}
  #comModal .modal-body .input-group-addon {background: #fff;}
  #comModal .modal-body .form-group input {border-left: 0; font-size: 12px; padding-left: 2px;}
  #comModal .modal-body .form-group .radio-inline {margin-right: 5px;}
</style>
<script src=""></script>
<script>
    $(function(){
        $('#comModal').on('show.bs.modal', function (e) {
          var button = $(e.relatedTarget);
          var type = button.data('whatever');
          var modal = $(this);
          if(type == 'register'){
            $('.modal-dialog').addClass('modal-sm');
            $.post('<?php echo U("public/Register/ajaxReg");?>',{},function(data){
              modal.find('.modal-body').html(data);},'html');
            modal.find('.modal-title').text('感谢您的注册');
          } 
        })

        

        // 推荐人，切换
        var dw = $(document).width();
        if(dw < 768) {
            $('.toggle').css('left', (dw-76)/2);
        }
        var pw = $('.test-container').width();
        $('.popover .arrow').css('left', pw/8);
        $('.test-container a').mouseover(function(){
            var x = $(this).parent().index() ;
            var L = parseInt(x * (pw/4)) + parseInt(pw / 8); 
            $('.popover .arrow').css('left', L);
            $('.popover .popover-content').html($(this).children('.data-content').html());
            
        })

        // 手机端 登录框可下拉隐藏
        var yw_box_height = 0; 
        $('.toggle').click(function(){
            var yw_box_h = $('.yw-box').height();
            yw_box_h += 33;
            if(yw_box_h > 33) {
                yw_box_height = yw_box_h > yw_box_height ? yw_box_h : yw_box_height;
                $(".yw-box").animate({height: 0});
                $('.yw-box').css('padding-bottom', 0);
                $(this).addClass('kp_bottom');
                $(this).removeClass('kp_top');
                $(this).parent().css('overflow', 'visible');
            }else{
                $(".yw-box").animate({height:yw_box_height+"px"});
                $('.yw-box').css('padding-bottom', 33+'px');
                $(this).addClass('kp_top');
                $(this).removeClass('kp_bottom');
                $(this).parent().css('overflow', 'visible');
            }
        })


    })
</script>
</body>
</html>