<?php
/**
 * 微吧控制器
 * @author 
 * @version TS3.0
 */
class IndexAction extends Action {

	/**
	 * 微吧首页
	 * @return void
	 */
	public function index() {
		// 获取个人信息
		$userinfo = model ( 'User' )->getUserInfo ( $this->mid );
		$this->assign('userinfo', $userinfo);
		//微吧推荐
		$this->_weiba_recommend(10,100,100);
		//热帖推荐
		//$this->_post_recommend(10);
		//微吧排行榜
		//$this->_weibaOrder();
		//帖子列表
		$this->_postList();


		$this->setTitle( '微吧首页' );
		$this->setKeywords( '微吧首页' );
		$this->display();
	}

	/**
	 * 微吧列表
	 * @return void
	 */
	public function weibaList(){
		// 获取个人信息
		$userinfo = model ( 'User' )->getUserInfo ( $this->mid );
		$this->assign('userinfo', $userinfo);
		/*
		$map['is_del'] = 0;
		$weibaList = D('weiba')->where($map)->order('recommend desc,follower_count desc,thread_count desc')->findpage(16);
		$weiba_ids = getSubByKey($weibaList['data'],'weiba_id');
		$followStatus = D('weiba')->getFollowStateByWeibaids($this->mid,$weiba_ids);
		foreach($weibaList['data'] as $k=>$v){
			$weibaList['data'][$k]['logo'] = getImageUrlByAttachId($v['logo'],100,100);
			$weibaList['data'][$k]['following'] = $followStatus[$v['weiba_id']]['following'];
		}
		$this->assign('weibaList',$weibaList);
		*/
		//回复最高5条
		$replyH_Post = D('weiba_post')->where('is_del=0')->order('reply_count desc')->limit(8)->select();
		$this->assign('replyH_Post',$replyH_Post);
		//微吧推荐
		$pidweiba = D('weiba_structure') -> field('pid') -> group('pid') -> select();
		foreach($pidweiba as $v){
			if($v['pid'] != 0){
				$weiba_info[] = D('weiba')->field('weiba_name, weiba_id') -> where('weiba_id='.$v['pid'])-> find();
			}			
		}
		$this->assign('weiba_info', $weiba_info);

		$weibaList_id = D('weiba_structure') -> field('weiba_id') -> where('pid='.$weiba_info[0]['weiba_id']) -> select();
		foreach($weibaList_id as $v){
			$weiba_info_tmp = D('weiba') -> order('recommend desc,follower_count desc,thread_count desc') -> where('weiba_id='.$v['weiba_id'])-> find();
			if($weiba_info_tmp['is_del'] == 0){
				$weiba_info_tmp['logo'] = getImageUrlByAttachId($weiba_info_tmp['logo'],100,100);
				$weiba_info_tmp['following'] = D('weiba_follow')->where('weiba_id='.$weiba_info_tmp['weiba_id'].' and follower_uid='.$this->mid)->getField('id');
				$weibaList[] = $weiba_info_tmp;
			}
		}
		$this->assign('weibaList', $weibaList);
		//微吧排行榜
		$this->_weibaOrder();
		$this->assign( 'cid' , $cid );
		$this->assign('nav','weibalist');
		$this->assign( 'weibacate' , $weibacate );
		$this->setTitle( '微吧列表' );
		$this->setKeywords( '全站微吧列表' );
		$this->display();
	}

	/**
	 * [ajax通过pid取出子话题]
	 * @return [type] [description]
	 */
	public function getWeibaChild() {
		$pid = t($_POST['pid']);
		if($pid) {
			$weibaList_id = D('weiba_structure') -> field('weiba_id') -> where('pid='.$pid) -> select();
			foreach($weibaList_id as $v){
				$weiba_info_tmp = D('weiba') -> order('recommend desc,follower_count desc,thread_count desc') -> where('weiba_id='.$v['weiba_id'])-> find();
				if($weiba_info_tmp['is_del'] == 0){
					$weiba_info_tmp['following'] = D('weiba_follow')->where('weiba_id='.$v['weiba_id'].' and follower_uid='.$this->mid)->getField('id');
					$weiba_info_tmp['logo'] = getImageUrlByAttachId($weiba_info_tmp['logo'],100,100);
					$weibaList[] = $weiba_info_tmp;
				}
			}
			$this->assign('weibaList', $weibaList);
			$con = $this->fetch();
			$this->ajaxReturn($con,'发布成功');
		}else{
			$this->error('访问有误');
		}
	}


	/**
	 * 帖子列表
	 */
	public function postList(){
		//微吧推荐
		$this->_weiba_recommend(9);
		//帖子列表
		$this->_postList();

		$this->setTitle( '全站帖子列表' );
		$this->setKeywords( '全站帖子列表' );
		$this->display();
	}

	/**
	 * 我的微吧
	 * @return  void
	 */
	public function myWeiba(){
		$map['weiba_id'] = array('in',getSubByKey(D('weiba')->where('is_del=0')->field('weiba_id')->findAll(),'weiba_id'));
		$map['is_del'] = 0;
		switch (t($_GET['type'])) {
			case 'myPost':
				$map['post_uid'] = $this->mid;
				$postList = D('weiba_post')->where($map)->order('post_time desc')->findpage(20);
				break;
			case 'myReply':
				$myreply = D('weiba_reply')->where('uid='.$this->mid)->order('ctime desc')->field('post_id')->findAll();
				$map['post_id'] = array('in',array_unique(getSubByKey($myreply, 'post_id')));
				$postList = D('weiba_post')->where($map)->order('last_reply_time desc')->findpage(20);
				break;
			case 'myFavorite':
				$myFavorite = D('weiba_favorite')->where('uid='.$this->mid)->order('favorite_time desc')->findAll();
				//dump($myFavorite);exit;
				$map['post_id'] = array('in',getSubByKey($myFavorite, 'post_id'));
				$postList = D('weiba_post')->where($map)->findpage(20);
				break;
			default:
				$myFollow = D('weiba_follow')->where('follower_uid='.$this->mid)->findAll();
				$map['weiba_id'] = array('in',getSubByKey($myFollow, 'weiba_id'));
				$postList = D('weiba_post')->where($map)->order('last_reply_time desc')->findpage(20);
				break;
		}	
		// if($postList['nowPage']==1){  //列表第一页加上全局置顶的帖子
		// 	$topPostList = D('weiba_post')->where('top=2 and is_del=0')->order('post_time desc')->findAll();
		// 	!$topPostList && $topPostList = array();
		// 	!$postList['data'] && $postList['data'] = array();
		// 	$postList['data'] = array_merge($topPostList,$postList['data']);
		// }
		$weiba_ids = getSubByKey($postList['data'], 'weiba_id');
		$nameArr = $this->_getWeibaName($weiba_ids);
		foreach($postList['data'] as $k=>$v){
			$postList['data'][$k]['weiba'] = $nameArr[$v['weiba_id']];
		}
		$post_uids = getSubByKey($postList['data'], 'post_uid');
		$reply_uids = getSubByKey($postList['data'], 'last_reply_uid');
		$uids = array_unique(array_merge($post_uids,$reply_uids));
		$this->_assignUserInfo($uids);
		$this->assign('postList',$postList);
		$this->assign('type',t($_GET['type']));
		$this->assign('nav','myweiba');

		$this->setTitle( '我的微吧' );
		$this->setKeywords( '我的微吧' );
		$this->display();
	}

