<!DOCTYPE html>
<?php
error_reporting(0);
include ("../common.php");
if (file_exists($base_cookie."filme.dat"))
  $val_search=file_get_contents($base_cookie."filme.dat");
else
  $val_search="";
$title = $_GET["title"];
$page = $_GET["page"];
$file=$_GET["file"];
$tip=$file;
if ($tip=="search") {
  $page_title="Cautare: ".urldecode($title);
  file_put_contents($base_cookie."filme.dat",urldecode($title));
} else
  $page_title=urldecode($title);
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

      <title><?php echo $page_title; ?></title>
<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="../jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="../jquery.fancybox.min.css">
<link rel="stylesheet" type="text/css" href="../custom.css" />
<script type="text/javascript">
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

function ajaxrequest(link) {
  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance

  // create pairs index=value with data that must be sent to server
  //var the_data = {mod:add,title:title, link:link}; //Array
  //link=document.getElementById('server').innerHTML;
  var the_data = link;
  //alert(the_data);
  var php_file="putlockerfit_f_add.php";
  request.open("POST", php_file, true);			// set the request

  // adds a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
       alert (request.responseText);
    }
  }
}
</script>
<script type="text/javascript">
var id_link="";
function isValid(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode,
        self = evt.target;
        //self = document.activeElement;
        //self = evt.currentTarget;
    //console.log(self.value);
       //alert (charCode);
    if (charCode == "97" || charCode == "49") {
     //alert (self.id);
     id = "imdb_" + self.id;
     id_link=self.id;
     val_imdb=document.getElementById(id).value;
     msg="imdb.php?tip=movie&" + val_imdb;
     document.getElementById("fancy").href=msg;
     document.getElementById("fancy").click();
    } else if  (charCode == "99" || charCode == "51") {
      id = "fav_" + self.id;
      val_fav=document.getElementById(id).value;
      ajaxrequest(val_fav);
    }
    return true;
}
   function zx(e){
     var instance = $.fancybox.getInstance();
     var charCode = (typeof e.which == "number") ? e.which : e.keyCode
     if (charCode == "13"  && instance !== false) {
       $.fancybox.close();
       setTimeout(function(){ document.getElementById(id_link).focus(); }, 500);
     } else if (charCode == "53" && e.target.type != "text") {
      document.getElementById("send").click();
     } else if (charCode == "50" && e.target.type != "text") {
      document.getElementById("fav").click();
    }
   }
$(document).on('keyup', '.imdb', isValid);
document.onkeypress =  zx;
</script>
</head>
<body>
<a id="fancy" data-fancybox data-type="iframe" href=""></a>
<div id="mainnav">
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
function decode_entities($text) {
    $text= html_entity_decode($text,ENT_QUOTES,"ISO-8859-1"); #NOTE: UTF-8 does not work!
    $text= preg_replace('/&#(\d+);/me',"chr(\\1)",$text); #decimal notation
    $text= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$text);  #hex notation
    return $text;
}
if (file_exists($base_pass."tastatura.txt")) {
$tast=trim(file_get_contents($base_pass."tastatura.txt"));
} else {
$tast="NU";
}
$w=0;
$n=0;
$w=0;
//echo '<H2>'.$page_title.'</H2>';
echo '<h2>'.$page_title.'</h2>';

echo '<table border="1px" width="100%">'."\n\r";
if ($tip=="release") {
echo "<TR>";
if ($page > 1) {
echo '<tr><TD colspan="4" align="right">';
echo '<a class="nav" href="putlockerfit_f.php?page='.($page-1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&lt;&lt;&nbsp;</a> | <a class="nav" href="putlockerfit_f.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
}else {
echo '<TR><TD class="cat"><a class "imdb" id="fav" href="putlockerfit_f_fav.php" target="blank">Favorite</a></TD>
<TD class="form" colspan="2">';
//echo '<TD colspan="2">';
//title=star&page=1&file=search
echo '<form action="putlockerfit_f.php" target="_blank">Cautare film:';
echo '<input type="text" id="title" name="title" value="'.$val_search.'">
<input type="hidden" id="page" name="page" value="1">
<input type="hidden" id="file" name="file" value="search">
<input type="submit" id="send" value="Cauta"></form></TD>';
echo '<TD colspan="1" align="right"><a class="nav" href="putlockerfit_f.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
}
}

if ($tip=="search")
  $requestLink = "https://putlocker0.com/?s=".str_replace(" ","+",$title);
 else
$requestLink="https://putlocker0.com/a-z-movies/page/".$page."/";

$r=parse_url($requestLink);
$host=$r["host"];
  $ch = curl_init($requestLink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://putlocker0.com/");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
//echo $l;
 $videos = explode('<a class="thumbnail', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('href="',$video);
  $t2 = explode('"', $t1[1]);
  $link1 = $t2[0];
  if (strpos($link1,"http") === false) $link1="https://".$host.$link1;
  $t1 = explode('h2>', $video);
  $t2 = explode('<', $t1[1]);
  $title11 = $t2[0];
  $title11=html_entity_decode($title11,ENT_QUOTES,'UTF-8');
  //$title11=decode_entities($title11);
  $title11=str_replace("#038;","",$title11);
  $title11=str_replace("&#8217;","'",$title11);
  $title11=trim(preg_replace("/Watch|Putlocker/i","",$title11));
  $t1 = explode('data-original="', $video);
  $t2 = explode('"', $t1[1]);
  $image = $t2[0];
  $link2='putlockerfit_fs.php?tip=movie&link='.$link1.'&title='.urlencode(fix_t($title11)).'&image='.$image."&sez=&ep=&ep_tit=";

  if ($title11 && strpos($link1,"/show") === false) {
  if ($n==0) echo '<TR>';
  $fav_link="mod=add&title=".urlencode(fix_t($title11))."&link=".$link1."&image=".urlencode($image);
    if ($tast == "NU") {
  echo '<td class="mp"align="center" width="25%"><a class="imdb" href="'.$link2.'" target="_blank"><img src="'.$image.'" width="200px" height="280px"><BR>'.$title11.'</a> <a onclick="ajaxrequest('."'".$fav_link."'".')" style="cursor:pointer;">*</a></TD>';
  } else {
   $year="";
  $val_imdb="title=".urlencode(fix_t($title11))."&year=".$year."&imdb=";
  echo '<td class="mp" align="center" width="25%"><a class="imdb" id="myLink'.$w.'" href="'.$link2.'" target="_blank"><img src="'.$image.'" width="200px" height="280px"><BR>'.unfix_t(urldecode($title11)).'</a>';
  echo '<input type="hidden" id="imdb_myLink'.($w*1).'" value="'.$val_imdb.'"><input type="hidden" id="fav_myLink'.($w*1).'" value="'.$fav_link.'"></a></TD>';
  $w++;
  }
  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
}
}

if ($tip=="release") {
echo '<tr><TD colspan="4" align="right">';
if ($page > 1)
echo '<a class="nav" href="putlockerfit_f.php?page='.($page-1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&lt;&lt;&nbsp;</a> | <a class="nav" href="putlockerfit_f.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
else
echo '<a class="nav" href="putlockerfit_f.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
}
echo "</table>";
?>
<br></div></body>
</html>
