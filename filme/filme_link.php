<?php
include ("../common.php");
error_reporting(0);
if (file_exists($base_cookie."render.dat")) unlink ($base_cookie."render.dat");
$list = glob($base_sub."*.srt");
   foreach ($list as $l) {
    str_replace(" ","%20",$l);
    unlink($l);
}
  $filelink = $_GET["file"];
  $link_f =  array();
  $type = "mp4";
if (isset($_GET["title"]))
  $pg=unfix_t(urldecode($_GET["title"]));
else {
$t1=explode(",",$filelink);
$filelink = urldecode($t1[0]);
$filelink = str_replace("*",",",$filelink);
$filelink = str_replace("@","&",$filelink); //seriale.subtitrate.info
$filelink=str_replace("www.seriale.filmesubtitrate.info","www.fsplay.net",$filelink);
$filelink=str_replace("www.filmesubtitrate.info","www.fsplay.net",$filelink);
if (sizeof($t1)>1) $pg = urldecode($t1[1]);
}
if (!$pg) $pg = "play now...";
$pg=unfix_t($pg);
//echo $filelink;
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}


/**####################################**/
/** Here we start.......**/
$last_link = "";
if (strpos($filelink,"desenefaine.ro") !== false) {
//echo $filelink;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_REFERER, "https://desenefaine.ro");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  $h = urldecode(str_replace("@","%",$h));
  //echo $h;
  $vid=str_between($h,'embed.php?vid=','"');
  $l="https://desenefaine.ro/embed.php?vid=".$vid;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_REFERER, "https://desenefaine.ro");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
  $html = urldecode(str_replace("@","%",$html));
  //$t1=explode("base64,",$html);
  //$t2=explode('"',$t1[1]);
  //echo base64_decode($t2[0]);
  $html =$h.'"'.$html.'"';
  //echo $html;
  //https://www.rovideo.net/get_file/1/07efb813ad617039eaf239afb6cd93364002a2b255/2000/2011/2011.mp4/?embed=true&rnd=1550392933101
  //https://www.rovideo.net/get_file/1/837300ba6f936f33dd1c1eeb29f9a67a4002a2b255/2000/2011/2011.mp4/?embed=true&rnd=1550317566
} elseif (strpos($filelink,"rovideo.") !== false) {
  $html='"'.$filelink.'"';
} elseif (strpos($filelink,"filmeonline2019.us") !== false) {
  $ua = $_SERVER['HTTP_USER_AGENT'];
  $html="";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch,CURLOPT_REFERER,$filelink);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  $t1=explode('showsrv" data-id="',$h);
  $t2=explode('"',$t1[1]);
  $embd=$t2[0];
  $videos = explode('b data-id="',$h);
  unset($videos[0]);
  $videos = array_values($videos);
  foreach($videos as $video) {
    $t1=explode('"',$video);
    $id=$t1[0];
    $l="https://filmeonline2019.us/embed/".$embd."/".$id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $l);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    curl_setopt($ch,CURLOPT_REFERER,$filelink);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $h1 = curl_exec($ch);
    curl_close($ch);
    $html .=$h1;
  }
} elseif (strpos($filelink,"filmenoihd.biz") !== false) {
  $ua = $_SERVER['HTTP_USER_AGENT'];
  $html="";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch,CURLOPT_REFERER,$filelink);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  //echo $h;
  $html=$h." ";
  $videos = explode('atob("', $h);
  unset($videos[0]);
  $videos = array_values($videos);
  foreach($videos as $video) {
    $t1=explode('"',$video);
    $html .=base64_decode($t1[0]).'" ';
  }
} elseif (strpos($filelink,"divxfilmeonline.") !== false) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_REFERER, "https://divxfilmeonline.org");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  //echo $h;
  $html=$h;
  if (preg_match_all("/player.php\?id\=([\w\-]*)/",$h,$m)) {
  //print_r ($m);
   for ($k=0;$k<count($m[1]);$k++) {
   $l="https://divxfilmeonline.org/script/myplayer/player.php?id=".$m[1][$k];
   //echo $l;
  $head=array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
'Accept-Encoding: gzip, deflate, br');
$cookie=$base_cookie."divx.dat";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; rv:64.0) Gecko/20100101 Firefox/64.0');
  //curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
  //curl_setopt($ch, CURLOPT_REFERER, "https://divxfilmeonline.org");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt($ch, CURLOPT_NOBODY,1);
  //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  if (strpos($h,"Location:") !== false) {
  $t1=explode("Location:",$h);
  $t2=explode("\n",$t1[1]);
  $html .=$t2[0].'" ';
  }
  }
  }
  //print_r ($m);
} elseif (strpos($filelink,"filmetop.org") !== false) {
$cookie=$base_cookie."cookie.dat";
$ua     =   $_SERVER['HTTP_USER_AGENT'];
  $html="";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_REFERER, "https://filmetop.org");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  $videos = explode('div class="TPlayerTb', $h);
  unset($videos[0]);
  $videos = array_values($videos);
  //print_r ($videos);
  foreach($videos as $video) {
  $video=htmlspecialchars_decode($video);
  $video=html_entity_decode($video);
  $t1=explode('src="',$video);
  $t2=explode('"',$t1[1]);
  $l=$t2[0];
  //echo $l."\n";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_REFERER, "https://filmetop.org");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  $t1=explode('src="',$h);
  $t2=explode('"',$t1[1]);
  $l2=$t2[0];
  $l2=htmlspecialchars_decode($l2);
  $l2=html_entity_decode($l2);
  //echo $l2."\n";
  if (strpos($l2,"filmetop.org") !== false) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $l2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
    curl_setopt($ch, CURLOPT_REFERER, "https://filmetop.org");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER,1);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    //curl_setopt($ch, CURLOPT_NOBODY,1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $h3 = curl_exec($ch);
    curl_close($ch);
    //echo $h3;
    $t1=explode("trde('",$h3);
    $t2=explode("'",$t1[1]);
    //$l3="https://filmetop.org/?trhide=1&trhex=".strrev($t1[1]);
    $l3="https://filmetop.org/?trhide=1&trhex=".strrev($t2[0]);
    //$l3=str_replace('trhex=&','trhex=',$l3);
    //echo $l3."\n";

  //sleep (3);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $l3);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
    curl_setopt($ch, CURLOPT_REFERER, "https://filmetop.org");
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
      //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_HEADER,1);
    //curl_setopt($ch, CURLOPT_NOBODY,1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $h3 = curl_exec($ch);
    curl_close($ch);
    //echo $h3;
    $t1=explode('HTTP/1.1 200 OK',$h3);
    $html .=$t1[0].'"';
  } else {
    $html .=$l2.'"';
  }
  //echo $l2."\n";
  }
} elseif (strpos($filelink,"pefilme.net") !== false) {
  $html="";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_REFERER, "https://pefilme.net");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  //echo $h;
  $videos = explode('baza64.com/pefilme/', $h);
  unset($videos[0]);
  $videos = array_values($videos);
  //print_r ($videos);
  foreach($videos as $video) {
    $t1=explode('"',$video);
    $l=base64_decode($t1[0]);
    if (strpos($l,'atob("') !== false) {
    $t1=explode('atob("',$l);
    $t2=explode('"',$t1[1]);
    $html .=base64_decode($t2[0]).'" ';
    } else {
    $html .=$l;
    }
  }
  $html .=$h;
  //echo $html;
} elseif (strpos($filelink,"veziseriale.online") !== false) {
  $headers = array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
   'Accept-Encoding: deflate',
   'Accept-Language: en-US,en;q=0.5',
   'Cookie: CAPTCHA=1; _popfired=2'
  );
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; rv:62.0) Gecko/20100101 Firefox/62.0');
  //curl_setopt($ch,CURLOPT_REFERER,$l);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
  //echo $html;
} elseif (strpos($filelink,"filmeseriale.online") !== false) {
  $headers = array('Accept: text/html, */*; q=0.01',
   'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
   'Accept-Encoding: deflate',
   'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
   'X-Requested-With: XMLHttpRequest',
   'Cookie: noprpvdtzseogxcqwcnt=2; noprpvdtzseogxcqwexp=Wed, 11 Oct 2030 07:39:41 GMT; go_through=1'
  );
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,$filelink);
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h2 = curl_exec($ch);
  curl_close ($ch);
  $html=$h2;
} elseif (strpos($filelink,"vezi-online.com") !== false) {
    //require_once("JavaScriptUnpacker.php");
   //$jsu = new JavaScriptUnpacker();
    //$html22=file_get_contents($filelink);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  //curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html22 = curl_exec($ch);
  //echo $html22;
  curl_close($ch);
      $t1=explode('url: "../',$html22);
      $t2=explode('"',$t1[1]);
      $l="https://vezi-online.com/".$t2[0];
      $t1=explode("{id: ",$html22);
      $t2=explode("}",$t1[1]);
      $post="id=".trim($t2[0]);
      //echo $l."<BR>";
      //echo $post;
  $head=array("Cookie: __cfduid=d226f4723cb35acbfa9b98f75f0ffb6a11497648892; vezi_online=1");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
  //curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt ($ch, CURLOPT_REFERER, "http://vezi-online.com/");
  curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html33 = curl_exec($ch);
  curl_close($ch);
  //echo $html33;
  $html=$html33;
    //}
}
elseif (strpos($filelink,"filmeserialeonline.org") !== false) {
//echo $filelink;
//GoogleCaptcha:"98715db6ecea80b068ccb92ffd578ad0"
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,$filelink);
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h2 = curl_exec($ch);
  curl_close ($ch);
  $id=str_between($h2,'post_id":"','"');