	/**
	 * 微吧详情页
	 * @return void
	 */
	public function detail(){
		$weiba_id = intval($_GET['weiba_id']);
		$weiba_detail = D('weiba')->where('is_del=0 and weiba_id='.$weiba_id)->find();
		if(!$weiba_detail){
			$this->error('该微吧不存在或已被解散');
		}
		$weiba_detail['logo'] = getImageUrlByAttachId($weiba_detail['logo'],50,50);
		//吧主
		$map['weiba_id'] = $weiba_id;
		$map['level'] = array('in','2,3');
		$weiba_admin = D('weiba_follow')->where($map)->order('level desc')->field('follower_uid,level')->findAll();
		if($weiba_admin){
			foreach($weiba_admin as $k=>$v){
				// 获取用户用户组信息
				$userGids = model('UserGroupLink')->getUserGroup($v['follower_uid']);
				$userGroupData = model('UserGroup')->getUserGroupByGids($userGids[$v['follower_uid']]);
				foreach($userGroupData as $key => $value) {
					if($value['user_group_icon'] == -1) {
						unset($userGroupData[$key]);
						continue;
					}
					$userGroupData[$key]['user_group_icon_url'] = THEME_PUBLIC_URL.'/image/usergroup/'.$value['user_group_icon'];
				}
				$weiba_admin[$k]['userGroupData'] = $userGroupData;
			}
			$weiba_admin_uids = getSubByKey($weiba_admin, 'follower_uid');		
			$this->_assignFollowUidState($weiba_admin_uids);
			$this->assign('weiba_admin',$weiba_admin);
			$this->assign('weiba_admin_uids',$weiba_admin_uids);
			$this->assign('weiba_super_admin',D('weiba_follow')->where('level=3 and weiba_id='.$weiba_id)->getField('follower_uid'));
			$this->assign('weiba_admin_count',D('weiba_follow')->where($map)->count());
			
		}
		$isadmin = 0;
		if( in_array( $this->mid , $weiba_admin_uids ) || CheckPermission('core_admin','admin_login')){
			$isadmin = 1;
		}
		$this->assign('isadmin',$isadmin);
		//帖子
		$DB_PREFIX = C('DB_PREFIX');
		$table = "{$DB_PREFIX}weiba_relation AS a LEFT JOIN {$DB_PREFIX}weiba_post AS b ON a.post_id=b.post_id";
		if($_GET['type'] == 's'){
			$_where = 'a.weiba_id = '.$weiba_id.' and b.is_del != 1 and b.post_type=2';
		} elseif ($_GET['type'] == 'a') {
			$_where = 'a.weiba_id = '.$weiba_id.' and b.is_del != 1';
		} else {
			$_where = 'a.weiba_id = '.$weiba_id.' and b.is_del = 0 and b.post_type=1';
		}		
		$this->assign('t', $_GET['type']);


		if($_GET['type']=='digest'){
			$_where .= ' and b.digest=1';
			$order = 'b.post_time desc';
			$this->assign('type','digest');
			$this->assign('post_count',model()->table($table) -> where('b.is_del=0 AND b.digest=1 AND a.weiba_id='.$weiba_id)->count());
		}else{
			$_where .= ' and b.top= 0';
			$this->assign('type','all');
			$this->assign('post_count',model()->table($table)->where('b.is_del=0 AND a.weiba_id='.$weiba_id)->count());
		}
		if($_GET['order']=='post_time'){
			$order = 'b.post_time desc';
			$this->assign('order','post_time');
		}else{
			$order = 'b.last_reply_time desc';
			$this->assign('order','reply_time');
		}
		
		
		$list = model()->table($table)->where($_where)->order($order)->findpage(20); 
		//获取关注状态
		$list['data'] = $this->_getFavoriteStatus($list['data']); 

		if($_GET['type']!='digest' && $list['nowPage']==1){  //列表第一页加上全局置顶的帖子
			$topPostList = D('weiba_post')->where('top=2 and is_del=0')->order('post_time desc')->findAll();  //全局置顶
			$innerTop = D('weiba_post')->where('top=1 and is_del=0 and weiba_id='.$weiba_id)->order('post_time desc')->findAll();
			!$topPostList && $topPostList = array();
			!$innerTop && $innerTop = array();
			!$list['data'] && $list['data'] = array();
			$list['data'] = array_merge($topPostList,$innerTop,$list['data']);
		}
		$post_uids = getSubByKey($list['data'], 'post_uid');
		$reply_uids = getSubByKey($list['data'], 'last_reply_uid');
		!$weiba_admin_uids && $weiba_admin_uids = array();
		$uids = array_unique(array_filter(array_merge($post_uids,$reply_uids,$weiba_admin_uids)));
		$uids[] = $this->mid;
		$this->_assignUserInfo($uids);

		$this->_assignFollowState($weiba_id);
		$this->assign('list',$list);
		$this->assign('weiba_detail',$weiba_detail);

		if($_GET['type']=='digest'){
			$jinghua = '精华帖';
		}
		$this->assign('nav' , 'weibadetail');
		$this->assign('weiba_name' , $weiba_detail['weiba_name']);
		$this->assign('weiba_id', $weiba_id );
		$this->setTitle( $weiba_detail['weiba_name'].$jinghua );
		$this->setKeywords( $weiba_detail['weiba_name'].$jinghua );
		$this->setDescription( $weiba_detail['weiba_name'].','.$weiba_detail['intro'] );
		$this->display();
	}

	/**
	 * 关注微吧
	 */
	public function doFollowWeiba(){
		$res = D('weiba')->doFollowWeiba($this->mid, intval($_REQUEST['weiba_id']));
    	$this->ajaxReturn($res, D('weiba')->getError(), false !== $res);
	}

	/**
	 * 取消关注微吧
	 */
	public function unFollowWeiba(){
		$res = D('weiba')->unFollowWeiba($this->mid, intval($_REQUEST['weiba_id']));
    	$this->ajaxReturn($res, D('weiba')->getError(), false !== $res);
	}

	/**
	 * 检查发帖权限
	 * @return boolean 是否有发帖权限 0：否  1：是
	 */
	public function checkPost(){
		$weiba_id = intval($_POST['weiba_id']);
		$map['weiba_id'] = $weiba_id;
		$map['follower_uid'] = $this->mid;
		if(D('weiba_follow')->where($map)->find()){
			echo 1;
		}else{
			echo 0;
		}
	}

	/**
	 * 弹窗加入微吧
	 */
	public function joinWeiba(){
		$weiba_id = intval($_GET['weiba_id']);
		$this->assign('weiba_id',$weiba_id);
		$this->display();
	}

