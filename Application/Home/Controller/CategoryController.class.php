<?php
namespace Home\Controller;
use Think\Controller;
class CategoryController extends Controller {
    public function index(){
        $this->show('home Category page');
    }
}