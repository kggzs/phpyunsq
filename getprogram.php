<?php
include 'ayangw/common.php';
?>
<!Doctype html>
<html>
<head>
<meta charset="utf-8">
 <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"  name="viewport" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>下载源码 - <?=$conf['title']?></title>
<meta name="keywords" content="<?=$conf['keywords']?>">
<meta name="description" content="<?=$conf['description']?>">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" media="screen" />
<script src="static/js/jquery.min.js"></script>
<script src="static/js/jquery.qrcode.min.js"></script>
<link rel="stylesheet" href="static/css/amazeui.min.css" />
<link rel="stylesheet" href="static/css/admin.css">
<link rel="stylesheet" href="static/css/app.css">

</head>
<body data-type="index">
<!--导航-->
<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <a href="#"><?=$conf['title']?></a>
    </div>
    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen" class="tpl-header-list-link"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>


</header>

<!--End 导航-->
<!--身体-->
<div class="amz-container am-cf">
    
    
    <div class="amz-banner">
        <div class="amz-container" data-am-scrollspy="{animation: 'scale-up', repeat: false}">
            <div class="am-g">
               
                <br><br><br>
                
                <?php
                include 'nav.php';
                ?>
                <br><br>
                <div class="am-u-md-10 am-u-sm-centered">
                    <!--分割线-->
                    <div class="row">
                       <div class="am-u-md-6 am-u-sm-12 row-mb">
                            <div class="tpl-portlet">
                                <!--分割线-->
                                <div class="tpl-portlet-title">
                                    <div class="tpl-caption font-green">
                                        <i class="am-icon-server"></i>
                                        <span> 扫描下载程序 </span>
                                    </div>
                                </div>
                                <!--分割线-->
                                <div class="am-tabs tpl-index-tabs" id="doc-my-tabs" data-am-tabs="{noSwipe: 1}">
                                    <ul class="am-tabs-nav am-nav am-nav-tabs">
                                        <li class="am-active"><a href="#tab1"></a></li>
                                   
                               
                                    </ul>
                                    <!--分割线-->
                                    <div class="am-tabs-bd">

<div class="am-form am-tab-panel am-fade am-in am-active" id="tab1" style="min-height: 300px;">

  <fieldset>
      <center>
         <img class="am-circle" src="http://android-artworks.25pp.com/fs01/2015/02/02/11/110_3395e627ca83ae423d7dad98a5768ede.png" width="80" height="80"/>

         <br><br><div class="am-input-group" id="selecthost" style="display: none"><span class="am-input-group-label">选择域名</span><select class="am-form-field" id="selectoption"></select></div>
         <div class="list-group-item list-group-item-info" style="font-weight: bold;" id="login">
				<span id="loginmsg">请使用邮箱下载</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
			</div>
         <div class="list-group-item" id="qrimg">
			</div>
       
     </center>
 
  </fieldset>
  
</div>   </div>
                                </div>
                            </div>
                        </div> 
                        
                        <!--End UI窗口-->
                        
                        <div class="am-u-md-6 am-u-sm-12 row-mb">
                            <div class="tpl-portlet">
                                <!--分割线-->
                                <div class="tpl-portlet-title">
                                    <div class="tpl-caption font-green">
                                        <i class="am-icon-server"></i>
                                        <span> 邮箱验证下载程序 </span>
                                    </div>
                                </div>
                               
                                <!--分割线-->
                                <div class="am-tabs tpl-index-tabs" id="doc-my-tabs" data-am-tabs="{noSwipe: 1}">
                                    <ul class="am-tabs-nav am-nav am-nav-tabs">
                                        <li class="am-active"><a href="#tab1"></a></li>
                                   
                               
                                    </ul>
                                    <!--分割线-->
                                    <div class="am-tabs-bd">

<div class="am-form am-tab-panel am-fade am-in am-active" id="tab1" style="min-height: 300px;">
    <div class="am-input-group">
  <span class="am-input-group-label">已授权的QQ</span>
  <input type="text" class="am-form-field" id="qq" name="qq" placeholder="" >
</div>
    <br> 
    
     <div class="am-form-group" id="checkqq_btn_div">
        <button class="am-btn am-btn-primary" id="checkqq_" type="submit" style="width: 100%">验证查询</button>
       </div> 
    <div id="get-hostinfo" style="display: none;">
    <div class="am-input-group">
  <span class="am-input-group-label">已授权的域名</span>
  <select class="am-form-field" id="host" name="host"></select>
</div><br> 
        <div class="am-input-group">
              <input type="text" class="am-form-field" id="email-vccode" name="email-vccode" placeholder="输入邮箱验证码">

              <span class="am-input-group-label am-btn-primary" id="send-to-email" style="cursor: pointer;">发送验证码</span>
</div>
    <br> 
    <div class="am-form-group">
        <button class="am-btn am-btn-primary" id="getpro"  type="button" style="width: 100%">获取程序</button>

</div>
    <div class="am-form-group" id="egetdow">
        
    </div>
    </div>
                                </div>
                            </div>
                        </div>
                        <!--End UI窗口-->
                        </div>
        </div> 
                        
                    </div>
                    <!--底部版权-->
                     <?php
                                   include 'footer.php';
                   ?>
                    <!--End 底部版权-->
                    <br>
                </div>
            </div>
        </div>
                
    </div>
</div>               
<!--End 身体-->
<!--预设提示-->
<div class="am-modal am-modal-alert" tabindex="-1" id="tip">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">温馨提示</div>
        <div id="tips" class="am-modal-bd">
            内部错误
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn">好的，知道了</span>
        </div>
    </div>
</div>
<!--End 预设提示-->

<!--弹窗-->
<div class="am-modal am-modal-alert" tabindex="-1" id="msg-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-bd" id="msg">
      
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn">确定</span>
    </div>
  </div>
</div>
<!--End 弹窗-->

<!--加载-->
<div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="ajax-loading">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">火速请求中...</div>
    <div class="am-modal-bd">
      <span class="am-icon-spinner am-icon-spin"></span>
    </div>
  </div>
</div>
<!--End 加载-->
<script src="static/js/qrlogin.js"></script>
<script src="static/js/jquery.min.js"></script>
<script src="static/js/auths.js"></script>
<script src="static/js/amazeui.min.js"></script>
<script src="static/js/iscroll.js"></script>
<script src="static/js/app.js"></script>

</body>
</html>