//echo $h2;
if (preg_match("/id:\s+(\d+)/",$h2,$m)){
$id=$m[1];
}
//wp-content/themes/grifus/includes/single/second.php
  if (strpos($h2,"grifus/includes") !== false) {
    //$id=str_between($h2,'data: {id: ',')');
    //$id=$m[1];
    $l="http://www.filmeserialeonline.org/wp-content/themes/grifus/includes/single/second.php";
  } else {
    //$id=str_between($h2,'data: {id: ','}');
    //$id=$m[1];
    $l="http://www.filmeserialeonline.org/wp-content/themes/grifus/loop/second.php";
  }
    //$l="http://www.filmeserialeonline.org/wp-content/themes/grifus/includes/single/second.php";
  $post="id=".$id."&logat=1";
  $cookie="Cookie: _ga=GA1.2.226532075.1472192307; _gat=1; GoogleCaptcha=c07edfad41d0f118e5d44ec9a725f017";
  $headers = array('Accept: text/html, */*; q=0.01',
   'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
   'Accept-Encoding: deflate',
   'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
   'X-Requested-With: XMLHttpRequest',
   'Cookie: _ga=GA1.2.226532075.1472192307; _gat=1; GoogleCaptcha=c07edfad41d0f118e5d44ec9a725f017'
  );
  if (file_exists($base_pass."filmeseriale.txt"))
    $captcha=trim(file_get_contents($base_pass."filmeseriale.txt"));
  else
   $captcha="1c438a6f21f56c99d9bcfbf6a43bb5325";
  $headers = array('Accept: text/html, */*; q=0.01',
   'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
   'Accept-Encoding: deflate',
   'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
   'X-Requested-With: XMLHttpRequest',
   'Cookie: _popfired=1; _gat=1; GoogleCaptcha='.$captcha.'; _gat=1;'
  );
   //echo $post;
  //$post="id=74337";
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,$filelink);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
  //echo $html;
} elseif (strpos($filelink,"vezi-online.com") !== false) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html22 = curl_exec($ch);
  curl_close($ch);
    //echo $html22;
    $out="";
    $html="";
    $videos = explode('player-video">', $html22);
    unset($videos[0]);
    $videos = array_values($videos);
    foreach($videos as $video) {
      $t1=explode('url: "../',$video);
      $t2=explode('"',$t1[1]);
      $l="https://vezi-online.com/".$t2[0];
      $t1=explode("id='+'",$video);
      $t2=explode("'",$t1[1]);
      $post="id=".$t2[0];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
  //curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt ($ch, CURLOPT_REFERER, "https://vezi-online.com/");
  curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $out = curl_exec($ch);
  curl_close($ch);
      $html .=" ".$out;
    }
} elseif (strpos($filelink,"filmeonlinesubtitrate") !== false) {

  $post="pageviewnr=1";
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,$filelink);
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
  //$l = str_between($html,"Link: <",">;");
  //echo $l;
  //Link: <http://www.filmeonlinesubtitrate.tv/?p=5382>; rel=shortlink
  //$AgetHeaders = @get_headers($filelink);
  //echo $AgetHeaders;
} elseif (strpos($filelink,"filmehd.net") !== false) {
  //require_once("JavaScriptUnpacker.php");

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $filelink);
   //curl_setopt ($ch, CURLOPT_POST, 1);
   //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
   //curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; rv:55.0) Gecko/20100101 Firefox/55.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch, CURLOPT_REFERER, $l2);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
   $x = curl_exec($ch);
   curl_close($ch);
