<!DOCTYPE html>
<?php
error_reporting(0);
include ("../common.php");
$page1="";
$page1=$_GET["page1"];
if (!$page1) {
$query = $_GET["page"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
   $page_title=urldecode($queryArr[2]);
   $search=str_replace("|","&",$search);
}
} else {
 $search1=$_GET["src"];
 file_put_contents($base_cookie."adult.dat",urldecode($search1));
 $search1=str_replace(" ","+",$search1);
 $page_title="Cautare: ".str_replace("+"," ",$search1);
 $search="https://www.redtube.com/?search=".$search1."&page=".$page1;
 //$search="https://www.redtube.com/?search";
 //http://www.redtube.com/?search=&page=2
 //https://www.redtube.com/?search=mom+son&page=2
}
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
      <title><?php echo $page_title; ?></title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript">
// create the XMLHttpRequest object, according browser
function get_XmlHttp() {
  // create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
  var xmlHttp = null;
  if(window.XMLHttpRequest) {		// for Forefox, IE7+, Opera, Safari, ...
    xmlHttp = new XMLHttpRequest();
  }
  else if(window.ActiveXObject) {	// for Internet Explorer 5 or 6
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlHttp;
}

// sends data to a php file, via POST, and displays the received answer
function ajaxrequest(title, link) {
  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance

  // create pairs index=value with data that must be sent to server
  //var the_data = {mod:add,title:title, link:link}; //Array
  on();
  var the_data = "mod=add&title="+ title +"&link="+link;
  var php_file="redtube_link.php";
  request.open("POST", php_file, true);			// set the request

  // adds a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
    off();
    document.getElementById("mytest1").href=request.responseText;
      document.getElementById("mytest1").click();
    }
  }
}
</script>
<link rel="stylesheet" type="text/css" href="../custom.css" />
<style>
#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    z-index: 2;
    cursor: pointer;
}

#text{
    position: absolute;
    top: 50%;
    left: 50%;
    font-size: 50px;
    color: white;
    transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
}
</style>
</head>
<body>
<script>
function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}
</script>
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
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
$c="";
  echo "<a href='".$c."' id='mytest1'></a>".'<div id="mainnav">';
//http://www.hdfilm.ro/index.php?p=filme&gen=Actiune&page=1
echo '<H2>'.$page_title.'</H2>';
echo '<table border="1px" width="100%">'."\n\r";
echo '<tr><TD colspan="4" align="right">';
if ($page1) {
if ($page1 > 1)
echo '<a href="redtube.php?page1='.($page1-1).'&src='.$search1.'">&nbsp;&lt;&lt;&nbsp;</a> | <a href="redtube.php?page1='.($page1+1).'&src='.$search1.'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
else
echo '<a href="redtube.php?page1='.($page1+1).'&src='.$search1.'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
//$html = file_get_contents($search);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $search);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
  //echo $html;
} else {
if ($page > 1)
echo '<a href="redtube.php?page='.($page-1).','.$search.','.urlencode($page_title).'">&nbsp;&lt;&lt;&nbsp;</a> | <a href="redtube.php?page='.($page+1).','.$search.','.urlencode($page_title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
else
echo '<a href="redtube.php?page='.($page+1).','.$search.','.urlencode($page_title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
//$html = file_get_contents($search."?page=".$page);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $search."?page=".$page);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
}
$n=0;
//echo $html;
//$videos = explode('<div class="video">', $html);
//$videos=explode('<span class="video-title">',$html);
//$videos=explode('class="video-thumb"',$html);
if (strpos($html,'li class="videoblock_list') !== false)
   $videos=explode('li class="videoblock_list',$html);
else {
  $t1=explode('class="video-listing',$html);
  //$html=$t1[1];
  $videos=explode("video_link",$html);
}
//echo $html;
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1=explode('href="',$video);
    $t2 = explode('"', $t1[1]);
    if (preg_match("/\/(\d+)/",$t2[0])) {
    $link = "https://www.redtube.com".$t2[0];
    } else
      $link="";
    //http://img02.redtubefiles.com/_thumbs/0000350/0350855/0350855_009m.jpg
    $t1 = explode('data-src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];
    $image=str_replace("https","http",$image);
    $t1=explode('class="video_title" >',$video);
    $t2=explode('<',$t1[1]);
    $title=trim($t2[0]);
    if (!$title) {
      $t1=explode('title="',$video);
      $t2=explode('"',$t1[1]);
      $title=trim($t2[0]);
    }
    //$title=str_between($video,'title="','"');
    $t1=explode('class="duration">',$video);
    $t2=explode('</a',$t1[1]);
    $durata = trim(preg_replace("/(<\/?)(\w+)([^>]*>)/e","",$t2[0]));
    if ($title && $link) {
    $title=$title." (".$durata.")";
  if ($n==0) echo '<TR>';
  if ($flash != "mp") {
  $link = "redtube_link.php?file=".$link."&title=".urlencode($title);
  echo '<td class="mp" align="center" width="25%"><a href="'.$link.'" target="_blank"><img src="'.$image.'" width="200px" height="150px"><BR>'.$title.'</a></TD>';
  } else {
  echo '<td class="mp" align="center" width="25%"><a onclick="ajaxrequest('."'".urlencode($title)."', '".urlencode($link)."')".'"'." style='cursor:pointer;'>".'<img src="'.$image.'" width="200px" height="150px"><BR>'.$title.'</a></TD>';
  }
  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
  }
}
echo '<tr><TD colspan="4" align="right">';
if ($page1) {
if ($page1 > 1)
echo '<a href="redtube.php?page1='.($page1-1).'&src='.$search1.'">&nbsp;&lt;&lt;&nbsp;</a> | <a href="redtube.php?page1='.($page1+1).'&src='.$search1.'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
else
echo '<a href="redtube.php?page1='.($page1+1).'&src='.$search1.'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';

} else {
if ($page > 1)
echo '<a href="redtube.php?page='.($page-1).','.$search.','.urlencode($page_title).'">&nbsp;&lt;&lt;&nbsp;</a> | <a href="redtube.php?page='.($page+1).','.$search.','.urlencode($page_title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
else
echo '<a href="redtube.php?page='.($page+1).','.$search.','.urlencode($page_title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';

}
echo "</table>";
?>
<br></div>
<div id="overlay"">
  <div id="text">Wait....</div>
</div>
</body>
</html>
