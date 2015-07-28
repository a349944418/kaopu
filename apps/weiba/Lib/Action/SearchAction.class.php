<?php
/**
 * 微吧搜索类
 */
Class SearchAction extends Action {

	/**
	 * [查找帖子名]
	 * @return [type] [description]
	 */
	public function title(){
		$title = t($_POST['text']);
		$res = D('weiba_post')->field('post_id, title, reply_count')->where('title like "%'.$title.'%"')->select();
		$html = '';
		if($res){
			$html = '<p>您的提问可能已经有答案</p>';
			foreach($res as $k=>$v){
				$html .= '<li><a href="'.U('weiba/Index/postDetail/',array('post_id'=>$v['post_id'])).'" target="_blank">'.$v['title'].'</a>('.$v['reply_count'].'个回答)</li>';
			}
		}
		die($html);
	}

	/**
	 * [话题名称搜索]
	 * @return [type] [description]
	 */
	public function weibaName(){
		$title = t($_POST['text']);
		$res = D('weiba')->field('weiba_id, weiba_name')->where('weiba_name like "%'.$title.'%"')->select();
		$html = '';
		if($res) {
			foreach($res as $k=>$v) {
				$html .= '<li style="cursor: pointer;" onclick="choose_weiba_flag('.$v['weiba_id'].',\''.$v['weiba_name'].'\');">'.$v['weiba_name'].'</li>';
			}
		}else {
			$html = '<p>只能选择已有标签</p>';
		}
		die($html);
	}
}

?>