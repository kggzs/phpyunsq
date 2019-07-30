<?php
include 'ayangw/common.php';


?>
<!Doctype html>
<html>
<head>
<meta charset="utf-8">
 <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"  name="viewport" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?=$conf['title']?></title>
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
    <div class="am-topbar-brand" style="">
      
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
                                        <span> 授权验证中心 </span>
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
 
    <div class="am-form-group">
      <input type="text" id="host" minlength="3" placeholder="域名" class="am-form-field" required/>
    </div>
   
 
<div class="am-form-group">
    <input type="text"  minlength="3" id="vcode" style="width: 40%;display: inline" placeholder="验证码" required/>
 <img src="./code.php?r=<?=time()?>" style="display: inline;" id="piccode" height="35"onclick="this.src='./code.php?r='+Math.random();" title="点击更换验证码">
    
    </div>
      
    <div class="am-form-group">
        <button class="am-btn am-btn-secondary" id="checkauths" type="submit" style="width: 100%">验证查询</button>
       </div>
    

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
                                        <span> 授权验证说明 </span>
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
   <?php
                   echo $conf['index-msg'];
   ?>
    
              
</div>   </div>
                                </div>
                            </div>
                        </div>
                        <!--End UI窗口-->
                        
                        
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

<script src="static/js/jquery.min.js"></script>
<script src="static/js/auths.js"></script>
<script src="static/js/amazeui.min.js"></script>
<script src="static/js/iscroll.js"></script>
<script src="static/js/app.js"></script>

</body>
</html>