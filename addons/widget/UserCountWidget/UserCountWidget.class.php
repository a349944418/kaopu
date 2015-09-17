<?php
/**
 * 用户统计Widget
 * @version TS3.0
 */
	class UserCountWidget extends Widget{
		
		public function render($data)
		{
			$content = '';
			return $content;
		}
		
		/**
		 * 获取指定用户的通知统计数目
		 */
		public function getUnreadCount()
		{
			
			$count = model('UserCount')->getUnreadCount($GLOBALS['ts']['mid']);
			$data['status'] = 1;
			$count['unread_totle'] = $count['unread_totle'] - $count['new_folower_count'] - $count['unread_atme'];
			$count['new_folower_count'] = $count['unread_atme'] = 0;
			$data['data'] = $count;
			echo json_encode($data);
		}
	}
?>