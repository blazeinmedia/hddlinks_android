<!DOCTYPE html>
<?php
include ("../common.php");
if (file_exists($base_cookie."filme.dat"))
  $val_search=file_get_contents($base_cookie."filme.dat");
else
  $val_search="";
$title = $_GET["title"];
$page = $_GET["page"];
$file=$_GET["file"];
$tip=$file;
if ($tip=="search"){
  $page_title="Cautare: ".urldecode($title);
  file_put_contents($base_cookie."filme.dat",urldecode($title));
} else
  $page_title=urldecode($title);
//https://filmeseriale.online/seriale/
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
      <title><?php echo $page_title; ?></title>
<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<!--<script src="../../gistfile1.js"></script>-->
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
     if (charCode == "13"  && instance !== false && e.target.type != "text") {
       $.fancybox.close();
       setTimeout(function(){ document.getElementById(id_link).focus(); }, 500);
    } else if (charCode == "53" && e.target.type != "text") {
      document.getElementById("send").click();
    }
   }
$(document).on('keyup', '.imdb', isValid);
document.onkeypress =  zx;
</script>
</head>
<body>
<a id="fancy" data-fancybox data-type="iframe" href=""></a>
<div id="mainnav">
<H2></H2>
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
$year="";
echo '<H2>'.$page_title.'</H2>';

echo '<table border="1px" width="100%">'."\n\r";
if ($tip=="release") {
echo "<TR>";
if ($page > 1) {
echo '<tr><TD class="nav" colspan="4" align="right">';
echo '<a class="nav" href="filmeseriale_filme.php?page='.($page-1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&lt;&lt;&nbsp;</a> | <a class="nav" href="filmeseriale_filme.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
}else {
echo '<TD class="form" colspan="2">';
//title=star&page=1&file=search
echo '<form action="filmeseriale_filme.php" target="_blank">Cautare film:';
echo '<input type="text" id="title" name="title" value="'.$val_search.'"><input type="hidden" id="page" name="page" value="1"><input type="hidden" id="file" name="file" value="search"><input type="submit" id="send" value="Cauta..."></form></TD>';
echo '<TD class="nav" colspan="2" align="right"><a href="filmeseriale_filme.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
}
}
if ($tip=="release")
$l ="http://www.filmeserialeonline.org/filme-online/page/".$page."/";
else
$l = "http://www.filmeserialeonline.org/?s=".str_replace(" ","+",$title);
//https://filmeseriale.online/seriale/page/2/
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_REFERER, "https://filmeseriale.online");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
$videos = explode('div id="mt-', $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	$link1 = $link;


    $t3 = explode('class="tt">',$video);
    $t4 = explode('<',$t3[1]);
    $title = trim($t4[0]);
    $title=htmlspecialchars_decode($title,ENT_QUOTES);
    $title=html_entity_decode($title,ENT_QUOTES);
    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image=$t2[0];
    //$link="fs.php?link=".$link1."&title=".urlencode($title)."&tip=movie";
    if (strpos($link1,"/seriale") === false) {
    $link = 'filme_link.php?file='.urlencode($link1).",".urlencode($title);
  if ($n==0) echo '<TR>';
  if ($tast == "NU")
    echo '<td class="mp" align="center" width="25%"><a href="filme_link.php?file='.urlencode($link1).','.urlencode(fix_t($title)).'" target="blank"><img src="'.$image.'" width="200px" height="278px"><BR>'.$title.'</a></TD>';
  else {
  $val_imdb="title=".$title."&year=".$year."&imdb=";
  echo '<td class="mp" align="center" width="25%"><a class ="imdb" id="myLink'.($w*1).'" href="filme_link.php?file='.urlencode($link1).','.urlencode(fix_t($title)).'" target="blank"><input type="hidden" id="imdb_myLink'.($w*1).'" value="'.$val_imdb.'"><img src="'.$image.'" width="200px" height="278px"><BR>'.$title.'</a></TD>';
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
echo '<tr><TD class="nav" colspan="4" align="right">';
if ($page > 1)
echo '<a class="nav" href="filmeseriale_filme.php?page='.($page-1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&lt;&lt;&nbsp;</a> | <a class="nav" href="filmeseriale_filme.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
else
echo '<a class="nav" href="filmeseriale_filme.php?page='.($page+1).'&file='.$file.'&title='.urlencode($title).'">&nbsp;&gt;&gt;&nbsp;</a></TD></TR>';
}
echo "</table>";
?>
<br></div></body>
</html>