	//发布帖子
	public function quickPost(){
		$post_type = intval($_POST['t']);
		$post_type = $post_type == 1 ? 1 : 2;
		$con = F('zbq_quickPost'.$post_type);
		if(!$con) {	
			$this->assign('post_type', $post_type);
			$con = $this->fetch();
			F('zbq_quickPost'.$post_type, $con , TEMP_PATH);
		}				
		echo $con;
	}

	/**
	 * 检查微吧 权限
	 */
	public function checkWeibaStatus(){
		$weibaid = intval ( $_POST['weibaid'] );
		$poststatus = D('weiba')->where('weiba_id='.$weibaid)->getField('who_can_post');
		switch ( $poststatus ){
			case 1:
				$follow_state = D('weiba')->getFollowStateByWeibaids($this->mid,$weibaid);
				if ( !$follow_state[$weibaid]['following'] && !CheckPermission('core_admin','admin_login')){
					echo 1;
				}
				break;
			case 2:
				//吧主
				$map['weiba_id'] = $weibaid;
				$map['level'] = array('in','2,3');
				$weiba_admin = D('weiba_follow')->where($map)->order('level desc')->field('follower_uid,level')->findAll();
				
				if ( !in_array(  $this->mid , getSubByKey( $weiba_admin , 'follower_uid' )) && !CheckPermission('core_admin','admin_login') ){
					echo 2;
				}
				break;
			case 3:
				//吧主
				$map['weiba_id'] = $weibaid;
				$map['level'] = 3;
				$weiba_admin = D('weiba_follow')->where($map)->order('level desc')->field('follower_uid,level')->find();
				if ( $this->mid != $weiba_admin['follower_uid']  && !CheckPermission('core_admin','admin_login') ){
					echo 3;
				}
				break;
		}
	}
	/**
	 * 发布帖子
	 * @return void
	 */
	public function post(){
		if( !CheckPermission('weiba_normal','weiba_post') ){
			$this->error('对不起，您没有权限进行该操作！');
		}
		$post_type = intval($_GET['pt']);
		$post_type = $post_type == 1 ? 1 : 2;
		$this->assign('post_type', $post_type);

		$this->setTitle( '发布问题 '.$weiba['weiba_name'] );
		$this->setKeywords( '发布问题 '.$weiba['weiba_name'] );
		$this->setDescription( $weiba['weiba_name'].','.$weiba['intro'] );
		$this->display();
	}

	/**
	 * 执行发布帖子
	 * @return void
	 */
	public function doPost(){
		if( !CheckPermission('weiba_normal','weiba_post') ){
			$this->error('对不起，您没有权限进行该操作！',true);
		}
		$weibaid_str = t($_POST['weiba_id']);
		if ( !$weibaid_str ){
			$this->error('请选择话题！',true);
		}
		$weibaId_Arr = explode(',', $weibaid_str);
		/* 权限验证，暂时不用
		if ( !CheckPermission('core_admin','admin_login') ) {
			switch ( $weiba['who_can_post'] ){
				case 1:
					$map['weiba_id'] = $weibaid;
					$map['follower_uid'] = $this->mid;
					$res = D('weiba_follow')->where($map)->find();
					if ( !$res && !CheckPermission('core_admin','admin_login')){
						$this->error('对不起，您没有发帖权限，请关注该微吧！',true);
					}
					break;
				case 2:
					$map['weiba_id'] = $weibaid;
					$map['level'] = array('in','2,3');
					$weiba_admin = D('weiba_follow')->where($map)->order('level desc')->field('follower_uid')->findAll();
					if ( !in_array( $this->mid , getSubByKey( $weiba_admin , 'follower_uid') ) && !CheckPermission('core_admin','admin_login')){
						$this->error( '对不起，您没有发帖权限，仅限管理员发帖！',true );
					}
					break;
				case 3:
					$map['weiba_id'] = $weibaid;
					$map['level'] = 3;
					$weiba_admin = D('weiba_follow')->where($map)->order('level desc')->field('follower_uid')->find();
					if ( $this->mid != $weiba_admin['follower_uid']  && !CheckPermission('core_admin','admin_login') ){
						$this->error( '对不起，您没有发帖权限，仅限吧主发帖！',true );
					}
					break;
			}
		}
		*/
		$checkContent = str_replace('&nbsp;', '', $_POST['content']);
		$checkContent = str_replace('<br />', '', $checkContent);
		$checkContent = str_replace('<p>', '', $checkContent);
		$checkContent = str_replace('</p>', '', $checkContent);
		$checkContents = preg_replace('/<img(.*?)src=/i','img',$checkContent);
		$checkContents = preg_replace('/<embed(.*?)src=/i','img',$checkContents);
		if(strlen(t($_POST['title']))==0) $this->error('帖子标题不能为空',true);
		if(strlen(t($checkContents))==0) $this->error('帖子内容不能为空',true);
		preg_match_all('/./us', t($_POST['title']), $match);  
        if(count($match[0])>30){     //汉字和字母都为一个字
        	$this->error('帖子标题不能超过30个字',true);
        }
		if ( $_POST['attach_ids'] ){
			$attach = explode('|', $_POST['attach_ids']);
			foreach ( $attach as $k=>$a){
				if ( !$a ){
					unset($attach[$k]);
				}
			}
			$attach = array_map( 'intval' , $attach);
			$data['attach'] =  serialize($attach);
		}
		$data['weiba_id'] = 1;
		$data['title'] = t($_POST['title']);
		$data['content'] = h($_POST['content']);
		$data['post_uid'] = $this->mid;
		$data['post_time'] = time();
		$data['last_reply_uid'] = $this->mid;
		$data['last_reply_time'] = $data['post_time'];
		$data['post_type'] = t($_POST['post_type']);
		$data['post_reason'] = t($_POST['post_reason']);
		$data['is_del'] = $data['post_type'] == 2 ? 2 : 0;
		$res = D('weiba_post')->add($data);
		if($res){
			$this->_addWeibaRelation($weibaId_Arr, $res, $data['is_del']);
			//同步到微博
			// $feed_id = D('weibaPost')->syncToFeed($res,$data['title'],t($checkContent),$this->mid);
			 D('weiba_post')->where('post_id='.$res)->setField('feed_id',$res);
			//$this->assign('jumpUrl', U('weiba/Index/postDetail',array('post_id'=>$res)));
			//$this->success('发布成功');

			//添加积分
			if($data['post_type'] == 2) {
				//分享，有原因加分
				if($data['post_reason'] != '') {
					model('Credit')->setUserCredit($this->mid, 'publish_shareReason');
				}
				model('Credit')->setUserCredit($this->mid,'publish_share');
			}else {
				model('Credit')->setUserCredit($this->mid,'publish_topic');
			}
			
			//进入帖子详情页
			$this->redirect('weiba/Index/postDetail',array('post_id'=>$res));
			//仿知乎，进入帖子单项编辑页
			//$this->redirect('weiba/Index/editQuestion',array('id'=>$res));
			//return $this->ajaxReturn($res, '发布成功', 1);
		}else{
			$this->error('发布失败',true);
		}
	}

