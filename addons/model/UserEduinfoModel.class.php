<?php
/**
 * 用户教育经历表
 */
Class UserEduinfoModel extends Model {
	protected $tableName = 'user_eduinfo';
	protected $fields = array (
			0 => 'ueid',
			1 => 'uid',
			2 => 'school_id',
			3 => 'school_name',
			4 => 'school_time',
			5 => 'school_type',
			6 => 'aid',
			'_autoinc' => true,
			'_pk' => 'ueid' 
	);

	/**
	 * [ 保存用户受教育经历 ]
	 * @param  [array] $arr [description]
	 * @return [type]       [description]
	 */
	public function save_Eduinfo($arr) {
		$list = array(1 => 'primary', 2 => 'middle', 3 => 'high', 4 => 'university');
		foreach($list as $k=>$v){
			$data = array('uid'=>intval($_SESSION[mid]));
			if(($arr[$v.'_school'] && $k==1) || ($arr[$v.'_school'] && $arr[$v.'_id']) || $arr[$v.'_time']) {
				$data['school_name'] = $arr[$v.'_school'];
				$data['school_id'] = $arr[$v.'_id'];
				$data['school_time'] = $arr[$v.'_school_time'];
				$data['aid'] = $arr[$v.'_aid'];
				$data['school_type'] = $k;
				$this->add($data);
			}
		}
		return 1;
	}
}
?>
