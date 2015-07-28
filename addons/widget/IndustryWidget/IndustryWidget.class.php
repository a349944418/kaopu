<?php
/**
 * 所在行业插件
 */
class IndustryWidget extends Widget {
	/**
	 * 所在行业插件
	 * @param  integer curPid 当前行业的父ID
	 * @param  integer curChild 当前行业的子ID
	 * @return [type]
	 */
	public function render($data) {
		$selectedIndustry = explode(',', t($_GET['selected']));
		if(!empty($selectedIndustry[0])) {
			$data['selectedIndustry'] = t($_GET['selected']);
		}

		$list = model('CategoryTree')->setTable('industry')->getNetworkList();
		$tmp = array();
		foreach ($list as $key => $value) {
			$tmp['industry_'.$key] = $value;
		}
		$list = $tmp;
		unset($tmp);
		$data['list'] = json_encode($list);	

		if($data['curPid'] && $data['curChild']){
			$data['selected'] = $data['curPid'].','.$data['curChild'];
		}	
		$content = $this->renderFile (dirname(__FILE__).'/industry.html', $data );
		return $content;
	}
}
?>