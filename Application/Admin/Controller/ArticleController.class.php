<?php
namespace Admin\Controller;
use Think\Controller;

class ArticleController extends Controller {

	
	protected $_validate = array(
		array('title','require','',0,'unique',1),
		array('content','require','',0,'',3),
		array('category','number','',0,'',3),
	);

	protected $_auto = array( 
		array('createuser','getuser',1,'callback'), // 对name字段在新增的时候回调getuser方法
		array('updateuser','getuser',3,'callback'), // 对name字段在新增和编辑的时候回调getuser方法
		array('createtime','time',1,'function'), // 对createtime字段在写入的时候写入当前时间戳
        array('updatetime','time',3,'function'), // 对update_time字段在写入/更新的时候写入当前时间戳
    );

	public function index(){
		$Article = D('Article');
		$art = $Article->alias('A')->join('my_category  C ON A.category = C.id')->field('A.id,A.title,A.content,C.catg_name as category,C.id as cid')->select();
		$count = $Article->count();
		$this->assign('art',$art);
		$this->assign('count',$count);
		$this->display('showart');
	}

	function editart(){
		$aid = I('get.aid',0);
		$Article = D('Article');
		$art = $Article->alias('A')->join('my_category  C ON A.category = C.id')->field('A.id,A.title,A.content,C.id as cid')->where('A.id = %d',array($aid))->select();
		$this->assign('art',$art[0]);
		$M = D('Category');
		$Ca = $M->select();
		$tree = self::genTree($Ca);
		$this->assign('tree',$tree);
		$this->display('editart');
	}

    function delart(){ 
		$id = I('post.id',0,'intval');
		if(is_array($id)){
			$ids = '';
			foreach($id as $key => $value){
				$ids .= $value.',';
			}
			$id = $ids;
		}
		$M = D('Article');
		echo $M->delete($id);
	}

	function saveart(){
		var_dump(I('post.'));exit;
		$id = I('post.id',0,'intval');
		$title = I('post.title','','strip_tags');
		$content = I('post.content','');
		$category = I('post.category',0,'intval');
		
		$Article = D("Article");
 
		if(!$Article->create()){
			echo -1;
		}else{
			if($id){
				var_dump($Article->save());
			}else{
				var_dump($Article->add());
			}
		}
	}

	private static function genTree($rows, $id='id', $pid='catg_parent') {
		$items = array();
		foreach ($rows as $row) $items[$row[$id]] = $row;
		foreach ($items as $item) $items[$item[$pid]]['son'][$item[$id]] = &$items[$item[$id]];
		return isset($items[0]['son']) ? $items[0]['son'] : array(); 
	}


	public function uploadfiles(){
        
        $CONFIG2 = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("./Public/ueditor/php/config.json")), true);
       
		$action = $_GET['action'];
        
		switch ($action) {
			case 'config':
			    $result =  json_encode($CONFIG2);
			    break;
			/* 上传图片 */
			case 'uploadimage':
			    $fieldName = $CONFIG2['imageFieldName'];
			    $result = $this->upFile($fieldName);
			    break;
			/* 上传涂鸦 */
			case 'uploadscrawl':
			    $config = array(
			        "pathFormat" => $CONFIG2['scrawlPathFormat'],
			        "maxSize" => $CONFIG2['scrawlMaxSize'],
			        "allowFiles" => $CONFIG2['scrawlAllowFiles'],
			        "oriName" => "scrawl.png"
			    );
			    $fieldName = $CONFIG2['scrawlFieldName'];
			    $base64 = "base64";
			    $result = $this->upBase64($config,$fieldName);
			    break;
			/* 上传视频 */
			case 'uploadvideo':
			    $fieldName = $CONFIG2['videoFieldName'];
			    $result = $this->upFile($fieldName);
			    break;
			/* 上传文件 */
			case 'uploadfile':
			    $fieldName = $CONFIG2['fileFieldName'];
			    $result = $this->upFile($fieldName);
			    break;
			/* 列出图片 */
			case 'listimage':
			    $allowFiles = $CONFIG2['imageManagerAllowFiles'];
			    $listSize = $CONFIG2['imageManagerListSize'];
			    $path = $CONFIG2['imageManagerListPath'];
			    $get =$_GET;
			    $result =$this->fileList($allowFiles,$listSize,$get);
			    break;
			/* 列出文件 */
			case 'listfile':
			    $allowFiles = $CONFIG2['fileManagerAllowFiles'];
			    $listSize = $CONFIG2['fileManagerListSize'];
			    $path = $CONFIG2['fileManagerListPath'];
			    $get = $_GET;
			    $result = $this->fileList($allowFiles,$listSize,$get);
			    break;
			/* 抓取远程文件 */
			case 'catchimage':
			    $config = array(
			        "pathFormat" => $CONFIG2['catcherPathFormat'],
			        "maxSize" => $CONFIG2['catcherMaxSize'],
			        "allowFiles" => $CONFIG2['catcherAllowFiles'],
			        "oriName" => "remote.png"
			    );
			    $fieldName = $CONFIG2['catcherFieldName'];
			    /* 抓取远程图片 */
			    $list = array();
			    isset($_POST[$fieldName]) ? $source = $_POST[$fieldName] : $source = $_GET[$fieldName];
			    
			    foreach($source as $imgUrl){
			        $info = json_decode($this->saveRemote($config,$imgUrl),true);
			        array_push($list, array(
			            "state" => $info["state"],
			            "url" => $info["url"],
			            "size" => $info["size"],
			            "title" => htmlspecialchars($info["title"]),
			            "original" => htmlspecialchars($info["original"]),
			            "source" => htmlspecialchars($imgUrl)
			        ));
			    }
			    $result = json_encode(array(
			        'state' => count($list) ? 'SUCCESS':'ERROR',
			        'list' => $list
			    ));
			    break;
				default:
			    $result = json_encode(array(
			        'state' => '请求地址出错'
			    ));
			    break;
		}
        /* 输出结果 */
        if(isset($_GET["callback"])){
            if(preg_match("/^[\w_]+$/", $_GET["callback"])){
                echo htmlspecialchars($_GET["callback"]).'('.$result.')';
            }else{
                echo json_encode(array(
                    'state' => 'callback参数不合法'
                ));
            }
        }else{
            echo $result;
        }
    }
    
    //上传文件
    private function upFile($fieldName){
		$editconfig= json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("./Public/ueditor/php/config.json")), true);
		$upload = new \Think\Upload();// 实例化上传类
	
		$upload->rootPath  =     'Public/uploads/';
		$upload->maxSize   =     $editconfig['imageMaxSize'];
		$upload->exts      =     explode('.', trim(join('',$editconfig['imageAllowFiles']),'.'));
		//$upload->savePath  =     $editconfig['imagePathFormat'];
		$upload->saveName  =     time().rand(100000,999999);
		$info   =   $upload->uploadOne($_FILES['upfile']);

		if(!$info) {// 上传错误提示错误信息
			$_re_data['state'] = $upload->getError();
			$_re_data['url'] = '';
			$_re_data['title'] = '';
			$_re_data['original'] = '';
			$_re_data['type'] = '';
			$_re_data['size'] = '';
		}else{// 上传成功 获取上传文件信息
			$_re_data['state'] = 'SUCCESS';
			$_re_data['url'] = $info['savepath'].$info['savename'];
			$_re_data['title'] = $info['savename'];
			$_re_data['original'] = $info['name'];
			$_re_data['type'] = '.'.$info['ext'];
			$_re_data['size'] = $info['size'];
		}
		
		return json_encode($_re_data);
	
    }
	

	function getuser(){
		return 2;
	}
}