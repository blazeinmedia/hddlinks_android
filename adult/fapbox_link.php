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
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);

  $l=str_between($html,'file:"','"');
  $img=str_between($html,'img: "','"');
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 0.5; en-us) AppleWebKit/522+ (KHTML, like Gecko) Safari/419.3');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt($ch, CURLOPT_NOBODY,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
  //echo $html;
  if (strpos($html,"Location") !== false) {
  $t1=explode("Location:",$html);
  $t2=explode("\n",$t1[1]);
  $out=trim($t2[0]);
  } else
   $out=$l;
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
header('Content-Disposition: attachment; filename="video/mp4"');
header("Location: $out");
} elseif ($flash == "mp") {
$c="intent:".$out."#Intent;type=video/mp4;package=com.mxtech.videoplayer.".$mx.";S.title=".urlencode($title).";end";
echo $c;
} elseif ($flash == "chrome") {
  $c="intent:".$out."#Intent;type=video/mp4;package=com.mxtech.videoplayer.".$mx.";S.title=".urlencode($title).";end";
  header("Location: $c");
} else {
$out=str_replace("&amp;","&",$out);
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
"sources": [{"file": "'.$out.'", "type": "mp4"}]
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
