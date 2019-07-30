<?php
include 'ayangw/common.php';
?>
<!Doctype html>
<html>
<head>
<meta charset="utf-8">
 <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"  name="viewport" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>代理授权查询 - <?=$conf['title']?></title>
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
                       <div class="am-u-md-12 am-u-sm-12 row-mb">
                            <div class="tpl-portlet">
                                <!--分割线-->
                                <div class="tpl-portlet-title">
                                    <div class="tpl-caption font-green">
                                        <i class="am-icon-server"></i>
                                        <span> 代理查询验证 </span>
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
      <form action="" method="POST">
    <div class="am-form-group">
      <input type="text" name="dailicheck" id="host" minlength="3" placeholder="代理QQ/代理机构名称" class="am-form-field" required/>
    </div>
      
    <div class="am-form-group">
        <button class="am-btn am-btn-secondary" type="submit" style="width: 100%">立即查询</button>
    </div>
          </form>
    <?php
    if(!empty($_POST['dailicheck'])){
        $dl = daddslashes($_POST['dailicheck']);
        $sql = "select * from auth_zzi_daili where daili_name = '$dl' or daili_qq = '$dl'";
        $row = $DB->get_row($sql);
        if($row){
            ?>
            <div style="width: 484px;height: 700px;background-image: url(static/certificate/proxybg.gif);margin: 0 auto;overflow: hidden">
          <div style="width: 100%;height: 60px;margin-top:1px;text-align: right;padding-right: 40px;padding-top: 40px">
              <span>授权编号：<?=$row['daili_id']+100000?></span>
          </div>
          <div style="width: 200px;height:70px;margin: 0 auto;background-image: url(static/certificate/logo.png);background-size: 200px 70px; ">
              
          </div>
          <div style="width: 227px;height:68px;background-image: url(static/certificate/proxytitle.gif);margin: 0 auto;margin-top: 20px;">
              
          </div>
          
          <div style="margin-top: 20px;text-align: center; padding:0px 35px;white-space:normal; word-break:break-all;">
              <span style="font-size: 24px;">兹授予:<?=$row['daili_name']?></span>
              <br>
                <span style="font-size: 24px;">为我司旗下:<?=index_daili_lv($row['daili_lv'])?></span>
          </div>
          <div  style="margin-top: 20px;text-align: left; padding:0px 50px;white-space:normal; word-break:break-all;">
              <span>
                  授权期限：永久有效<br>
                  授权商状态：<?=daili_sta($row['daili_status'])?><br>
              </span>
              <small>
                  备注：本授权书以正本为有效文本，不得影印，涂改、转让。
                  康哥网络拥有此授权书的最终解释权。<br>
查询网址：<?=$_SERVER['HTTP_HOST']?>
              </small>
              <h5>授权单位：<?=$conf['title']?></h5>
          </div>
      </div>    
                
       <?php
        }else{
           ?>
      <img src="/static/certificate/error.png" width="30px;">没有查到相关代理信息！   
            <?php
        }
    }
    ?>
  

  </fieldset>
  
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