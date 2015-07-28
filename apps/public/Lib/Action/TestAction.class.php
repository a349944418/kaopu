<?php
Class TestAction Extends Action {

	public function highshow() {
		$this->display();
	}

	// 高校保存
	public function highsave() {
		if($_POST['id']){
			$data['id'] = t($_POST['id']);
		} 
		$data['title'] = t($_POST['title']);
		$data['pid'] = t($_POST['pid']);
		if(t($_POST['type']) == 'school'){
			$model = M('univsity');
			$res['id'] = $model->add($data);
		}else{
			$model = M('univsArea');
			$res['id'] = $model->add($data);
		}
		if($res){
			$this->ajaxReturn($res);
		}else{
			$res['error'] = 1;
			$this->ajaxReturn($res);
		}
	}

	public function middleschool(){
		header("content-type:text/html;charset=utf-8");
		set_time_limit(0);
		$model = M('school');
		$dir = 'D:\Apache\htdocs\thinksns/_runtime/filecache/middleschool';
		$filesnames = scandir($dir);
		foreach($filesnames as $names){
			if($names == '.' || $names == '..'){
				continue;
			}
			$filename = str_replace('.php', '', $names);
			$str = F('middleschool/'.$filename);
			$str = str_replace("\n", '', $str);
			$str = str_replace("\r", '', $str);
			$n = strpos($str,'bytes');
			$str = substr($str, $n+5);
			$str = mb_convert_encoding($str, "utf-8", 'HTML-ENTITIES');
			$n1 = strpos($str,'</ul>');
			$str1 = substr($str, $n1+5);
			$arr = explode('</ul>',$str1);
			foreach($arr as $v){
				$v1= $v;
				//$pattern= '/(.*)city_qu_(\d+)(.*)href="\d+">(.*)</a>.*/';
				$pattern = '/(.*)city_qu_(\d+)(.*)/';
				$pid = preg_replace($pattern,'$2',$v1);
				$arr1 = explode('</li>',$v);
				foreach($arr1 as $val){
					if($val != ''){
						$pattern1 = '/(.*)href=\"(\d+)\">(.*)<\/a>(.)?/';	
						$id_title = preg_replace($pattern1, '$2,$3',$val);
						$id_title_arr = explode(',',$id_title);
						$data = array('school_id'=>$id_title_arr[0],'title'=>$id_title_arr[1],'pid'=>$pid,'type'=>2);
						if($model->add($data)){
							unset($data);							
						}else{
							dump('*****************************************************');
							dump($pid.'---'.$val.'---出错');
							dump('*****************************************************');
							continue;
						}
					}
						
				}
			}
			dump($filename.'成功');		
		}
		
	}


	public function highschool(){
		header("content-type:text/html;charset=utf-8");
		set_time_limit(0);
		$model = M('school');
		$dir = 'D:\Apache\htdocs\thinksns/_runtime/filecache/highschool';
		$filesnames = scandir($dir);
		foreach($filesnames as $names){
			if($names == '.' || $names == '..'){
				continue;
			}
			$filename = str_replace('.php', '', $names);
			$str = F('highschool/'.$filename);
			$str = str_replace("\n", '', $str);
			$str = str_replace("\r", '', $str);
			$n = strpos($str,'bytes');
			$str = substr($str, $n+5);
			$str = mb_convert_encoding($str, "utf-8", 'HTML-ENTITIES');
			$n1 = strpos($str,'</ul>');
			$str1 = substr($str, $n1+5);
			$arr = explode('</ul>',$str1);
			foreach($arr as $v){
				$v1= $v;
				//$pattern= '/(.*)city_qu_(\d+)(.*)href="\d+">(.*)</a>.*/';
				$pattern = '/(.*)city_qu_(\d+)(.*)/';
				$pid = preg_replace($pattern,'$2',$v1);
				$arr1 = explode('</li>',$v);
				foreach($arr1 as $val){
					if($val != ''){
						$pattern1 = '/(.*)href=\"(\d+)\">(.*)<\/a>(.)?/';	
						$id_title = preg_replace($pattern1, '$2,$3',$val);
						$id_title_arr = explode(',',$id_title);
						$data = array('school_id'=>$id_title_arr[0],'title'=>$id_title_arr[1],'pid'=>$pid,'type'=>3);
						if($model->add($data)){
							unset($data);							
						}else{
							dump('*****************************************************');
							dump($pid.'---'.$val.'---出错');
							dump('*****************************************************');
							continue;
						}
					}
						
				}
			}
			dump($filename.'成功');		
		}
		
	}


	public function upload(){
		


		$model = M('Area');
		$res = $model->field('area_id')->where('pid =0')->select();
		foreach($res as $v){
			$res1 = $model->field('area_id')->where('pid ='.$v['area_id'])->select();
			foreach($res1 as $val){
				$id = substr($val['area_id'],0,4);
				$curl = curl_init();
				// 设置你需要抓取的URL
				curl_setopt($curl, CURLOPT_URL, 'http://support.renren.com/juniorschool/'.$id.'.html');
				// 设置header
				curl_setopt($curl, CURLOPT_HEADER, 1);
				// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				// 运行cURL，请求网页
				$data = curl_exec($curl);
				// 关闭URL请求
				curl_close($curl);
				// 显示获得的数据
				F('middleschool/'.$id,$data);
			}
		}
/*  高中数据抓取		
		$arr = array(9101,9102,9103,919001,919002);
		foreach($arr as $id){
			$curl = curl_init();
			// 设置你需要抓取的URL
			curl_setopt($curl, CURLOPT_URL, 'http://support.renren.com/juniorschool/'.$id.'.html');
			// 设置header
			curl_setopt($curl, CURLOPT_HEADER, 1);
			// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			// 运行cURL，请求网页
			$data = curl_exec($curl);
			// 关闭URL请求
			curl_close($curl);
			// 显示获得的数据
			F('middleschool/'.$id,$data);
		}

/*
		$model = M('industry');
		$str = '"1901:非盈利机构","1902:慈善机构","1903:协会/学会","1904:社团/俱乐部","1999:其它"';
		$arr = explode(',',$str);
		$data['level'] = 2;
		$data['fup'] = 19;
		foreach($arr as $v){
			$v = trim($v, '"');
			$arr1 = explode(':',$v);
			$data['id'] = $arr1['0'];
			$data['name'] = $arr1['1'];
			$model->add($data);
		}
		echo $data['fup'].'成功';
*/
	}
}
?>