<?php
include 'ayangw/common.php';
@header('Content-Type: application/json; charset=UTF-8');
if (empty($_GET['action'])) {
	exit("非法访问！");
} else {
	$act = $_GET['action'];
}
include 'ayangw/db.biz.php';
$biz = new Biz();
switch ($act) {
case 'query':
	$host = daddslashes($_POST['host']);
	$vcode = daddslashes($_POST['vcode']);
	$vc_code = $_SESSION['vc_code'];
	if (strexists($host, "http://")) {
		$data = array("code" => -1, "msg" => "域名无需输入http://");
		$DB->close();
		exit(json_encode($data));
	}
	if (!strexists($host, ".")) {
		$data = array("code" => -1, "msg" => "域名格式疑似不正确");
		$DB->close();
		exit(json_encode($data));
	}
	if ($vcode != $vc_code && strtolower($vcode) != $vc_code) {
		$data = array("code" => -1, "msg" => "验证码错误");
	} else {
		$row = $biz->query($host);
		if ($row) {
			if ($row['auth_status'] != 1) {
				if ($row['auth_status'] == 0) {
					$data = array("code" => -1, "msg" => "您的授权域名<font color=red>被冻结</font>,请联系客服处理！");
				} else if ($row['auth_status'] == -1) {
					$data = array("code" => -1, "msg" => "您的授权域名<font color=red>被拉黑</font>,请联系客服处理！");
				} else {
					$data = array("code" => -1, "msg" => "您的授权域名<font color=red>异常</font>！");
				}
			} else {
				if (strtotime($date) > strtotime($row['auth_endtime'])) {
					$data = array("code" => 1, "msg" => "您的域名授权<font color=red>已到期</font>，请联系客服续期！");
				} else {
					$data = array("code" => 1, "msg" => "您的域名<font color=green>已认证</font>,可使用本站正版程序！");
				}

			}

		} else {
			$data = array("code" => -1, "msg" => "您的域名<font color=red>暂未授权</font>,请自助授权或联系客服授权！");
		}

	}
	$DB->close();
	exit(json_encode($data));
	break;
case 'addauths':
	$host = daddslashes(trim($_POST['host']));
	$zzqq = daddslashes(trim($_POST['zzqq']));
	$vcode = daddslashes(trim($_POST['vcode']));
	$skey = daddslashes(trim($_POST['skey']));
	$km = daddslashes(trim($_POST['km']));
	$vc_code = $_SESSION['vc_code'];
	if (strexists($host, "http://")) {
		$data = array("code" => -1, "msg" => "域名无需输入http://");
		$DB->close();
		exit(json_encode($data));
	}
	if (!strexists($host, ".")) {
		$data = array("code" => -1, "msg" => "域名格式疑似不正确");
		$DB->close();
		exit(json_encode($data));
	}
	if (substr_count($host, ".") == 1) {
		$data = array("code" => -1, "msg" => "授权顶级域名请加www");
		$DB->close();
		exit(json_encode($data));
	}
	if ($vcode != $vc_code && strtolower($vcode) != $vc_code) {
		$data = array("code" => -1, "msg" => "验证码错误");
		$DB->close();
		exit(json_encode($data));
	} else {
		$checkkm = $biz->checkkm($km);
		if ($checkkm['code'] != 1) {
			$DB->close();
			exit(json_encode($checkkm));
		} else {
			$checkhost = $biz->checkhost($host);
			if ($checkhost['code'] != 1) {
				$DB->close();
				exit(json_encode($checkhost));
			} else {
				$addauths = $biz->addauths($km, $zzqq, $skey, $host);

				$DB->close();
				exit(json_encode($addauths));
			}
		}
	}
	break;
case 'gethost':
	$qq = daddslashes($_GET['uin']);
	exit(json_encode($biz->gethost($qq)));
	break;
case 'checkqqandgethost':
	$qq = daddslashes($_POST['uin']);
	exit(json_encode($biz->gethost($qq)));
	break;
case 'send-email-vc':
	$send_interval = intval($conf['send_interval']);
	if ($_SESSION['sendemailtime']) {
		$timec = time() - $_SESSION['sendemailtime'];

		if ($timec < $send_interval) {
			$timex = $send_interval - $timec;
			$data = array("code" => -1, "msg" => "请" . $timex . "秒后再试！");
			exit(json_encode($data));
		}
	}
	$qq = daddslashes($_POST['uin']);
	$hostid = daddslashes($_POST['hostid']);
	if ($biz->checkqq($qq)) {
		if ($biz->checkhostbyid($hostid)) {
			$to = $qq . "@qq.com";
			$etitle = $conf['title'] . "下载程序验证码";
			$evc = random(6, 1);
			$_SESSION['evc'] = $evc;
			$_SESSION['sendemailtime'] = time();
			$edata = send_email($to, $etitle, "您的验证码是<font color=red>" . $evc . "</font>，请在" . ($send_interval / 60) . "分钟内完成验证！");
			if ($edata['code'] == 1) {
				systemlog(1, "邮箱下载程序,邮箱：" . $to . ",验证码：" . $evc);
				$data = array("code" => 1, "msg" => "验证码已经成功发送到您的QQ邮箱！");
			} else {
				$data = array("code" => -1, "msg" => "验证码发送失败！");
			}

		} else {
			$data = array("code" => -1, "msg" => "该域名还没有授权！");
		}
	} else {
		$data = array("code" => -1, "msg" => "该QQ还没有授权！");
	}
	exit(json_encode($data));
	break;
case 'getpro':
	$qq = daddslashes($_POST['uin']);
	$hostid = daddslashes($_POST['hostid']);
	$vccode = daddslashes($_POST['vccode']);
	if (empty($_SESSION['evc']) || $vccode != $_SESSION['evc']) {
		$data = array("code" => -1, "msg" => "验证码不正确！");
		exit(json_encode($data));
	}
	if ($_SESSION['sendemailtime']) {
		$timec = time() - $_SESSION['sendemailtime'];
		if ($timec < intval($conf['send_interval'])) {
			//有效
			systemlog(1, "邮箱下载程序验证成功,邮箱：" . $to . ",验证码：" . $vccode);
			if ($conf['down_iswurl'] == 1) {
				$data = array("code" => 2, "msg" => "验证成功！", "downurl" => $conf['down_w_url']);
			} else {
				$_SESSION['logintoken'] = md5($qq . "/");
				$_SESSION['loginqq'] = $qq;
				$data = array("code" => 1, "msg" => "验证成功！", "nickname" => get_qqnick($qq));
			}

			exit(json_encode($data));
		} else {
			//无效
			$data = array("code" => -1, "msg" => "验证码已经过期，请刷新重试！");
			exit(json_encode($data));
		}
	}
	exit(json_encode($data));
	break;
case 'changeauthbyskey':
	if (empty($conf['ischangeauth']) || $conf['ischangeauth'] == 0) {
		$data = array("code" => -1, "msg" => "自助更换授权未开启！");
		$DB->close();
		exit(json_encode($data));
	}
	$qq = daddslashes($_POST['uin']);
	$host = daddslashes($_POST['host']);
	$newhost = daddslashes($_POST['newhost']);
	$skey = daddslashes($_POST['skey']);
	$vcode = daddslashes($_POST['vccode']);
	if (strexists($host, "http://")) {
		$data = array("code" => -1, "msg" => "旧域名无需输入http://");
		$DB->close();
		exit(json_encode($data));
	}
	if (!strexists($host, ".")) {
		$data = array("code" => -1, "msg" => "旧域名格式疑似不正确");
		$DB->close();
		exit(json_encode($data));
	}
	if (strexists($newhost, "http://")) {
		$data = array("code" => -1, "msg" => "新域名无需输入http://");
		$DB->close();
		exit(json_encode($data));
	}
	if (!strexists($newhost, ".")) {
		$data = array("code" => -1, "msg" => "新域名格式疑似不正确");
		$DB->close();
		exit(json_encode($data));
	}
	$vc_code = $_SESSION['vc_code'];
	if ($vcode != $vc_code && strtolower($vcode) != $vc_code) {
		$data = array("code" => -1, "msg" => "验证码错误");
		$DB->close();
		exit(json_encode($data));
	}
	if (!$biz->checkqq($qq)) {
		$data = array("code" => -1, "msg" => "QQ验证失败！");
		$DB->close();
		exit(json_encode($data));
	}
	if (!$biz->checkhost($host)) {
		$data = array("code" => -1, "msg" => "旧域名验证失败！");
		$DB->close();
		exit(json_encode($data));
	}
	$data = $biz->changehost($host, $qq, $skey, $newhost);
	$DB->close();
	exit(json_encode($data));

	break;
case 'txcheck':
	$apiurl = daddslashes($_POST['apiurl']);
	$serverapi = daddslashes($_POST['serverapi']);
	$apitoken = daddslashes($_POST['apitoken']);
	$url = $apiurl . "api.php?act=apicheck";
	$post = "token=" . $serverapi . "&mytoken=" . $apitoken;
	if (GetHttpStatusCode($url) != 200) {
		$data = array("code" => -1, "msg" => "通讯异常！");
		$DB->close();
		exit(json_encode($data));
	}
	$ret = get_curl($url, $post);
	systemlog(3, "API通讯检测");
	$DB->close();
	exit($ret);
	break;
case 'checkdatasynchronize':
	$index = intval($_POST['index']);
	$lastindex = intval($_POST['lastindex']);

	$sql = "select auth_host from auth_zzi_authlist order by auth_id desc limit $index,$lastindex ";
	$rs = $DB->query($sql);
	$hoststr = "";
	while ($row = $DB->fetch($rs)) {
		if ($hoststr != "") {
			$hoststr = $hoststr . "|";
		}
		$hoststr .= $row['auth_host'];
	}

	$apiurl = $conf['apiurl'];
	$url = $apiurl . "api.php?act=datasynchronize";
	$post = "hoststr=" . $hoststr . "&token=" . $conf['serverapi'];
	systemlog(3, "API同步数据检测");
	$ret = get_curl($url, $post);
	$DB->close();
	exit($ret);
	break;
case 'execdatasynchronize':
	$hostlist = daddslashes($_POST['hostlist']);
	$hostlist = explode("|", $hostlist);
	$host = '';
	$i = 0;
	foreach ($hostlist as $value) {
		if ($host != "") {
			$host .= ",";
		}

		$host = $host . '"' . $value . '"';
		$i++;
	}
	$sql = "select auth_host,auth_qq,auth_skey,auth_time,auth_endtime,auth_revisecount,auth_operator,auth_remark,auth_status from auth_zzi_authlist where auth_host in ($host)";

	$rs = $DB->query($sql);
	$hostdata = array();
	while ($row = $DB->fetch($rs)) {
		array_push($hostdata, $row);
	}
	$apiurl = $conf['apiurl'];
	$url = $apiurl . "api.php?act=data_save";
	$post = "token=" . $conf['serverapi'] . "&data=" . json_encode($hostdata);
	systemlog(3, "执行API同步数据,待同步数据：" . $i);
	$ret = get_curl($url, $post);
	$DB->close();
	exit($ret);

	break;
case 'deltallog':
	$str = daddslashes($_POST['str']);
	$sql = "delete from auth_zzi_log where log_id in ($str)";
	if ($DB->query($sql)) {
		$data = array("code" => 1, "msg" => "删除选择数据成功！");
	} else {
		$data = array("code" => -1, "msg" => "删除选择数据失败！");
	}
	$DB->close();
	exit(json_encode($data));
	break;
case 'setwread':
	$str = daddslashes($_POST['str']);
	$sql = "update auth_zzi_log set log_read = 0 where log_id in ($str)";
	if ($DB->query($sql)) {
		$data = array("code" => 1, "msg" => "状态更新成功！");
	} else {
		$data = array("code" => -1, "msg" => "状态更新失败！");
	}
	$DB->close();
	exit(json_encode($data));
	break;
case 'setyread':
	$str = daddslashes($_POST['str']);
	$sql = "update auth_zzi_log set log_read = 1 where log_id in ($str)";
	if ($DB->query($sql)) {
		$data = array("code" => 1, "msg" => "状态更新成功！");
	} else {
		$data = array("code" => -1, "msg" => "状态更新失败！");
	}
	$DB->close();
	exit(json_encode($data));
	break;
case 'detalllog':
	$sql = "delete from auth_zzi_log";
	if ($DB->query($sql)) {
		$data = array("code" => 1, "msg" => "删除数据成功！");
	} else {
		$data = array("code" => -1, "msg" => "删除数据失败！");
	}
	$DB->close();
	exit(json_encode($data));
	break;
case 'setreadalllog':
	$sql = "update auth_zzi_log set log_read = 1 ";
	if ($DB->query($sql)) {
		$data = array("code" => 1, "msg" => "状态更新成功！");
	} else {
		$data = array("code" => -1, "msg" => "状态更新失败！");
	}
	$DB->close();
	exit(json_encode($data));
	break;
default:break;
}
?>