<?php
/**
 * 生日选择 widget
 * @example W('Birth',array('curY'=>1990,'curM'=>2,'day'=>3))
 */
class BirthWidget extends Widget {
	/**
	 * @param integer curY 出生年
     * @param integer curM 出生月
     * @param integer day 出生日
	 */
	public function render($data){
		$data['yearArr'] = json_encode(range(1915,date('Y')));
		$data['monthArr'] = json_encode(range(1,12));
		$data['dayArr'] = json_encode(range(1,31));
		$content = $this->renderFile (dirname(__FILE__).'/birth.html', $data);
		return $content;
	}


}
?>