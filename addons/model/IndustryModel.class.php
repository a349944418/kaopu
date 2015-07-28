<?php
/**
 * 所在行业数据模型
 */
class IndustryModel extends Model {

	protected $tableName = 'industry';

	/**
	 * 获取指定行业的树形结构
	 * @param integer $pid 父地区ID
	 * @return array 指定树形结构
	 */
	public function getNetworkList($pid = '0') {
		// 子地区树形结构
		if($pid != 0) {
			return $this->_MakeTree($pid);
		}
		// 全部地区树形结构
		$list = S('industry');
		if(empty($list)) {
			set_time_limit(0);
			$list = $this->_MakeTree($pid);
			S('industry', $list);
		}
	
		return $list;
	}

	/**
	 * 递归形成树形结构
	 * @param integer $pid 父级ID
	 * @param integer $level 等级
	 * @return array 树形结构
	 */
	private function _MakeTree($pid, $level = '0') {
		$result = $this->where('pid='.$pid)->findAll();
		if($result) {
			foreach($result as $key => $value) {
				$id = $value['industry_id'];
				$list[$id]['id'] = $value['industry_id'];
				$list[$id]['pid'] = $value['pid'];
				$list[$id]['name'] = $value['name'];
				$list[$id]['level'] = $level;
				$list[$id]['child'] = $this->_MakeTree($value['industry_id'], $level + 1);
			}
		}

		return $list;
	}
}
?>