	/**
	 * [修改发布的帖子]
	 * @return [type] [description]
	 */
	public function editQuestion() {
		$post_id = t($_GET['id']);
		if($post_id) {
			// 获取个人信息
			$userinfo = model ( 'User' )->getUserInfo ( $this->mid );
			$this->assign('userinfo', $userinfo);
			//微吧推荐
			$this->_weiba_recommend(10,100,100);

			$res = D('weiba_post') -> field('title, content, reply_count') -> where('post_id='.$post_id.' and post_uid='.$this->mid) -> find();
			if($res) {
				$relation_res = D('weiba_relation') -> field('weiba_id, weiba_name') -> where('post_id='.$post_id) -> select();
				$this->assign('res',$res);
				$this->assign('relation_res', $relation_res);
				$this->display();

			} else {
				$this->error('您访问的页面有误');
			}		
		} else {
			$this->error('您访问的页面有误');
		}
		
	}


	/**
     * 获取评论列表
     * @return array
     */
    public function getCommentList() {
      $map = array ();
      $map ['post_id'] = intval ( $_POST ['row_id'] ); // 必须存在
      if (! empty ( $map ['post_id'] )) {
        // 分页形式数据
        $var ['limit'] = 10;
        $var ['order'] = 'DESC';
        $var ['cancomment'] = $_POST ['cancomment'];
        $var ['showlist'] = $_POST ['showlist'];
        $var ['app_name'] = t ( $_POST ['app_name'] );
        $var ['table'] = t ( $_POST ['table'] );
        $var ['row_id'] = intval ( $_POST ['row_id'] );
        $var ['list'] = D('weiba')->getCommentList( $map, 'reply_id ' . $var ['order'], $var ['limit'] );
      }
      $this->assign('list', $var['list']);
      $content = $this->fetch ();
      exit ( $content );
    }

    /**
     * [删除评论]
     * @return [type] [description]
     */
    public function del_reply() {
    	$reply_id = t($_POST['id']);
    	$post_id = t($_POST['pid']);
    	if($reply_id && $post_id){
    		$data['is_del'] = 1;
    		$res = D('weiba_reply') -> where('reply_id='.$reply_id.' and (uid='.$this->mid.' or post_id='.$this->mid.')') -> save($data);
    		if($res) {
    			D('weiba_post') -> where('post_id='.$post_id) -> setDec('reply_count');
    			$this->ajaxReturn(1);
    		} 
    	}
    	$this->error('操作有误');
    }

	/**
	 * 帖子详情页
	 * @return void
	 */
	public function postDetail(){
		//避免重复加载富文本框js,导致失效
		$this->assign('p',1);

		$post_id = intval($_GET['post_id']);
		$post_detail = D('weiba_post')->where('post_id='.$post_id)->find();
		$is_del = D('weiba')->where('weiba_id='.$post_detail['weiba_id'])->getField('is_del');
		if(!$post_detail || $post_detail['is_del'] == 1) $this->error('帖子不存在或已被删除');
		//if( $post_detail[is_del]==2 && $this->mid !=1 && $this->mid != $post_detail['post_uid'] ) $this->error('帖子不存在或已被删除');
		$post_detail['favorite'] = $this->_getFavoriteStatus($post_id);
		if ( $post_detail['attach'] ){
			$attachids = unserialize( $post_detail['attach'] );
			$attachinfo = model('Attach')->getAttachByIds( $attachids );
			foreach($attachinfo as $ak => $av) {
				$_attach = array(
						'attach_id'   => $av['attach_id'],
						'attach_name' => $av['name'],
						'attach_url'  => getImageUrl($av['save_path'].$av['save_name']),
						'extension'   => $av['extension'],
						'size'		  => $av['size']
				);
				$post_detail['attachInfo'][$ak] = $_attach;
			}
		}

		$this->assign('post_detail',$post_detail);
		D('weiba_post')->where('post_id='.$post_id)->setInc('read_count');
		$weiba_name = D('weiba')->where('weiba_id='.$post_detail['weiba_id'])->getField('weiba_name');
		$this->assign('weiba_id' , $post_detail['weiba_id']);
		$this->assign('weiba_name', $weiba_name);
		//获得问题所属微吧
		$relation_res = D('weiba_relation') -> field('weiba_id, weiba_name') -> where('post_id='.$post_id) -> select();
		$this->assign('relation_res', $relation_res);
		//获得关注问题人的信息
		$favorite_res = D('weiba_favorite') -> field('uid') -> limit(18) -> where('post_id='.$post_id) -> order('favorite_time') -> select();
		foreach($favorite_res as $k=>$v){
			$favorite_people_tmp = D('user') -> field('uid, uname') -> where('uid='.$v['uid']) -> find();
			$favorite_people[] = array_merge ( $favorite_people_tmp, model ( 'Avatar' )->init ( $v['uid'] )->getUserAvatar () );
		}
		$this->assign('favorite_people', $favorite_people);
		/*
		//获得吧主uid,获取权限管理
		$map['weiba_id'] = $post_detail['weiba_id'];
		$map['level'] = array('in','2,3');
		$weiba_admin = getSubByKey(D('weiba_follow')->where($map)->order('level desc')->field('follower_uid')->findAll(),'follower_uid');
		$weiba_manage = false;
		if ( CheckWeibaPermission( $weiba_admin , 0 , 'weiba_global_top')
				 || CheckWeibaPermission( $weiba_admin , 0 , 'weiba_top') 
				 || CheckWeibaPermission( $weiba_admin , 0 , 'weiba_recommend' )
				 || CheckWeibaPermission( $weiba_admin , 0 , 'weiba_edit' )
				 || CheckWeibaPermission( $weiba_admin , 0 , 'weiba_del' )){
			$weiba_manage = true;
		}
		$this->assign( 'weiba_manage' , $weiba_manage );
		$this->assign('weiba_admin', $weiba_admin );
		//该作者的其他帖子
		$map1['post_id'] = array('neq',$post_id);
		$map1['post_uid'] = $post_detail['post_uid'];
		$map1['is_del'] = 0;
		$otherPost = D('weiba_post')->where($map1)->order('reply_count desc')->limit(5)->findAll();
		$weiba_ids = getSubByKey($otherPost, 'weiba_id');
		$nameArr = $this->_getWeibaName($weiba_ids);
		foreach($otherPost as $k=>$v){
			$otherPost[$k]['weiba'] = $nameArr[$v['weiba_id']];
		}
		$this->assign('otherPost',$otherPost);
		*/
		$uids = $post_detail['post_uid'] .','.$this->mid;
		$this->_assignUserInfo($uids);
		
		//回复最高5条
		$replyH_Post = D('weiba_post')->where('is_del=0')->order('reply_count desc')->limit(5)->select();
		// $weiba_ids = getSubByKey($replyH_Post, 'weiba_id');
		// $nameArr = $this->_getWeibaName($weiba_ids);
		// foreach($replyH_Post as $k=>$v){
		// 	$replyH_Post[$k]['weiba'] = $nameArr[$v['weiba_id']];
		// }
		$this->assign('replyH_Post',$replyH_Post);
		
		$this->_weibaOrder();
		$this->assign( 'nav' , 'weibadetail' );
		$this->setTitle( $post_detail['title'].' '.$weiba_name );
		$this->setKeywords( $post_detail['title'].' '.$weiba_name );
		$this->setDescription( $post_detail['title'].','.t(getShort($post_detail['content'],100)) );
		$this->display();
	}