//echo $x;
//die();

$videos = explode('data-src="', $x);
unset($videos[0]);
$videos = array_values($videos);
//print_r ($videos);
//captcha-hf=77cbb937bb268f877d01db67ba4786520921cbe142f51385&captcha-idhf=0: undefined
//http://filmehd.net/?modal&post_id=26504&field=embed&index=1&index2=0
//http://filmehd.net/?modal&post_id=26504&field=embed&index=2&index2=0
//Cookie: __cfduid=d2289684b572eadefa78139c0b32c2ae21517319933; PHPSESSID=5h1e85itr5dk90jst0mp6p5207
//Cookie: __cfduid=d2289684b572eadefa78139c0b32c2ae21517319933; PHPSESSID=5h1e85itr5dk90jst0mp6p5207
//intent:https://m.ok.ru/dk?st.cmd=moviePlaybackRedirect&st.sig=12f38127a3ebfcb21697f73a19aca133d406507a&st.mq=2&st.mvid=734562487003&st.ip=82.210.178.241&st.dla=on&st.exp=1533649548210&st.hls=off&_prevCmd=movieLayer&tkn=5332#Intent;package=com.mxtech.videoplayer.pro;S.title=Viceroy%26%238217%3Bs+House+%282017%29;end
$out="";
foreach($videos as $video) {
   //$t1=explode('"',$video);
   //print_r ($t1);
   //$l2="http://filmehd.net/?modal&post_id=".str_replace("&amp;","&",$t1[0]);
   //echo $l2."\n";
   //$l2="http://filmehd.net/?modal&post_id=26504&field=embed&index=3&index2=0";
   //$l2="http://filmehd.net/?modal&post_id=26504&field=embed&index=3&index2=0";
   //$head=array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8','Accept-Language: ro-ro,ro;q=0.8,en-us;q=0.6,en-gb;q=0.4,en;q=0.2','Accept-Encoding: deflate','Content-Type: application/x-www-form-urlencoded','Content-Length: '.strlen($post));
   $t1=explode('"',$video);
   $l2="https://filmehd.net".$t1[0];
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $l2);
   //curl_setopt ($ch, CURLOPT_POST, 1);
   //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
   //curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch, CURLOPT_REFERER, $l2);
  //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
   $y = curl_exec($ch);
   curl_close($ch);

   $out .=$y;
}
$html=$out;
} elseif (strpos($filelink,"fsplay.net") !== false) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch,CURLOPT_REFERER,"http://www.fsplay.net");
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:14.0) Gecko/20100101 Firefox/14.0.1');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html=curl_exec($ch);
  curl_close($ch);
  $html= decode_entities($html);
  //echo $html;
} elseif (strpos($filelink,"topvideohd.com") !== false) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch,CURLOPT_REFERER,"http://www.topvideohd.com/");
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:14.0) Gecko/20100101 Firefox/14.0.1');
  //curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html=curl_exec($ch);
  curl_close($ch);
  $html= decode_entities($html);
  //echo $html;
} elseif (strpos($filelink,"tvhub.org") !== false) {
//echo $filelink;
require_once("JavaScriptUnpacker.php");
$cookie=$base_cookie."hdpopcorns.dat";
$ua     =   $_SERVER['HTTP_USER_AGENT'];
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch,CURLOPT_REFERER,"https://tvhub.org");
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h1 = curl_exec($ch);
  curl_close ($ch);
  //echo $h1;
  $id=str_between($h1,"post_ID' value='","'");
  $id=str_between($h1,'data-id="','"');
  $t1=explode('eval(function(p,a,c,k,e,d)',$h1);
  $h2="eval(function(p,a,c,k,e,d)".$t1[count($t1)-1];
  $jsu = new JavaScriptUnpacker();
  $out = $jsu->Unpack($h2);
  //echo $out;
$l="https://tvhub.org/wp-content/themes/serialenoi/field-ajax.php";
$l="https://tvhub.org/wp-content/themes/grifus/loop/field-ajax.php";
//$l="https://tvhub.org/wp-content/themes/grifus/includes/single/field-ajax.php";
$l="https://tvhub.org/wp-content/themes/grifus/includes/single/field-ajax.php";
$l="https://tvhub.org/wp-content/themes/grifus/loop/field2-ajax.php";
$post="post_id=".$id;
$t1=explode('url:"',$out);
$t2=explode('"',$t1[1]);
$l="https://tvhub.org".$t2[0];
//echo $l;
//echo $post;
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch,CURLOPT_REFERER,"https://tvhub.org");
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close ($ch);
  //echo $h;
  //die();
  $html=$h;

} elseif (strpos($filelink,"filme--online.") !== false) {
$ua = $_SERVER['HTTP_USER_AGENT'];
$cookie=$base_cookie."hdpopcorns.dat";
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch,CURLOPT_REFERER,"https://filme--online.ro/");
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h1 = curl_exec($ch);
  curl_close ($ch);
  //echo $h1;

  $id=str_between($h1,'data-id="','"');

$l="https://filme--online.ro/wp-content/themes/vizer/inc/parts/single/field-ajax.php";
$post="post_id=".$id;
//echo $post;
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch,CURLOPT_REFERER,"https://filme--online.ro/");
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
} elseif (strpos($filelink,"voxfilmeonline.net") !== false) {
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://voxfilmeonline.net");
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
$videos = explode('class="play_button', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
 $t1=explode('data-singleid="',$video);
 $t2=explode('"',$t1[1]);
 $id=$t2[0];
 $t1=explode('data-server="',$video);
 $t2=explode('"',$t1[1]);
 $s=$t2[0];
 $l="https://voxfilmeonline.net/wp-admin/admin-ajax.php";
 $post="action=samara_video_lazyload&singleid=".$id."&server=".$s;
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://voxfilmeonline.net");
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close ($ch);
 $html .=$h;
}
} elseif (strpos($filelink,"filmeseriale-hd.") !== false) {
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://filmeseriale-hd.com");
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
$videos = explode("li id='player-option", $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
 $t1=explode("data-post='",$video);
 $t2=explode("'",$t1[1]);
 $id=$t2[0];
 $t1=explode("data-nume='",$video);
 $t2=explode("'",$t1[1]);
 $nume=$t2[0];
 $t1=explode("data-type='",$video);
 $t2=explode("'",$t1[1]);
 $tip=$t2[0];
 $l="https://filmeseriale-hd.com/wp-admin/admin-ajax.php";
 $post="action=doo_player_ajax&post=".$id."&nume=".$nume."&type=".$tip;
 //echo $post;
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://filmeseriale-hd.com");
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close ($ch);
 $html .=$h;
}
//echo $html;
} elseif (strpos($filelink,"filmeonline2016.biz") !== false) {
  $ua=$_SERVER['HTTP_USER_AGENT'];
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT,$ua);
  curl_setopt($ch,CURLOPT_REFERER,"http://www.filmeonline2016.biz/");
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
  //echo $html;
