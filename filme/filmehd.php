<!DOCTYPE html>
<?php
include ("../common.php");
$page = $_GET["page"];
$tip= $_GET["tip"];
$tit=$_GET["title"];
$link=$_GET["link"];
$width="200px";
$height="278px";
if ($tip=="search") {
  $page_title = "Cautare: ".$tit;
  file_put_contents($base_cookie."filme.dat",$tit);
} else
  $page_title=$tit;
$base=basename($_SERVER['SCRIPT_FILENAME']);
$p=$_SERVER['QUERY_STRING'];
parse_str($p, $output);

if (isset($output['page'])) unset($output['page']);
$p = http_build_query($output);
if (!isset($_GET["page"]))
  $page=1;
else
  $page=$_GET["page"];
$next=$base."?page=".($page+1)."&".$p;
$prev=$base."?page=".($page-1)."&".$p;
if($tip=="release") {
 if ($page>1)
  $l = $link."/page/".$page;
 else
  $l=$link;
} else {
  $search=str_replace(" ","+",$tit);
  $l="https://filmehd.net/?s=".$search;
}
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
var id_link="";
function isValid(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode,
    self = evt.target;
    if (charCode == "49") {
     id = "imdb_" + self.id;
     id_link=self.id;
     val_imdb=document.getElementById(id).value;
     msg="imdb.php?tip=movie&" + val_imdb;
     document.getElementById("fancy").href=msg;
     document.getElementById("fancy").click();
    }
    return true;
}
   function zx(e){
     var instance = $.fancybox.getInstance();
     var charCode = (typeof e.which == "number") ? e.which : e.keyCode
     if (charCode == "13"  && instance !== false) {
       $.fancybox.close();
       setTimeout(function(){ document.getElementById(id_link).focus(); }, 500);
    }
   }
$(document).on('keyup', '.imdb', isValid);
document.onkeypress =  zx;
</script>
</head>
<body>
<a id="fancy" data-fancybox data-type="iframe" href=""></a>
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
echo '<H2>'.$page_title.'</H2>';

echo '<table border="1px" width="100%" style="table-layout:fixed;">'."\n\r";

if ($tip == "release") {
echo '<tr><TD class="nav" colspan="4" align="right">';
if ($page > 1)
echo '<a class="nav" href="'.$prev.'"><font size="4">&nbsp;&lt;&lt;&nbsp;</font></a> | <a href="'.$next.'"><font size="4">&nbsp;&gt;&gt;&nbsp;</font></a></TD></TR>';
else
echo '<a class="nav" href="'.$next.'"><font size="4">&nbsp;&gt;&gt;&nbsp;</font></a></TD></TR>';
}
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
$html=urlencode($html);
$x=urlencode('<div class="imgleft"');
//$videos = explode('d%3D%22post', $html);
$videos = explode($x,$html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
	$t1 = explode('href%3D%22', $video);
	$t2 = explode("%22", $t1[1]);
	$link = urldecode($t2[0]);
	$link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link);
	$t1 = explode('src%3D%22', $video);
	$t2 = explode('%22', $t1[1]);
	$image = urldecode($t2[0]);

	$t1 = explode('alt%3D%22', $video);
	$t2 = explode('%22', $t1[1]);
	$t2=urldecode($t2[0]);
	$t3 = explode("&#8211;",$t2);
	$title = str_replace("– Filme online gratis subtitrate in romana","",$t3[0]);
	$title = str_replace("– Filme online gratis subtitratate in romana","",$title);
	$title = str_replace("– Filme online gratis subititrate in romana","",$title);
	$title = trim($title);
    $title=htmlspecialchars_decode($title,ENT_QUOTES);
    $title=html_entity_decode($title,ENT_QUOTES);
	$title=preg_replace("/online|subtitrat(e*)|film(e*)|vezi(.*)(:)|gratis/si","",$title);
	$title=trim(str_replace("&nbsp;","",$title));
    $year="";
	$pos = strpos($image, '.jpg');
	if (($pos !== false) && ($title <> "") && strpos($link,"serial-tv") === false){
    //$link = 'filme_link.php?file='.$link.','.urlencode($title);
  $link_f='filme_link.php?file='.urlencode($link).'&title='.urlencode(fix_t($title));
  if ($n==0) echo '<TR>';
  if ($tast == "NU")
    echo '<td class="mp" width="25%"><a href="'.$link_f.'" target="blank"><img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR><font size="4">'.$title.'</font></a></TD>';
  else {
    $val_imdb="title=".$title."&year=".$year."&imdb=";
    echo '<td class="mp" width="25%"><a class ="imdb" id="myLink'.($w*1).'" href="'.$link_f.'" target="blank"><input type="hidden" id="imdb_myLink'.($w*1).'" value="'.$val_imdb.'"><img src="'.$image.'" width="'.$width.'" height="'.$height.'"><BR>'.$title.'</a></TD>';
    $w++;
  }
  $n++;
  if ($n == 4) {
  echo '</tr>';
  $n=0;
  }
}
}
if ($tip == "release") {
echo '<tr><TD class="nav" colspan="4" align="right">';
if ($page > 1)
echo '<a class="nav" href="'.$prev.'"><font size="4">&nbsp;&lt;&lt;&nbsp;</font></a> | <a href="'.$next.'"><font size="4">&nbsp;&gt;&gt;&nbsp;</font></a></TD></TR>';
else
echo '<a class="nav" href="'.$next.'"><font size="4">&nbsp;&gt;&gt;&nbsp;</font></a></TD></TR>';
}
echo "</table>";
?>
<br></body>
</html>
