<?php if (!defined('THINK_PATH')) exit();?><?php if(empty($userList['data'])): ?>
	<!-- <p>暂时没有相关用户</p> -->
<?php else: ?>
  <div class="page"><?php echo ($userList["html"]); ?></div>
	<div class="row test-container">
		<?php if(is_array($userList["data"])): ?><?php $i = 0;?><?php $__LIST__ = $userList["data"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="col-xs-3" style="padding:2%;"><a href="<?php echo ($vo["space_url"]); ?>" data-toggle="popover" data-placement="bottom"><img src="<?php echo ($vo["avatar_middle"]); ?>" width="100%" class="img-circle yw-spectrum1"/><div class="data-content"><?php echo htmlspecialchars_decode($vo['info']);?></div></a></div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
	</div>
  <div class="row" style="color:#fff;">
    <div class="col-md-12">
        <div class="popover bottom in col-xs-12 yw-topic" role="tooltip"  style="display: block; width:100%;">
            <div class="arrow"></div>
            <div class="popover-content">
            	<?php echo htmlspecialchars_decode($userList[data][0][info]);?>
            </div>
        </div>
    </div>
  </div>
<?php endif; ?>