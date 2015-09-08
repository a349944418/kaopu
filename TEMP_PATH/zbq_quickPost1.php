<?php
return '<!-- <h3>发新贴</h3> -->
<style>
    .form-group {position: relative;}
    .title_changes, .flag_changes{width:100%; position:absolute; top:57px; list-style:none; background:#FFF; border:1px solid #66afe9; border-top: none; display:none; z-index: 1000; padding: 0px;}

    .title_changes li, .title_changes p, .flag_changes li, .flag_changes p{padding:2px 12px;}
    .title_changes p, .flag_changes p{ color: #bbb;font-size: 12px;padding-bottom: 0px;}

    .title_changes li.active, .flag_chenges li.active{ background:#CEE7FF;}
</style>
<form method="post" action="http://localhost/kaopu/index.php?app=weiba&mod=Index&act=doPost" onkeydown="if(event.keyCode==13){return false;}" name="weibaPost" id="weibaPost">
    <input type="hidden" value="" name="weiba_id" id="weiba_id">
    <input type="hidden" value="1" name="post_type" id="post_type">
    <div class="form-group">
        <label for="title">标题：</label>
        <input class="form-control" type="text" name="title" id="title" autocomplete="off">
        <ul class="title_changes"></ul>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">详情：</label>
        <textarea name="content" id="wb_content" class="form-control" rows="6" style="resize:none;"></textarea>
    </div>
        <div class="form-group">
        <label for="weiba_flag" class="weiba_flag">选择话题：</label>
        <input type="text" class="form-control" id="weiba_flag" autocomplete="off">
        <ul class="flag_changes"></ul>
    </div>
    <div style="text-align:right"><span style="float:left"><a href="http://localhost/kaopu/question/post?pt=1">高级模式</a></span><a href="javascript:;" onclick="close_Modal()">取消</a> &nbsp;&nbsp; <a href="javascript:;" class="btn btn-danger" style="background-color:#FC5241;color:white;" onclick="return weibaPost_submit_check(ue)">发布</a></div>
</form>
<script src="http://localhost/kaopu/addons/theme/stv2/_static/js/input_extend.js"></script>
<script >
    $("#title").changeTips({
        divTip:".title_changes",
        url : "http://localhost/kaopu/index.php?app=weiba&mod=Search&act=title"
    }); 
    $(\'#weiba_flag\').changeTips({
        divTip:".flag_changes",
        url : "http://localhost/kaopu/index.php?app=weiba&mod=Search&act=weibaName"
    })
</script>
<script>

    function choose_weiba_flag(id,name){
      var con = $(\'#weiba_id\').val();
      if(con == \'\'){
        con = id;
      } else {
        con += \',\'+id;
      }
      name = \'<div style="background:#FC5241;color:white;display:inline-block;border-radius:10px;font-weight: normal;padding: 0 10px;">\'+name+\' <button type="button" class="close" aria-label="Close" onclick="del_weiba_flag(\'+id+\',this);"><span aria-hidden="true">&times;</span></button></div>&nbsp;\';
      $(\'#weiba_id\').val(con);
      $(\'.form-group .weiba_flag\').append(name);
      $(\'#weiba_flag\').val(\'\');
    }

    function del_weiba_flag(id, obj) {
        $(obj).parent(\'div\').remove();
        var txt = \'\';
        var con = $(\'#weiba_id\').val();
        var arr = con.split(\',\');
        for(var i=0;i<arr.length;i++){
            if(arr[i] != id){
                txt += arr[i]+\',\';
            }
        }
        $(\'#weiba_id\').val(txt.substr(0,txt.length-1));
    }

</script>';
?>