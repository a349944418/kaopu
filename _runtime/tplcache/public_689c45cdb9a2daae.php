<?php if (!defined('THINK_PATH')) exit();?><form id="Reg_form" method="post" action="<?php echo U('public/Register/doStep1');?>"> <div class="form-group form-group-lg row"> <div class="col-xs-12"><div class="input-group"> <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div> <input type="text" class="form-control" id="Reg_name" placeholder="昵称" name="Reg_name">  </div></div> </div> <div class="form-group form-group-lg row"> <div class="col-xs-12"><div class="input-group"> <div class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></div> <input type="text" class="form-control" id="Reg_email" placeholder="邮箱" name="Reg_email"> </div> </div></div><div class="form-group form-group-lg row"> <div class="col-xs-12"><div class="input-group"> <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div> <input type="password" class="form-control" id="Reg_pwd" placeholder="密码" name="Reg_pwd">  </div> </div></div> <div class="form-group form-group-lg row"><div class="col-xs-12" style="text-align:center;"><label class="radio-inline"> <input type="radio" name="Reg_capacity" id="inlineRadio1" value="1" checked> 学生 </label> <label class="radio-inline"> <input type="radio" name="Reg_capacity" id="inlineRadio2" value="2"> 家长 </label> <label class="radio-inline"> <input type="radio" name="Reg_capacity" id="inlineRadio4" value="4"> 老师 </label> <label class="radio-inline"> <input type="radio" name="Reg_capacity" id="inlineRadio3" value="3"> 过来人 </label> </div> </div> </div> <div class="form-group row"> <div class="col-xs-12"><button type="submit" class="btn btn-primary btn-block btn-lg">注册</button></div></div> </form>
<script>
	$(function(){
		$('#Reg_form').validate({
          	rules : {
	            Reg_name : {
	              required : true,
	              minlength : 2,
	              maxlength : 20,
	            },
	            Reg_email : {
	              email : true,
	              remote : "<?php echo U('public/Register/isEmailAvailable');?>"
	            },
	            Reg_pwd : {
	              required : true,
	              minlength : 6,
	              maxlength : 18,
	            }
         	},
          	messages : {
	            Reg_name : {
	              required : '昵称必填',
	              minlength : '昵称不得小于2个字节',
	              maxlength : '昵称不能超过20个字节',
	            },
	            Reg_email : {
	            	email : '请输入正确的邮箱格式',
	            	remote : '该邮箱已注册'
	            },
	            Reg_pwd : {
	            	required : '密码必须填写',
	            	minlength : '密码不能小于6个字节',
	            	maxlength : '密码不能超过18个字节'
	            }
          	},
          	errorPlacement: function(error, element) {  
			    error.appendTo(element.parent().parent());  
			},
        })
	})
</script>
<style>
	label.error {color: red; font-size: 12px; font-family: '微软雅黑'; float: right; margin: 5px 0 0;}
</style>