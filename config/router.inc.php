<?php
return array(
	/**
	 * 路由的key必须写全称. 比如: 使用'wap/Index/index', 而非'wap'.
	 */
	'router' => array(
		// 基本
		'page/Index/index'			=>  SITE_URL.'/page/[page].html',
 		//'public/Index/index'		=> 	SITE_URL.'/home',
		
		'public/Passport/login'  	=>  SITE_URL.'/welcome',
		'public/Passport/logout'	=>  SITE_URL.'/logout',
		'public/Register/index'  	=>  SITE_URL.'/register',
		'public/Register/waitForActivation'  =>  SITE_URL.'/activate/[uid]',
		'public/Register/waitForAudit'  =>  SITE_URL.'/review/[uid]',
		'public/Register/step2'  	=>  SITE_URL.'/register/upload_photo',
		'public/Register/step3'  	=>  SITE_URL.'/register/work_information',
		'public/Register/step4'  	=>  SITE_URL.'/register/follow_interesting',
		'public/Profile/feed'  		=>  SITE_URL.'/weibo/[feed_id]',
		'public/Topic/index'  		=>  SITE_URL.'/topic',

		'public/Profile/index'		=>	SITE_URL.'/people/[uid]',
		'public/Profile/answer'		=>	SITE_URL.'/people/[uid]/answer',
		'public/Profile/data'  		=>  SITE_URL.'/people/[uid]/profile',
		'public/Profile/following'  =>  SITE_URL.'/people/[uid]/following',
		'public/Profile/follower'  	=>  SITE_URL.'/people/[uid]/follower',
		'public/Profile/share'		=>	SITE_URL.'/people/[uid]/share',
		'public/Profile/collection'	=>	SITE_URL.'/people/[uid]/collection',
		'public/Profile/question'	=>	SITE_URL.'/people/[uid]/ask',
		
		'public/Index/myFeed'  		=>  SITE_URL.'/myFeed',
		'public/Index/following'  	=>  SITE_URL.'/myFollowing',
		'public/Index/follower'  	=>  SITE_URL.'/myFollower',
		'public/Collection/index'  	=>  SITE_URL.'/myCollection',
		'public/Mention/index'  	=>  SITE_URL.'/myMention',
 		'public/Comment/index'  	=>  SITE_URL.'/myComment',
		'public/Task/index'  		=>  SITE_URL.'/myTask',
		'public/Medal/index'  		=>  SITE_URL.'/myMedal',
		'public/Rank/index'  		=>  SITE_URL.'/myRank',
		'public/Invite/invite'  	=>  SITE_URL.'/invite',
		'public/Message/index'  	=>  SITE_URL.'/message',
		'public/Message/notify'  	=>  SITE_URL.'/notify',
		'public/Message/detail' 	=> 	SITE_URL.'/message/[id]',
			
		'public/Account/index'  	=>  SITE_URL.'/setting/index',
		'public/Account/avatar'  	=>  SITE_URL.'/setting/avatar',
		'public/Account/domain'  	=>  SITE_URL.'/setting/domain',
		'public/Account/authenticate'=>  SITE_URL.'/setting/authenticate',
		'public/Account/privacy'  	=>  SITE_URL.'/setting/privacy',
		'public/Account/notify'  	=>  SITE_URL.'/setting/notify',
		'public/Account/blacklist'  =>  SITE_URL.'/setting/blacklist',
		'public/Account/security'  	=>  SITE_URL.'/setting/security',
		'public/Account/bind'  		=>  SITE_URL.'/setting/bind',
		'public/Account/tag'  		=>  SITE_URL.'/setting/tag',
		'public/Account/workinfo'	=>  SITE_URL.'/setting/workinfo',
		
		//频道
 		'channel/Index/index'  		=>  SITE_URL.'/channel',
 		
 		//找人
 		'people/Index/index'  		=>  SITE_URL.'/people',

 		//微吧
		'weiba/Index/index'  		=>  SITE_URL.'/home',
		'weiba/Index/weibaList'  	=>  SITE_URL.'/topiclist',
		'weiba/Index/postList'  	=>  SITE_URL.'/question/postlist',
		'weiba/Index/myWeiba'  		=>  SITE_URL.'/question/[type]',
		'weiba/Index/detail'  		=>  SITE_URL.'/topic/[weiba_id]',
		'weiba/Index/post'  		=>  SITE_URL.'/question/post',
		'weiba/Index/postDetail'  	=>  SITE_URL.'/question/post_[post_id]',
		'weiba/Index/postEdit'  	=>  SITE_URL.'/question/post_[post_id]/edit',
		'weiba/Index/replyEdit'  	=>  SITE_URL.'/question/reply_[reply_id]/edit',
		'weiba/Manage/index'  		=>  SITE_URL.'/question/[weiba_id]/manage',
		'weiba/Manage/member'  		=>  SITE_URL.'/question/[weiba_id]/manage/member',
		'weiba/Manage/notify'  		=>  SITE_URL.'/question/[weiba_id]/manage/notify',
		'weiba/Manage/log'  		=>  SITE_URL.'/question/[weiba_id]/manage/log',
		'weiba/Index/search'		=>  SITE_URL.'/question/search',
		'weiba/Index/doFollowWeiba' =>  SITE_URL.'/question/c_[weiba_id]/dofollow',
		'weiba/Comment/answer'		=> 	SITE_URL.'/question/[post_id]/answer/[reply_id]',

		//靠谱圈
		'public/Circles/index'		=>  SITE_URL.'/circles',

		// 日志
		'blog/Index/index'			=>	SITE_URL.'/app/blog',
		'blog/Index/news'			=>	SITE_URL.'/app/blog/lastest',
		'blog/Index/followsblog'	=>	SITE_URL.'/app/blog/following',
		'blog/Index/my'				=>	SITE_URL.'/app/blog/my',
		'blog/Index/personal'		=>	SITE_URL.'/app/blog/[uid]',
		'blog/Index/show'			=>	SITE_URL.'/app/blog/detail/[id]',
		'blog/Index/addBlog'		=>	SITE_URL.'/app/blog/post',
		'blog/Index/edit'			=>	SITE_URL.'/app/blog/edit/[id]',
		'blog/Index/admin'			=>	SITE_URL.'/app/blog/manage',

		// 相册
		'photo/Index/index'			=>	SITE_URL.'/app/photo',
		'photo/Index/all_albums'	=>	SITE_URL.'/app/photo/all_albums',
		'photo/Index/all_photos'	=>	SITE_URL.'/app/photo/all_photos',
		'photo/Index/albums'		=>	SITE_URL.'/app/photo/albums',
		'photo/Index/photos'		=>	SITE_URL.'/app/photo/photos',
		'photo/Index/album'			=>	SITE_URL.'/app/photo/album/[id]',
		'photo/Index/photo'			=>	SITE_URL.'/app/photo/photo/[id]',
		'photo/Upload/flash'		=>	SITE_URL.'/app/photo/multi_upload',
		'photo/Upload/index'		=>	SITE_URL.'/app/photo/upload',
		'photo/Manage/album_edit'	=>	SITE_URL.'/app/photo/edit/[id]',
		'photo/Manage/album_order'	=>	SITE_URL.'/app/photo/order/[id]',

		// 活动
		'event/Index/index'			=>	SITE_URL.'/event',
		'event/Index/personal'		=>	SITE_URL.'/event/events',
		'event/Index/addEvent'		=>	SITE_URL.'/event/post',
		'event/Index/edit'			=>	SITE_URL.'/event/edit/[id]',
		'event/Index/eventDetail'	=>	SITE_URL.'/event/detail/[id]',
		'event/Index/member'		=>	SITE_URL.'/event/member/[id]',

		// 投票
		'vote/Index/index'			=>	SITE_URL.'/app/vote',
		'vote/Index/my'				=>	SITE_URL.'/app/vote/my',
		'vote/Index/personal'		=>	SITE_URL.'/app/vote/[uid]',
		'vote/Index/addPoll'		=>	SITE_URL.'/app/vote/post',
		'vote/Index/pollDetail'		=>	SITE_URL.'/app/vote/detail/[id]',

		// 礼物
		'gift/Index/index'			=>	SITE_URL.'/app/gift',
		'gift/Index/receivebox'		=>	SITE_URL.'/app/gift/receive',
		'gift/Index/sendbox'		=>	SITE_URL.'/app/gift/send',
		'gift/Index/personal'		=>	SITE_URL.'/app/gift/[uid]',

		// 招贴版
		'poster/Index/index'		=>	SITE_URL.'/app/poster',
		'poster/Index/personal'		=>	SITE_URL.'/app/poster/posters',
		'poster/Index/addPosterSort'=>	SITE_URL.'/app/poster/post',
		'poster/Index/addPoster'	=>	SITE_URL.'/app/poster/post/[typeId]',
		'poster/Index/editPoster'	=>	SITE_URL.'/app/poster/edit/[id]',
		'poster/Index/posterDetail'	=>	SITE_URL.'/app/poster/detail/[id]',
		
		// 群组
		'group/Index/index'			=>	SITE_URL.'/app/group',
		'group/Index/newIndex'		=>	SITE_URL.'/app/group/index',
		'group/Index/post'			=>	SITE_URL.'/app/group/my_post',
		'group/Index/replied'		=>	SITE_URL.'/app/group/replied',
		'group/Index/comment'		=>	SITE_URL.'/app/group/comment',
		'group/Index/atme'			=>	SITE_URL.'/app/group/atme',
		'group/SomeOne/index'		=>	SITE_URL.'/app/group/groups',
		'group/Index/find'			=>	SITE_URL.'/app/group/class',
		'group/Index/search'		=>	SITE_URL.'/app/group/search',
		'group/Index/add'			=>	SITE_URL.'/app/group/add',
		'group/Group/index'			=>	SITE_URL.'/app/group/[gid]',
		'group/Group/search'		=>	SITE_URL.'/app/group/[gid]/search',
		'group/Group/detail'		=>	SITE_URL.'/app/group/[gid]/detail/[feed_id]',
		'group/Invite/create'		=>	SITE_URL.'/app/group/[gid]/invite',
		'group/Manage/index'		=>	SITE_URL.'/app/group/[gid]/setting/baseinfo',
		'group/Manage/privacy'		=>	SITE_URL.'/app/group/[gid]/setting/private',
		'group/Manage/membermanage'	=>	SITE_URL.'/app/group/[gid]/setting/member',
		'group/Manage/announce'		=>	SITE_URL.'/app/group/[gid]/setting/announcement',
		'group/Log/index'			=>	SITE_URL.'/app/group/[gid]/setting/log',
		'group/Topic/index'			=>	SITE_URL.'/app/group/[gid]/bbs',
		'group/Topic/add'			=>	SITE_URL.'/app/group/[gid]/bbs/post',
		'group/Topic/edit'			=>	SITE_URL.'/app/group/[gid]/bbs/edit/[tid]',
		'group/Topic/editPost'		=>	SITE_URL.'/app/group/[gid]/bbs_reply/edit/[pid]',
		'group/Topic/topic'			=>	SITE_URL.'/app/group/[gid]/bbs/[tid]',
		'group/Dir/index'			=>	SITE_URL.'/app/group/[gid]/file',
		'group/Dir/upload'			=>	SITE_URL.'/app/group/[gid]/file/upload',
		'group/Member/index'		=>	SITE_URL.'/app/group/[gid]/member',
	)
);