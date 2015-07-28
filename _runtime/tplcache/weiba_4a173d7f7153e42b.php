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
<div id="body_page" name='body_page'>
    <div id="body-bg">
    <div id="header" name="header">
    	<?php echo constant(" 未登录时 *");?>
    	<?php if( !isset($_SESSION["mid"])): ?><div class="header-wrap">
        	<div class="head-bd">
                <!-- logo -->
                <div class="reg">
                    <a href="<?php echo U('public/Register');?>"><?php echo L('PUBLIC_REGISTER');?></a>
                    <i class="vline"> | </i>
                    <a href="<?php echo U('public/Passport/login');?>"><?php echo L('PUBLIC_LOGIN');?></a>
                </div>
                <div class="logo" <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false): ?>style="_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo ($site["logo"]); ?>', sizingMethod='crop');_background:none;"<?php else: ?>style="background:url(<?php echo ($site["logo"]); ?>) no-repeat;"<?php endif; ?>><a href="<?php echo SITE_URL;?>"></a></div>
                <!-- logo -->
                <div class="nav">
                    <ul>
                        <?php if(is_array($site_guest_nav)): ?><?php $i = 0;?><?php $__LIST__ = $site_guest_nav?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$st): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li <?php if(APP_NAME == $st['app_name'] || $_GET['page'] == $st['app_name']): ?> class="current" <?php endif; ?> ><a href="<?php echo ($st["url"]); ?>" target="<?php echo ($st["target"]); ?>" class="app"><?php echo ($st["navi_name"]); ?></a>
                            <?php if(isset($st['child'])): ?><div model-node="drop_menu_list" class="dropmenu" style="width:100px;display:none;">
                                <dl class="acc-list" >
                                    <?php if(is_array($st["child"])): ?><?php $i = 0;?><?php $__LIST__ = $st["child"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$stc): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo ($stc["url"]); ?>" target="<?php echo ($stc["target"]); ?>"><?php echo (getshort($stc["navi_name"],6)); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                                </dl>
                            </div><?php endif; ?>
                          </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
		</div><?php endif; ?>

		<?php echo constant(" 登录后 *");?>
		<?php if(isset($_SESSION["mid"])): ?><nav class="navbar navbar-inverse header-wrap">
        	<div class="container head-bd">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#"></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php if(is_array($site_top_nav)): ?><?php $i = 0;?><?php $__LIST__ = $site_top_nav?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$st): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li class="<?php if(APP_NAME == $st['app_name'] || $_GET['page'] == $st['app_name']): ?>current active<?php endif; ?><?php if(isset($st[child])): ?>dropdown<?php endif; ?>"  ><a href="<?php echo ($st["url"]); ?>" target="<?php echo ($st["target"]); ?>" <?php if(isset($st[child])): ?>class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"<?php endif; ?> ><?php echo ($st["navi_name"]); ?><?php if(isset($st[child])): ?><span class="caret"></span><?php endif; ?></a>
                            <?php if(isset($st['child'])): ?><ul class="dropdown-menu">
                                    <?php if(is_array($st["child"])): ?><?php $i = 0;?><?php $__LIST__ = $st["child"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$stc): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo ($stc["url"]); ?>" target="<?php echo ($stc["target"]); ?>"><?php echo (getshort($stc["navi_name"],6)); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                                </ul><?php endif; ?>
                          </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>    
                    </ul>
                    <form name="search_weiba" id="search_weiba" class="navbar-form navbar-left" method="post" action="<?php echo U('weiba/Index/search');?>">
                        <!-- <input name="app" value="public" type="hidden"/>
                        <input name="mod" value="Search" type="hidden"/>
                        <input type="hidden" name="t" value="2"/>
                        <input type="hidden" name="a" value="public"/> -->
                        <input type="hidden" name="type" value="2"/>
                        <div class="form-group">
                            <div class="input-group">
                                <input autocomplete="off" id="searchweiba_input" class="s-txt left"  type="text" value="<?php if(!empty($searchkey)){ ?><?php echo ($searchkey); ?><?php }else{ ?>搜微吧 / 帖子<?php } ?>" onfocus="this.value=''" onblur="setTimeout(function(){ $('#search-box').remove();} , 200);if(this.value=='') this.value='搜微吧 / 帖子';" event-node="searchKey" name='k'><a href="javascript:void(0)" class="btn-search" onclick="if(getLength($('#searchweiba_input').val()) && $('#searchweiba_input').val()!=='搜微吧 / 帖子'){ $('#search_weiba').submit(); return false;}"><span>搜索</span></a>
                            </div></div>
                    </form>
                    <!-- <form name="search_feed" role="search" class="navbar-form navbar-left" id="search_feed" method="get" action="<?php echo U('public/Search/index');?>" >
                        <div class="form-group">
                        <input name="app" value="public" type="hidden"/>
                        <input name="mod" value="Search" type="hidden"/>
                        <input type="hidden" name="t" value="2"/>
                        <input type="hidden" name="a" value="public"/>
                        <div class="input-group">
                            <input id="search_input" class="form-control left"  type="text" value="搜微博 / 昵称 / 标签" onfocus="this.value=''" onblur="setTimeout(function(){ $('#search-box').remove();} , 200);if(this.value=='') this.value='搜微博 / 昵称 / 标签';" event-node="searchKey" name='k'  autocomplete="off"><div class="input-group-addon"><a href="javascript:void(0)" class="ico-search left" onclick="if(getLength($('#search_input').val()) && $('#search_input').val()!=='搜微博 / 昵称 / 标签'){ $('#search_feed').submit(); return false;}"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></div>
                        </div></div>
                    </form> -->
                    <ul class="nav navbar-nav navbar-right">
                        <li model-node="person" class="dorp-right">
                            <a href="<?php echo ($user['space_url']); ?>" class="username"><?php echo (getshort($user['uname'],6)); ?></a>
                        </li>                       
                        <li model-node="notice" class="dorp-right dropdown"><a href="javascript:void(0);"class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo L('PUBLIC_MESSAGE');?><span class="caret"></span></a>
                            <ul class="dropdown-menu message_list_container message_list_new" >
                                <li rel="new_folower_count" style="display:none">
                                    <span></span>，<a href="<?php echo U('public/Index/follower',array('uid'=>$mid));?>"><?php echo L('PUBLIC_FOLLOWERS_REMIND');?></a></li>
                                <li rel="unread_comment" style="display:none"><span></span>，<a href="<?php echo U('public/Comment/index',array('type'=>'receive'));?>">
                                    <?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                <li rel="unread_message" style="display:none"><span></span>，<a href="<?php echo U('public/Message');?>" ><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                <li rel="unread_atme" style="display:none"><span></span>，<a href="<?php echo U('public/Mention');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                <li rel="unread_notify" style="display:none"><span></span>，<a href="<?php echo U('public/Message/notify');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                <!-- <li><a  href="<?php echo U('public/Mention/index');?>">@提到我的</a></li> -->
                                <li><a  href="<?php echo U('public/Comment/index', array('type'=>'receive'));?>">收到的评论</a></li>
                                <!-- <li><a  href="<?php echo U('public/Comment/index', array('type'=>'send'));?>">发出的评论</a></li> -->
                                <!-- <li><a  href="<?php echo U('public/Message/index');?>">我的私信</a></li> -->
                                <li><a  href="<?php echo U('public/Message/notify');?>">系统消息</a></li>
                                <!-- 消息菜单钩子 -->
                                <?php echo Addons::hook('header_message_dropmenu');?>
                            <?php if(CheckPermission('core_normal','send_message')){ ?>
                            <li class="border"><a event-node="postMsg" href="javascript:void(0)" onclick="ui.sendmessage()"><?php echo L('PUBLIC_SEND_PRIVATE_MESSAGE');?>&raquo;</a></li>
                            <?php } ?>
                            </ul>
                        </li>
                        <li model-node="account" class="dropdown dorp-right"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo L('PUBLIC_ACCOUNT');?><span class="caret"></span></a>
                            <ul class="dropdown-menu acc-list">
                                <li><a href="<?php echo U('public/Account/index');?>"><?php echo L('PUBLIC_SETTING');?></a></li>
                                <!--
                                <?php if(CheckTaskSwitch()): ?>
                                <li><a href="<?php echo U('public/Task/index');?>">任务中心</a></li>
                                <li><a href="<?php echo U('public/Medal/index');?>">勋章馆</a></li>
                                <?php endif; ?>
                                
                                <li><a href="<?php echo U('public/Rank/weibo');?>">排行榜</a></li>

                                <?php if(!isVerified($user['uid'])): ?>
                                <li><a href="<?php echo U('public/Account/authenticate');?>">申请认证</a></li>
                                <?php endif; ?>

                                <?php if(isInvite() && CheckPermission('core_normal','invite_user')): ?>
                                <li><a href="<?php echo U('public/Invite/invite');?>"><?php echo L('PUBLIC_INVITE_COLLEAGUE');?></a></li>
                                <?php endif; ?> -->
                                <!-- 个人设置菜单钩子 -->
                                <?php echo Addons::hook('header_account_dropmenu');?>
                                <?php if(CheckPermission('core_admin','admin_login')){ ?>
                                <li><a href="<?php echo U('admin');?>"><?php echo L('PUBLIC_SYSTEM_MANAGEMENT');?></a></li>
                                <?php } ?>

                                <li class="border"><a href="<?php echo U('public/Passport/logout');?>"><?php echo L('PUBLIC_LOGOUT');?>&raquo;</a></li>
                            </ul>
                        </li>
                    </ul>   
                </div>   
                <?php if(MODULE_NAME !='Register'): ?>
                <div id="message_container" class="layer-massage-box" style="display:none">
                	<ul class="message_list_container" >
                        <li rel="new_folower_count" style="display:none"><span></span>，<a href="<?php echo U('public/Index/follower',array('uid'=>$mid));?>"><?php echo L('PUBLIC_FOLLOWERS_REMIND');?></a></li>
                		<li rel="unread_comment" style="display:none"><span></span>，<a href="<?php echo U('public/Comment/index',array('type'=>'receive'));?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                        <li rel="unread_message" style="display:none"><span></span>，<a href="<?php echo U('public/Message');?>" ><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
 	                    <li rel="unread_atme" style="display:none"><span></span>，<a href="<?php echo U('public/Mention');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
     	                <li rel="unread_notify" style="display:none"><span></span>，<a href="<?php echo U('public/Message/notify');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
     	                <li rel="unread_group_atme" style="display:none"><span></span>，<a href="<?php echo U('group/SomeOne/index');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
     	                <li rel="unread_group_comment" style="display:none"><span></span>，<a href="<?php echo U('group/SomeOne/index');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li> 
                	</ul>
                <a href="javascript:void(0)" onclick="core.dropnotify.closeParentObj()" class="ico-close1"></a>
                </div>
                <?php endif; ?>
        	</div>
        </nav>
        <?php if(MODULE_NAME != 'Search'): ?>
        <div id="search"  class="mod-at-wrap search_footer" model-node='search_footer' style="display:none;z-index:-1">
            <div class="search-wrap">
                <div class="input">
                     <form id="search_form" action="<?php echo U('public/Search/index');?>" method="GET">
                        <div class="search-menu" model-node='search_menu' model-args='a=<?php echo ($curApp); ?>&t=<?php echo ($curType); ?>'>
                            <a href="javascript:;" id='search_cur_menu'><?php echo (($curTypeName)?($curTypeName):"全站"); ?><i class="ico-more"></i></a>
                        </div>
                        <input name="app" value="public" type="hidden" />
                        <input name="mod" value="Search" type="hidden" />
                        <input name="a" value="<?php echo ($curApp); ?>" id='search_a' type="hidden"/>
                        <input name="t" value="<?php echo ($curType); ?>" id='search_t' type="hidden"/>
                        <input name="k" value="<?php echo (t($_GET['k'])); ?>" type="text" class="s-txt" onblur="this.className='s-txt'" onfocus="this.className='s-txt-focus'" autocomplete="off">
                        <a class="btn-red left" href="javascript:void(0);" onclick="$('#search_form').submit();"><span class="ico-search"></span></a>
                    </form>
                </div>
            </div>
        </div>
        <div class="mod-at-wrap" id="search_menu" ison='no' style="display:none" model-node="search_menu_ul">
        <div class="mod-at">
            <div class="mod-at-list">
                <ul class="at-user-list">
                    <li onclick="core.search.doShowCurMenu(this)" a='public' t='' typename='<?php echo L('PUBLIC_ALL_WEBSITE');?>'><?php echo L('PUBLIC_ALL_WEBSITE');?></li>
                <?php if(is_array($menuList)): ?><?php $i = 0;?><?php $__LIST__ = $menuList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$m): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php if($m['app_name'] == $curApp && $m['type_id'] == $curType){
                            $curTypeName = $m['type'];
                        } ?>
                    <li onclick="core.search.doShowCurMenu(this)" a='<?php echo ($m["app_name"]); ?>' t='<?php echo ($m["type_id"]); ?>' typename='<?php echo ($m["type"]); ?>'><?php echo ($m["type"]); ?></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>   
                </ul>
            </div>
        </div>
        </div>
       <?php endif; ?> 
    <script type="text/javascript">
    $(document).ready(function(){
        $("#mod-product dd").hover(function() {
            $(this).addClass("hover");
        },function() {
            $(this).removeClass("hover");
        });
        core.plugInit('search');
    });
    core.plugFunc('dropnotify',function(){
        setTimeout(function(){
            core.dropnotify.init('message_list_container','message_container');
        },320);   
    });
    </script><?php endif; ?>
    </div>
