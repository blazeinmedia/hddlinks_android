<?php
//set_time_limit(0);
error_reporting(0);
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
include ("../common.php");
if (file_exists($base_pass."player.txt")) {
$flash=trim(file_get_contents($base_pass."player.txt"));
} else {
$flash="direct";
}
if (file_exists($base_pass."mx.txt")) {
$mx=trim(file_get_contents($base_pass."mx.txt"));
} else {
$mx="ad";
}
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
if ($flash != "mp") {
if (preg_match("/android|ipad/i",$user_agent) && preg_match("/chrome|firefox|mobile/i",$user_agent)) $flash="chrome";
}
if (isset($_POST["link"])) {
$link = urldecode($_POST["link"]);
$link=str_replace(" ","%20",$link);
$title = urldecode($_POST["title"]);
} else {
$link = $_GET["file"];
$title = $_GET["title"];
}
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_REFERER, "https://xhamster.com");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
$t1=explode("sources",$html);
$html=$t1[1];
$html=str_replace("\\","",$html);
//echo $html;
//preg_match('/[\d+p":"]([http|https][\.\d\w\-\.\/\\\:\?\&\#\%\_\,]*(\.mp4))/', $html, $m);
//print_r ($m);
//die();
//$link = urldecode(str_between($html, "flv_url=", "&"));
//if (!$link) {
$t1=explode('720p":"',$html);
$t2=explode('"',$t1[1]);
$link=$t2[0];
if (!$link) {
$t1=explode('480p":"',$html);
$t2=explode('"',$t1[1]);
$link=$t2[0];
}
if (!$link) {
$t1=explode('360p":"',$html);
$t2=explode('"',$t1[1]);
$link=$t2[0];
}
if (!$link) {
$t1=explode('240p":"',$html);
$t2=explode('"',$t1[1]);
$link=$t2[0];
}

$link1=str_replace("\\","",$link);

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $link1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0');
      curl_setopt($ch, CURLOPT_REFERER, "https://xhamster.com");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_NOBODY,true);
      curl_setopt($ch, CURLOPT_HEADER,1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      $ret = curl_exec($ch);
      curl_close($ch);
      $t1=explode("Location:",$ret);
      $t2=explode("\n",$t1[1]);
      $link=trim($t2[0]);
      //echo $link;
      if (!$link) $link=$link1;

$out=$link;
/*
//echo $out;
//if (strpos($out,"ahcdn.com") === false) $out=str_replace("https","http",$out);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $out);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0');
      curl_setopt($ch, CURLOPT_REFERER, "https://xhamster.com");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_NOBODY,true);
      curl_setopt($ch, CURLOPT_HEADER,1);
      $ret = curl_exec($ch);
      curl_close($ch);
echo $ret;
die();
*/
if (strpos($out,"http") === false) $out="";
if ($flash=="mpc") {
  $mpc=trim(file_get_contents($base_pass."mpc.txt"));
  $c='"'.$mpc.'" /fullscreen "'.$out.'"';
  pclose(popen($c,"r"));
  echo '<script type="text/javascript">window.close();</script>';
  die();
}
elseif ($flash == "direct") {
header('Content-type: application/vnd.apple.mpegURL');
header('Content-Disposition: attachment; filename="video.mp4"');
header("Location: $out");
} elseif ($flash == "mp") {
$c="intent:".$out."#Intent;type=video/mp4;package=com.mxtech.videoplayer.".$mx.";S.title=".urlencode($title).";end";
echo $c;
} elseif ($flash == "chrome") {
  $c="intent:".$out."#Intent;type=video/mp4;package=com.mxtech.videoplayer.".$mx.";S.title=".urlencode("Play").";end";
  header("Location: $c");
} else {
$out=str_replace("&amp;","&",$out);
//$title="play now..";
echo '
<!doctype html>
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>'.$title.'</title>
<style type="text/css">
body {
margin: 0px auto;
overflow:hidden;
}
body {background-color:#000000;}
</style>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="../jwplayer.js"></script>

</HEAD>
<body><div id="mainnav">
<div id="container"></div>
<script type="text/javascript">
jwplayer("container").setup({
"playlist": [{
"sources": [{"file": "'.$out.'"}]
}],
"height": $(document).height(),
"width": $(document).width(),
"skin": {
    "name": "beelden",
    "active": "#00bfff",
    "inactive": "#b6b6b6",
    "background": "#282828"
},
"autostart": true,
"startparam": "start",
"fallback": false,
"wmode": "direct",
"stagevideo": true
});
</script>
</div></body>
</HTML>
';
}
?>