$videos = explode('atob("', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1=explode('"',$video);
  //echo base64_decode($t1[0]);
  $h='"'.base64_decode($t1[0]).'" ';
 $html .=$h;
}
//echo $html;
} elseif (strpos($filelink,"topfilmeonline.net") !== false) {
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"http://topfilmeonline.net/");
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
 // echo $html;
$videos = explode('class="play_button', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
 $t1=explode('data-singleid="',$video);
 $t2=explode('"',$t1[1]);
 $id=$t2[0];
 $t1=explode('data-server="',$video);
 $t2=explode('"',$t1[1]);
 $s=$t2[0];
 $l="https://topfilmeonline.net/wp-admin/admin-ajax.php";
 $post="action=samara_video_lazyload&singleid=".$id."&server=".$s;
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"http://topfilmeonline.net/");
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close ($ch);
 $html .=$h;
}
//echo $html;
} elseif (strpos($filelink,"filmeonline.biz") !== false) {
  $headers = array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
   'Accept-Encoding: deflate',
   'Accept-Language: en-US,en;q=0.5',
   'Cookie: __cfduid=ded1ed4adfb33449348ecf104a4aa875d1518878631; BPC=c03f55bd3b504cc3ebeaa3ed0fa71640'
  );
  $cookie=$base_cookie."biz.dat";
  $ua=$_SERVER['HTTP_USER_AGENT'];
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  //curl_setopt($ch,CURLOPT_REFERER,$l);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
} elseif (strpos($filelink,"f-hd.") !== false) {
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://f-hd.net");
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close ($ch);
$videos = explode('class="play_button', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
 $t1=explode('data-singleid="',$video);
 $t2=explode('"',$t1[1]);
 $id=$t2[0];
 $t1=explode('data-server="',$video);
 $t2=explode('"',$t1[1]);
 $s=$t2[0];
 $l="https://f-hd.biz/wp-admin/admin-ajax.php";
 $post="action=samara_video_lazyload&singleid=".$id."&server=".$s;
  $ch = curl_init($l);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch,CURLOPT_REFERER,"https://f-hd.net");
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close ($ch);
 $html .=$h;
}
} elseif (strpos($filelink,"filme-seriale.") !== false) {
  $cookie=$base_cookie."gold.dat";
  $ch = curl_init($filelink);
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
  $html .=urldecode(str_replace("@","%",$html));
} elseif (strpos($filelink,"streamplay1") !== false) {
   //echo $filelink;
   $html='"'.$filelink.'"';
} elseif (strpos($filelink,"thevideo.me") !== false || strpos($filelink,"vev.io") !== false) {
  $html='"'.$filelink.'"';
} elseif (strpos($filelink,"vidup.io") !== false) {
  $html='"'.$filelink.'"';
} else {
//echo $filelink;
$filelink=str_replace(" ","%20",$filelink);
//echo $filelink;
//echo base64_decode("Ly93d3cub2sucnUvdmlkZW9lbWJlZC83ODU3NTA2MjQ4Nzk=");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //curl_setopt($ch,CURLOPT_REFERER,"http://www.topvideohd.com/");
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:14.0) Gecko/20100101 Firefox/14.0.1');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html=curl_exec($ch);
  curl_close($ch);
  $html = urldecode(str_replace("@","%",$html));
  //echo $html;
  if (strpos($filelink,"vezi-online.net") !== false) {
    //$h1=str_between($html,'class="player">','</div');
    $h1=explode('class="player">',$html);
    $t1=explode("document.write(unescape('",$h1[1]);
    $t2=explode("'",$t1[1]);
    if ($t2[0]) $html=urldecode($t2[0]);
  }
}
/**################ All links ################**/
//echo $html;
//die();
$html=str_replace("https","http",$html);
if(preg_match_all("/(\/\/.*?)(\"|\'|\s)+/si",$html,$matches)) {
$links=$matches[1];
//print_r ($links);
}
$s="/adf\.ly|vidxden\.c|divxden\.c|vidbux\.c|movreel\.c|videoweed\.(c|e)|novamov\.(c|e)|vk\.com|gounlimited\.to";
$s=$s."|movshare\.net|youtube\.com|youtube-nocookie\.com|flvz\.com|rapidmov\.net|putlocker\.com|mixturevideo\.com|played\.to|";
$s=$s."peteava\.ro\/embed|peteava\.ro\/id|content\.peteava\.ro|divxstage\.net|divxstage\.eu|thevideo\.me|grab\.php\?link1=";
$s=$s."|vimeo\.com|googleplayer\.swf|filebox\.ro\/get_video|vkontakte\.ru|megavideo\.com|videobam\.com|vidzi\.tv|estream\.to|briskfile\.com|playedto\.me";
$s=$s."|fastupload|video\.rol\.ro|zetshare\.net\/embed|ufliq\.com|stagero\.eu|ovfile\.com|videofox\.net|fastplay\.cc|watchers\.to|fastplay\.to";
$s=$s."|trilulilu|proplayer\/playlist-controller.php|viki\.com|modovideo\.com|roshare|rosharing|ishared\.eu|stagevu\.com|vidup\.me|vidup\.io";
$s=$s."|filebox\.com|glumbouploads\.com|uploadc\.com|sharefiles4u\.com|zixshare\.com|uploadboost\.com|hqq\.tv|hqq\.watch|waaw\.|vidtodo\.com|vshare\.eu|bit\.ly";
$s=$s."|nowvideo\.eu|nowvideo\.co|vreer\.com|180upload\.com|dailymotion\.com|nosvideo\.com|vidbull\.com|purevid\.com|videobam\.com|streamcloud\.eu|donevideo\.com|upafile\.com|docs\.google|mail\.ru|superweb|moviki\.ru|entervideos\.com";
$s=$s."|indavideo\.hu|redfly\.us|videa\.hu|videakid\.hu|mooshare\.biz|streamin\.to|kodik\.biz|videomega\.tv|ok\.ru|realvid\.net|up2stream\.com|openload|allvid\.ch|oload|";
$s=$s."vidoza\.net|spankbang\.com|sexiz\.net|streamflv\.com|streamdefence\.com|veehd\.com|coo5shaine\.com|divxme\.com|movdivx\.com|thevideobee\.to|speedvid\.net|streamango|fruithosts|streamplay\.|gorillavid\.in|daclips\.in|movpod\.in|vodlocker\.com|filehoot\.com|bestreams\.net|vidto\.me|cloudyvideos\.com|allmyvideos\.net|goo\.gl|cloudy\.ec|rapidvideo\.com|megavideo\.pro|raptu\.com|vidlox|flashservice\.xvideos\.com|xhamster\.com|entervideo\.net|vcstream\.to|vev\.io|vidcloud\.icu|powvideo|povvideo|cloudvideo|vidtodo|vidcloud\.co|flashx\.";
$s=$s."|putload\.|event\.2target\.net|fembed\.com|streamcherry\.com|hideiframe\.com|filmeonlinehd\.tv\/sharemovie|rovideo\.net|flix555\.com|gamovideo\.com|playhd\.fun|idtbox\.com|bitporno\.com|thevideobee\.to/i";
for ($i=0;$i<count($links);$i++) {
  if (strpos($links[$i],"http") !== false) {
    $t1=explode("http:",$links[$i]);
   if (sizeof ($t1) > 1 ) {
    $p=count($t1);
    $cur_link="http:".$t1[$p-1];
	}
  } else {
  $cur_link="http:".$links[$i];
  }
  if (strpos($links[$i],"bit.ly") !== false) {
  $l=trim("https:".$links[$i]);
  //echo $l;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt($ch, CURLOPT_NOBODY,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h2 = curl_exec($ch);
  curl_close($ch);
  //echo $h2;
  $t1=explode("Location:",$h2);
  $t2=explode("\n",$t1[1]);
  $cur_link=trim($t2[0]);
  //echo $cur_link;
  }
  if (strpos($links[$i],"goo.gl") !== false) {
  $l="https:".$links[$i];
  //echo $l;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt($ch, CURLOPT_NOBODY,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h2 = curl_exec($ch);
  curl_close($ch);
  //echo $h2;
  $t1=explode("Location:",$h2);
  $t2=explode("\n",$t1[1]);
  $cur_link=trim($t2[0]);
  //echo $cur_link;
  }
  if (strpos($links[$i],"hideiframe.com") !== false) {
  $l="https:".$links[$i];
  //echo $l;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt($ch, CURLOPT_NOBODY,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h2 = curl_exec($ch);
  curl_close($ch);
  //echo $h2;
  $t1=explode("Location:",$h2);
  $t2=explode("\n",$t1[1]);
  $cur_link=trim($t2[0]);
  //echo $cur_link;
  }
  if (strpos($links[$i],"2target.net") !== false) {
    //https://event.2target.net/jc1M
    $l="https:".$links[$i];
    $cookie=$base_cookie."event.dat";
    if (file_exists($cookie)) unlink ($cookie);
    $ua     =   $_SERVER['HTTP_USER_AGENT'];
$head = array(
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
'Accept-Language: en-US,en;q=0.5',
'Accept-Encoding: deflate',
'Connection: keep-alive',
'Upgrade-Insecure-Requests: 1'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $l);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $ua);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_HEADER, 1);
$h1 = curl_exec($ch);

  $t1=explode('<form method="post',$h1);
  $t2=explode("</form",$t1[1]);
  $xx='<form method="post'.$t2[0]."</form>";


  //die();
  $t1=explode('name="_csrfToken',$h1);
  $t2=explode('value="',$t1[1]);
  $t3=explode('"',$t2[1]);
  $csrfToken=$t3[0];
  $t1=explode('name="ad_form_data',$h1);
  $t2=explode('value="',$t1[1]);
  $t3=explode('"',$t2[1]);
  $ad_form_data=$t3[0];
  //die();
  //echo "aa=".base64_decode($ad_form_data)."\n";
  $t1=explode('name="_Token[fields]',$h1);
  $t2=explode('value="',$t1[1]);
  $t3=explode('"',$t2[1]);
  $token1=$t3[0];

  $t1=explode('name="_Token[unlocked]',$h1);
  $t2=explode('value="',$t1[1]);
  $t3=explode('"',$t2[1]);
  $token2=$t3[0];