	/**
	 * 收藏帖子
	 * @return void
	 */
	public function favorite(){
		$data['post_id'] = intval($_POST['post_id']);
		$data['weiba_id'] = intval($_POST['weiba_id']);
		$data['post_uid'] = intval($_POST['post_uid']);
		$data['uid'] = $this->mid;
		$data['favorite_time'] = time();
		if(D('weiba_favorite')->add($data)){
			D('weiba_post')->where('post_id='.$data['post_id'])->setInc('favorite_count');
			//添加积分
			model('Credit')->setUserCredit($this->mid,'collect_topic');
			model('Credit')->setUserCredit($data['post_uid'],'collected_topic');

			echo 1;
		}else{
			echo 0;
		}
	}

	/**
	 * 取消收藏帖子
	 * @return void
	 */
	public function unfavorite(){
		$map['post_id'] = intval($_POST['post_id']);
		$map['uid'] = $this->mid;
		if(D('weiba_favorite')->where($map)->delete()){
			D('weiba_post')->where('post_id='.$data['post_id'])->setDec('favorite_count');
			echo 1;
		}else{
			echo 0;
		}
	}

	/**
	 * 编辑帖子
	 * @return void
	 */
	public function postEdit(){
		$this->assign('p', 1);
		$post_id = intval($_GET['post_id']);
		
		$post_detail = D('weiba_post')->where('post_id='.$post_id)->find();
		//获得吧主uid
		$map['weiba_id'] = $post_detail['weiba_id'];
		$map['level'] = array('in','2,3');
		$weiba_admin = getSubByKey(D('weiba_follow')->where($map)->order('level desc')->field('follower_uid')->findAll(),'follower_uid');
		
		//管理权限判断
		if ( !CheckWeibaPermission( $weiba_admin , 0 ,'weiba_edit') ){
			//用户组权限判断
			if ( !CheckPermission('weiba_normal','weiba_edit') ){
				$this->error('对不起，您没有权限进行该操作！');
			}
		}
		
		if( $this->mid==$post_detail['post_uid'] || CheckWeibaPermission( $weiba_admin , 0 ,'weiba_edit')){
			$post_detail['attach'] = unserialize( $post_detail['attach'] );
			$this->assign('post_detail',$post_detail);
			if($_GET['log']) $this->assign('log',intval($_GET['log']));
			//$this->assign('weiba_name',D('weiba')->where('weiba_id='.$post_detail['weiba_id'])->getField('weiba_name'));
			$tmpArr = D('weiba_relation')->where('post_id='.$post_detail['post_id'])->field('weiba_name, weiba_id')->select();
			foreach($tmpArr as $v){
				$weiba_id .= $v['weiba_id'].',';
			}
			$this->assign('weiba_Arr', $tmpArr);
			$this->assign('weiba_id', rtrim($weiba_id,',')); 

			$this->setTitle( '编辑帖子 '.$weiba['weiba_name'] );
			$this->setKeywords( '编辑帖子 '.$weiba['weiba_name'] );
			$this->setDescription( $post_detail['title'].','.t(getShort($post_detail['content'],100)) );
			$this->display();
		}else{
			$this->error('您没有权限！');
		}
		
	}

	/**
	 * 执行编辑帖子
	 * @return void
	 */
	public function doPostEdit(){
		$weibaid_str = t($_POST['weiba_id']);
		if ( !$weibaid_str ){
			$this->error('请选择话题！',true);
		}
		$weibaId_Arr = explode(',', $weibaid_str);
		$weiba = D('weiba_post')->where('post_id='.intval($_POST['post_id']))->field('attach, post_uid')->find();
		/*
			if ( !CheckWeibaPermission( '' , $weiba['weiba_id'] ,'weiba_edit') ){
				if ( !CheckPermission('weiba_normal','weiba_edit') ){
					$this->error('对不起，您没有权限进行该操作！',true);
				}
			}
		*/
		if($weiba['post_uid'] == $this->mid){
			$_POST['content'] = $_POST['editorValue'];
			$checkContent = str_replace('&nbsp;', '', $_POST['content']);
			$checkContent = str_replace('<br />', '', $checkContent);
			$checkContent = str_replace('<p>', '', $checkContent);
			$checkContent = str_replace('</p>', '', $checkContent);
			$checkContents = preg_replace('/<img(.*?)src=/i','img',$checkContent);
			$checkContents = preg_replace('/<embed(.*?)src=/i','img',$checkContents);
			if(strlen(t($_POST['title']))==0) $this->error('帖子标题不能为空',true);
			if(strlen(t($checkContents))==0) $this->error('帖子内容不能为空',true);
			preg_match_all('/./us', t($_POST['title']), $match);  
	        if(count($match[0])>30){     //汉字和字母都为一个字
	        	$this->error('帖子标题不能超过30个字',true);
	        }
			$post_id = intval($_POST['post_id']);
			$data['title'] = t($_POST['title']);
			$data['content'] = h($_POST['content']);
			$data['attach'] = '';
			if ( $_POST['attach_ids'] ){
				$attach = explode('|', $_POST['attach_ids']);
				foreach ( $attach as $k=>$a){
					if ( !$a ){
						unset($attach[$k]);
					}
				}
				$attach = array_map( 'intval' , $attach);
				$data['attach'] =  serialize($attach);
			}
			$data['post_reason'] = t($_POST['post_reason']);
			$data['is_del'] = $data['post_type'] == 2 ? 2 : 0;
			$res = D('weiba_post')->where('post_id='.$post_id)->save($data);

			if($res!==false){
				$post_detail = D('weiba_post')->where('post_id='.$post_id)->find();
				if(intval($_POST['log'])==1){
					D('log')->writeLog($post_detail['weiba_id'],$this->mid,'编辑了帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”','posts');
				}
				//保存所属微吧
				$this->_addWeibaRelation($weibaId_Arr, $post_id);
				//同步到微博
				/*
				$feedInfo = D('feed_data')->where('feed_id='.$post_detail['feed_id'])->find();
				$datas = unserialize($feedInfo['feed_data']);
				$datas['content'] = '【'.$data['title'].'】'.getShort(t($checkContent),100).'&nbsp;';
				$datas['body'] = $datas['content'];
				$data1['feed_data'] = serialize($datas);
				$data1['feed_content'] = $datas['content'];
				$feed_id = D('feed_data')->where('feed_id='.$post_detail['feed_id'])->save($data1);
				model('Cache')->rm('fd_'.$post_detail['feed_id']);
				*/
				$this->redirect('weiba/Index/postDetail', array('post_id'=>$post_id), 0, '编辑成功');
			}
		}
		$this->error('编辑失败',true);
	}

	
	/**
	 * 删除帖子
	 * @return void
	 */
	public function postDel(){
		$post_uid = D('weiba_post')->where('post_id='.intval($_POST['post_id']))->getField('post_uid');
		if($this->mid == $post_uid) {
			$post_id = $_POST['post_id'];
			if(D('weiba_post')->where('post_id='.$post_id)->setField('is_del',1)){
				$post_detail = D('weiba_post')->where('post_id='.$post_id)->find();
				if(intval($_POST['log'])==1){
					D('log')->writeLog($post_detail['weiba_id'],$this->mid,'删除了帖子“'.$post_detail['title'].'”','posts');
				}
				$weiba_Arr = D('weiba_relation')->where('post_id='.$post_id)->field('weiba_id, rid')->select();
				foreach($weiba_Arr as $v){
					D('weiba')->where('weiba_id='.($v['weiba_id']))->setDec('thread_count');
				}	
					
				//添加积分
				model('Credit')->setUserCredit($this->mid,'delete_topic');

				// 删除相应的微博信息
				model('Feed')->doEditFeed($post_detail['feed_id'], 'delFeed', '', $this->mid);
				
				echo 1;
			}
		}
		
	}

