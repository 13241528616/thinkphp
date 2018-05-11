<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $array['name']    =    'thinkphp';
	$array['email']   =    'liu21st@gmail.com';
	$array['phone']   =    '12335678';
	$this->assign($array);
	$this->display();
    }
}