$data = array('_method' => 'POST',
'_csrfToken' => $csrfToken,
'ad_form_data' => $ad_form_data,
'_Token[fields]' => $token1,
'_Token[unlocked]' => $token2
);
$post =  http_build_query ($data);
$l2="https://event.2target.net/links/go";
$head=array('Accept: application/json, text/javascript, */*; q=0.01',
'Accept-Language: en-US,en;q=0.5',
'Accept-Encoding: deflate',
'X-CSRF-Token: '.$csrfToken.'',
'Referer: https://event.2target.net/jc1M',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'X-Requested-With: XMLHttpRequest',
'Content-Length: '.strlen($post).''
);
//sleep (1);
  curl_setopt($ch, CURLOPT_URL, $l2);
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_HEADER,0);
  //curl_setopt($ch, CURLOPT_NOBODY,1);
  $x = curl_exec($ch);
  curl_close($ch);
  $r=json_decode($x,1);
  if (isset($r['url']))
    $cur_link = $r['url'];
  else
    $cur_link = "";
  }
  //echo $cur_link;
  $t1=explode(" ",$cur_link);     //vezi-online
  $cur_link=$t1[0];
  $t1=explode("&stretching",$cur_link);    //vezi-online
  $cur_link=$t1[0];
  if (strpos($cur_link,"raptu.com") !== false) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $cur_link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch, CURLOPT_HEADER,1);
  //curl_setopt($ch, CURLOPT_NOBODY,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h2 = curl_exec($ch);
  curl_close($ch);
  $cur_link=str_between($h2,'property="og:url" content="','"');
  }
  if (strpos($cur_link,"entervideos.com/vidembed") !==false) {
  $t1=explode("&",$cur_link);    //
  $cur_link=$t1[0];
  }
  if (strpos($cur_link,"hqq.watch") !==false) {
   if (!preg_match("/(hqq|netu)(\.tv|\.watch)\/player\/embed_player\.php\?vid=(?P<vid>[0-9A-Za-z]+)/",$cur_link)) $cur_link="";

  }
  $cur_link=str_replace(urldecode("%0D"),"",$cur_link);
  //echo $cur_link."<BR>";
  if (preg_match($s,$cur_link)) {
    if ($cur_link <> $last_link) {
     $t1=explode("proxy.link=",$cur_link); //vezi-filme
   if (sizeof ($t1) > 1 ) {
     if ($t1[1]) {
       $t2=explode("&",$t1[1]);
       $cur_link=trim($t2[0]);
     }
   }
      if (!preg_match("/hqq\.tv\/player\/script\.php|top\.mail\.ru|facebook|twitter|player\.swf|img\.youtube|youtube\.com\/user|radioarad|\.jpg|\.png|\.gif|jq\/(js|css)|fsplay\.net\?s|changejplayer\.js|validateemb\.php|restore_google\.php/i",$cur_link)) {
        $t1=explode("proxy.link=",$cur_link); //filmeonline.org
      if (sizeof ($t1) > 1 ) {
        if ($t1[1] <> "") {
        $cur_link=$t1[1];
        }
      }
        if (strpos($cur_link,"captions.file") !== false) {  //http://vezi-online.net
        $a=explode("&captions.file",$cur_link);
        $mysrt=str_between($cur_link,"captions.file=","&");
        if (strpos($mysrt,"http") === false && $mysrt) {
         $t=explode("/",$filelink);
         $mysrt="http://".$t[2].$mysrt;
        }
        $cur_link=$a[0];
        }

        if (strpos($cur_link,"adf.ly") !==false) { //onlinemoca
           $a1=explode($cur_link,$html);
           $a2=explode('server/',$a1[1]);
           $a3=explode('.',$a2[1]);
           $server=$a3[0];
        } else {
          $server = str_between($cur_link,"http://","/");
          //echo "aasasasas ";
          if (!$server) $server = str_between($cur_link,"https://","/");
          //echo "Server=".$server;
        }
        //if (!$server) $server = str_between($cur_link,"https://","/");
        $cur_link=str_replace(urldecode("%0A"),"",$cur_link);
        $last_link=$cur_link;
        if (strpos($cur_link,"google") !==false) {
        //echo $cur_link."<BR>";
          $t1=explode("docid=",$cur_link);
          $t2=explode("&",$t1[1]);
          $docid=$t2[0];
          $mysrt_google="http://video.google.com/videotranscript?frame=c&docid=".$docid."&hl=ro&type=track&name=ro&lang=ro";
        }
        if (strpos($cur_link,"viki.com") !==false) {
          preg_match('/(viki\.com\/player\/medias\/)([\w\-]+)/', $cur_link, $match);
          $viki_id = $match[2];
        }
        $link_f[]=$cur_link;
      }
    }
  //echo $cur_link;
  }
}
/**################ special links ##############**/

