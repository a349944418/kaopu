<?php
/**
 * 用户教育经历表
 */
Class UserWorkinfoModel extends Model {
	protected $tableName = 'user_workinfo';
	protected $fields = array (
			0 => 'uwid',
			1 => 'uid',
			2 => 'company_name',
			3 => 'company_startime',
			'_autoinc' => true,
			'_pk' => 'uwid' 
	);

	/**
	 * [ 保存用户工作经历 ]
	 * @param  [array] $arr [description]
	 * @return [type]       [description]
	 */
	public function save_workinfo($arr) {
		$arr['uid'] = intval($_SESSION[mid]);
		$this->add($arr);
	}
}
?>