<?php //出现注册提示的页面
$show_register_tips = array('public/Profile','public/Topic','weiba/Index');
if(!$mid && in_array(APP_NAME.'/'.MODULE_NAME,$show_register_tips)){ ?>
<?php $registerConf = model('Xdata')->get('admin_Config:register'); ?>
<!--未登录前-->
<div class="login-no-bg">
  <div class="login-no-box boxShadow clearfix">       
    <div class="login-reg right">
        <?php if($registerConf['register_type'] == 'open'){ ?>
        <a href="<?php echo U('public/Register/index');?>" class="btn-reg">立即注册</a>
        <?php } ?>
        <span>已有帐号？<a href="javascript:quickLogin()">立即登录</a></span>
    </div>
    <p class="left"><span>欢迎来到<?php echo ($site["site_name"]); ?></span>赶紧注册与朋友们分享快乐点滴吧！</p>
  </div>
</div>
<?php } ?>
<link href="__APP__/weiba.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__APP__/weiba.js"></script>
<script type="text/javascript" src="__THEME__/js/plugins/core.comment.js"></script>
<?php  ?>
<div class="center">
    <div class="container">
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
              <div class="row">
                  <div class="col-sm-9">
                      <?php if ($weiba_recommend) { ?>
                          <div class="Interest1 clearfix">
                              <div class="Interest row">
                                    <div class="Interest-left col-sm-1">
                                        <img src="__THEME__/image/Interest.png"/>
                                    </div>
                                    <div class="Interest-right col-sm-11">
                                        <p class="may"><span style="display:none;"><a href="#"><img src="__THEME__/image/cha.png"/></a></span>你可能感兴趣的话题</p>
                                        <p class="According"><span style="display:none;"><a href="#">上一页</a><a href="#">下一页</a></span>动态中会根据关注话题来显示你的内容-<a href="<?php echo U('weiba/Index/weibaList');?>">查看更多推荐</a></p>
                                    </div>
                                </div>
                                <div class="ascension row">
                                    <div class="Interest-left col-sm-1"></div>
                                    <div class="col-sm-11"><div class="row">
                                    <?php if(is_array($weiba_recommend)): ?><?php $i = 0;?><?php $__LIST__ = array_slice($weiba_recommend,0,4) ?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dl class="col-sm-3">
                                          <dt><a href="<?php echo U('weiba/Index/detail',array('weiba_id'=>$vo['weiba_id']));?>" ><img src="<?php echo ($vo["logo"]); ?>" width="124px"/></dt>
                                          <dd class="rebellious"><a href="<?php echo U('weiba/Index/detail',array('weiba_id'=>$vo['weiba_id']));?>" ><?php echo ($vo["weiba_name"]); ?></a></dd>
                                          <dd class="people"><?php echo ($vo["follower_count"]); ?>人关注</dd>
                                          <dd class="guan"><?php echo W('FollowWeiba',array('weiba_id'=>$vo['weiba_id'],'follow_state'=>array('following'=>0),'isrefresh'=>1));?></dd>
                                      </dl><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                                  </div></div>
                                </div>
                          </div>
                      <?php } ?>
                      <div class="confused clearfix">
                          <div class="confused-top row">
                              <div class="confused-left col-sm-1">
                                  <img src="__THEME__/image/confused-left.png"/>
                                </div>
                                <div class="confused-right col-sm-11">
                                  <p><span>动态</span>&nbsp;&nbsp;/&nbsp;&nbsp;学习中的困惑</p>
                                </div>
                            </div>
                            <div class="confused-bottom row">
                              <div class="Interest-left col-sm-1"></div>
                              <div class="col-sm-11">
                                <?php if(is_array($postList[data])): ?><?php $i = 0;?><?php $__LIST__ = $postList[data]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="higher">
                                    <h5><a href="<?php echo U('weiba/Index/postDetail',array('post_id'=>$vo['post_id']));?>"><?php if(($vo["post_type"])  ==  "2"): ?>【分享】-- &nbsp;<?php endif; ?><?php echo ($vo["title"]); ?></a></h5>
                                      <p class="from"><?php echo date('Y/m/d',$vo['post_time']);?> | 来自：<a href="<?php echo U('public/Profile/index',array('uid'=>$vo['post_uid']));?>"><?php echo ($vo["post_uname"]); ?></a> | 阅读：<?php echo ($vo["read_count"]); ?></p>
                                      <div class="trouble"><?php if($vo['content_img']){ echo '<img src="'.$vo[content_img].'" width="25%" style="float:left;margin-right:15px;"/>'; } ?><?php echo (getshort($vo[content],400)); ?></div>
                                      <div style="clear:both"></div>
                                      <div class="problem clearfix">
                                        <span class="chakan"><a href="<?php echo U('weiba/Index/postDetail',array('post_id'=>$vo['post_id']));?>">查看原文</a></span>
                                        <span class="guanzhu">
                                          <?php if($vo['favorite']==1){ ?>
                                            <a event-args="post_id=<?php echo ($vo['post_id']); ?>&post_uid=<?php echo ($vo['post_uid']); ?>" href="javascript:void(0)" event-node="post_unfavorite" id="favorite">已关注</a>
                                          <?php }else{ ?>
                                            <a event-args="post_id=<?php echo ($vo['post_id']); ?>&post_uid=<?php echo ($vo['post_uid']); ?>" href="javascript:void(0)" event-node="post_favorite" id="favorite">关注问题</a>
                                          <?php } ?>
                                        </span>
                                        <span class="pinglun"><a class="comment_btns" href="javascript:void(0)" event-args="row_id=<?php echo ($vo[post_id]); ?>&app_name=weiba&table=feed&cancomment=0"><span id="question<?php echo ($vo["post_id"]); ?>_reply_count"><?php echo (($vo["reply_count"])?($vo["reply_count"]):0); ?></span>条评论</a></span><span class="zan" style="display:none;"><a href="#">赞</a></span><span class="fenxiang" style="display:none;"><a href="#">分享</a></span>
                                      </div>
                                      <div id="comment_detail_<?php echo ($vo[post_id]); ?>" class="comments repeat clearfix popover bottom in" style="display:none;"></div>
                                  </div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="visual1">
    <?php if($userinfo) { ?>
        <div class="visual1-top clearfix">
            <div class="visual1-left">
              <img src="<?php echo ($userinfo["avatar_big"]); ?>" width="100%"/>
            </div>
            <div class="visual1-right">
              <p class="shi"><a href="<?php echo ($user['space_url']); ?>"><?php echo ($userinfo['uname']); ?></a></p>
                <p class="jue"><?php echo (getshort($userinfo['intro'],100)); ?></p>
            </div>
        </div>
        <div class="quiz">
          我的关注 ······ （<h6 style="display:inline-block">话题 <?php echo count($userinfo['weibaList']);?></h6>）
          <div class="row" style="margin: 0;">
            <?php if(is_array($userinfo['weibaList'])): ?><?php $i = 0;?><?php $__LIST__ = array_slice($userinfo['weibaList'],0,6) ?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="col-xs-2 tiwen1" style="padding: 0;"><a href="<?php echo U('weiba/Index/detail',array('weiba_id'=>$vo['weiba_id']));?>" title="<?php echo ($vo["weiba_name"]); ?>"><img src="<?php echo ($vo["logo"]); ?>" width="90%"></a></div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
          </div>
        </div>
        <div class="quiz">
            <div class="row">
                <div class="col-xs-3 tiwen"><a href="<?php echo U('public/Profile/question',array('uid'=>$uid));?>">提问<span><?php echo (($userinfo['postCount'])?($userinfo['postCount']):0); ?></span></a></div>
                <div class="col-xs-3 tiwen"><a href="<?php echo U('public/Profile/index',array('uid'=>$uid));?>">回答<span><?php echo (($userinfo['replyCount'])?($userinfo['replyCount']):0); ?></a></span></div>
                <div class="col-xs-3 tiwen"><a href="<?php echo U('public/Profile/share',array('uid'=>$uid));?>">分享<span><?php echo (($userinfo['shareCount'])?($userinfo['shareCount']):0); ?></span></a></div>
                <div class="col-xs-3 tiwen1"><a href="<?php echo U('public/Profile/collection',array('uid'=>$uid));?>">收藏<span><?php echo (($userinfo['favoriteCount'])?($userinfo['favoriteCount']):0); ?></span></a></div>
            </div>
        </div>
    <?php } ?>
    <div class="ask">
        <a href="javascript:;" onclick="showquiz('<?php echo U('weiba/Index/quickPost');?>')" id="quiz">提问</a>
    </div>
    <div class="maybe">
      <?php echo Addons::hook('show_ad_space', array('place'=>'weiba_right'));?>
    </div>
    <div class="topics">
      <h6>热门话题</h6>
        <p>
          <?php if(is_array($weiba_recommend)): ?><?php $i = 0;?><?php $__LIST__ = $weiba_recommend?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><a href="<?php echo U('weiba/Index/detail',array('weiba_id'=>$vo['weiba_id']));?>" ><?php echo ($vo["weiba_name"]); ?></a><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
        </p>
    </div>
    <div class="draft" style="display:none;">
      <p class="draft1">我的草稿</p>
        <p class="draft2">我的收藏</p>
        <p class="draft3">我关注的问题</p>
        <p class="draft4">邀请我回答的问题</p>
        <p class="draft5">所有问题</p>
        <p class="draft6">话题广场</p>
        <p class="draft7">公共编辑动态</p>
        <p class="draft8">社区服务中心</p>
    </div>
