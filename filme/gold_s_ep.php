<!DOCTYPE html>
<?php
include ("../common.php");
$tit=unfix_t(urldecode($_GET["title"]));
$image=$_GET["image"];
$link=$_GET["file"];
$tip=$_GET["tip"];
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="../custom.css" />
      <meta charset="utf-8">
      <title><?php echo $tit; ?></title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

</head>
<body><div id="mainnav">
<?php
error_reporting(0);
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
echo '<h2>'.$tit.'</h2>';
echo '<table border="1" width="100%">'."\n\r";
//echo '<TR><td style="color:#000000;background-color:deepskyblue;text-align:center" colspan="3" align="center">'.$tit.'</TD></TR>';
///flixanity_s_ep.php?tip=serie&file=http://flixanity.watch/the-walking-dead&title=The Walking Dead&image=http://flixanity.watch/thumbs/show_85a60e7d66f57fb9d75de9eefe36c42c.jpg

$requestLink=$link;
$cookie=$base_cookie."gold.dat";
  $ch = curl_init($requestLink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://filme-seriale.gold");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
//echo $html;
$t1=explode('img itemprop="image"',$html);
$t2=explode('src="',$t1[1]);
$t3=explode('"',$t2[1]);
$pageimage=str_replace("https","http",$t3[0]);
   echo '<table border="1px" width="100%">'."\n\r";
   $n=0;
 $videos = explode('class="se-t">', $html);
$sezoane=array();
unset($videos[0]);
$videos = array_values($videos);
//$videos = array_reverse($videos);
foreach($videos as $video) {
  //$t1=explode('Season',$video);
  $t2=explode("<",$video);
  $sezoane[]=trim($t2[0]);
}
echo '<table border="1" width="100%">'."\n\r";
echo '<TR>';
$c=count($sezoane);
for ($k=0;$k<$c;$k++) {
echo '<td class="sez" style="color:black;text-align:center"><a href="#sez'.($sezoane[$k]).'">Sezonul '.($sezoane[$k]).'</a></TD>';
}
echo '</TR></TABLE>';
foreach($videos as $video) {
  //$t1=explode('Season',$video);
  $t2=explode("<",$video);
  $season=trim($t2[0]);
  $sez = $season;
  $first=true;
  $vids = explode('<a', $video);
unset($vids[0]);
$videos = array_values($videos);
//$vids = array_reverse($vids);
foreach($vids as $vid) {
  if ($first) {
    $first=false;
    $n=0;
    echo '<table border="1" width="100%">'."\n\r";
    echo '<TR><td class="sez" style="color:black;background-color:#0a6996;color:#64c8ff;text-align:center" colspan=3">Sezonul '.($sez).'</TD></TR>';


  }
$title="";

    //$t0=explode('<',$video);
    //$ep_nr=$t0[0];
    $t1 = explode('href="', $vid);
    $t2=explode('"',$t1[1]);
    //$t2 = explode('"', $t1[1]);
    //$link1 = "https://filme-seriale.net/episode/".$t1[0];
    $link1=$t2[0];
    $ep_nr="";
    $sez="";
    if (preg_match("/sezonul-(\d+)-episodul-(\d+)/",$vid,$m)) {
    //print_r ($m);
    $ep_nr=$m[2];
    $sez=$m[1];
    }
    $t3=explode('>',$t1[1]);
    $t4=explode("<",$t3[1]);
    //$t2=explode('"',$t1[1]);
    $ep_tit=$sez."x".$ep_nr." -".trim($t4[0]);


  //$link='watchfree_fs.php?tip=serie&file='.$link1.'&title='.$season.'|'.$episod.'|'.$tit.'|'.$ep_tit.'&image='.$image;
  $link="filme_link.php?file=".$link1.",".urlencode(fix_t($tit." ".$ep_tit));
  if ($sez && $ep_nr) {
      if ($n == 0) echo "<TR>"."\n\r";
		echo '<TD class="mp" width="33%" align="center">'.'<a id="sez'.$sez.'" href="'.$link.'" target="_blank"><img width="200px" height="100px" src="'.$pageimage.'"><BR>'.$ep_tit.'</a>';
		echo '</TD>'."\n\r";
        $n++;
        if ($n > 2) {
         echo '</TR>'."\n\r";
         $n=0;
        }
  }
}  

echo '</table>';
}
echo '</table>';
?>
<br></div></body>
</html>