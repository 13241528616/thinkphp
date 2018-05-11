<?php
namespace Admin\Controller;
use Think\Controller;

class CategoryController extends Controller {

	protected $_validate = array(
		array('catg_num','','',0,'unique',1),
		array('catg_name','require','',0,'',3),
		array('catg_parent','number','',0,'',3),

	);


	public function index(){
		$where = I('get.cate_name',0);
		$wheresql = '';
		if($where){
			$wheresql = "catg_name like '%$where%'";
		}
		$M = D('Category');
		$Ca = $M->where($wheresql)->select();
		$tree = self::genTree($Ca);
		$count = $M->count();
		$this->assign('tree',$tree);
		$this->assign('count',$count); 
		$this->display('showcategory');
	}

	function editcat(){
		$cid = I('get.cid',0);
		$M = D('Category');
		$cat = $M->select($cid);
		$trees = $M->select();
		$tree = self::genTree($trees);
		$this->assign('tree',$tree);
		$this->assign('cat',$cat[0]);
		$this->display();
	}

	function addcat(){
		$M = D('Category');
		$Ca = $M->select();
		$tree = self::genTree($Ca);
		$this->assign('tree',$tree);
		$this->display('addcat');
	}

	function savecat(){
		$id = I('post.id',0,'intval');
		$catg_num = I('post.catg_num','','strip_tags');
		$catg_name = I('post.catg_name','','strip_tags');
		$catg_parent = I('post.catg_parent',0,'intval');

		$CATE = D("Category");
 
		if(!$CATE->create()){
			echo -1;
		}else{
			if($id){
				echo $CATE->save();
			}else{
				echo $CATE->add();
			}
		}
	} 

	function delcat(){ 
		$id = I('post.id',0,'intval');
		if(is_array($id)){
			$ids = '';
			foreach($id as $key => $value){
				$ids .= $value.',';
			}
			$id = $ids;
		}
		$M = D('Category');
		echo $M->delete($id);
	}

	private static function genTree($rows, $id='id', $pid='catg_parent') {
		$items = array();
		foreach ($rows as $row) $items[$row[$id]] = $row;
		foreach ($items as $item) $items[$item[$pid]]['son'][$item[$id]] = &$items[$item[$id]];
		return isset($items[0]['son']) ? $items[0]['son'] : array(); 
	}
}