</div>



                  </div>
              </div>
            </div>
        </div>
    </div>
</div>


<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="footer-img">
                          <img src="__THEME__/image/footer1.jpg"/>
                          <p>地址/Add：北京市海淀区上地东路颐泉汇一号楼303<br/>电话/Tel：010-60608200<br/>邮箱/Mail：cooperate@17growing.com</p>
                          <p><a href="#"><img src="__THEME__/image/footer-img1.png"/></a><a href="#"><img src="__THEME__/image/footer-img2.png"/></a><a href="#"><img src="__THEME__/image/footer-img3.png"/></a><a href="#"><img src="__THEME__/image/footer-img4.png"/></a></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                      <div class="guanyu">
                          <p>关于</p>
                            <p><a href="#">靠谱人自述</a></p>
                            <p><a href="#">版权声明</a></p>
                            <p><a href="#">关于隐私</a></p>
                            <p><a href="#">申请加入我们</a></p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="guanyu">
                            <p>服务专区</p>
                            <p><a href="#">原创文章</a></p>
                            <p><a href="#">经典评论</a></p>
                            <p><a href="#">学习资料</a></p>
                            <p><a href="#">线下Or线上活动</a></p>
                            <p><a href="#">朋友圈</a></p>
                            <p><a href="#">名师解答</a></p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="guanyu">
                            <p>知识学院</p>
                            <p><a href="#">学习方法</a></p>
                            <p><a href="#">时间管理</a></p>
                            <p><a href="#">心态调整</a></p>
                            <p><a href="#">初高中数学</a></p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="guanyu">
                            <p>话题广场</p>
                            <p><a href="#">热门话题</a></p>
                            <p><a href="#">分类话题</a></p>
                            <p><a href="#">小组话题</a></p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="guanyu">
                            <p>联系</p>
                            <p><a href="#">在线提问</a></p>
                            <p><a href="#">联系我们</a></p>
                            <p><a href="#">和博士微博</a></p>
                            <p><a href="#">高考帮公众号</a></p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="guanyu">
                            <p>友链</p>
                            <p><a href="#">慧聚成长</a></p>
                            <p><a href="#">阿里巴巴</a></p>
                            <p><a href="#">腾讯</a></p>
                            <p><a href="#">好未来教育</a></p>
                            <p><a href="#">新东方</a></p>
                        </div>
                    </div>
                    <div class="col-md-10">
                      <p class="copyright">京 ICP 备 13052560 号 京公网安备 11010802010035 号</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 统计代码-->
<div id="site_analytics_code" style="display:none;">
<?php echo (base64_decode($site["site_analytics_code"])); ?>
</div>
<div class="modal fade " id="comModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
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
<script type="text/javascript" charset="utf-8" src="__THEME__/js/main.js"></script>
<?php if(($site["site_online_count"])  ==  "1"): ?><script src="<?php echo SITE_URL;?>/online_check.php?uid=<?php echo ($mid); ?>&uname=<?php echo ($user["uname"]); ?>&mod=<?php echo MODULE_NAME;?>&app=<?php echo APP_NAME;?>&act=<?php echo ACTION_NAME;?>&action=trace"></script><?php endif; ?>
</body>
</html>