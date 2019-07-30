<?php
include 'ayangw/common.php';

@header('Content-Type: application/json; charset=UTF-8');
$act = !empty($_GET['act'])?str_filter($_GET['act']):null;

switch ($act){
    case 'update':
        $_POST = $_GET;
        $host = daddslashes($_POST['host']);
        $authcode = daddslashes($_POST['authcode']);
        $version = daddslashes($_POST['version']);
        $buiid = intval($_POST['buiid']);
        $r = $_POST['r'];
        $sql = "select auth_host,auth_status,auth_endtime from auth_zzi_authlist where auth_endtime > now() and auth_status = 1 and  auth_host = '$host'";
        $row = $DB->get_row($sql);
        if(!$row){
            $data = array("code"=>-1,"msg"=>"无法为该站点提供更新服务");
            $DB->close();
            exit(json_encode($data));
        }
        if($buiid<intval($conf['buiid'])){
            //需要更新
            $data = array("code" => 2,"msg"=>"发现最新版本","version"=>$conf['version'],"buiid"=>$conf['buiid'],"updatezip"=>$conf['updatezip'],"version-msg"=>$conf['version-msg']);
            $DB->close();
            exit(json_encode($data));
        }elseif ($buiid==intval($conf['buiid'])) {
            //正常
            $data = array("code" => 1,"msg"=>"当前已是最新版本","version"=>$conf['version'],"buiid"=>$conf['buiid']);
            $DB->close();
            exit(json_encode($data));
        }else{
            $data = array("code"=>-1,"msg"=>"检测到程序异常,无法为该站点提供更新服务");
            $DB->close();
            exit(json_encode($data));
        }
        break;
    //授权验证
    case 'query':
        $_POST = $_GET;
        $host = daddslashes($_POST['host']);
        $authcode = daddslashes($_POST['authcode']);
        $referer = $_SERVER['HTTP_REFERER']  ;
        $notauthtis = !empty($conf['notauth-msg'])?$conf['notauth-msg']:"检查到您的网站未授权,暂时无法使用我们的程序!";
        $errtis = !empty($conf['errauth-msg'])?$conf['errauth-msg']:"检查到您的网站使用异常,暂时无法使用我们的程序!";
        $endtis = !empty($conf['endauth-msg'])?$conf['endauth-msg']:"您的网站已到期,请联系客服续费!";
        if(cauthcode($host) != $authcode){
            //授权码错误
            $sql = "select auth_host,auth_status,auth_endtime from auth_zzi_authlist where auth_host = '$host'";
            $row = $DB->get_row($sql);
            if($row){
                if($row['auth_status'] != 1){
                    $data = array("code"=>-1,"msg"=>$errtis);
                    $DB->close();
                    exit(json_encode($data));
                }elseif((strtotime($row['auth_endtime'])) < strtotime(date("Y-m-d H:i:s"))){
                    $data = array("code"=>-1,"msg"=>$endtis."--");
                    $DB->close();
                    exit(json_encode($data));
                }else{
                     $data = array(
                         "code"=>1,
                         "msg"=>"正版授权".$referer,
                         "authcode"=>cauthcode($host),
                         "version"=>$conf['version'],
                         "buiid"=>$conf['buiid']);
                     $DB->close();
                     exit(json_encode($data));
                }
            }else{
                $data = array("code"=>-1,"msg"=>$notauthtis);
                $DB->close();
                exit(json_encode($data));
            }
        }else{
           
              $sql = "select auth_host,auth_status,auth_endtime from auth_zzi_authlist where auth_host = '$host'";
            $row = $DB->get_row($sql);
            if($row){
                if($row['auth_status'] != 1){
                    $data = array("code"=>-1,"msg"=>$errtis);
                    $DB->close();
                    exit(json_encode($data));
                }elseif((strtotime($row['auth_endtime'])) < strtotime(date("Y-m-d H:i:s"))){
                    $data = array("code"=>-1,"msg"=>$endtis);
                    $DB->close();
                    exit(json_encode($data));
                }else{
                     $data = array(
                         "code"=>1,
                         "msg"=>"正版授权",
                         "authcode"=>cauthcode($host),
                         "version"=>$conf['version'],
                         "buiid"=>$conf['buiid']);
                     $DB->close();
                     exit(json_encode($data));
                }
            }else{
                $data = array("code"=>-1,"msg"=>$notauthtis);
                $DB->close();
                exit(json_encode($data));
            }
        }
    break;
    //API验证
    case 'apicheck':
        if(empty($conf['apitoken']) || $conf['apitoken'] == ""){
            $data = array("code"=>-1,"msg"=>"未初始化接口！");
            $DB->close();
            exit(json_decode($data));
        }
        $token = daddslashes($_POST['token']);
        $serverapi = daddslashes($_POST['mytoken']);
        if($token == $conf['apitoken']){
            if($serverapi == $conf['serverapi']){
                 systemlog(3,"API通讯检测请求[单成功],来源：".$_SERVER['HTTP_REFERER'].",携带我方token：".$token);
                $data = array("code"=>1,"msg"=>"双方连接成功！");
            }else{
                systemlog(3,"API通讯检测请求[成功],来源：".$_SERVER['HTTP_REFERER'].",携带我方token：".$token);
                $data = array("code"=>1,"msg"=>"单方连接成功！");
            }
        }else{
            systemlog(3,"API通讯检测请求[失败],来源：".$_SERVER['HTTP_REFERER'].",携带我方token：".$token);
            $data = array("code"=>-1,"msg"=>"apitoken错误！");
        }
        $DB->close();
        exit(json_encode($data));
        break;
    
    //检查同步数据
    case 'datasynchronize':
        $hoststr = daddslashes($_POST['hoststr']);
        $token = daddslashes($_POST['token']);
        if(empty($conf['apitoken']) || $token != $conf['apitoken']){
            $hostdata = array("code"=>1,"msg"=>"接口TOKEN验证失败！");
            $DB->close();
            exit(json_encode($hostdata));
        }
        $hostarr = explode("|", $hoststr);
        $w = 0;
        $h = "";
        foreach ($hostarr as $value) {
            $row = $DB->get_row("select auth_host from auth_zzi_authlist where auth_host = '$value' limit 1");
            if(!$row){
                $w++;
                if($h != "") $h = $h."|";
                $h .= $value;
            }
        }
        $hostdata = array("code"=>1,"msg"=>"数据检查完毕","wnum"=>$w,"hoststr"=>$h);
        $DB->close();
        exit(json_encode($hostdata));
    break;
    //保存传过来的数据
    case 'data_save':
        $data = $_POST['data'];
        $data = (array)json_decode($data);
         $token = daddslashes($_POST['token']);
         if(empty($conf['apitoken']) || $token != $conf['apitoken']){
            $hostdata = array("code"=>1,"msg"=>"接口TOKEN验证失败！");
            $DB->close();
            exit(json_encode($hostdata));
        }
        $k = 0;
       for($i = 0;$i<count($data);$i++){
           $temp = (array)$data[$i];
           $sql = "insert into auth_zzi_authlist(auth_host,auth_qq,auth_skey,auth_time,auth_endtime,auth_revisecount,auth_operator,auth_remark,auth_status)"
                   . " values('{$temp['auth_host']}','{$temp['auth_qq']}','{$temp['auth_skey']}','{$temp['auth_time']}','{$temp['auth_endtime']}','{$temp['auth_revisecount']}','{$temp['auth_operator']}','{$temp['auth_remark']}','{$temp['auth_status']}')";
           if($DB->query($sql)) $k++;
        }
        exit(json_encode(array("code"=>1,"msg"=>"成功保存". $k."条数据","oknum"=>$k)));
        break;
    case 'data_delete':
         $token = daddslashes($_POST['token']);
         if(empty($conf['apitoken']) || $token != $conf['apitoken']){
            $hostdata = array("code"=>1,"msg"=>"接口TOKEN验证失败！");
            $DB->close();
            exit(json_encode($hostdata));
        }
        $host = daddslashes($_POST['host']);
        $qq = daddslashes($_POST['qq']);
        $sql = "delete from auth_zzi_authlist where auth_host='$host' and auth_qq ='$qq'";
        if($DB->query($sql)){
             systemlog(3,"【远程删除授权】：".$host);
             exit(json_encode(array("code"=>1,"msg"=>"删除成功")));
        }else{
            exit(json_encode(array("code"=>-1,"msg"=>"删除失败")));
        }
        break;
    case 'data_update':
        $token = daddslashes($_POST['token']);
         if(empty($conf['apitoken']) || $token != $conf['apitoken']){
            $hostdata = array("code"=>1,"msg"=>"接口TOKEN验证失败！");
            $DB->close();
            exit(json_encode($hostdata));
        }
        $host = daddslashes($_POST['host']);
        $qq = daddslashes($_POST['qq']);
        $set = urldecode($_POST['set']);
        $sql = "update auth_zzi_authlist set {$set} where auth_host='$host' and auth_qq ='$qq'";
        if($DB->query($sql)){
             systemlog(3,"【远程修改授权】：".$host);
             exit(json_encode(array("code"=>1,"msg"=>"修改成功")));
        }else{
            systemlog(3,"【远程修改授权失败】");
            exit(json_encode(array("code"=>-1,"msg"=>"修改失败")));
        }
        break;
    default :
        exit('{"code":-2,"message":"NOT ACTION！"}'); break;
}