	/**
	 * 设置帖子类型(置顶或精华)
	 * @return void
	 */
	public function postSet(){
		$post_id = intval($_POST['post_id']);
		$type = intval($_POST['type']);
		if($type==1){
			$field = 'top';
		}
		if($type==2){
			$field = 'digest';
		}
		if($type==3){
			$field = 'recommend';
		}
		$currentValue = intval($_POST['currentValue']);
		$targetValue = intval($_POST['targetValue']);
		if ( $targetValue == '1' && $type == 1 ){
			$action = 'weiba_top';
		} else if( $targetValue == '2' && $type == 1){
			$action = 'weiba_global_top';
		} else if ( $type == 2 ){
			$action = 'weiba_marrow';
		} else if ( $type == 3 ){
			$action = 'weiba_recommend';
		}
		$weiba_id = D('weiba_post')->where('post_id='.$post_id)->getField('weiba_id');
		if ( $targetValue == '0' && $type == 1 ){
			if ( !CheckWeibaPermission( '' , $weiba_id , 'weiba_top') && !CheckWeibaPermission( '' , $weiba_id , 'weiba_global_top') ){
				$this->error( '对不起，您没有权限进行该操作！' );
			}
		} else {
			if ( !CheckWeibaPermission( '' , $weiba_id , $action) ){
				$this->error( '对不起，您没有权限进行该操作！' );
			}
		}
		
		if(D('weiba_post')->where('post_id='.$post_id)->setField($field,$targetValue)){
			$post_detail = D('weiba_post')->where('post_id='.$post_id)->find();
			$config['post_name'] = $post_detail['title'];
			$config['post_url'] = '<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>';
			if($type==1){
				switch ($targetValue) {
					case '0':      //取消置顶
						if($currentValue==1){
							D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”取消了吧内置顶','posts');
						}else{
							D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”取消了全局置顶','posts');
						}

						//添加积分
						model('Credit')->setUserCredit($post_detail['post_uid'],'untop_topic_all');

						break;
					case '1':     //设为吧内置顶
							$config['typename'] = "吧内置顶";
							model('Notify')->sendNotify($post_detail['post_uid'], 'weiba_post_set', $config); 
							D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”设为了吧内置顶','posts');
						
						//添加积分
						model('Credit')->setUserCredit($post_detail['post_uid'],'top_topic_weiba');

						break;
					case '2':     //设为全局置顶
							$config['typename'] = "全局置顶";
							model('Notify')->sendNotify($post_detail['post_uid'], 'weiba_post_set', $config); 
							D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”设为了全局置顶','posts');
						
						//添加积分
						model('Credit')->setUserCredit($post_detail['post_uid'],'top_topic_all');

						break;
				}
			}
			if($type==2){
				switch ($targetValue) {
					case '0':     //取消精华
						D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”取消了精华','posts');
						break;
					case '1':     //设为精华
							$config['typename'] = "精华";
							model('Notify')->sendNotify($post_detail['post_uid'], 'weiba_post_set', $config); 
							D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”设为了精华','posts');
						
						//添加积分
						model('Credit')->setUserCredit($post_detail['post_uid'],'dist_topic');
						break;
				}
			}
			if($type==3){
				switch ($targetValue) {
					case '0':     //取消推荐
						D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”取消了推荐','posts');
						break;
					case '1':     
						//设为推荐
						$config['typename'] = "推荐";
						model('Notify')->sendNotify($post_detail['post_uid'], 'weiba_post_set', $config); 
						D('log')->writeLog($post_detail['weiba_id'],$this->mid,'将帖子“<a href="'.U('weiba/Index/postDetail',array('post_id'=>$post_id)).'" target="_blank">'.$post_detail['title'].'</a>”设为了推荐','posts');
						
						//添加积分
						model('Credit')->setUserCredit($post_detail['post_uid'],'recommend_topic');

						break;
				}
			}
			echo 1;
		}else{
			echo 0;
		}
	}

	/**
	 * 搜索微吧或帖子
	 * @return  void
	 */
	public function search(){
		if($this->mid) {
			// 获取个人信息
			$userinfo = model ( 'User' )->getUserInfo ( $this->mid );
			$this->assign('userinfo', $userinfo);
		}	
		$k = t($_REQUEST['k']);
		$this->setTitle( '搜索'.$k );
		$this->setKeywords( '搜索'.$k );
		$this->setDescription( '搜索'.$k );

		//微吧推荐
		//$this->_weiba_recommend(9,50,50);
		//微吧排行榜
		//$this->_weibaOrder();
		$this->assign('nav','search');
		if($k == ""){
			if($_REQUEST['type'] == '1'){
				$this->display('search_weiba');
			}else{
				$this->display('search_post');
			}
			exit;
		}
		$_POST['k'] && $_SERVER['QUERY_STRING'] = $_SERVER['QUERY_STRING'].'&k='.$k;
		$this->assign('searchkey',$k);
		$map1['is_del'] = 0;
		//搜微吧
		$map1['weiba_name'] = array('like','%'.$k.'%');
		$weibaList = D('weiba')->where($map1)->order('follower_count desc')->limit(10)->select();
		if($weibaList){
			foreach($weibaList as $k=>$v){
				$weibaList[$k]['logo'] = getImageUrlByAttachId($v['logo'],100,100);
			}
			$this->assign('weibaList',$weibaList);
			$this->assign('countWeibaList', count($weibaList));
		}
		//搜帖子
		$map['is_del'] = array('neq',1);
		$map['title'] = array('like','%'.$k.'%');
		//$where['content'] = array('like','%'.$k.'%');
		//$where['_logic'] = 'or';
		//$map['_complex'] = $where;
		$postList = D('weiba_post')->where($map)->order('post_time desc')->findPage(10);
		if($postList['data']){
			$weiba_ids = getSubByKey($postList['data'], 'weiba_id');
			$nameArr = $this->_getWeibaName($weiba_ids);
			foreach($postList['data'] as $k=>$v){
				$postList['data'][$k]['weiba'] = D('weiba_relation')->where('post_id='.$v['post_id'])->field('weiba_id, weiba_name') -> limit(3) -> select();
			}
			$post_uids = getSubByKey($postList['data'], 'post_uid');
			$reply_uids = getSubByKey($postList['data'], 'last_reply_uid');
			$uids = array_unique(array_merge($post_uids,$reply_uids));
			$this->_assignUserInfo($uids);
			$this->assign('postList',$postList);
		}
		$this->display('search_post');	
	}

