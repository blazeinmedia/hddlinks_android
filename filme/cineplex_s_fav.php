<!DOCTYPE html>
<?php
include ("../common.php");
$page_title="Seriale favorite";
$token=$_GET["token"];
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
      <title><?php echo $page_title; ?></title>
<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="../jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="../jquery.fancybox.min.css">
<link rel="stylesheet" type="text/css" href="../custom.css" />

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
function ajaxrequest(link) {
  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance

  // create pairs index=value with data that must be sent to server
  //var the_data = {mod:add,title:title, link:link}; //Array
  var the_data = link;
  var php_file='cineplex_s_add.php';
  request.open("POST", php_file, true);			// set the request

  // adds a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      alert (request.responseText);
      location.reload();
    }
  }
}
</script>
<script type="text/javascript">
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
var id_link="";
function isValid(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode,
    self = evt.target;
    if (charCode == "49") {
     id = "imdb_" + self.id;
     id_link=self.id;
     val_imdb=document.getElementById(id).value;
     msg="imdb.php?tip=series&" + val_imdb;
     document.getElementById("fancy").href=msg;
     document.getElementById("fancy").click();
    } else if  (charCode == "51") {
      id = "fav_" + self.id;
      val_fav=document.getElementById(id).value;
      ajaxrequest(val_fav);
    }
    return true;
}
$(document).on('keyup', '.imdb', isValid);
document.onkeypress =  zx;
</script>
</head>
<body>
<a id="fancy" data-fancybox data-type="iframe" href=""></a>
<H2></H2>
<div id="mainnav">
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
if (file_exists($base_pass."tastatura.txt")) {
$tast=trim(file_get_contents($base_pass."tastatura.txt"));
} else {
$tast="NU";
}
$w=0;
$n=0;
$w=0;
if (file_exists($base_pass."player.txt")) {
$flash=trim(file_get_contents($base_pass."player.txt"));
} else {
$flash="direct";
}
echo '<H2>'.$page_title.'</H2>';

$file=$base_fav."cineplex_s.dat";
$arr=array();
$h="";
if (file_exists($file)) {
  $h=trim(file_get_contents($file));
  //echo $h;
  $t1=explode("\r\n",$h);
  for ($k=0;$k<count($t1);$k++) {
    $a=explode("#separator",$t1[$k]);
    if ($a) {
      $tit=trim($a[0]);
      $l=trim($a[1]);
      $y=trim($a[2]);
      $img=trim($a[3]);
      $arr[$tit]["link"]=$l;
      $arr[$tit]["year"]=$y;
      $arr[$tit]["image"]=$img;
    }
  }
}
if ($arr) {
//print_r ($arr);
$n=0;
$nn=count($arr);
//echo "nn=".$nn;
$k=intval($nn/10) + 1;
$p=0;
echo '<table border="1px" width="100%">'."\n\r";
for ($m=1;$m<$k;$m++) {
if ($p==0) echo '<TR>';
   echo '<TD class="salt" align="center"><a href="#myLink'.($m*10).'">Salt:'.($m*10).'</a></td>';
   $p++;
  if ($p == 14) {
  echo '</tr>';
  $p=0;
  }
}
echo '</table>';
$p=0;
echo '<table border="1px" width="100%">'."\n\r";
foreach($arr as $key => $value) {

	$link = $arr[$key]["link"];
    $link1=$link;
    $title11 = $key;
    $image=$arr[$key]["image"];
    $year=$arr[$key]["year"];

  if ($n==0) echo '<TR>';
  $link='cineplex_s_ep.php?tip=series&imdb='.$link1.'&title='.urlencode(fix_t($title11)).'&image='.$image."&year=".$year."&token=".$token;

  $fav_link="mod=del&title=".urlencode(fix_t($title11))."&imdb=".$link1."&year=".$year."&image=".$image;
  if ($tast == "NU") {
  echo '<td class="mp" align="center" width="25%"><a class="imdb" id="myLink'.($p*1).'" href="'.$link.'" target="_blank"><img src="'.$image.'" width="200px" height="280px"><BR>'.unfix_t(urldecode($title11)).' ('.$year.')</a>';
  echo '<a onclick="ajaxrequest('."'".$fav_link."'".')" style="cursor:pointer;">*</a></TD>';
  } else {
  $val_imdb="title=".unfix_t(urldecode($title11))."&year=".$year."&imdb=";
  echo '<td class="mp" align="center" width="25%"><a class="imdb" id="myLink'.($p*1).'" href="'.$link.'" target="_blank"><img src="'.$image.'" width="200px" height="280px"><BR>'.unfix_t(urldecode($title11)).' ('.$year.')<input type="hidden" id="imdb_myLink'.($p*1).'" value="'.$val_imdb.'"><input type="hidden" id="fav_myLink'.($p*1).'" value="'.$fav_link.'"></a></TD>';

  }
  $p++;
  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
}
echo '</TABLR>';
}
?>
</div>
<br></body>
</html>