/**################ flash... mediafile,file.....############**/

//http://www.filmesubtitrate.info/2010/06/10-things-i-hate-about-you-sez1-ep1.html
//http://www.seriale.filmesubtitrate.info/2010/06/10-things-i-hate-about-you-sez1-ep1.html
//www.seriale.filmesubtitrate.info
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
$link_f=array_unique($link_f);
//print_r ($link_f);
$n= count($link_f);
if (isset($link_f[0])) {
if ($n>1 || strpos($link_f[0],"http") !== false) {
echo '
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

      <meta charset="utf-8">
      <title>Alege varianta</title>
   	  <link rel="stylesheet" type="text/css" href="../custom.css" />
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
 <script src="../jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="../jquery.fancybox.min.css">
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
  document.getElementById("server").innerHTML = '."'".'<font size="6" color="red">Asteptati..................</font>'."'".';
  var the_data = "title="+ title +"&link="+link;
  var php_file="link1.php";
  request.open("POST", php_file, true);			// set the request

  // adds a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
       //alert (request.responseText);
       document.getElementById("server").innerHTML = '."'".'<font size="6" color="lightblue">Alegeti un server</font>'."'".';
       document.getElementById("mytest1").href=request.responseText;
      document.getElementById("mytest1").click();
    }
  }
}
function ajaxrequest1(link) {
  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance

  // create pairs index=value with data that must be sent to server
  //var the_data = {mod:add,title:title, link:link}; //Array
  document.getElementById("server").innerHTML = '."'".'<font size="6" color="red">Asteptati..................</font>'."'".';
  var the_data = link;
  var php_file="hqq2.php";
  request.open("POST", php_file, true);			// set the request

  // adds a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
       //alert (request.responseText);
       document.getElementById("server").innerHTML = '."'".'<font size="6" color="lightblue">Alegeti un server</font>'."'".';

    }
  }
}

   function zx(e){
     var charCode = (typeof e.which == "number") ? e.which : e.keyCode
    if (charCode == "53") {   // 5
    //alert (charCode);
     //$.fancybox.close();
     //$.fancybox.close();
     //closeIFrame();
    }
   }
document.onkeypress =  zx;
</script>
<style>
td.link {
    font-style: bold;
    font-size: 25px;
    text-align: left;
}
</style>
<!--font-family: Arial, Helvetica, sans-serif;-->
</head>
<body>';
//$out1="http://127.0.0.1:8080/scripts/subs/out.m3u";
//$title="play...";
//$c="intent:".$out1."#Intent;package=com.mxtech.videoplayer.".$mx.";S.title=".urlencode($title).";end";
//alert (request.responseText);
$c="";
  echo "<a href='".$c."' id='mytest1'></a>".'<div id="mainnav">';
