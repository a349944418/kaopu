<?php
/**
 * 微吧评论控制器
 * @author 
 * @version TS3.0
 */
class CommentAction extends Action {

	/**
     * [ 获取评论的评论列表]
     * @return [type] [description]
     */
	public function reply_commentList(){
		if ( !CheckPermission('weiba_normal','weiba_reply') ){
      		return false;
      	}
      	$var = $_POST;

      	$var['initNums'] = model('Xdata')->getConfig('weibo_nums', 'feed');
      	$var['commentInfo'] = model('Comment')->getCommentInfo($var['comment_id'], false);
      	$var['canrepost']  = $var['commentInfo']['table'] == 'feed'  ? 1 : 0;
      	$var['cancomment'] = 1;

      	// 获取原作者信息
      	$rowData = model('Feed')->get(intval($var['commentInfo']['row_id']));
      	$appRowData = model('Feed')->get($rowData['app_row_id']);
      	$var['user_info'] = $appRowData['user_info'];
      	// 微博类型
      	$var['feedtype'] = $rowData['type'];
      	// $var['cancomment_old'] = ($var['commentInfo']['uid'] != $var['commentInfo']['app_uid'] && $var['commentInfo']['app_uid'] != $this->uid) ? 1 : 0;
      	if($var['flag'] != 1){
      		$var['initHtml'] = L('PUBLIC_STREAM_REPLY').'@'.$var['commentInfo']['user_info']['uname'].' ：';
      	}

      	//获取回评
      	$commentList = D('weiba_reply')->where('is_del = 0 and to_reply_id='.$var['to_reply_id'])->order('ctime')->select();
      	foreach($commentList as $k=>$v){
      		$commentList[$k]['content'] = parse_html(h(htmlspecialchars($v['content'])));
      	}
      	$this->assign('commentList', $commentList);
      	$uids = getSubByKey($commentList, 'uid');
      	$this->_assignUserInfo($uids);

      	$this->assign('var', $var);
		$con = $this->fetch();
		echo $con;
	}

	/**
	 * [给评论点赞]
	 * @return [type] [description]
	 */
	public function click_zan(){
		$data['reply_id'] = intval($_POST['rid']);
		$data['uid'] = $this->mid;
		$id = D('weiba_czan')->where($data)->getField('id');
		if($id){
			$this->error('已赞过，不能重复点击');
		}else{
			$data['zan_time'] = time();
			D('weiba_czan')->add($data);
			D('weiba_reply')->where('reply_id='.$data[reply_id])->setInc('zan');
			
			$this->ajaxReturn(1);
		}
	}

	/**
	 * 批量获取用户的相关信息加载
	 * @param string|array $uids 用户ID
	 */
	private function _assignUserInfo($uids) {
		!is_array($uids) && $uids = explode(',', $uids);
		$user_info = model('User')->getUserInfoByUids($uids);
		$this->assign('user_info', $user_info);
		//dump($user_info);exit;
	}


}