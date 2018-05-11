<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/thinkphp/Public/x-admin/css/font.css">
    <link rel="stylesheet" href="/thinkphp/Public/x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/thinkphp/Public/x-admin/js/xadmin.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-body">
        <form class="layui-form" action="<?php echo U('Article/saveart/','',false);?>" method="post">
        <input type="hidden" name="id" value="<?php echo ($art["id"]); ?>" id="aid">
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>标题   
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="title" name="title" required="" lay-verify="required"
                  autocomplete="off" value="<?php echo ($art["title"]); ?>" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>内容
              </label>
          </div>
          <div class="layui-form-item">
              <div class="">
                  <textarea name="content" id="content" style="margin-left:65px;"><?php echo ($art["content"]); ?></textarea>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="phone" class="layui-form-label">
                  <span class="x-red">*</span>所属分类
              </label>
              <div class="layui-input-inline">
                  <select name="category" id="category">
                      <option value="0" <?php if(($$art["cid"]) == "0"): ?>selected<?php endif; ?>>顶级分类</option>
                      <?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["id"]); ?>" <?php if(($cate["id"]) == $art["cid"]): ?>selected<?php endif; ?>>—<?php echo ($cate["catg_name"]); ?></option>
                            <?php if(!empty($cate['son'])): if(is_array($cate['son'])): $i = 0; $__LIST__ = $cate['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate1["id"]); ?>" <?php if(($cate1["id"]) == $art["cid"]): ?>selected<?php endif; ?>>——<?php echo ($cate1["catg_name"]); ?></option>
                                      <?php if(!empty($cate1['son'])): if(is_array($cate1['son'])): $i = 0; $__LIST__ = $cate1['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate2["id"]); ?>" <?php if(($cate2["id"]) == $art["cid"]): ?>selected<?php endif; ?>>——<?php echo ($cate2["catg_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                  </select>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  提交
              </button>
          </div>
      </form>
    </div>
    <script>
/*
    $(".layui-btn").click(function(){
        var array = new Array();;
        id = $("#aid").val();
        title = $("#title").val();
        content = $("#content").val();
        category = $("#category").val();
        hash = $("input[name='__hash__']").val();
        $.ajax({
	        type:'post',
	        url:'/thinkphp/admin.php/article/saveart',
	        data:{
      			"id":id,
      			"title":title,
      			"content":content,
      			"category":category,
      			"__hash__":hash
      		},
      		success:function(res){
      			if(res != -1){
      			    layer.msg('提交成功!',{icon:1,time:1000},function(){
                    var index=parent.layer.getFrameIndex(window.name);
                    window.parent.location.reload();
                    parent.layer.close(index);
                });


      			}else{
                layer.msg('提交失败!',{icon:1,time:1000},function(){
                    var index = parent.layer.getFrameIndex(window.name);
                    window.parent.location.reload();
                    parent.layer.close(index);
                });	
      			}
      		}		
       });
   	   return false;
    })
*/
    </script>
    <script>
        var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
        })();

        var url="http://weixin.n5y.cn<?php echo U('Article/uploadfiles','',false);?>";
        var ue = UE.getEditor('content',{
	serverUrl:url,
	initialFrameWidth:"auto",
	initialFrameHeight:320
	});
      </script>
  </body>

</html>