 <ul class="am-nav am-nav-pills am-nav-justify">
<li class="<?php echo "am-".checkIfActive(",index");?>"><a href="./">授权查询</a></li>
<li class="<?php echo "am-".checkIfActive("onlineauth");?>"><a href="./onlineauth.html">在线授权</a></li>
<li class="<?php echo "am-".checkIfActive("getprogram");?>"><a href="./getprogram.html">下载源码</a></li>
<li class="<?php echo "am-".checkIfActive("changeauth");?>"><a href="./changeauth.html">更换授权</a></li>
<li class="<?php echo "am-".checkIfActive("checkdaili");?>"><a href="./checkdaili.html">代理查询</a></li>
</ul>
<div style="display: none;">
    <script src="https://s13.cnzz.com/z_stat.php?id=1272902400&web_id=1272902400" language="JavaScript"></script>
</div>

<div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="ajax-loading">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">火速请求中...</div>
    <div class="am-modal-bd">
      <span class="am-icon-spinner am-icon-spin"></span>
    </div>
  </div>
</div>