	/**
	 * 检查是否有申请资格
	 * @return void
	 */
	public function checkApply(){
		$weiba_id = intval($_POST['weiba_id']);
		if(intval($_POST['type']) == 3){
			if(D('weiba_follow')->where('weiba_id='.$weiba_id.' AND level=3')->find()){
				echo 2;
				exit;
			} 
		}
		if(D('weiba_apply')->where('weiba_id='.$weiba_id.' AND follower_uid='.$this->mid)->find()){
			echo -1;exit;
		}
		if(D('weiba_follow')->where('weiba_id='.$weiba_id.' AND follower_uid='.$this->mid.' AND (level=3 OR level=2)')->find()){
			echo -2;exit;
		}
		if(D('weiba_post')->where('weiba_id='.$weiba_id.' AND post_uid='.$this->mid)->count()>=5){
			echo 1;
		}else{
			echo 0;
		}
	}

	/**
	 * 申请成为吧主或小吧
	 * @return void
	 */
	public function apply(){
		if ( !CheckPermission('weiba_normal','weiba_apply_manage') ){
			$this->error( '对不起，您没有权限执行该操作！' );
		}
		$weiba_id = intval($_GET['weiba_id']);
		if(D('weiba_follow')->where('weiba_id='.$weiba_id.' AND follower_uid='.$this->mid.' AND (level=3 OR level=2)')->find()){
			$this->error('您已经是吧主，不能重复申请');
		}
		if(D('weiba_post')->where('weiba_id='.$weiba_id.' AND post_uid='.$this->mid)->count()<5){
			$this->error('您需要发布5篇以上帖子才能申请');
		}
		if(!D('weiba_follow')->where('weiba_id='.$weiba_id.' AND follower_uid='.$this->mid)->find()) $this->error('您尚未关注该微吧');
		$type = intval($_GET['type']);
		if($type!=2 && $type!=3) $this->error('参数错误');
		$this->assign('weiba_name',D('weiba')->where('weiba_id='.$weiba_id)->getField('weiba_name'));
		$this->assign('type',$type);
		$this->assign('weiba_id',$weiba_id);
		$this->display();
	}

	/**
	 * 执行申请成为吧主或小吧
	 * @return void
	 */
	public function doApply(){
		if ( !CheckPermission('weiba_normal','weiba_apply_manage') ){
			$this->error( '对不起，您没有权限执行该操作！' );
		}
		if(strlen(t($_POST['reason']))==0) $this->error('申请理由不能为空');
		preg_match_all('/./us', t($_POST['reason']), $match);  
        if(count($match[0])>140){     //汉字和字母都为一个字
        	$this->error('申请理由不能超过140个字');
        } 
        if(D('weiba_follow')->where('weiba_id='.intval($_POST['weiba_id']).' AND follower_uid='.$this->mid.' AND (level=3 OR level=2)')->find()){
			$this->error('您已经是吧主，不能重复申请');
		}
		$data['follower_uid'] = $this->mid;
		$data['weiba_id'] = intval($_POST['weiba_id']);
		$data['type'] = intval($_POST['type']);
		$data['status'] = 0;
		$data['reason'] = t($_POST['reason']);
		$res = D('weiba_apply')->add($data);
		if($res){
			$weiba = D('weiba')->where('weiba_id='.$data['weiba_id'])->find();
			$actor = model('User')->getUserInfo($this->mid);
            $config['name'] = $actor['space_link'];
			$config['weiba_name'] = $weiba['weiba_name'];
			$config['source_url'] = U('weiba/Manage/member',array('weiba_id'=>$data['weiba_id'],'type'=>'apply'));
			if($data['type']==3){
				model('Notify')->sendNotify($weiba['uid'], 'weiba_apply', $config); 
			}else{
				model('Notify')->sendNotify($weiba['admin_uid'], 'weiba_apply', $config); 
			}
			 
			return $this->ajaxReturn($data['weiba_id'], '申请成功，请等待管理员审核', 1);
		}else{
			$this->error('申请失败');
		}
	}

	/**
	 * [修改问题标题 zbq]
	 * @return [type] [description]
	 */
	public function ajax_saveTitle() {
		$data['title'] = t($_POST['title']);
		$res = D('weiba_post')->where('post_id='.intval($_POST['id']).' and post_uid='.$this->mid)->save($data);
		if($res) {
			return $this->ajaxReturn(1);
		} else {
			$this->error('修改失败');
		}
	}

	/**
	 * [修改问题所属微吧 zbq]
	 * @return [type] [description]
	 */
	public function ajax_saveweiba() {
		$data['title'] = t($_POST['title']);
		$res = D('weiba_post')->where('post_id='.intval($_POST['id']).' and post_uid='.$this->mid)->find();
		if($res) {
			return $this->ajaxReturn(1);
		} else {
			$this->error('修改失败');
		}
	}


	/**
	 * 微吧推荐
	 * @param integer limit 获取微吧条数
	 * @return void
	 */
	private function _weiba_recommend($limit=9,$width=100,$height=100){
		//已关注的微吧
		$weiba_follow = D('weiba_follow')->field('weiba_id')->where('follower_uid = '.$this->mid) -> select();
		$weiba_follow = getSubByKey($weiba_follow, 'weiba_id');
		$weiba_follow_ids = join(',', $weiba_follow);
		$weiba_follow_ids = $weiba_follow_ids ? $weiba_follow_ids : 0;
		$weiba_not_follow_where['weiba_id'] = array('not in',$weiba_follow_ids);
		$weiba_recommend = D('weiba')->where('recommend=1 and is_del=0')->where($weiba_not_follow_where)->limit($limit)->findAll();
		foreach($weiba_recommend as $k=>$v){
			$weiba_recommend[$k]['logo'] = getImageUrlByAttachId($v['logo'],$width,$height);
		}
		$weiba_ids = getSubByKey($weiba_recommend, 'weiba_id');
		$this->_assignFollowState($weiba_ids);
		$this->assign('weiba_recommend',$weiba_recommend);
	}

