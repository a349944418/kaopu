<?php
/**
 * 获取学校信息
 */
Class SchoolAction extends Action {

	public function getSchool() {
		$t = t($_POST['t']);
		$id = t($_POST['id']);
		if ($t && $id) {
			// S('school_'.$t.'_'.$id, null);
			$list = S('school_'.$t.'_'.$id);
			if(empty($list)){
				if($t == 'middle' || $t == 'high') {
					$type = $t == 'middle' ? '2' : '3';
					$list = D('Area') -> getNetworkList($id);
					$Municipality = array('110000', '120000', '310000', '500000' );
					if(in_array($id, $Municipality)){					
						foreach($list as $k=>$v){
							if($v['pid'] == $id){
								foreach($v['child'] as $key=>$val){
									$list[$key] = $val;
								}							
							}
							unset($list[$k]);
						}
					}
					$list = $this->_getAreaSchool($list, $type);
				}else{
					$list = model('CategoryTree')->setTable('univs_area') -> getNetworkList($id);
					!$list && $list = $id;
					$list = $this->_getAreaSchool($list, 4);
				}
				$list = json_encode($list);
				S('school_'.$t.'_'.$id, $list);
			}
			
			echo $list;
		}
	}

	private function _getAreaSchool($list, $type){
		if($type != 4){
			foreach($list as $k=>$v){
				if($v['title'] == '市辖区'){
					unset($list[$k]);
				}else{
					if($v['child']){
						$list[$k]['child'] = $this->_getAreaSchool($v['child'],$type);
					}else{
						$list[$k]['school'] = M('School')->field('school_id, title')->where('pid='.$v['id'].' and type='.$type)->select();
					}
				}
			}
		}else{
			if(is_array($list)){
				foreach($list as $k=>$v){
					if($v['child']){
						$list[$k]['child'] = $this->_getAreaSchool($v['child'],$type);
					}else{
						$list[$k]['school'] = M('Univsity')->field('id as school_id, title')->where('pid='.$v['id'])->select();
					}
				}
			} else {
				$res['school'] = M('Univsity')->field('id as school_id, title')->where('pid='.$list)->select();
				$list = array();
				$list['school'] = $res['school'];
			}			
		}
		
		return $list;
	}
}
?>