echo '<h2>'.$pg."</H2><BR>";
//echo "<H1>Alegeti una din variantele de mai jos (sau una din parti)</H1>";
echo '<label id="server"><font size="6" color="lightblue">Alegeti un server</font></label><BR>';
//echo '<a href="hqq.php" target="_blank">captcha hqq</a>';
echo '<table border="0" width="90%">'."\n\r";
//echo $html;
//<input type="button" value="Click me" onclick="msg'.$k.'()">
//print_r ($link_f);
//for ($k=0; $k<$n;$k++) {
foreach($link_f as $k=>$val) {
$server="";
//echo $link_f[$k]."\n";
$server= str_between(trim($link_f[$k]),"http://","/");
if (!$server) $server = str_between($link_f[$k],"https://","/");
if (strpos($filelink,"blogspot.ro") !== false && (strpos($filelink,"sezonul") !== false) && $n>5) $server=$server." - Episodul ".($k+1);
 if ($flash != "mp")  {
   //echo $link_f[$k];
   if (strpos($link_f[$k],"hqq.") !== false || strpos($link_f[$k],"waaw") !== false) {
      $pattern = "@(?:\/\/|\.)((?:waaw1?|netu|hqq)\.(?:tv|watch))\/(?:watch_video\.php\?v|.+?vid)=([a-zA-Z0-9]+)@";
      if (preg_match($pattern,$link_f[$k],$m)) {
         $vid=$m[2];
         $link_f[$k]="http://hqq.watch/player/embed_player.php?vid=".$vid."&autoplay=no";
      }
    echo '<TR><td class="link"><a href="link1.php?file='.urlencode($link_f[$k]).','.urlencode($pg).'" target="_blank">'.$server.'</a>
    <a href="hqq_captcha.php?file='.urlencode($link_f[$k]).'" target="_blank"><font color="lightblue"> | Rezolva captcha</font></a>
    </TD></TR>';
   echo '
   <script>
   function msg1'.$k.'() {
     val_l=document.getElementById("target'.$k.'").value;
     msg="file=" + encodeURIComponent(val_l);
     ajaxrequest1(msg);
   }
   </script>
   ';
   } elseif (strpos($link_f[$k],"thevideo.") !== false || strpos($link_f[$k],"vev.") !== false)
    echo '<TR><td class="link"><a href="link1.php?file='.urlencode($link_f[$k]).','.urlencode($pg).'" target="_blank">'.$server.'</a> <a href="https://vev.io/pair" target="_blank"><font color="lightblue"> | Pair IP (4 ore)</font></a></TD></TR>';
   elseif (strpos($link_f[$k],"vidup.io") !== false)
    echo '<TR><td class="link"><a href="link1.php?file='.urlencode($link_f[$k]).','.urlencode($pg).'" target="_blank">'.$server.'</a> <a href="https://vidup.io/pair" target="_blank"><font color="lightblue"> | Pair IP (4 ore)</font></a></TD></TR>';
   elseif (strpos($link_f[$k],"1target.net") !== false) {
     echo '<TR><td class="link"><a href="'.$link_f[$k].'" target="_blank">Open video and get link ...    </a><input type="text" id="target'.$k.'" value="" size="40" onpaste="setTimeout(msg'.$k.',1000)">  </TD></TR>';
   echo '
   <script>
   function msg'.$k.'() {
     val_l=document.getElementById("target'.$k.'").value;
     msg="link1.php?file=" + val_l + "," + "'.urlencode($pg).'";
     window.open(msg);
   }
   </script>
   ';
   } elseif (strpos($link_f[$k],"rovideo1.net") !== false || strpos($link_f[$k],"playhd1.fun") !== false) {
  //echo $link_f[$k];
  $ua=$_SERVER['HTTP_USER_AGENT'];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link_f[$k]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_ENCODING, "");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  curl_setopt($ch, CURLOPT_HEADER,1);
  //curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
  $html = curl_exec($ch);
  curl_close($ch);
  //$html=str_replace("https://www.rovideo.net/player/kt_player.js","kt.js",$html);
  //$html= preg_replace('/([http|https][\.\d\w\-\.\/\\\:\?\&\#\%\_\,]*(kt_player\.js))/', "kt.js", $html);
  //if (file_exists("kt.html")) unlink ("kt.ktml");
  //if (file_exists("kt.txt")) unlink ("kt.txt");
$t1=explode('var flashvars',$html);
$t2=explode('</script',$t1[1]);
$html='<div id="kt_player"></div><script type="text/javascript" src="kt.js?v=4.0.4"></script>';
$html .='<script type="text/javascript">'.' ';
$html .="var flashvars".$t2[0]."</script>";
$html=str_replace("https","http",$html);
  file_put_contents("kt.html",$html);
//echo $html;
//die();
echo '<iframe src="kt.html" style="display: none;"></iframe>';
echo '<TR><td class="link"><a href="link1.php?file='.urlencode($link_f[$k]).','.urlencode($pg).'" target="_blank">'.$server.'</a></TD></TR>';
} elseif (strpos($link_f[$k],"streamplay1.") !== false) {
  preg_match('/(?:\/\/|\.)(streamplay\.(?:to|club|top|me))\/(?:embed-|player-)?([0-9a-zA-Z]+)/',$link_f[$k],$m);
  $filelink="https://streamplay.me/player-".$m[2]."-920x360.html";
  if (file_exists($base_script."/filme/streamplay.txt")) unlink ($base_script."/filme/streamplay.txt");
  $ua=$_SERVER["HTTP_USER_AGENT"];
  $head=array('Cookie: __cfduid=d48f1e8e1e5ae6884e29bbb7a61ba14cf1537565473; lang=1; ref_yrp=http%3A%2F%2Fcecileplanche-psychologue-lyon.com%2Fshow%2Fthe-good-cop%2Fseason-1%2Fepisode-2; _ga=GA1.2.1094333956.1537565367; _gid=GA1.2.1392157958.1537565367; ref_kun=1; _gat=1');
  //$filelink="https://streamplay.me/player-3q1lxhws3g77-920x360.html";
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_ENCODING, "");
  curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
  curl_setopt($ch, CURLOPT_REFERER, $filelink);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  $t1=explode("return r[",$h);
  preg_match_all("/return (_0x[a-z0-9]+)/",$t1[1],$x);
  $replace="var request = new XMLHttpRequest();
  var the_data = '';
  var php_file='streamplay.php?link=' + encodeURIComponent(".$x[1][1].");
  request.open('GET', php_file, true);
  request.send(the_data);
  ";
  $h=str_replace($x[0][1],$replace,$h);
  $h=str_replace('src="/','src="https://streamplay.to/',$h);
  file_put_contents("streamplay.html",$h);
  echo '<iframe src="streamplay.html" style="display: none;"></iframe>';
  echo '<TR><td class="link"><a href="link1.php?file='.urlencode($link_f[$k]).','.urlencode($pg).'" target="_blank">'.$server.'</a></TD></TR>';
} else
   echo '<TR><td class="link"><a href="link1.php?file='.urlencode($link_f[$k]).','.urlencode($pg).'" target="_blank">'.$server.'</a></TD></TR>';
  } else {  //== "mp"
   if (strpos($link_f[$k],"hqq.") !== false  || strpos($link_f[$k],"waaw") !== false) {
      $pattern = "@(?:\/\/|\.)((?:waaw1?|netu|hqq)\.(?:tv|watch))\/(?:watch_video\.php\?v|.+?vid)=([a-zA-Z0-9]+)@";
      if (preg_match($pattern,$link_f[$k],$m)) {
         $vid=$m[2];
         $link_f[$k]="http://hqq.watch/player/embed_player.php?vid=".$vid."&autoplay=no";
      }
   echo '<TR><td class="link"><a onclick="ajaxrequest('."'".urlencode($pg)."', '".urlencode($link_f[$k])."')".'"'." style='cursor:pointer;'>".$server.'</a>
   <a href="hqq_captcha.php?file='.urlencode($link_f[$k]).'" target="_blank"><font color="lightblue"> | Captcha</font></a>
   <a href="intent:http://127.0.0.1:8080/scripts/filme/hqq_captcha.php?file='.urlencode($link_f[$k]).'#Intent;package=org.mozilla.firefox;S.title=Captcha;end" target="_blank"><font color="lightblue"> | Captcha (firefox)</font></a>
   <a href="intent:http://127.0.0.1:8080/scripts/filme/hqq_captcha.php?file='.urlencode($link_f[$k]).'#Intent;package=com.android.chrome;S.title=Captcha;end" target="_blank"><font color="lightblue"> | Captcha (chrome)</font></a>
   ';
   echo '
   <script>
   function msg1'.$k.'() {
     val_l=document.getElementById("target'.$k.'").value;
     msg="file" + encodeURIComponent(val_l);
     ajaxrequest1(msg);
     }
     </script>
   ';
   } elseif (strpos($link_f[$k],"thevideo.") !== false || strpos($link_f[$k],"vev.") !== false)
   echo '<TR><td class="link"><a onclick="ajaxrequest('."'".urlencode($pg)."', '".urlencode($link_f[$k])."')".'"'." style='cursor:pointer;'>".''.$server.'</a> <a href="https://vev.io/pair" target="_blank"><font color="lightblue"> | Pair IP (4 ore)</font></a></TD></TR>';
    elseif (strpos($link_f[$k],"vidup.io") !== false )
   echo '<TR><td class="link"><a onclick="ajaxrequest('."'".urlencode($pg)."', '".urlencode($link_f[$k])."')".'"'." style='cursor:pointer;'>".''.$server.'</a> <a href="https://vidup.io/pair" target="_blank"><font color="lightblue"> | Pair IP (4 ore)</font></a></TD></TR>';

    elseif (strpos($link_f[$k],"1target.net") !== false) {
     echo '<TR><td class="link"><a href="'.$link_f[$k].'" target="_blank">Open video and get link ...    </a><input type="text" id="target'.$k.'" value="" size="40" onpaste="setTimeout(msg'.$k.',1000)">  </TD></TR>';
   echo '
   <script>
   function msg'.$k.'() {
     val_l=document.getElementById("target'.$k.'").value;
     msg="'.urlencode($pg).'" + "," + val_l;
     ajaxrequest("'.urlencode($pg).'",val_l);
   }
   </script>
   ';
} elseif (strpos($link_f[$k],"rovideo1.net") !== false  || strpos($link_f[$k],"playhd1.fun") !== false) {
  /*
  $ua=$_SERVER['HTTP_USER_AGENT'];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $link_f[$k]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_ENCODING, "");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $html = curl_exec($ch);
  curl_close($ch);
  */
  $html=file_get_contents($link_f[$k]);
  //$html=str_replace("https://www.rovideo.net/player/kt_player.js","kt.js",$html);
  $html= preg_replace('/([http|https][\.\d\w\-\.\/\\\:\?\&\#\%\_\,]*(kt_player\.js))/', "kt.js", $html);
  //if (file_exists("kt.html")) unlink ("kt.ktml");
  //if (file_exists("kt.txt")) unlink ("kt.txt");
  file_put_contents("kt.html",$html);

echo '<iframe src="kt.html" style="display: none;"></iframe>';
echo '<TR><td class="link"><a onclick="ajaxrequest('."'".urlencode($pg)."', '".urlencode($link_f[$k])."')".'"'." style='cursor:pointer;'>".$server.'</a></TD></TR>';
} elseif (strpos($link_f[$k],"streamplay1.to") !== false || strpos($link_f[$k],"streamplay1.me") !== false) {
  preg_match('/(?:\/\/|\.)(streamplay\.(?:to|club|top|me))\/(?:embed-|player-)?([0-9a-zA-Z]+)/',$link_f[$k],$m);
  $filelink="https://streamplay.me/player-".$m[2]."-920x360.html";
  $ua=$_SERVER["HTTP_USER_AGENT"];
  $head=array('Cookie: __cfduid=d48f1e8e1e5ae6884e29bbb7a61ba14cf1537565473; lang=1; ref_yrp=http%3A%2F%2Fcecileplanche-psychologue-lyon.com%2Fshow%2Fthe-good-cop%2Fseason-1%2Fepisode-2; _ga=GA1.2.1094333956.1537565367; _gid=GA1.2.1392157958.1537565367; ref_kun=1; _gat=1');
  //$filelink="https://streamplay.me/player-3q1lxhws3g77-920x360.html";
  if (file_exists($base_script."/filme/streamplay.txt")) unlink ($base_script."/filme/streamplay.txt");
  $ch = curl_init($filelink);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_ENCODING, "");
  curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
  curl_setopt($ch, CURLOPT_REFERER, $filelink);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $h = curl_exec($ch);
  curl_close($ch);
  $t1=explode("return r[",$h);
  preg_match_all("/return (_0x[a-z0-9]+)/",$t1[1],$x);
  $replace="var request = new XMLHttpRequest();
  var the_data = '';
  var php_file='streamplay.php?link=' + encodeURIComponent(".$x[1][1].");
  request.open('GET', php_file, true);
  request.send(the_data);
  ";
  $h=str_replace($x[0][1],$replace,$h);
  $h=str_replace('src="/','src="https://streamplay.to/',$h);
  file_put_contents("streamplay.html",$h);
  echo '<iframe src="streamplay.html" style="display: none;"></iframe>';
  echo '<TR><td class="link"><a onclick="ajaxrequest('."'".urlencode($pg)."', '".urlencode($link_f[$k])."')".'"'." style='cursor:pointer;'>".$server.'</a></TD></TR>';

   } else
     echo '<TR><td class="link"><a onclick="ajaxrequest('."'".urlencode($pg)."', '".urlencode($link_f[$k])."')".'"'." style='cursor:pointer;'>".$server.'</a></TD></TR>';
   }
}
echo '</TABLE>';
//echo '<img id="load" src= "load.jpg" width="450px" height="450px">';

echo '<br></div></body>
</html>';
}
} else {
echo '
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

      <meta charset="utf-8">
      <title>Alege varianta</title>
   	  <link rel="stylesheet" type="text/css" href="../custom.css" />
</head>
<body>';
echo '<h2>'.$pg."</H2>";
echo "<H2>Nu s-au gasit servere!?</H2>";
echo '<br></div></body>
</html>';
}
?>
<!--
table {
  table-layout:fixed;
}
-->