	/**
	 * 热帖推荐
	 * @param integer limit 获取微吧条数
	 * @return void
	 */
	private function _post_recommend($limit){
		$db_prefix = C('DB_PREFIX');
		$sql = "SELECT a.* FROM `{$db_prefix}weiba_post` a, `{$db_prefix}weiba` b WHERE a.weiba_id=b.weiba_id AND ( b.`is_del` = 0 ) AND ( a.`recommend` = 1 ) AND ( a.`is_del` = 0 ) ORDER BY a.recommend_time desc LIMIT ".$limit;
		$post_recommend = D('weiba_post')->query($sql);
		$weiba_ids = getSubByKey($post_recommend, 'weiba_id');
		$nameArr = $this->_getWeibaName($weiba_ids);
		foreach($post_recommend as $k=>$v){
			$post_recommend[$k]['weiba'] = $nameArr[$v['weiba_id']];
			$post_recommend[$k]['user'] = model( 'User' )->getUserInfo( $v['post_uid'] );
			$post_recommend[$k]['replyuser'] = model( 'User' )->getUserInfo( $v['last_reply_uid'] );
			$images = matchImages($v['content']);
			$images[0] && $post_recommend[$k]['image'] = array_slice( $images , 0 , 5 );
		}
		$this->assign('post_recommend',$post_recommend);
	}

	/**
	 * 微吧排行榜
	 * @return void
	 */
	private function _weibaOrder($limit = 10){
		$weiba_order = D('weiba')->where('is_del=0')->order('follower_count desc,thread_count desc')->limit($limit)->findAll();
		foreach($weiba_order as $k=>$v){
			$weiba_order[$k]['logo'] = getImageUrlByAttachId($v['logo'],30,30);
		}
		$map['post_uid'] = $this->mid;
		$postCount = D('weiba_post')->where($map)->count();
		$reply = D('weiba_reply')->where('uid='.$this->mid)->group('post_id')->findAll();
		$replyCount = count( $reply );
		$favoriteCount = D('weiba_favorite')->where('uid='.$this->mid)->count();
		$followCount = D('weiba_follow')->where('follower_uid='.$this->mid)->count();
		
		$data['postCount'] = $postCount ? $postCount : 0;
		$data['replyCount'] = $replyCount ? $replyCount : 0;
		$data['favoriteCount'] = $favoriteCount ? $favoriteCount : 0;
		$data['followCount'] = $followCount ? $followCount : 0;
		$this->assign( $data );
		//dump($weiba_order);exit;
		$this->assign('weiba_order',$weiba_order);
		
	}

	/**
	 * 获取uid与微吧的关注状态
	 * @return void
	 */
	private function _assignFollowState($weiba_ids){
		// 批量获取uid与微吧的关注状态
		$follow_state = D('weiba')->getFollowStateByWeibaids($this->mid,$weiba_ids);
		//dump($follow_state);exit;
		$this->assign('follow_state', $follow_state);
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

	/**
	 * 批量获取用户uid与一群人fids的彼此关注状态
	 * @param  array $fids 用户uid数组
	 * @return void
	 */
	private function _assignFollowUidState($fids = null) {
		// 批量获取与当前登录用户之间的关注状态
		$follow_state = model('Follow')->getFollowStateByFids($this->mid, $fids);
		$this->assign('follow_user_state', $follow_state);
		//dump($follow_state);exit;
	}

	/**
	 * 帖子列表
	 */
	private function _postList(){
		$map['top'] = array('neq',2);
		$map['is_del'] = 0;
		$postList = D('weiba_post')->where($map)->order('post_time desc')->findpage(20);
		if($postList['nowPage']==1){  //列表第一页加上全局置顶的帖子
			$map['top'] = 2;
			$topPostList = D('weiba_post')->where($map)->order('post_time desc')->findAll();
			!$topPostList && $topPostList = array();
			!$postList['data'] && $postList['data'] = array();
			$postList['data'] = array_merge($topPostList,$postList['data']);
		}
		
		$weiba_ids = getSubByKey($postList['data'], 'weiba_id');
		$nameArr = $this->_getWeibaName($weiba_ids);
		//dump($postList['data']);
		foreach($postList['data'] as $k=>$v){
			$postList['data'][$k]['weiba'] = $nameArr[$v['weiba_id']];
			$postList['data'][$k]['post_uname'] = D('user') -> where('uid='.$v['post_uid']) -> getField('uname');
			if(strstr($v['content'],'<img')) {
				//<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'
				preg_match('/<img.+src=\"?(.*?)\"[^>]*?\/?\s*>/',$v['content'],$match); 
				$postList['data'][$k]['content_img'] = $match[1];
			}
			$postList['data'][$k]['content'] = strip_tags($v[content]);
			$postList['data'][$k]['favorite'] = $this->_getFavoriteStatus($v['post_id']);
		}
		
		$post_uids = getSubByKey($postList['data'], 'post_uid');
		$reply_uids = getSubByKey($postList['data'], 'last_reply_uid');
		$uids = array_unique(array_merge($post_uids,$reply_uids));
		$this->_assignUserInfo($uids);
		//微吧排行榜
		$this->_weibaOrder();
		$this->assign('postList',$postList);
	}

	/**
	 * [获取微吧名称]
	 * @param  [type] $weiba_ids [description]
	 * @return [type]            [description]
	 */
	private function _getWeibaName($weiba_ids){
		$weiba_ids = array_unique($weiba_ids);
		if(empty($weiba_ids)){
			return false;
		}
		$map['weiba_id'] = array('in', $weiba_ids);
		$names = D('weiba')->where($map)->field('weiba_id,weiba_name')->findAll();
		foreach ( $names as $n){
			$nameArr[$n['weiba_id']] = $n['weiba_name'];
		}		
		return $nameArr;
	}
	
	/**
	 * [获取话题关注状态]
	 * @param  [type] $list [description]
	 * @return [type]       [description]
	 */
	private function _getFavoriteStatus($list) {
		if(is_array($list)){
			foreach($list as $k=>$v){
				$res = D('weiba_favorite')->where('uid='.$this->mid.' AND post_id='.$v['post_id'])->find();
				$list[$k]['favorite'] = $res ? 1 : 0;
			}
			return $list;
		}else{
			if(D('weiba_favorite')->where('uid='.$this->mid.' AND post_id='.$list)->find()){
				return 1;
			}	
		}
	}

	/**
	 * [保存问题所属话题]
	 * @param [type] $weibaId_Arr [description]
	 * @param [type] $post_id     [description]
	 */
	private function _addWeibaRelation($weibaId_Arr, $post_id, $is_del = 0) {

		//编辑之前所属话题
		$have = getSubByKey( D('weiba_relation')->field('weiba_id')->where('post_id='.$post_id)->select(),'weiba_id');
		$have = $have ? $have : array();
		//取差集，不存在的删掉
		$del_weibaid = array_diff($have, $weibaId_Arr);
		foreach($del_weibaid as $v){
			D('weiba_relation')->where('post_id='.$post_id.' and weiba_id='.$v)->delete();
			D('weiba')->where('weiba_id='.$weibaid)->setDec('thread_count');
		}
		//取差集，多的增加上
		$add_weibaid = array_diff($weibaId_Arr, $have);
		foreach($add_weibaid as $weibaid) {
			$weiba = D('weiba')->where('weiba_id='.$weibaid)->find();
			if($is_del == 0){
				D('weiba')->where('weiba_id='.$weibaid)->setInc('thread_count');
			}	
			$tmp = array('weiba_id'=>$weibaid,'post_id'=>$post_id, 'weiba_name'=>$weiba['weiba_name']);
			D('weiba_relation')->add($tmp);
		}
	}
}